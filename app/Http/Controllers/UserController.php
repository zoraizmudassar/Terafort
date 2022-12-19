<?php

namespace App\Http\Controllers;

use DB;
use Hash;
use Auth;    
use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Role;
use App\Models\UserDetail;
use App\Models\Objectives;
use App\Models\Department;
use App\Models\Designation;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function User(Request $request)
    {
        if(Auth::user()->role == 'Admin'){
            try{
                $department = Department::orderBy('name','ASC')->get();
                $designation = Designation::orderBy('name','ASC')->get();
                $role = Role::orderBy('name','ASC')->get();
                return view('user.user-create',compact('designation','department','role'));
            }
            catch(Exception $e){
                $notification = array(
                    'message' => $e->getMessage(),
                    'alert-type' => 'error'
                );
                return back()->with($notification);
            }
        }
        else{
            return $this->accessDenied();
        }
    }

    public function Create(Request $request)
    {
        if(Auth::user()->role == 'Admin'){
            try{
                $input = $request->all();
                $filename = "Profile.png";
                if($request->image){
                    $file = $request->file('image');
                    $extension = $file->getClientOriginalExtension(); 
                    $filename = time() . '.' . $extension;
                    $file->move('uploads/appsetting/', $filename);
                }
                Validator::make($input, [
                    'name' => ['required', 'string', 'max:15'],
                    'username' => ['required', 'string', 'max:15'],
                    'firstname' => ['required', 'string', 'max:10'],
                    'lastname' => ['required', 'string', 'max:10'],
                    'phone' => ['required'],
                    'department' => ['required'],
                    'designation' => ['required'],
                    'role' => ['required'],
                    'location' => ['location'],
                    'image' => ['required'],
                    'email' => ['required', 'string', 'email', 'max:30', 'unique:users'],
                    'password' => ['required', 'string', 'min:8', 'confirmed'],
                ]);        
                User::create([
                    'name' => $input['name'],
                    'username' => $input['username'],
                    'firstname' => $input['firstname'],
                    'lastname' => $input['lastname'],
                    'email' => $input['email'],
                    'phone' => $input['phone'],
                    'department' => $input['department'],
                    'designation' => $input['designation'],
                    'role' => $input['role'],
                    'location' => $input['location'],
                    'image' => $filename,
                    'password' => Hash::make($input['password']),
                ]);
                $notification = array(
                    'message' => 'User Created',
                    'alert-type' => 'success'
                );
                return redirect()->route('manage-user')->with($notification); 
            }
            catch(Exception $e){
                $notification = array(
                    'message' => $e->getMessage(),
                    'alert-type' => 'error'
                );
                return back()->with($notification);
            }
        }
        else{
            return $this->accessDenied();
        }
    }

    public function Display(Request $request)
    {
        if(Auth::user()->role == 'Admin'){
            try{
                $data = [];
                $id = Auth::user()->id;
                $data = User::orderBy('name','ASC')->where('id', '!=', auth()->id())->get();
                return view('user.user-manage',compact('data'))->with('i', 1);
            }
            catch(Exception $e){
                $notification = array(
                    'message' => $e->getMessage(),
                    'alert-type' => 'error'
                );
                return back()->with($notification);
            }
        }
        else{
            return $this->accessDenied();
        }
    }

    public function userEdit(Request $request)
    {
        if(Auth::user()->role == 'Admin'){
            try{
                $id = $request->id;
                $user = User::find($id);
                $role = Role::orderBy('name','ASC')->get();
                $department = Department::orderBy('name','ASC')->get();
                $designation = Designation::orderBy('name','ASC')->get();
                return view('user.user-edit',compact('id','user','role','department','designation'));
            }
            catch(Exception $e){
                $notification = array(
                    'message' => $e->getMessage(),
                    'alert-type' => 'error'
                );
                return back()->with($notification);
            }
        }
        else{
            return $this->accessDenied();
        }
    }

    public function Edituser(Request $request)
    {
        $current_date_time = Carbon::now()->toDateTimeString();
        if(Auth::user()->role == 'Admin'){
            try{
                $id = $request->id;
                $filename = "Profile.png";
                if($request->image){
                    $file = $request->file('image');
                    $extension = $file->getClientOriginalExtension(); 
                    $filename = time() . '.' . $extension;
                    $file->move('uploads/appsetting/', $filename);
                }
                if($request->image){
                    $data = array(
                        'name' => $request->name,
                        'username' => $request->username,
                        'firstname' => $request->firstname,
                        'lastname' => $request->lastname,
                        'email' => $request->email,
                        'department' => $request->department,            
                        'designation' => $request->designation,            
                        'role' => $request->role,
                        'image' => $filename,
                        'updated_at' => $current_date_time,
                    );
                }
                else{
                    $data = array(
                        'name' => $request->name,
                        'username' => $request->username,
                        'firstname' => $request->firstname,
                        'lastname' => $request->lastname,
                        'email' => $request->email,
                        'department' => $request->department,            
                        'designation' => $request->designation,            
                        'role' => $request->role,
                        'updated_at' => $current_date_time,
                    );
                }
                $update = User::where('id', $id)->update($data);
                if($update){
                    $notification = array(
                        'message' => 'User Updated!',
                        'alert-type' => 'success'
                    );
                }
                else{
                    $notification = array(
                        'message' => 'Something Went Wrong',
                        'alert-type' => 'error'
                    );
                }
                return redirect()->route('manage-user')->with($notification);
            }
            catch(Exception $e){
                $notification = array(
                    'message' => $e->getMessage(),
                    'alert-type' => 'error'
                );
                return back()->with($notification);
            }
        }
        else{
            return $this->accessDenied();
        }
    }

    public function userProfile(Request $request)
    {
        $id = Auth::user()->id;
        $result = User::where('id', $id)->first();
        return view('user.user-profile')->with(['data'=> $result]);
    }

    public function UpdateProfile(Request $request)
    {
        try{
            $filename = "Profile.png";
            if($request->image){
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension(); 
                $filename = time() . '.' . $extension;
                $file->move('uploads/appsetting/', $filename);
            }
            $rules = [
                'email' => ['required'],
                'PhoneNo' => ['required'],
            ];
            $validator = Validator::make($request->all(), $rules);
            $data = $request->input();
            $id = Auth::user()->id;
            if($request->image){
                $userDetail = array(
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'name' => $request->name,
                    'firstname' => $request->firstname,
                    'lastname' => $request->lastname,
                    'username' => $request->username,
                    'image' => $filename,
                );
            }
            else{
                $userDetail = array(
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'name' => $request->name,
                    'firstname' => $request->firstname,
                    'lastname' => $request->lastname,
                    'username' => $request->username,
                );
            }
            $userDetail = User::where('id', $id)->update($userDetail);
            if($userDetail){
                $notification = array(
                    'message' => 'Profile Updated',
                    'alert-type' => 'success'
                );
            return redirect()->route('profile')->with($notification);
            }
            else{
                $notification = array(
                    'message' => 'Operation Failed. Please try again!',
                    'alert-type' => 'error'
                );
                return back()->with($notification);
            }
        } 
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function Signupp(Request $request)
    {
        try{
            $request->validate([
                'email' => 'required',
                'password' => 'required'
            ]);
    
            $credentials = $request->except(['_token']);
            $user = User::where('email',$request->email)->orWhere('username',$request->email)->first();
            if($user){
                if($user->status == 1){
                    $fieldType = filter_var($request->email, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
                    if(auth()->attempt(array($fieldType => $request['email'], 'password' => $request['password']))){
                        return redirect()->route('home');
                }
                else{
                    $notification = array(
                        'message' => 'Invalid Credentials!',
                        'alert-type' => 'error'
                    );
                    return back()->with($notification);
                }
                }
                else{
                    if($user->status == 2){
                            $notification = array(
                                'message' => 'Your Account has been Deactive',
                                'alert-type' => 'warning'
                            );
                        }
                    elseif($user->status == 3){
                            $notification = array(
                                'message' => 'Your account has been Terminated',
                                'alert-type' => 'warning'
                            );
                        }
                    elseif($user->status == 4){
                            $notification = array(
                                'message' => 'Your account has been Deleted',
                                'alert-type' => 'warning'
                            );
                        }
                    return back()->with($notification);
                }
            }
            else{
                $notification = array(
                    'message' => 'Username not Found',
                    'alert-type' => 'error'
                );
            return redirect()->back()->with($notification);
            }
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function changePassword(Request $request) 
    {
        try{
            if(!(Hash::check($request->get('CurrentPassword'), Auth::user()->password))){
                return redirect()->back()->with("error","Your current password does not matches with the password.");
            }
            if(strcmp($request->get('CurrentPassword'), $request->get('Password')) == 0){
                return redirect()->back()->with("error1","New Password cannot be same as your current password.");
            }
            $user = Auth::user();
            $user->password = Hash::make($request->get('Password'));
            $user->save();
            if($user->save()){
                $notification = array(
                    'message' => 'Password changed!',
                    'alert-type' => 'success'
                );
                return redirect()->back()->with($notification);
            }
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function username($id)
    {
        try{
            $update = User::where('username', $id)->pluck('username');
            if(isset($update[0]) == $id){
                $value = 1;
                return response()->json($value);
            }
            else{
                $value = 2;
                return response()->json($value);
            }
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function email($id)
    {
        try{
            $update = User::where('email', $id)->pluck('email');
            if(isset($update[0]) == $id){
                $value = 1;
                return response()->json($value);
            }
            else{
                $value = 2;
                return response()->json($value);
            }
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function delete(Request $request, $id)
    {
        if(Auth::user()->role == 'Admin'){
            try{
                $users = User::where('id', $id)->update(['status' => 4]);
                if($users){
                    return response()->json($users);
                }
                else{
                    $error = 400;
                    return response()->json($error);
                }
            }
            catch(Exception $e){
                $notification = array(
                    'message' => $e->getMessage(),
                    'alert-type' => 'error'
                );
                return back()->with($notification);
            }
        }
        else{
            return $this->accessDenied();
        }
    }
}