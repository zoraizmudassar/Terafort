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
        if(Auth::user()->designation == "Admin"){
            return view('admin-dashboard');
        }
        $id = Auth::user()->id;
        $final = Complaint::orderBy('id','DESC')->where('user', $id)->where('status', 4)->get();
        $total = Complaint::orderBy('id','DESC')->where('user', $id)->get();
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
