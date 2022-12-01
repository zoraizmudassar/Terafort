<?php

namespace App\Http\Controllers;

use DB;
use Hash;
use Auth;    
use Exception;
use App\Models\User;
use App\Models\RoleName;
use App\Models\UserDetail;
use App\Models\Objectives;
use App\Models\Department;
use App\Models\Designation;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function masterData(Request $request)
    {
        if(Auth::user()->role == 'Admin'){
            try{
                $user = User::orderBy('id','DESC')->where('id', '!=', 1)->get();
                $department = Department::orderBy('id','DESC')->get();
                $designation = Designation::orderBy('id','DESC')->get();
                return view('admin.master-data',compact('user','department','designation'));
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

    public function addDepartment(Request $request)
    {
        if(Auth::user()->role == 'Admin'){
            try{
                $data = array([
                    'name' => $request->department,
                ]);
                $Add = Department::insert($data);
                if($Add){
                    $notification = array(
                        'message' => 'Department Added!',
                        'alert-type' => 'success'
                    );
                }
                else{
                    $notification = array(
                        'message' => 'Operation Failed',
                        'alert-type' => 'danger'
                    );
                }
                return redirect()->route('master-data')->with($notification); 
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

    public function addDesignation(Request $request)
    {
        if(Auth::user()->role == 'Admin'){
            try{
                $data = array([
                    'name' => $request->designation,
                ]);
                $Add = Designation::insert($data);
                if($Add){
                    $notification = array(
                        'message' => 'Designation Added!',
                        'alert-type' => 'success'
                    );
                }
                else{
                    $notification = array(
                        'message' => 'Operation Failed',
                        'alert-type' => 'danger'
                    );
                }
                return redirect()->route('master-data')->with($notification); 
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

    public function updateDepartment($value,$id)
    {
        if(Auth::user()->role == 'Admin'){
            try{
                $data = array(
                    'name' => $value,
                );
                $update = Department::where('id', $id)->update($data);
                if($update){
                    $notification = array(
                        'message' => 'Department Updated',
                        'alert-type' => 'success'
                    );
                }
                else{
                    $notification = array(
                        'message' => 'Operation Failed',
                        'alert-type' => 'danger'
                    );
                }
                return response()->json($notification);
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

    public function updateDesignation($value,$id)
    {
        if(Auth::user()->role == 'Admin'){
            try{
                $data = array(
                    'name' => $value,
                );
                $update = Designation::where('id', $id)->update($data);
                if($update){
                    $notification = array(
                        'message' => 'Designation Updated',
                        'alert-type' => 'success'
                    );
                }
                else{
                    $notification = array(
                        'message' => 'Operation Failed',
                        'alert-type' => 'danger'
                    );
                }
                return response()->json($notification);
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

    public function changePasswordAdmin(Request $request) 
    {
        if(Auth::user()->role == 'Admin'){
            try{
                $id = $request->name;
                $userData = array(
                    'password' => Hash::make($request->password)            
                );
        
                $save = User::where('id', $id)->update($userData);
                if($save){
                    $notification = array(
                        'message' => 'Password Changed!',
                        'alert-type' => 'success'
                    );
                    return back()->with($notification);
                }
                else{
                    $notification = array(
                        'message' => 'Operation Failed',
                        'alert-type' => 'danger'
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
        else{
            return $this->accessDenied();
        }
    }
    
    public function changeStatusAdmin(Request $request)
    {
        if(Auth::user()->role == 'Admin'){
            try{
                $id = $request->id;
                $userData = array(
                    'status' => $request->status          
                );
        
                $save = User::where('id', $id)->update($userData);
                if($save){
                    $notification = array(
                        'message' => 'Status Changed!',
                        'alert-type' => 'success'
                    );
                    return redirect()->back()->with($notification);
                }
                else{
                    $notification = array(
                        'message' => 'Operation Failed',
                        'alert-type' => 'danger'
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
        else{
            return $this->accessDenied();
        }
    }

    public function accessDenied()
    {
        $notification = array(
            'message' => 'Access Denied',
            'alert-type' => 'warning'
        );
        return back()->with($notification);
    }
}
