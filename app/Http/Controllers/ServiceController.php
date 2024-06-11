<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Service;
use Auth;
use Illuminate\Support\Carbon;
class ServiceController extends Controller
{public function __construct()
    {
        $this->middleware('auth');
    }
    public function Index(){
        // $suppliers = Supplier::all();
        $suppliers = Service::latest()->get();
        return view('service.index',compact('suppliers'));
    }
    public function create(){
        // $suppliers = Supplier::all();
        return view('service.create');
    }
    public function store(Request $request){
        Service::insert([
            'service_name' => $request->service_name,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(), 
        ]);
         $notification = array(
            'message' => 'Service Inserted Successfully', 
            'alert-type' => 'success'
        );
        return redirect()->route('viewsupp')->with($notification);
    }
    public function Edit($id){
        $supplier = Service::findOrFail($id);
        return view('service.Edit',compact('supplier'));
    }
    public function update(Request $request){
        $sullier_id = $request->id;
        Service::findOrFail($sullier_id)->update([
            'service_name' => $request->service_name,
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now(), 
        ]);
         $notification = array(
            'message' => 'Service Updated Successfully', 
            'alert-type' => 'success'
        );
        return redirect()->route('viewsupp')->with($notification);
    }
    public function delete($id){
        Service::findOrFail($id)->delete();
        $notification = array(
             'message' => 'Service Deleted Successfully', 
             'alert-type' => 'success'
         );
         return redirect()->back()->with($notification);
 
     } // End Method 
}
