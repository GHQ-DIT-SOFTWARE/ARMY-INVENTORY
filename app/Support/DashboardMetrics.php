<?php

declare(strict_types=1);

namespace App\Support;

use App\Models\AggregatedIssueItem;
use App\Models\Armory;
use App\Models\Category;
use App\Models\IssueItemOut;
use App\Models\Item;
use App\Models\MotorPool;
use App\Models\Personnel;
use App\Models\Restock;
use App\Models\SubCategory;
use App\Models\Supplier;
use App\Models\Vehicle;
use App\Models\VehicleCategory;
use App\Models\VehicleDeployment;
use App\Models\VehicleInventory;
use App\Models\Weapon;
use App\Models\WeaponCategory;
use App\Models\WeaponInventory;
use App\Models\WeaponIssueLog;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;

class DashboardMetrics
{
    public static function globalSummary(): array
    {
        $allItems = Item::with(['category', 'subcategory'])->get();
        $allRestocks = Restock::with(['stocks', 'supplier'])->get();
        $allIssues = IssueItemOut::with(['issuedoutitem', 'createdBy'])->get();

        $totals = [
            'items' => $allItems->count(),
            'stock_quantity' => $allItems->sum(fn (Item $item) => (int) $item->qty),
            'restock_quantity' => $allRestocks->sum(fn (Restock $restock) => (int) $restock->qty),
            'categories' => Category::count(),
            'sub_categories' => SubCategory::count(),
            'suppliers' => Supplier::count(),
            'personnel' => Personnel::count(),
        ];

        $totals['pending_requests'] = $allIssues->filter(fn (IssueItemOut $issue) => ($issue->status ?? '0') !== '1')->count();
        $totals['issued_today'] = $allIssues->filter(function (IssueItemOut $issue) {
            if (empty($issue->confirmed_issued)) {
                return false;
            }

            return Carbon::parse($issue->confirmed_issued)->isToday();
        })->count();
        $totals['restocks_30_days'] = $allRestocks->filter(function (Restock $restock) {
            if (empty($restock->restock_date)) {
                return false;
            }

            return Carbon::parse($restock->restock_date)->greaterThanOrEqualTo(Carbon::now()->subDays(30));
        })->sum(fn (Restock $restock) => (int) $restock->qty);

        $lowStockItems = $allItems->sortBy(fn (Item $item) => (int) $item->qty)->take(6)->values()->map(function (Item $item) {
            return [
                'name' => $item->item_name,
                'qty' => (int) $item->qty,
                'category' => optional($item->category)->category_name,
                'subcategory' => optional($item->subcategory)->sub_name,
            ];
        });

        $recentRestocks = $allRestocks->sortByDesc(function (Restock $restock) {
            $reference = $restock->restock_date ?? $restock->created_at;

            return $reference ? Carbon::parse($reference)->timestamp : 0;
        })->take(5)->values()->map(function (Restock $restock) {
            return [
                'item' => optional($restock->stocks)->item_name,
                'supplier' => optional($restock->supplier)->company_name,
                'qty' => (int) $restock->qty,
                'restock_date' => $restock->restock_date ? Carbon::parse($restock->restock_date)->format('d M Y') : null,
            ];
        });

        $pendingIssueRequests = $allIssues->filter(fn (IssueItemOut $issue) => ($issue->status ?? '0') !== '1')
            ->sortByDesc(fn (IssueItemOut $issue) => $issue->created_at?->timestamp ?? 0)
            ->take(5)
            ->values()
            ->map(function (IssueItemOut $issue) {
                return [
                    'invoice' => $issue->invoice_no,
                    'item' => optional($issue->issuedoutitem)->item_name,
                    'qty' => (int) $issue->qty,
                    'requester' => optional($issue->createdBy)->name,
                    'created_at' => $issue->created_at ? Carbon::parse($issue->created_at)->format('d M Y') : null,
                ];
            });

        $recentlyIssued = $allIssues->filter(fn (IssueItemOut $issue) => ($issue->status ?? '0') === '1')
            ->sortByDesc(function (IssueItemOut $issue) {
                $reference = $issue->confirmed_issued ?? $issue->updated_at ?? $issue->created_at;

                return $reference ? Carbon::parse($reference)->timestamp : 0;
            })
            ->take(5)
            ->values()
            ->map(function (IssueItemOut $issue) {
                return [
                    'invoice' => $issue->invoice_no,
                    'item' => optional($issue->issuedoutitem)->item_name,
                    'qty' => (int) $issue->qty,
                    'confirmed_issued' => $issue->confirmed_issued ? Carbon::parse($issue->confirmed_issued)->format('d M Y') : null,
                ];
            });

        $categoryDistribution = $allItems->groupBy('category_id')->map(function (Collection $items) {
            $first = $items->first();

            return [
                'category_name' => optional(optional($first)->category)->category_name ?? 'Unassigned',
                'total_qty' => $items->sum(fn (Item $item) => (int) $item->qty),
                'item_count' => $items->count(),
            ];
        })->sortByDesc('total_qty')->take(5)->values();

        $issueStatusBreakdown = $allIssues->groupBy(function (IssueItemOut $issue) {
            return ($issue->status ?? '0') === '1' ? 'Issued' : 'Pending';
        })->map->count();

        $monthlyIssueTrend = self::buildMonthlyTrend($allIssues);
        $restockTrend = self::buildMonthlyRestockTrend($allRestocks);
        $batchedIssueSummary = Schema::hasTable('aggregated_issue_items') ? self::buildBatchedIssueSummary() : [];

        return compact(
            'totals',
            'lowStockItems',
            'recentRestocks',
            'pendingIssueRequests',
            'recentlyIssued',
            'categoryDistribution',
            'issueStatusBreakdown',
            'monthlyIssueTrend',
            'restockTrend',
            'batchedIssueSummary'
        );
    }

    public static function weaponSummary(): array
    {
        $totals = [
            'categories' => WeaponCategory::count(),
            'weapon_platforms' => Weapon::count(),
            'inventory' => WeaponInventory::count(),
            'available' => WeaponInventory::where('status', 'in_store')->count(),
            'issued' => WeaponInventory::where('status', 'issued')->count(),
            'armories' => Armory::count(),
        ];

        $recentIssues = WeaponIssueLog::with(['inventory.weapon', 'armory'])
            ->latest('issued_at')
            ->take(6)
            ->get();

        $returnsDue = WeaponIssueLog::with(['inventory.weapon', 'armory'])
            ->whereNull('returned_at')
            ->whereNotNull('expected_return_at')
            ->where('expected_return_at', '<', Carbon::now()->addDays(3))
            ->orderBy('expected_return_at')
            ->take(6)
            ->get();

        $armoryStock = Armory::withCount(['weaponInventories as issued_count' => function ($query) {
            $query->where('status', 'issued');
        }])->withCount(['weaponInventories as total_count'])->get();

        $categoryDistribution = WeaponCategory::withCount('weapons')->orderByDesc('weapons_count')->take(5)->get();

        $statusTimeline = WeaponIssueLog::selectRaw('DATE(issued_at) as day, count(*) as total')
            ->where('issued_at', '>=', Carbon::now()->subDays(14))
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        return compact(
            'totals',
            'recentIssues',
            'returnsDue',
            'armoryStock',
            'categoryDistribution',
            'statusTimeline'
        );
    }

    public static function vehicleSummary(): array
    {
        $totals = [
            'categories' => VehicleCategory::count(),
            'platforms' => Vehicle::count(),
            'inventory' => VehicleInventory::count(),
            'available' => VehicleInventory::where('status', 'in_pool')->count(),
            'deployed' => VehicleInventory::where('status', 'deployed')->count(),
            'motor_pools' => MotorPool::count(),
        ];

        $recentDeployments = VehicleDeployment::with(['inventory.vehicle', 'motorPool'])
            ->latest('deployed_at')
            ->take(6)
            ->get();

        $dueReturns = VehicleDeployment::with(['inventory.vehicle', 'motorPool'])
            ->whereNull('returned_at')
            ->whereNotNull('expected_return_at')
            ->where('expected_return_at', '<', Carbon::now()->addDays(3))
            ->orderBy('expected_return_at')
            ->take(6)
            ->get();

        $motorPoolStock = MotorPool::withCount(['vehicleInventories as deployed_count' => function ($query) {
            $query->where('status', 'deployed');
        }])->withCount(['vehicleInventories as total_count'])->get();

        $categoryDistribution = VehicleCategory::withCount('vehicles')->orderByDesc('vehicles_count')->take(5)->get();

        $deploymentTimeline = VehicleDeployment::selectRaw('DATE(deployed_at) as day, count(*) as total')
            ->where('deployed_at', '>=', Carbon::now()->subDays(14))
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        return compact(
            'totals',
            'recentDeployments',
            'dueReturns',
            'motorPoolStock',
            'categoryDistribution',
            'deploymentTimeline'
        );
    }

    private static function buildMonthlyTrend(Collection $issues): array
    {
        $start = Carbon::now()->subMonths(5)->startOfMonth();
        $buckets = collect(range(0, 5))->mapWithKeys(function (int $offset) use ($start) {
            $month = $start->copy()->addMonths($offset);
            $label = $month->format('M Y');

            return [
                $label => [
                    'issued' => 0,
                    'pending' => 0,
                ],
            ];
        });

        $issues->filter(fn (IssueItemOut $issue) => $issue->created_at && Carbon::parse($issue->created_at)->greaterThanOrEqualTo($start))
            ->each(function (IssueItemOut $issue) use (&$buckets) {
                $label = Carbon::parse($issue->created_at)->format('M Y');
                if (! $buckets->has($label)) {
                    return;
                }

                $bucket = $buckets->get($label);
                if (($issue->status ?? '0') === '1') {
                    $bucket['issued']++;
                } else {
                    $bucket['pending']++;
                }
                $buckets->put($label, $bucket);
            });

        return $buckets->map(function (array $bucket, string $label) {
            return array_merge(['label' => $label], $bucket);
        })->values()->toArray();
    }

    private static function buildMonthlyRestockTrend(Collection $restocks): array
    {
        $start = Carbon::now()->subMonths(5)->startOfMonth();
        $buckets = collect(range(0, 5))->mapWithKeys(function (int $offset) use ($start) {
            $month = $start->copy()->addMonths($offset);
            $label = $month->format('M Y');

            return [
                $label => 0,
            ];
        });

        $restocks->filter(function (Restock $restock) use ($start) {
            $reference = $restock->restock_date ?? $restock->created_at;

            return $reference && Carbon::parse($reference)->greaterThanOrEqualTo($start);
        })->each(function (Restock $restock) use (&$buckets) {
            $label = Carbon::parse($restock->restock_date ?? $restock->created_at)->format('M Y');
            if (! $buckets->has($label)) {
                return;
            }

            $buckets->put($label, $buckets->get($label) + (int) $restock->qty);
        });

        return $buckets->map(function (int $qty, string $label) {
            return [
                'label' => $label,
                'qty' => $qty,
            ];
        })->values()->toArray();
    }

    private static function buildBatchedIssueSummary(): array
    {
        if (! Schema::hasColumn('aggregated_issue_items', 'status')) {
            return [];
        }

        $summaries = AggregatedIssueItem::select(['status'])->get()->groupBy(function (AggregatedIssueItem $item) {
            return $item->status ?? 'Uncategorized';
        })->map->count();

        return $summaries->map(function (int $count, string $status) {
            return [
                'status' => ucfirst(str_replace(['_', '-'], ' ', strtolower($status))),
                'count' => $count,
            ];
        })->values()->toArray();
    }
}