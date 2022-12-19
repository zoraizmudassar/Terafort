<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Exception;
use App\Models\User;
use App\Models\Newrole;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{   
    public function roleCreate()
    {
        try{
            return view('role.role-create');
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function roleManage(Request $request)
    {
        try{
            $data = Role::orderBy('name','ASC')->get();
            return view('role.role-manage')->with(['data' => $data]);
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function roleManagew(Request $request)
    {
        try{
            $userRoles = RoleName::orderBy('id','DESC')->get();
            return view('role.manage-rolee')->with(['data' => $userRoles]);
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function ajax(Request $request, $id)
    {
        try{
            $role = DB::table("permissions")->where("role_name", $id)->where("role_head","Role")->get();
            $user = DB::table("permissions")->where("role_name", $id)->where("role_head","User")->get();
            $others = DB::table("permissions")->where("role_name", $id)->where("role_head","Others")->get();
            $users = User::where('id', '!=', auth()->id())->orderBy('id','DESC')->get();
            $array = array(
                'id' => $id, 'user' => $user, 'role' => $role, 'others' => $others,
            );
            return response()->json($array); 
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function roleManageAjax(Request $request)
    {
        try{
            $Userdata = [];
            $RoleName = [];
            $Roledata = [];
            $Otherdata = [];
            $name = $request->name;
            $id = Auth::user()->id;
            $Role = array("Role List" => 0, "Role Create" => 0, "Role Edit" => 0, "Role Delete" => 0);
            $User = array("User List" => 0, "User Create" => 0, "User Edit" => 0, "User Delete" => 0);
            $Others = array("Employee" => 0, "Admin" => 0,"Support Administrator" => 0);
    
            if($request->Others != NULL){
                for($i=0; $i<count($request->Others); $i++){ 
                    if($request['Others'][$i] == "Employee") $Others['Employee'] = 1;
                    if($request['Others'][$i] == "Admin") $Others['Admin'] = 1;
                    if($request['Others'][$i] == "Support Administrator") $Others['Support Administrator'] = 1;
                }
            }
            else{
                $Otherss = array("Employee", "Admin", "Support Administrator");
            }
    
            if($request->Role != NULL){
                for($i=0; $i<count($request->Role); $i++){ 
                    if($request['Role'][$i] == "Role List") $Role['Role List'] = 1;
                    if($request['Role'][$i] == "Role Create") $Role['Role Create'] = 1;
                    if($request['Role'][$i] == "Role Edit") $Role['Role Edit'] = 1;
                    if($request['Role'][$i] == "Role Delete") $Role['Role Delete'] = 1;
                }
            }
            else{
                $Rolee = array("Role-List", "Role-Create", "Role-Edit", "Role-Delete");
            }
    
            if($request->User != NULL){
                for($i=0; $i<count($request->User); $i++){ 
                    if($request['User'][$i] == "User List") $User['User List'] = 1;
                    if($request['User'][$i] == "User Create") $User['User Create'] = 1;
                    if($request['User'][$i] == "User Edit") $User['User Edit'] = 1;
                    if($request['User'][$i] == "User Delete") $User['User Delete'] = 1;
                }
            }
            else{
                $Userr = array("User List", "User Create", "User Edit", "User Delete");
            }
    
            if($request->Others != NULL){
                foreach($Others as $data => $key){
                    $Otherdata[] = [
                        'role_name' => $name,
                        'permission_name' => $data,
                        'permission_value' => $key,
                        'role_head' => "Others",
                    ];
                }
            }
            else{
                for($i=0; $i<3; $i++){
                    $Otherdata[] = [
                        'role_name' => $name,
                        'permission_name' => $Otherss[$i],
                        'permission_value' => 0,
                        'role_head' => "Others",
                    ];
                }            
            }
    
            if($request->Role != NULL){
                foreach($Role as $data => $key){
                    $Roledata[] = [
                        'role_name' => $name,
                        'permission_name' => $data,
                        'permission_value' => $key,
                        'role_head' => "Role",
                    ];
                }
            }
            else{
                for($i=0; $i<4; $i++){
                    $Roledata[] = [
                        'role_name' => $name,
                        'permission_name' => $Rolee[$i],
                        'permission_value' => 0,
                        'role_head' => "Role",
                    ];
                }            
            }
    
            if($request->User != NULL){
                foreach($User as $data => $key){
                    $Userdata[] = [
                        'role_name' => $name,
                        'permission_name' => $data,
                        'permission_value' => $key,
                        'role_head' => "User",
                    ];
                }
            }
            else{
                for($i=0; $i<4; $i++){
                    $Userdata[] = [
                        'role_name' => $name,
                        'permission_name' => $Userr[$i],
                        'permission_value' => 0,
                        'role_head' => "User",
                    ];
                }            
            }
    
            $RoleName[] = [
                'name' => $name,
            ];
                
            Permission::where('role_name', $name)->delete();
            Role::where('name', $name)->delete();
            Permission::insert($Userdata);
            Permission::insert($Roledata);
            Permission::insert($Otherdata);
            Role::insert($RoleName);
            $notification = array(
                'message' => 'Roles Updated',
                'alert-type' => 'success'
            );
            return redirect()->route('role-manage-new')->with($notification);
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function createRole(Request $request)
    {
        try{
            $Userdata = [];
            $RoleName = [];
            $Roledata = [];
            $Otherdata = [];
            $name = $request->name;
            $id = Auth::user()->id;
            $Role = array("Role List" => 0, "Role Create" => 0, "Role Edit" => 0, "Role Delete" => 0);
            $User = array("User List" => 0, "User Create" => 0, "User Edit" => 0, "User Delete" => 0);
            $Others = array("Employee" => 0, "Admin" => 0, "Support Administrator (LHR)" => 0, "Support Administrator (ISB)" => 0);
    
            if($request->Others != NULL){
                for($i=0; $i<count($request->Others); $i++){ 
                    if($request['Others'][$i] == "Employee") $Others['Employee'] = 1;
                    if($request['Others'][$i] == "Admin") $Others['Admin'] = 1;
                    if($request['Others'][$i] == "Support Administrator (LHR)") $Others['Support Administrator (LHR)'] = 1;
                    if($request['Others'][$i] == "Support Administrator (ISB)") $Others['Support Administrator (ISB)'] = 1;
                }
            }
            else{
                $Otherss = array("Employee", "Admin", "Support Administrator", "Support Administrator (LHR)", "Support Administrator (ISB)");
            }
    
            if($request->Role != NULL){
                for($i=0; $i<count($request->Role); $i++){ 
                    if($request['Role'][$i] == "Role List") $Role['Role List'] = 1;
                    if($request['Role'][$i] == "Role Create") $Role['Role Create'] = 1;
                    if($request['Role'][$i] == "Role Edit") $Role['Role Edit'] = 1;
                    if($request['Role'][$i] == "Role Delete") $Role['Role Delete'] = 1;
                }
            }
            else{
                $Rolee = array("Role-List", "Role-Create", "Role-Edit", "Role-Delete");
            }
    
            if($request->User != NULL){
                for($i=0; $i<count($request->User); $i++){ 
                    if($request['User'][$i] == "User List") $User['User List'] = 1;
                    if($request['User'][$i] == "User Create") $User['User Create'] = 1;
                    if($request['User'][$i] == "User Edit") $User['User Edit'] = 1;
                    if($request['User'][$i] == "User Delete") $User['User Delete'] = 1;
                }
            }
            else{
                $Userr = array("User List", "User Create", "User Edit", "User Delete");
            }
    
            if($request->Others != NULL){
                foreach($Others as $data => $key){
                    $Otherdata[] = [
                        'role_name' => $name,
                        'permission_name' => $data,
                        'permission_value' => $key,
                        'role_head' => "Others",
                    ];
                }
            }
            else{
                for($i=0; $i<4; $i++){
                    $Otherdata[] = [
                        'role_name' => $name,
                        'permission_name' => $Otherss[$i],
                        'permission_value' => 0,
                        'role_head' => "Others",
                    ];
                }            
            }
    
            if($request->Role != NULL){
                foreach($Role as $data => $key){
                    $Roledata[] = [
                        'role_name' => $name,
                        'permission_name' => $data,
                        'permission_value' => $key,
                        'role_head' => "Role",
                    ];
                }
            }
            else{
                for($i=0; $i<4; $i++){
                    $Roledata[] = [
                        'role_name' => $name,
                        'permission_name' => $Rolee[$i],
                        'permission_value' => 0,
                        'role_head' => "Role",
                    ];
                }            
            }
    
            if($request->User != NULL){
                foreach($User as $data => $key){
                    $Userdata[] = [
                        'role_name' => $name,
                        'permission_name' => $data,
                        'permission_value' => $key,
                        'role_head' => "User",
                    ];
                }
            }
            else{
                for($i=0; $i<4; $i++){
                    $Userdata[] = [
                        'role_name' => $name,
                        'permission_name' => $Userr[$i],
                        'permission_value' => 0,
                        'role_head' => "User",
                    ];
                }            
            }
    
            $RoleName[] = [
                'name' => $name,
            ];
    
            // Permission::where('name', $name)->delete();
            Permission::insert($Userdata);
            Permission::insert($Roledata);
            Permission::insert($Otherdata);
            Role::insert($RoleName);
            $notification = array(
                'message' => 'Roles Created!',
                'alert-type' => 'success'
            );
            return redirect()->route('role-manage-new')->with($notification);
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function role($id)
    {
        try{
            $update = Role::where('name', $id)->pluck('name');
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
}