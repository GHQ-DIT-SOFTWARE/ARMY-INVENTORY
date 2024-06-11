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
        $ranks=rank::all();
        return view('personnel.create',compact('ranks'));
    }
    public function store(Request $request){
        $request->validate([
            'svcnumber' => 'required',
            'othernames' => 'required',
            'email' => 'required',
            'mobile_no' => 'required'
        ]);
        Personnel::insert([
            'rank_name' => $request->rank_name,
            'svcnumber' => $request->svcnumber,
            'surname' => $request->surname,
            'othernames' => $request->othernames,
            'mobile_no' => $request->mobile_no,
            'email' => $request->email,
            'gender' => $request->gender,
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
        $ranks=rank::all();
        return view('personnel.edit',compact('personel','ranks'));
    }
    public function update(Request $request){
        $personnel_id = $request->id;
        Personnel::findOrFail($personnel_id)->update([
            'rank_name' => $request->rank_name,
            'svcnumber' => $request->svcnumber,
            'surname' => $request->surname,
            'othernames' => $request->othernames,
            'mobile_no' => $request->mobile_no,
            'email' => $request->email,
            'gender' => $request->gender,
            'updated_by' => Auth::user()->id,
            'created_at' => Carbon::now(),
        ]);
         $notification = array(
            'message' => 'Personnel Updated  Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('perview')->with($notification);
        }


public function delete($id){

        Personnel::findOrFail($id)->delete();
        $notification = array(
            'message' => 'Personnel Deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);

    } // End Method


}
