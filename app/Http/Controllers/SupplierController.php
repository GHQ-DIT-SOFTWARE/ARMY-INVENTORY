<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class SupplierController extends Controller
{
    public $user;
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('web')->user();
            return $next($request);
        });
    }
    public function Index()
    {
        $suppliers = Supplier::latest()->get();
        return view('supplier.index', compact('suppliers'));
    }
    public function create()
    {
        return view('supplier.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'company_name' => ['required', Rule::unique('suppliers')],
            'mobile_no' => ['required', Rule::unique('suppliers')],
            'email' => ['required', Rule::unique('suppliers')],
            'address' => ['required', Rule::unique('suppliers')],
        ]);
        Supplier::create([
            'company_name' => $request->company_name,
            'mobile_no' => $request->mobile_no,
            'email' => $request->email,
            'address' => $request->address,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),
        ]);
        $notification = array(
            'message' => 'Supplier Inserted Successfully',
            'alert-type' => 'success',
        );
        return redirect()->route('viewsupp')->with($notification);
    }
    public function Edit($uuid)
    {
        $supplier = Supplier::where('uuid', $uuid)->first();
        if (!$supplier) {
            abort(404);
        }
        return view('supplier.Edit', compact('supplier'));
    }
    public function update(Request $request)
    {
        $sullier_id = $request->uuid;
        $supplier = Supplier::where('uuid', $sullier_id)->first();
        if (!$supplier) {
            abort(404);
        }
        $supplier->update([
            'company_name' => $request->company_name,
            'mobile_no' => $request->mobile_no,
            'email' => $request->email,
            'address' => $request->address,
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now(),
        ]);
        $notification = array(
            'message' => 'Supplier Updated Successfully',
            'alert-type' => 'success',
        );
        return redirect()->route('viewsupp')->with($notification);
    }
    public function delete($uuid)
    {
        $supplier = Supplier::where('uuid', $uuid)->first();
        if (!$supplier) {
            abort(404);
        }
        $supplier->delete();
        $notification = array(
            'message' => 'Supplier Deleted Successfully',
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);
    }
}
