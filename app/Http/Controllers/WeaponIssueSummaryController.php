<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Armory;
use App\Models\WeaponIssueLog;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;

class WeaponIssueSummaryController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:weapons.view');
    }

    public function __invoke(): View
    {
        $now = Carbon::now();
        $startOfMonth = (clone $now)->startOfMonth();

        $metrics = [
            'totalIssued' => WeaponIssueLog::count(),
            'currentlyIssued' => WeaponIssueLog::whereNull('returned_at')->count(),
            'returnedThisMonth' => WeaponIssueLog::whereNotNull('returned_at')
                ->whereBetween('returned_at', [$startOfMonth, $now])
                ->count(),
            'overdue' => WeaponIssueLog::whereNull('returned_at')
                ->whereNotNull('expected_return_at')
                ->where('expected_return_at', '<', $now)
                ->count(),
        ];

        $armoryBreakdown = WeaponIssueLog::query()
            ->leftJoin('armories', 'armories.id', '=', 'weapon_issue_logs.armory_id')
            ->selectRaw("COALESCE(armories.name, 'Unassigned') as armory, COUNT(*) as total")
            ->whereNull('weapon_issue_logs.returned_at')
            ->groupBy('armory')
            ->orderByDesc('total')
            ->get();

        $activeIssues = WeaponIssueLog::with([
            'inventory.weapon',
            'armory',
            'issuer',
        ])
            ->whereNull('returned_at')
            ->latest('issued_at')
            ->get();

        return view('weapons.issues.summary', [
            'metrics' => $metrics,
            'armoryBreakdown' => $armoryBreakdown,
            'activeIssues' => $activeIssues,
        ]);
    }
}

