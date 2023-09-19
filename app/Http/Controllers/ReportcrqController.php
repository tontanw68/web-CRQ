<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Timesheet;

class TimesheetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $name = session('LoggedUser.user_login');
        $where[] = ['user_login', '=', $name];
        // Edit By Pluk Query Join table
        $data = Timesheet::where($where)
                ->where('Date','Like','2021%')
                ->orderBy('Date','DESC')
                ->get();
        // $data = Timesheet::where()
        //         ->join('company', 'member.memGp_id', '=', 'company.company_id')
        //         ->orderBy('member.mem_update_datetime')
        //        ->get(['member.*', 'company.company_name']);

        // $data2 = Member::where($where)
        //     ->orderBy('mem_update_datetime')
        //     ->get();

        return view('timesheet', compact('data'));
    }
}
