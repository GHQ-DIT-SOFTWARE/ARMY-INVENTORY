<?php

namespace App\Http\Controllers;

use App\Imports\UnitsImport;
use App\Models\Unit;
use Auth;
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
        $units = Unit::latest()->get();
        return view('unit.index', compact('units'));
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
