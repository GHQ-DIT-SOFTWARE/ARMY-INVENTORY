<?php

namespace App\Http\Controllers;

use App\Imports\UnitsImport;
use App\Models\Unit;
use App\Models\IssueItemOut;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class UnitController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function import(Request $request)
    {
        Excel::import(new UnitsImport, $request->file('file'));
        $notification = [
            'message' => 'Imported Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->back()->with($notification);
    }

    public function View()
    {
        $unitQuery = Unit::orderBy('unit_name');
        $units = $unitQuery->paginate(15)->withQueryString();

        $issuesByUnit = collect();
        if (Schema::hasTable('issue_item_outs')) {
            $issuesByUnit = IssueItemOut::select('unit_id', DB::raw('COUNT(*) as active_count'), DB::raw('SUM(qty) as total_qty'))
                ->whereNotNull('unit_id')
                ->where('status', 0)
                ->groupBy('unit_id')
                ->get()
                ->keyBy('unit_id');
        }

        $units->getCollection()->transform(function ($unit) use ($issuesByUnit) {
            $stats = $issuesByUnit->get($unit->id);
            $unit->active_issue_count = $stats->active_count ?? 0;
            $unit->active_issue_qty = $stats->total_qty ?? 0;
            return $unit;
        });

        $summary = [
            'totalUnits' => Unit::count(),
            'activeUnits' => Schema::hasTable('issue_item_outs')
                ? Unit::whereIn('id', $issuesByUnit->keys())->count()
                : 0,
            'totalItemsIssued' => $issuesByUnit->sum('total_qty'),
        ];

        return view('unit.index', compact('units', 'summary'));
    }

    public function Add()
    {
        return view('unit.create');
    }

    public function Store(Request $request)
    {
        Unit::create([
            'unit_name' => $request->unit_name,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),
        ]);

        $notification = [
            'message' => 'Unit Inserted Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('view-unit')->with($notification);
    }

    public function Edit($uuid)
    {
        $unit = Unit::where('uuid', $uuid)->first();
        if (!$unit) {
            abort(404);
        }

        // $unit = Unit::findOrFail($id);
        return view('unit.edit', compact('unit'));
    }

    public function Update(Request $request, $uuid)
    {
        $unit = Unit::where('uuid', $uuid)->first();
        if (!$unit) {
            abort(404);
        }
        $unit->unit_name = $request->unit_name;
        $unit->updated_by = Auth::user()->id;
        $unit->save();
        $notification = [
            'message' => 'Unit Updated Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('view-unit')->with($notification);
    }

    public function Delete($uuid)
    {
        $unit = Unit::where('uuid', $uuid)->first();
        if (!$unit) {
            abort(404);
        }
        $unit->delete();
        $notification = [
            'message' => 'Unit Deleted Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->back()->with($notification);
    }
}
