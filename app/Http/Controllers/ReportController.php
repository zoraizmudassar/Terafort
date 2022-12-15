<?php

namespace App\Http\Controllers;

use DB;
use Hash;
use Auth;
use Exception;
use App\Exports\Transfer;
use App\Exports\Helpdesk;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\User;
use App\Models\Complaint;
use App\Models\Department;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller
{
    public function Helpdesk(Request $request)
    {
        try{
            $departments = Department::orderBy('name','ASC')->get();
            $user = User::orderBy('name','ASC')->get();
            $permission = 0;
            return view('report.helpdesk',compact('departments','user','permission'));
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function HelpdeskReportDisplay(Request $request)
    {      
        try{
            $permission = 1;
            $present = array();
            $complaint = array();
            $sessionData = array();
            $complaintData = array();
            $Storedepartment = $request->department;
            $Storeuser = $request->user;
            if($Storeuser != "All"){
               $name = User::orderBy('name','ASC')->where('id',$Storeuser)->pluck('name');
            }
            $Storestatus = $request->status;
            $Storedaterange = $request->daterange;
            $daterange = str_replace(" - ", "", $request['daterange']);
            $start = date("Y-m-d", strtotime(substr($Storedaterange, 0,10)));
            $end = date("Y-m-d", strtotime(substr($Storedaterange, -10)));
            $user = User::orderBy('name','ASC')->get();
            $departments = Department::orderBy('name','ASC')->get();
            $data = User::orderBy('id','DESC')->where('department', $request->department)->pluck('id');         
            if($request->department == 'none' || $request->department == 'All' && $request->status == null && $request->user != 'none'){
                $usernName = User::orderBy('name','ASC')->where('id', $request->user)->pluck('emp_name');
                $Storeuser = $usernName[0];
                $Storedepartment = "-";
                $complaint = Complaint::orderBy('id','DESC')->whereBetween('created_at', [$start, $end])->where('user', $request->user)->get();
            }   
            elseif($request->department == 'none' || $request->department == 'All' && $request->status == null && $request->user == 'none'){
                $complaint = Complaint::orderBy('id','DESC')->whereBetween('created_at', [$start, $end])->get();
            }   
            elseif($request->department == 'All' && $request->status != null && $request->user != 'none'){
                $complaint = Complaint::orderBy('id','DESC')->where('user', $request->user)->where('status', $request->status)->whereBetween('created_at', [$start, $end])->get();
            }
            elseif($request->department == null || $request->department == 'All' && $request->user == 'none' && $request->status != null){
                $Storeuser = "-";
                $complaint = Complaint::orderBy('id','DESC')->where('status', $request->status)->whereBetween('created_at', [$start, $end])->get();
            }
            elseif($request->department != 'All' && $request->status != null){
                $Storedepartment = $request->department;
                $Storeuser = "-";
                foreach($data as $key){
                    $dataComplaint = Complaint::orderBy('id','DESC')->where('user', $key)->where('status', $request->status)->whereBetween('created_at', [$start, $end])->get();
                    if(count($dataComplaint)>0){
                        $present[] = $dataComplaint;        
                    }
                }
                for($z=0; $z<count($present); $z++){
                    foreach($present[$z] as $data){
                        $support[] = $data; 
                    }
                }
            }
            elseif($request->department != 'All' && $request->user != null && $request->user != 'All'){
                $complaint = Complaint::orderBy('id','DESC')->where('user', $request->user)->whereBetween('created_at', [$start, $end])->get();
            }
            elseif($request->department != 'All' && $request->user == 'All'){
                $Storeuser = "-";
                foreach($data as $key){
                    $dataComplaint = Complaint::orderBy('id','DESC')->where('user', $key)->whereBetween('created_at', [$start, $end])->get();
                    if(count($dataComplaint)>0){
                        $present[] = $dataComplaint;        
                    }
                }
                for($z=0; $z<count($present); $z++){
                    foreach($present[$z] as $data){
                        $complaint[] = $data; 
                    }
                }
            }
            elseif($request->department != 'All'){
                foreach($data as $key){
                    if($request->status != null){
                        $result = Complaint::orderBy('id','DESC')->where('user', $key)->where('status', $request->status)->whereBetween('created_at', [$start, $end])->get();
                    }   
                    else{
                        $result = Complaint::orderBy('id','DESC')->where('user', $key)->whereBetween('created_at', [$start, $end])->get();
                    }            
                    if(count($result)>0){
                        $present[] = $result;        
                    }
                }
                for($z=0; $z<count($present); $z++){
                    foreach($present[$z] as $data){
                        $complaint[] = $data; 
                    }
                }
            }
            else{
                $complaint = Complaint::orderBy('id','DESC')->get();
            }
            if(!empty($complaint)){
                foreach($complaint as $data){
                    $department = User::orderBy('id','DESC')->limit(1)->where('id', $data['user'])->get();
                    if(isset($department[0])){
                        $complaintData[] = [
                            'department' => $department[0]->department,
                            'name' => $department[0]->name,
                            'data' => $data
                        ]; 
                    }
                }
            }
            $strtdte2a = date("m/d/Y", strtotime(substr($daterange, 0,10)));
            $strtdte3a = date("m/d/Y", strtotime(substr($daterange, 10)));
            $sessionData = [
                'department' => $Storedepartment,
                'user' => $Storeuser,
                'status' => $Storestatus,
                'start' => $start,
                'end' => $end,
                'strtdte2a' => $strtdte2a,
                'strtdte3a' => $strtdte3a,
                'Storestart' => date("d-M-Y", strtotime(substr($Storedaterange, 0,10))),
                'Storeend' => date("d-M-Y", strtotime(substr($Storedaterange, -10))),
            ];
            return view('report.helpdesk',compact('departments','user','permission','complaintData','sessionData'));
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function HelpdeskReportDownload(Request $request)
    {   
        try{
            $permission = 1;
            $present = array();
            $complaint = array();
            $sessionData = array();
            $complaintData = array();
            $Storedepartment = $request->department;
            $Storeuser = $request->user;
            $Storestatus = $request->status;
            $Storedaterange = $request->daterange;
            $start = date("Y-m-d", strtotime(substr($Storedaterange, 0,10)));
            $end = date("Y-m-d", strtotime(substr($Storedaterange, -10)));
            $user = User::orderBy('name','ASC')->get();
            $departments = Department::orderBy('name','ASC')->get();
            $data = User::orderBy('id','DESC')->where('department', $request->department)->pluck('id');         
            if($request->department == 'none' || $request->department == 'All' && $request->status == null && $request->user != 'none'){
                $usernName = User::orderBy('name','ASC')->where('id', $request->user)->pluck('emp_name');
                $Storeuser = $usernName[0];
                $Storedepartment = "-";
                $complaint = Complaint::orderBy('id','DESC')->whereBetween('created_at', [$start, $end])->where('user', $request->user)->get();
            }   
            elseif($request->department == 'none' || $request->department == 'All' && $request->status == null && $request->user == 'none'){
                $complaint = Complaint::orderBy('id','DESC')->whereBetween('created_at', [$start, $end])->get();
            }   
            elseif($request->department == 'All' && $request->status != null && $request->user != 'none'){
                $complaint = Complaint::orderBy('id','DESC')->where('user', $request->user)->where('status', $request->status)->whereBetween('created_at', [$start, $end])->get();
            }
            elseif($request->department == null || $request->department == 'All' && $request->user == 'none' && $request->status != null){
                $Storeuser = "-";
                $complaint = Complaint::orderBy('id','DESC')->where('status', $request->status)->whereBetween('created_at', [$start, $end])->get();
            }
            elseif($request->department != 'All' && $request->status != null){
                $Storedepartment = $request->department;
                $Storeuser = "-";
                foreach($data as $key){
                    $dataComplaint = Complaint::orderBy('id','DESC')->where('user', $key)->where('status', $request->status)->whereBetween('created_at', [$start, $end])->get();
                    if(count($dataComplaint)>0){
                        $present[] = $dataComplaint;        
                    }
                }
                for($z=0; $z<count($present); $z++){
                    foreach($present[$z] as $data){
                        $support[] = $data; 
                    }
                }
            }
            elseif($request->department != 'All' && $request->user != null && $request->user != 'All'){
                $complaint = Complaint::orderBy('id','DESC')->where('user', $request->user)->whereBetween('created_at', [$start, $end])->get();
            }
            elseif($request->department != 'All' && $request->user == 'All'){
                $Storeuser = "-";
                foreach($data as $key){
                    $dataComplaint = Complaint::orderBy('id','DESC')->where('user', $key)->whereBetween('created_at', [$start, $end])->get();
                    if(count($dataComplaint)>0){
                        $present[] = $dataComplaint;        
                    }
                }
                for($z=0; $z<count($present); $z++){
                    foreach($present[$z] as $data){
                        $complaint[] = $data; 
                    }
                }
            }
            elseif($request->department != 'All'){
                foreach($data as $key){
                    if($request->status != null){
                        $result = Complaint::orderBy('id','DESC')->where('user', $key)->where('status', $request->status)->whereBetween('created_at', [$start, $end])->get();
                    }   
                    else{
                        $result = Complaint::orderBy('id','DESC')->where('user', $key)->whereBetween('created_at', [$start, $end])->get();
                    }            
                    if(count($result)>0){
                        $present[] = $result;        
                    }
                }
                for($z=0; $z<count($present); $z++){
                    foreach($present[$z] as $data){
                        $complaint[] = $data; 
                    }
                }
            }
            else{
                $complaint = Complaint::orderBy('id','DESC')->get();
            }
            if(!empty($complaint)){
                foreach($complaint as $data){
                    $department = User::orderBy('id','DESC')->limit(1)->where('id', $data['user'])->get();
                    if(isset($department[0])){
                        $complaintData[] = [
                            'department' => $department[0]->department,
                            'name' => $department[0]->name,
                            'data' => $data
                        ]; 
                    }
                }
            }
            foreach($complaintData as $data){
                $created_at = $data['data']['created_at']->format('d-M-Y g:i A'); 
                if(!empty($data['data']['updated_at'])){
                    $updated_at = $data['data']['updated_at']->format('d-M-Y g:i A');
                }else{
                    $updated_at = "-";
                }
                if($data['data']['status'] == 1){
                    $status = 'No Action';
                }
                elseif($data['data']['status'] == 2){
                    $status = 'In Process';
                }                
                elseif($data['data']['status'] == 3){
                    $status = 'Closed';
                }                
                elseif($data['data']['status'] == 4){
                    $status = 'Complete';
                }
                $PrintData[] = array(
                    'Complaint No' => $data['data']['id'],
                    'Employee' => $data['name'],
                    'Department' => $data['department'],
                    'Category' => $data['data']['category'],
                    'Sub Category' => $data['data']['subcategory'],
                    'Status' => $status,
                    'Date & Time' => $created_at,
                    'Operator' => $data['data']['approve_by'],
                    'Closing Date' => $updated_at,
                );
            }
            return Excel::download(new Helpdesk($PrintData), 'Help Desk Report.xlsx');
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function Department($id)
    {
        try{
            $Support = User::orderBy('name','ASC')->where('department', $id)->get();
            foreach($Support as $data){
                $value[] = [
                    'id' => $data['id'],
                    'name' => $data['name'],
                ]; 
            }
            return response()->json($value);
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
