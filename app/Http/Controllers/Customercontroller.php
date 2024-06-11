<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Personnel;
use App\Models\rank;
use App\Models\Unit;
use App\Models\Service;
use Auth;
use Illuminate\Support\Carbon;
use Image; 


class personnelcontroller extends Controller
{
    public function index(){
        $pers = Personnel::latest()->get();
        return view('personnel.index',compact('pers'));
    }
    public function create(){
        $unit=Unit::all();
        $ranks=rank::all();
        $service=Service::all();
        return view('personnel.create',compact('unit','ranks','service'));
    }
    public function store(Request $request){
        $request->validate([
            'personnel_image' => 'required',  
              
        ]);
        $image = $request->file('personnel_image');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension(); // 343434.png
        Image::make($image)->resize(200,200)->save('upload/personnel/'.$name_gen);
        $save_url = 'upload/personnel/'.$name_gen;

        Personnel::insert([
            'unit_name' => $request->unit_name,
            'rank_name' => $request->rank_name,
            'service_name' => $request->service_name,
            'svcnumber' => $request->svcnumber,
            'surname' => $request->surname,
            'othernames' => $request->othernames,
            'mobile_no' => $request->mobile_no,
            'email' => $request->email,
            'gender' => $request->gender,
            'personnel_image' => $save_url ,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),
        ]);
         $notification = array(
            'message' => 'Personnel Inserted Successfully', 
            'alert-type' => 'success'
        );
        return redirect()->route('perview')->with($notification);
    }
    public function edit($id){
        $personel = Personnel::findOrFail($id);
        $unit=Unit::all();
        $ranks=rank::all();
        $service=Service::all();
        return view('personnel.edit',compact('personel','unit','ranks','service'));
    }
    public function update(Request $request){
        $personnel_id = $request->id;
        if ($request->file('personnel_image')) {
        $image = $request->file('personnel_image');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension(); // 343434.png
        Image::make($image)->resize(200,200)->save('upload/personnel/'.$name_gen);
        $save_url = 'upload/personnel/'.$name_gen;
        Personnel::findOrFail($personnel_id)->update([
            'unit_name' => $request->unit_name,
            'rank_name' => $request->rank_name,
            'service_name' => $request->service_name,
            'svcnumber' => $request->svcnumber,
            'surname' => $request->surname,
            'othernames' => $request->othernames,
            'mobile_no' => $request->mobile_no,
            'email' => $request->email,
            'gender' => $request->gender,
            'personnel_image' => $save_url ,
            'updated_by' => Auth::user()->id,
            'created_at' => Carbon::now(),
        ]);

         $notification = array(
            'message' => 'Personnel Updated with Image Successfully', 
            'alert-type' => 'success'
        );
        return redirect()->route('perview')->with($notification);   
        } else{

          Personnel::findOrFail($personnel_id)->update([
            'unit_name' => $request->unit_name,
            'rank_name' => $request->rank_name,
            'service_name' => $request->service_name,
            'svcnumber' => $request->svcnumber,
            'surname' => $request->surname,
            'othernames' => $request->othernames,
            'mobile_no' => $request->mobile_no,
            'email' => $request->email,
            'gender' => $request->gender,
            'personnel_image' => $save_url ,
            'updated_by' => Auth::user()->id,
            'created_at' => Carbon::now(),

        ]);
         $notification = array(
            'message' => 'Personnel Updated without Image Successfully', 
            'alert-type' => 'success'
        );

        return redirect()->route('perview')->with($notification);

        } // end else 

    } // End Method

public function delete($id){
        $personel = Personnel::findOrFail($id);
        $img = $personel->personnel_image;
        unlink($img);
        Personnel::findOrFail($id)->delete();
        $notification = array(
            'message' => 'Customer Deleted Successfully', 
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);

    } // End Method

  
}
