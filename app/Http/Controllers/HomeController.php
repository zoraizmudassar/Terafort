<?php

namespace App\Http\Controllers;
use Auth;
use App\Models\Complaint;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        if(Auth::user()->role == "Admin"){
            $total = Complaint::orderBy('id','DESC')->get();
            $final = Complaint::orderBy('id','DESC')->where('status', 4)->get();
            $Process = Complaint::orderBy('id','DESC')->where('status', 2)->get();
            $noAction = Complaint::orderBy('id','DESC')->where('status', 1)->get();
            $complete = Complaint::orderBy('id','DESC')->where('status', 3)->get();
            return view('admin-dashboard')->with([
                'noAction'=> count($noAction),   
                'Process'=> count($Process), 
                'complete'=> count($complete), 
                'final'=> count($final), 
                'total'=> count($total)
            ]);
        }
        elseif(Auth::user()->role == 'Support Administrator'){
            $total = Complaint::orderBy('id','DESC')->get();
            $final = Complaint::orderBy('id','DESC')->where('status', 4)->get();
            $Process = Complaint::orderBy('id','DESC')->where('status', 2)->get();
            $noAction = Complaint::orderBy('id','DESC')->where('status', 1)->get();
            $complete = Complaint::orderBy('id','DESC')->where('status', 3)->get();
            return view('user-dashboard')->with([
                'noAction'=> count($noAction),   
                'Process'=> count($Process), 
                'complete'=> count($complete), 
                'final'=> count($final), 
                'total'=> count($total)
            ]);
            return view('user-dashboard');
        }
        else{
            $id = Auth::user()->id;
            $total = Complaint::orderBy('id','DESC')->where('user', $id)->get();
            $final = Complaint::orderBy('id','DESC')->where('user', $id)->where('status', 4)->get();
            $Process = Complaint::orderBy('id','DESC')->where('user', $id)->where('status', 2)->get();
            $noAction = Complaint::orderBy('id','DESC')->where('user', $id)->where('status', 1)->get();
            $complete = Complaint::orderBy('id','DESC')->where('user', $id)->where('status', 3)->get();
            return view('user-dashboard')->with([
                'noAction'=> count($noAction),   
                'Process'=> count($Process), 
                'complete'=> count($complete), 
                'final'=> count($final), 
                'total'=> count($total)
            ]);
            return view('user-dashboard');
        }

    }
}
