<?php

namespace App\Http\Controllers;

use DB;
use Hash;
use Auth;
use DateTime;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\LastNumber;
use App\Models\Notification;
use App\Models\RoleName;
use App\Models\UserDetail;
use App\Models\Category;
use App\Models\SubCategory; 
use App\Models\Complaint;
use App\Models\ComplaintDetail;
use App\Models\NotificationDetail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;

class ComplaintController extends Controller
{
    public function Category($id)
    {
        try{
            $Support = SubCategory::orderBy('id','ASC')->where('category', $id)->get();
            foreach($Support as $data){
                $value[] = $data['category_desc'];
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

    public function Create(Request $request)
    {
        try{
            $store = 1;
            $category = Category::orderBy('id','DESC')->limit(5)->get();
            $subCategory = SubCategory::orderBy('id','DESC')->get();
            $complaint = Complaint::orderBy('id','DESC')->limit(1)->get();
            if(count($complaint) == 0){
                $result = $store + 0;
            }
            else{
                $result = $store + $complaint[0]->id;
            }
            return view('complaint.support-case')->with([
                'category'=> $category, 
                'subCategory'=> $subCategory, 
                'complaintNo'=> $result
            ]);
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function masterSetting(Request $request)
    {          
        if(Auth::user()->role == 'Admin' || 'Support Administrator' ){
            try{
                $user = user::orderBy('id','DESC')->get();
                $Category = Category::orderBy('id','DESC')->limit(5)->get();
                $SubCategory = SubCategory::orderBy('id','DESC')->get();
                return view('admin.master-settings')->with(['data'=> $user, 'i' => 1, 'category'=> $Category, 'SubCategory'=> $SubCategory, 'j' => 1]);
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
    
    public function addCategory(Request $request)
    {
        try{
            $data = array(
                'category' => $request['category'],
                'category_desc' => $request['category_desc']
            );
            Category::create($data);
            $notification = array(
                'message' => 'Category Added',
                'alert-type' => 'success'
            );
            return redirect()->route('master-settings')->with($notification); 
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function addSubCategory(Request $request)
    {
        try{
            $data = array(
                'category' => $request['category'],
                'category_desc' => $request['category_desc']
            );
    
            SubCategory::create($data);
            $notification = array(
                'message' => 'Sub Category Added!',
                'alert-type' => 'success'
            );
            return redirect()->route('master-settings')->with($notification); 
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function submitComplaint(Request $request)
    {
        try{
            date_default_timezone_set("Asia/karachi");
            $id = Auth::user()->id;
            $filename = "0";
            if($request->doc){
                $file = $request->file('doc');
                $extension = $file->getClientOriginalExtension(); 
                $filename = time() . '.' . $extension;
                $file->move('uploads/appsetting/', $filename);
            }
            $data = array(
                'user' => $id,
                'status' => 1,
                'category' => $request['category'],
                'subcategory' => $request['subcategory'],
                'message' => $request['message'],
                'location' => Auth::user()->location,
                'type' => $request['type'],
                'dep' => $request['dep'],
                'nature' => $request['nature'],
                'doc' => $filename,
            );
            $storeComplaint = Complaint::create($data);
            $notificationData = array(
                'event_id' => $storeComplaint['id'],
                'event_name' => 'New Complaint'
            );
            $user = Notification::create($notificationData);
            if(Auth::user()->location == 'Lahore'){
                $assignUsers = User::orderBy('id','ASC')->where('role', 'Support Administrator (LHR)')->Orwhere('role', 'Support Administrator Head')->pluck('id');
            }
            if(Auth::user()->location == 'Islamabad'){
                $assignUsers = User::orderBy('id','ASC')->where('role', 'Support Administrator (ISB)')->Orwhere('role', 'Support Administrator Head')->pluck('id');
            }
            foreach($assignUsers as $assignUser){
                $NotificationDetailData = array(
                    'notificationId' => $user['id'],
                    'assignUsers' => $assignUser,
                    'event_name' =>  $user['event_name'],
                    'url' => 'complaints-view',
                    'complaint_id' => $storeComplaint['id'],
                    'userid' => $id,
                );
                NotificationDetail::create($NotificationDetailData);
            }
            $notification = array(
                'message' => 'Complaint Submited',
                'alert-type' => 'success'
            );
            return redirect()->route('manage-complaint')->with($notification); 
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function manageUsersComplaint(Request $request)
    {
        try{
            $id = Auth::user()->id;
            $present = array();
            $support = Complaint::orderBy('id','DESC')->where('user', $id)->get();
            foreach($support as $data){
                $user = User::orderBy('id','DESC')->where('id', $data['user'])->get();
                $present[] = [
                    'department' => $user[0]->department,
                    'name' => $user[0]->name,
                    'data' => $data
                ]; 
            }
            $noAction = Complaint::orderBy('id','DESC')->where('user', $id)->where('status', 1)->get();
            $Process = Complaint::orderBy('id','DESC')->where('user', $id)->where('status', 2)->get();
            $complete = Complaint::orderBy('id','DESC')->where('user', $id)->where('status', 3)->get();
            $final = Complaint::orderBy('id','DESC')->where('user', $id)->where('status', 4)->get();
            $total = Complaint::orderBy('id','DESC')->where('user', $id)->get();
            return view('complaint.manage-complaints-user')->with([
                'support'=> $present,
                'noAction'=> count($noAction),   
                'Process'=> count($Process), 
                'complete'=> count($complete), 
                'final'=> count($final), 
                'total'=> count($total),
                'i'=>1
            ]);
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }
   
    public function manageComplaints(Request $request)
    {   
        if(Auth::user()->role == 'Admin' || 'Support Administrator (LHR)' || 'Support Administrator (ISB)'){
            try{
                $diff = 'empty';
                $lastupdate = 0;
                if(Auth::user()->role == 'Support Administrator (LHR)'){
                    $lastupdate = Complaint::orderBy('id','ASC')->where('location', "Lahore")->limit(1)->get();
                }
                if(Auth::user()->role == 'Support Administrator (ISB)'){
                    $lastupdate = Complaint::orderBy('id','ASC')->where('location', "Islamabad")->limit(1)->get();
                }
                if(Auth::user()->role == 'Support Administrator Head'){
                    $lastupdate = Complaint::orderBy('id','ASC')->limit(1)->get();
                }
                if(Auth::user()->role == 'Admin'){
                    $lastupdate = Complaint::orderBy('id','ASC')->limit(1)->get();
                }
                date_default_timezone_set("Asia/karachi");
                $time = date("h:i A");
                $datetime2 = new DateTime($time);
                if(count($lastupdate) > 0){
                    $month = $lastupdate[0]['created_at'];
                    $delimiter = ' ';
                    $words = explode($delimiter, $month);
                    $datetime3 = new DateTime($lastupdate[0]['created_at']);
                    $interval = $datetime2->diff($datetime3);
                    $diff = $interval->format('%d Day, %h Hour, %i min');
                }
                $present = array();
                if(Auth::user()->role == 'Support Administrator (LHR)'){
                    $support = Complaint::orderBy('id','DESC')->where('location', "Lahore")->get();
                }
                if(Auth::user()->role == 'Support Administrator (ISB)'){
                    $support = Complaint::orderBy('id','DESC')->where('location', "Islamabad")->get();
                }
                if(Auth::user()->role == 'Support Administrator Head'){
                    $support = Complaint::orderBy('id','DESC')->get();
                }
                if(Auth::user()->role == 'Admin'){
                    $support = Complaint::orderBy('id','DESC')->get();
                }
                foreach($support as $data){
                    $department = User::orderBy('id','DESC')->limit(1)->where('id', $data['user'])->get();
                    if(isset($department[0])){
                        $present[] = [
                            'department' => $department[0]->department,
                            'name' => $department[0]->name,
                            'data' => $data
                        ]; 
                    }
                }
                if(Auth::user()->role == 'Support Administrator (LHR)'){
                    $loc = "Lahore";
                }
                if(Auth::user()->role == 'Support Administrator (ISB)'){
                    $loc = "Islamabad";
                }
                if(Auth::user()->role == 'Support Administrator Head'){
                    $loc = "Islamabad";
                    $loc1 = "Lahore";
                }
                if(Auth::user()->role == 'Admin'){
                    $noAction = Complaint::orderBy('id','DESC')->where('status', 1)->get();
                    $Process = Complaint::orderBy('id','DESC')->where('status', 2)->get();
                    $complete = Complaint::orderBy('id','DESC')->where('status', 3)->get();
                    $final = Complaint::orderBy('id','DESC')->where('status', 4)->get();
                    $total = Complaint::orderBy('id','DESC')->get();
                }
                if(Auth::user()->role == 'Support Administrator Head'){
                    $noAction = Complaint::orderBy('id','DESC')->where('status', 1)->get();
                    $Process = Complaint::orderBy('id','DESC')->where('status', 2)->get();
                    $complete = Complaint::orderBy('id','DESC')->where('status', 3)->get();
                    $final = Complaint::orderBy('id','DESC')->where('status', 4)->get();
                    $total = Complaint::orderBy('id','DESC')->get();
                }
                if(Auth::user()->role == 'Support Administrator (LHR)' || Auth::user()->role == 'Support Administrator (ISB)'){
                    $noAction = Complaint::orderBy('id','DESC')->where('location', $loc)->where('status', 1)->get();
                    $Process = Complaint::orderBy('id','DESC')->where('location', $loc)->where('status', 2)->get();
                    $complete = Complaint::orderBy('id','DESC')->where('location', $loc)->where('status', 3)->get();
                    $final = Complaint::orderBy('id','DESC')->where('location', $loc)->where('status', 4)->get();
                    $total = Complaint::orderBy('id','DESC')->where('location', $loc)->get();
                }
                return view('complaint.manage-complaints')->with([
                        'support'=> $present,  
                        'noAction'=> count($noAction),   
                        'Process'=> count($Process), 
                        'complete'=> count($complete),
                        'final'=> count($final), 
                        'total'=> count($total),
                        'diff'=> $diff,
                        'i'=> 1
                ]);
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

    public function countComplain(Request $request)
    {
        try{
            date_default_timezone_set("Asia/karachi");
            $time = date("M");
            $Months = Complaint::orderBy('id','ASC')->where('month', $time)->get()->unique('date')->pluck('date');    
            foreach($Months as $data){
                $NoAction = Complaint::orderBy('id','DESC')->where('date', $data)->where('status', 1)->get();
                $InProcess = Complaint::orderBy('id','DESC')->where('date', $data)->where('status', 2)->get();
                $Complete = Complaint::orderBy('id','DESC')->where('date', $data)->where('status', 3)->get();
                $Closed = Complaint::orderBy('id','DESC')->where('date', $data)->where('status', 4)->get();
                $var = $data;
                $newDate = date("d-M", strtotime($var));
                $show = (int)$newDate;
                $result[] = [
                    'NoAction' => count($NoAction),
                    'InProcess' => count($InProcess),
                    'Complete' => count($Complete),
                    'Closed' => count($Closed),
                    'Month' => $newDate,
                ];
            }
            return response()->json($result);
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function Support(Request $request)
    {
        try{
            $chat = 0;
            $event = "New Message";
            date_default_timezone_set("Asia/karachi");
            $time = date("G:i:s");
            $date = date("d-m-Y");
            $complaintNo = $request->complaint;
            $id = Auth::user()->id;
            $name = Auth::user()->name;
            $input = $request->all();
            $complaint = Complaint::orderBy('id','DESC')->get();
            $updateStatus = array(
                'approve_by' => $name,
                'status' => $request->status,
            );
            if($request->status == 3){
                $event = "Complaint Solved";
            }
            if($request->status == 2){
                $event = "Complaint In Process";
            }
            Complaint::where('id', $complaintNo)->update($updateStatus);
            $data = array(
                'message' => $request->message,
                'sender' => Auth::user()->id,
                'receiver' => $request->id,
                'complaint' => $request->complaint
            );            
            $create = ComplaintDetail::create($data);
            $notificationData = array(
                'event_id' => $create['id'],
                'event_name' => $event
            );
            $user = Notification::create($notificationData);
            $assignUsers = User::orderBy('id','ASC')->where('id', $request->id)->pluck('id');
            foreach($assignUsers as $assignUser){
                $NotificationDetailData = array(
                    'notificationId' => $user['id'],
                    'assignUsers' => $assignUser,
                    'event_name' =>  $user['event_name'],
                    'url' => 'complaints-view',
                    'complaint_id' => $create['complaint'],
                    'userid' => $id,
                );
                NotificationDetail::create($NotificationDetailData);
            }
    
            $SupportDetail = ComplaintDetail::orderBy('id','ASC')->where('complaint', $complaintNo)->get();
            if(count($SupportDetail) > 0){
                $chat = 1;
            }
            $users = User::orderBy('id','DESC')->where('id', $request->id)->get();
            $data = Complaint::orderBy('id','DESC')->where('id', $complaintNo)->get();
            return back();
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function Read($id)
    {
        try{
            date_default_timezone_set("Asia/karachi");
            $time = date("h:i A");
            $date = date("d-F-Y");
            $result = $time." ".$date;
            $data = DB::table('notification_details')->where('complaint_id', $id)->update(['read_at' => $result]);
            if($data){
                $update = 1;
                return response()->json($update);
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

    public function DisplayUser(Request $request)
    {
        try{
            $file = 0; 
            $chat = 0;
            $sender = 0; 
            $present = array();
            $id = $_COOKIE["CD"];
            $getUser = Complaint::orderBy('id','DESC')->where('id', $id)->pluck('user');
            $user = User::orderBy('id','DESC')->where('id', $getUser[0])->get();
            $SupportDetail = ComplaintDetail::orderBy('id','ASC')->where('complaint', $id)->get();
            foreach($SupportDetail as $data){
                $detail = User::orderBy('id','DESC')->limit(1)->where('id', $data['sender'])->get();
                if(isset($detail[0])){
                    $result = $data['created_at']; 
                    $time = $result->format('g:i A');
                    $present[] = [
                        'image' => $detail[0]->image,
                        'name'  => $detail[0]->name,
                        'data'  => $data,
                        'time'  => $time
                    ]; 
                }
            }
            if(count($SupportDetail) > 0){
                $chat = 1;
            }
            $data = Complaint::orderBy('id','DESC')->where('id', $id)->get();
            if(count($data) == 1){
                $img = $data[0]['doc'];
                $ext = pathinfo($img, PATHINFO_EXTENSION);
                $imageMimeTypes = array('png','jpg','jpeg');        
                if(in_array($ext, $imageMimeTypes)) {
                    $file = 'image';
                }
            }
            // before we only send "user varaible"
            return view('complaint.display-complaints-user')->with(['data'=> $data[0], 'user'=> $user[0], 'file'=> $file, 'chat'=> $chat, 'SupportDetail'=> $present, 'userid'=> $user[0]['id'], 'C_id'=> $id]);
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function Display(Request $request)
    {
        if(Auth::user()->role == 'Admin' || 'Support Administrator (LHR)' || 'Support Administrator (ISB)'){
            try{
                $file = 0;
                $chat = 0;
                $id = $_COOKIE["CID"];
                $getUser = Complaint::orderBy('id','DESC')->where('id', $id)->pluck('user');
                $present = array();
                $user = User::orderBy('id','DESC')->where('id', $getUser[0])->get();
                $SupportDetail = ComplaintDetail::orderBy('id','ASC')->where('complaint', $id)->get();
                foreach($SupportDetail as $data){
                    $detail = User::orderBy('id','DESC')->limit(1)->where('id', $data['sender'])->get();
                    if(isset($detail[0])){
                        $result = $data['created_at']; 
                        $time = $result->format('g:i A');
                        $present[] = [
                            'image' => $detail[0]->image,
                            'name'  => $detail[0]->name,
                            'data'  => $data,
                            'time'  => $time
                        ]; 
                    }
                }
                if(count($SupportDetail) > 0){
                    $chat = 1;
                }
                $data = Complaint::orderBy('id','DESC')->where('id', $id)->get();
                if(count($data) == 1){
                    $img = $data[0]['doc'];
                    $ext = pathinfo($img, PATHINFO_EXTENSION);
                    $imageMimeTypes = array('png','jpg','jpeg');        
                    if(in_array($ext, $imageMimeTypes)) {
                        $file = 'image';
                    }
                }
                return view('complaint.display-complaints')->with(['data'=> $data[0], 'user'=> $user[0], 'file'=> $file, 'chat'=> $chat, 'SupportDetail'=> $present]);
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

    public function chat(Request $request,$complaint,$userid)
    {
        try{
            $chat = 0;
            $present = array();
            $user = User::orderBy('id','DESC')->where('id', $userid)->get();
            $SupportDetail = ComplaintDetail::orderBy('id','ASC')->where('complaint', $complaint)->get();
            foreach($SupportDetail as $data){
                $detail = User::orderBy('id','DESC')->limit(1)->where('id', $data['sender'])->get();
                if(isset($detail[0])){
                    $result = $data['created_at']; 
                    $time = $result->format('g:i A');
                    $present[] = [
                        'image' => $detail[0]->image,
                        'name'  => $detail[0]->emp_name,
                        'data'  => $data,
                        'time'  => $time
                    ]; 
                }
            }
            if(count($SupportDetail) > 0){
                $chat = 1;
            }
            return response()->json(['data'=> $data,'chat'=> $chat,'present'=> $present]);
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function chat1(Request $request,$complaint,$userid)
    {
        try{
            $chat = 0;
            $present = array();
            $user = User::orderBy('id','DESC')->where('id', $userid)->get();
            $SupportDetail = ComplaintDetail::orderBy('id','ASC')->where('complaint', $complaint)->get();
            foreach($SupportDetail as $data){
                $detail = User::orderBy('id','DESC')->limit(1)->where('id', $data['sender'])->get();
                if(isset($detail[0])){
                    $result = $data['created_at']; 
                    $time = $result->format('g:i A');
                    $present[] = [
                        'image' => $detail[0]->image,
                        'name'  => $detail[0]->name,
                        'data'  => $data,
                        'time'  => $time
                    ]; 
                }
            }
            if(count($SupportDetail) > 0){
                $chat = 1;
            }
            return response()->json(['data'=> $data,'chat'=> $chat,'present'=> $present]);
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function Chats1(Request $request)
    {
        try{
            date_default_timezone_set("Asia/karachi");
            $time = date("h:i A");
            $date = date("d-m-Y");
            $id = $request->user_id;
            $name = Auth::user()->name;
            $image = Auth::user()->image;
            $chat = 0;
            $support_id = $request->complaint_id;
            $userid = $request->user_id;
            $status = Complaint::orderBy('id','DESC')->where('id', $request['complaint_id'])->pluck('status');
            $event = "New Message";
            if($request->status == 'closed'){
                $event = "Complaint Solved";
            }
            if($request->status == 'in process'){
                $event = "Complaint In Process";
            }
            $data = array(
                'message' => $request->message,
                'sender' => Auth::user()->id,
                'receiver' => $id,
                'complaint' => $request->id
            );
            $storeMessage = ComplaintDetail::create($data);
            $notificationData = array(
                'event_id' => $storeMessage['id'],
                'event_name' => $event
            );
            $userData = Notification::create($notificationData);
                $NotificationDetailData = array(
                    'notificationId' => $userData['id'],
                    'assignUsers' => $id,
                    'event_name' =>  $userData['event_name'],
                    'url' => 'complaints-view-user',
                    'complaint_id' => $storeMessage['complaint'],
                    'userid' => Auth::user()->id,
                );
                NotificationDetail::create($NotificationDetailData);
            $user = User::orderBy('id','DESC')->where('id', $id)->get();
            $SupportDetail = ComplaintDetail::orderBy('id','ASC')->where('complaint', $support_id)->get();
            if(count($SupportDetail) > 0){
                $chat = 1;
            }
            $data = Complaint::orderBy('id','DESC')->where('id', $support_id)->get();
            $variable = 1;
            return response()->json($variable);   
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function Chats(Request $request)
    {
        try{
            date_default_timezone_set("Asia/karachi");
            $time = date("h:i A");
            $date = date("d-m-Y");
            $id = $request->user_id;
            $chat = 0;
            $support_id = $request->complaint_id;
            $status = Complaint::orderBy('id','DESC')->where('id', $request['complaint_id'])->pluck('status');
            $event = "New Message";
            if($request->status == 'closed'){
                $event = "Complaint Solved";
            }
            if($request->status == 'in process'){
                $event = "Complaint In Process";
            }
            if(Auth::user()->location == 'Lahore'){
                $receiver = User::orderBy('id','ASC')->where('role', 'Support Administrator (LHR)')->pluck('id');
            }
            if(Auth::user()->location == 'Islamabad'){
                $receiver = User::orderBy('id','ASC')->where('role', 'Support Administrator (ISB)')->pluck('id');
            }
            $data = array(
                'complaint' => $support_id,
                'message' => $request->message,
                'sender' => Auth::user()->id,
                'receiver' => $receiver,
            );
            $storeMessage = ComplaintDetail::create($data);
            $notificationData = array(
                'event_id' => $storeMessage['id'],
                'event_name' => 'New Message'
            );
            $user = Notification::create($notificationData);
            $assignUsers = User::orderBy('id','ASC')->where('id', $receiver)->pluck('id');
            foreach($assignUsers as $assignUser){
                $NotificationDetailData = array(
                    'notificationId' => $user['id'],
                    'assignUsers' => $assignUser,
                    'event_name' =>  $user['event_name'],
                    'url' => 'complaints-view',
                    'complaint_id' => $storeMessage['complaint'],
                    'userid' => $id,
                );
                NotificationDetail::create($NotificationDetailData);
            }
            $variable = 1;
            return response()->json($variable);   
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function Complete(Request $request, $id)
    {
        try{
            date_default_timezone_set("Asia/karachi");
            $date = date("d-m-Y");
            $data = array(
                'event_id' => $id,
                'event_name' => 'Complaint Completed'
            );
            $user = Notification::create($data);
            $update = DB::table('complaints')->where('id', $id)->update(['status' => 4]);
            if($update){
                $event = "Complaint Completed";
                if(Auth::user()->location == 'Lahore'){
                    $assignUsers = User::orderBy('id','ASC')->where('role', 'Support Administrator (LHR)')->pluck('id');
                }
                if(Auth::user()->location == 'Islamabad'){
                    $assignUsers = User::orderBy('id','ASC')->where('role', 'Support Administrator (ISB)')->pluck('id');
                }
                foreach($assignUsers as $assignUser){
                    $NotificationDetailData = array(
                        'notificationId' => $user['id'],
                        'assignUsers' => $assignUser,
                        'event_name' => $user['event_name'],
                        'url' => 'complaints-view',
                        'complaint_id' => $id,
                        'userid' => Auth::user()->id,
                    );
                    NotificationDetail::create($NotificationDetailData);
                }    
                // NotificationDetail::where('notificationId', $user['id'])->where('assign_users', Auth::user()->id)->delete();
                return response()->json($update);
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

    public function accessDenied()
    {
        $notification = array(
            'message' => 'Access Denied',
            'alert-type' => 'warning'
        );
        return back()->with($notification);
    }

    public function Reject(Request $request, $id)
    {
        try{
            date_default_timezone_set("Asia/karachi");
            $date = date("d-m-Y");
            $data = array(
                'event_id' => $id,
                'event_name' => 'Complaint Re-Open'
            );
            $user = Notification::create($data);
            $update = DB::table('complaints')->where('id', $id)->update(['status' => 2]);
            if($update){
                $event = "Complaint Re-Open";
                if(Auth::user()->location == 'Lahore'){
                    $assignUsers = User::orderBy('id','ASC')->where('role', 'Support Administrator (LHR)')->pluck('id');
                }
                if(Auth::user()->location == 'Islamabad'){
                    $assignUsers = User::orderBy('id','ASC')->where('role', 'Support Administrator (ISB)')->pluck('id');
                }
                foreach($assignUsers as $assignUser){
                    $NotificationDetailData = array(
                        'notificationId' => $user['id'],
                        'assignUsers' => $assignUser,
                        'event_name' => $user['event_name'],
                        'url' => 'complaints-view',
                        'complaint_id' => $id,
                        'userid' => Auth::user()->id,
                    );
                    NotificationDetail::create($NotificationDetailData);
                }    
                // notification_details::where('notification_id', $Noti_id)->where('assign_users', Auth::user()->id)->delete();
                return response()->json($update);
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
}
