<?php

namespace App\Http\Controllers;

use App\Imports\ImportPersonnel;
use App\Models\Personnel;
use App\Models\rank;
use App\Models\Service;
use App\Models\Unit;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Image;
use Maatwebsite\Excel\Facades\Excel;

class personnelcontroller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // $pers = Personnel::latest()->get();
        return view('personnel.index');
    }

    public function create()
    {
        $unit = Unit::all();
        $ranks = rank::all();
        $service = Service::all();

        return view('personnel.create', compact('unit', 'ranks', 'service'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'personnel_image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'svcnumber' => ['required', 'unique:personnels,svcnumber'],
            'surname' => 'required',
            'othernames' => 'required',
            'mobile_no' => 'required|digits:10',
        ]);
        $save_url = null;
        if ($request->hasFile('personnel_image')) {
            $image = $request->file('personnel_image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(200, 200)->save('upload/personnel/' . $name_gen);
            $save_url = 'upload/personnel/' . $name_gen;
        }
        $firstLetterFirstName = substr($request->first_name, 0, 1);
        $firstLettersOthernames = '';

        if (!empty($request->othernames)) {
            $othernames = explode(' ', $request->othernames);

            foreach ($othernames as $othername) {
                $firstLettersOthernames .= substr($othername, 0, 1);
            }
        }
        $initials = strtoupper($firstLetterFirstName . $firstLettersOthernames) . ' ' . strtoupper($request->surname);
        Personnel::create([
            'unit_name' => $request->unit_name,
            'rank_id' => $request->rank_id,
            'arm_of_service' => $request->arm_of_service,
            'svcnumber' => $request->svcnumber,
            'surname' => $request->surname,
            'first_name' => $request->first_name,
            'othernames' => $request->othernames,
            'initial' => $initials,
            'mobile_no' => $request->mobile_no,
            'email' => $request->email,
            'gender' => $request->gender,
            'height' => $request->height,
            'blood_group' => $request->blood_group,
            'virtual_mark' => $request->virtual_mark,
            'service_category' => $request->service_category,
            'personnel_image' => $save_url,
            'created_by' => Auth::user()->id,
            'created_at' => now(),
        ]);
        $notification = [
            'message' => 'Personnel Inserted Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->route('personal-view')->with($notification);
    }

    public function edit($uuid)
    {
        $personel = Personnel::where('uuid', $uuid)->first();
        if (!$personel) {
            abort(404);
        }
        $unit = Unit::all();
        $ranks = rank::all();
        $service = Service::all();
        return view('personnel.edit', compact('personel', 'unit', 'ranks', 'service'));
    }

    public function update(Request $request)
    {
        $uuid = $request->uuid;
        // Calculate initials
        $firstLetterFirstName = substr($request->first_name, 0, 1);
        $firstLettersOthernames = '';
        if (!empty($request->othernames)) {
            $othernames = explode(' ', $request->othernames);

            foreach ($othernames as $othername) {
                $firstLettersOthernames .= substr($othername, 0, 1);
            }
        }
        $initials = strtoupper($firstLetterFirstName . $firstLettersOthernames) . ' ' . strtoupper($request->surname);
        // Prepare update data
        $updateData = [
            'unit_id' => $request->unit_id,
            'rank_id' => $request->rank_id,
            'arm_of_service' => $request->arm_of_service,
            'svcnumber' => $request->svcnumber,
            'surname' => $request->surname,
            'first_name' => $request->first_name,
            'othernames' => $request->othernames,
            'initial' => $initials,
            'mobile_no' => $request->mobile_no,
            'email' => $request->email,
            'gender' => $request->gender,
            'height' => $request->height,
            'virtual_mark' => $request->virtual_mark,
            'blood_group' => $request->blood_group,
            'service_category' => $request->service_category,
            'updated_by' => Auth::user()->id,
            'created_at' => Carbon::now(),
        ];
        // Check if a new image is uploaded
        if ($request->hasFile('personnel_image')) {
            $image = $request->file('personnel_image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(200, 200)->save('upload/personnel/' . $name_gen);
            $save_url = 'upload/personnel/' . $name_gen;
            $updateData['personnel_image'] = $save_url;
        }
        $updateDat = Personnel::where('uuid', $uuid)->firstOrFail();
        // Retain existing image if no new image is uploaded
        if (!$request->hasFile('personnel_image')) {
            unset($updateData['personnel_image']);
        }
        $updateDat->update($updateData);
        $notification = [
            'message' => $request->hasFile('personnel_image')
            ? 'Personnel Updated with Image Successfully'
            : 'Personnel Updated Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->route('personal-view')->with($notification);
    }

//     public function update(Request $request)
// {
//     $uuid = $request->uuid;

//     // Calculate initials
//     $firstLetterFirstName = substr($request->first_name, 0, 1);
//     $firstLettersOthernames = '';
//     if (!empty($request->othernames)) {
//         $othernames = explode(' ', $request->othernames);
//         foreach ($othernames as $othername) {
//             $firstLettersOthernames .= substr($othername, 0, 1);
//         }
//     }
//     $initials = strtoupper($firstLetterFirstName . $firstLettersOthernames) . ' ' . strtoupper($request->surname);

//     // Prepare update data for Personnel
//     $updateData = [
//         'unit_id' => $request->unit_id,
//         'rank_id' => $request->rank_id,
//         'arm_of_service' => $request->arm_of_service,
//         'svcnumber' => $request->svcnumber,
//         'surname' => $request->surname,
//         'first_name' => $request->first_name,
//         'othernames' => $request->othernames,
//         'initial' => $initials,
//         'mobile_no' => $request->mobile_no,
//         'email' => $request->email,
//         'gender' => $request->gender,
//         'height' => $request->height,
//         'virtual_mark' => $request->virtual_mark,
//         'service_category' => $request->service_category,
//         'updated_by' => Auth::user()->id,
//         'created_at' => Carbon::now(),
//     ];

//     // Check if a new image is uploaded
//     if ($request->hasFile('personnel_image')) {
//         $image = $request->file('personnel_image');
//         $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
//         Image::make($image)->resize(200, 200)->save('upload/personnel/' . $name_gen);
//         $save_url = 'upload/personnel/' . $name_gen;
//         $updateData['personnel_image'] = $save_url;
//     }

//     // Update the Personnel record
//     $personnel = Personnel::where('uuid', $uuid)->firstOrFail();
//     $personnel->update($updateData);

//     // If the image is updated, update associated records in GafMissionRecord
//     if ($request->hasFile('personnel_image')) {
//         GafMissionRecord::where('svcnumber', $request->svcnumber)
//             ->update(['personnel_image' => $save_url]);
//     }

//     $notification = [
//         'message' => $request->hasFile('personnel_image')
//             ? 'Personnel Updated with Image Successfully'
//             : 'Personnel Updated Successfully',
//         'alert-type' => 'success',
//     ];
//     return redirect()->route('personal-view')->with($notification);
// }

    public function delete($uuid)
    {
        $personel = Personnel::where('uuid', $uuid)->first();
        if (!$personel) {
            abort(404);
        }
        $personel->delete();
        $notification = [
            'message' => 'Deleted Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->back()->with($notification);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,xls,xlsx',
        ]);
        Excel::import(new ImportPersonnel, $request->file('file'));
        $notification = [
            'message' => 'Imported Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->back()->with($notification);
    }

    public function downloadSampleExcel()
    {
        // $filePath = storage_path('app/public/sample_excel/personnel.csv');
        // return response()->download($filePath, 'personnel.csv');
        // $file_path = public_path('sample_excel/personnel.csv');
        // $file_name = 'personnel.csv';
        // return response()->download($file_path, $file_name);

        $path = Storage::path('personnel.csv');

        return response()->file($path);
    }
}
