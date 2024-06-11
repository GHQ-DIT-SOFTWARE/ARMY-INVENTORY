<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\rank;
use App\Models\Service;
use Auth;
use DB;
use Illuminate\Support\Carbon;
class rankcontroller extends Controller
{
  public function __construct()
    {
        $this->middleware('auth');
    }

    public function View(){
      $rank= rank::latest()->get();
        return view('rank.index',compact('rank'));
      }

      public function RankAdd(){

          return view('rank.create');
      }
      public function Store(Request $request){
        rank::insert([
          'rank_name' => $request->rank_name,
          'created_by' => Auth::user()->id,
          'created_at' => Carbon::now(),
      ]);
       $notification = array(
          'message' => 'Rank Inserted Successfully',
          'alert-type' => 'success'
      );
      return redirect()->route('viewrank')->with($notification);
      }

      public function Edit($id){
        $rank = rank::findOrFail($id);

        return view('rank.edit',compact('rank'));
      }
      public function Update(Request $request,$id){
        $rank=rank::find($id);
        $rank->rank_name=$request->rank_name;
        $rank->updated_by = Auth::user()->id;
         $rank->save();
         $notification = array(
            'message' => 'Rank Updated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('viewrank')->with($notification);
      }
  public function Delete($id){
    rank::findOrFail($id)->delete();
    $notification = array(
         'message' => 'Rank Deleted Successfully',
         'alert-type' => 'success'
     );
     return redirect()->back()->with($notification);
  }
}
