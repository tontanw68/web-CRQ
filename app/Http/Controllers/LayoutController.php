<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Timesheet;
use App\Models\Crq;

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
    public function worksatis(Request $request) {

        
        $name = session('LoggedUser.user_login');
        $log = session('LoggedUser.department');
        //$where[] = ['user_login', '=', $name];

        //$queryCRQAmm = "SELECT * FROM crq WHERE Request_datetime BETWEEN '$startdate 00:00:00' AND '$enddate 23:59:59' AND Ch IN ('0','1','2','3','4','5') AND Assign_by = 'Amm'";
        // $startdate=$_POST['startd'];
        // $enddate=$_POST['endd'];

        $result = Crq::where('Request_datetime', 'Between', '$startdate', 'AND', '$enddate' )
        ->orderBy('Request_datetime', 'DESC')
        ->get();

        if ($log == "Dev" || $log == "Sup" || $log == "Sale") { 
            $where[] = ['user_login', '<>', $name];
            $where[] = ['Status_id','=','W'];

        } else {
            $where[] = ['user_login', '=', $name];
            $where[] = ['Status_id','=','W'];
        }

        $data = Crq::where($where)
            //->where('Status_id','=','P')
            ->orderBy('CRQ_id', 'DESC')
            ->get();
        
        //filter date
        if($request->startdate){
            $start = $request->startdate;
            $end = $request->enddate;
        
            $data = Crq::where($where)
                        ->where('Request_datetime','>=',$start)
                        ->where('Request_datetime','<=',$end)
                        ->get();
        }
        return view('layouts.nav', compact('result','data'));
    
}
}