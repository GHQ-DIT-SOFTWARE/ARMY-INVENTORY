<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Session;
class ProfileController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }

    public function ProfileView(){
    	$id = Auth::user()->id;
    	$user = User::find($id);
        return view('usermanage.user_profile',compact('user'));
    }
    public function ProfileEdit(){
        $id = Auth::user()->id;
    	$editData = User::find($id);
return view('usermanage.edit_profile',compact('editData'));
    }
    public function ProfileStore(Request $request){
        $data = User::find(Auth::user()->id);
    	$data->name = $request->name;
    	$data->email = $request->email;
    	$data->gender = $request->gender;
    	if ($request->file('image')) {
    		$file = $request->file('image');
    		@unlink(public_path('upload/user_images/'.$data->image));
    		$filename = date('YmdHi').$file->getClientOriginalName();
    		$file->move(public_path('upload/user_images'),$filename);
    		$data['image'] = $filename;
    	}
    	$data->save();
    	$notification = array(
    		'message' => 'User Profile Updated Successfully',
    		'alert-type' => 'success'
    	);
    	return redirect()->route('profileview')->with($notification);
    }

    public function PasswordView(){
        return view('usermanage.edit_password');
    }
    /*
    public function PasswordUpdate(Request $request){
        $validatedData = $request->validate([
    		'oldpassword' => 'required',
    		'password' => 'required|confirmed',
    	]);

    	$hashedPassword = Auth::user()->password;
    	if (Hash::check($request->oldpassword,$hashedPassword)) {
    		$user = User::find(Auth::id());
    		$user->password = Hash::make($request->password);
    		$user->save();
    		Auth::logout();
    		return redirect()->route('login');
    	}else{
    		return redirect()->back();
    	}
    }
    */

    public function PasswordUpdate(Request $request)
{
    $validatedData = $request->validate([
        'oldpassword' => 'required',
        'password' => 'required|confirmed',
    ]);

    $hashedPassword = Auth::user()->password;
    if (Hash::check($request->oldpassword, $hashedPassword)) {
        $user = User::find(Auth::id());
        // Logging the logout activity
        $name = $user->name;
        $email = $user->email;
        $dt = Carbon::now();
        $todayDate = $dt->toDayDateTimeString();
        $activityLog = [
            'name' => $name,
            'email' => $email,
            'description' => 'has logged out',
            'date_time' => $todayDate,
        ];
        DB::table('activity_logs')->insert($activityLog);
        // Updating the password and logging out
        $user->password = Hash::make($request->password);
        $user->is_logged_in = 0;
        $user->save();
        Auth::logout();

        return redirect()->route('login')->with('success', 'Password changed successfully. Please login again.');
    } else {
        return redirect()->back()->withErrors(['oldpassword' => 'Incorrect old password.']);
    }
}

}
