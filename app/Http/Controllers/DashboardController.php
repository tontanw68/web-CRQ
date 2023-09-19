<?php

namespace App\Http\Controllers;

// Model 
use App\Models\Crq;
// end

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

use Illuminate\Http\Request;
use Illuminate\Http\Response;


class DashboardController extends Controller
{
    public function index(Request $request) {

        $name = session('LoggedUser.user_login');
        $where[] = ['', '=', $name];
        
        // Get date From Date To
        

if(date('d',strtotime('now')) < 16){
        $monthfrom = date('Y-m',strtotime('-1 month')) ;
        }
        else
        {
        $monthfrom = date('Y-m',strtotime('now')) ;
        }
        $yearfrom = date('y',strtotime('now')) ;
        
        if(date('d',strtotime('now')) < 16){
        $monthto = date('Y-m',strtotime('now')) ;
        
        }
        else
        {
        $monthto = date('Y-m',strtotime('+1 month')) ;
        }
        $yearto = date('y',strtotime('+1 month')) ;
        
        if(date('d',strtotime('now')) < 16){
        $textmonthfrom = date('M',strtotime('-1 month'));
        }
        else{
        $textmonthfrom = date('M',strtotime('now'));
        }
        
        if(date('d',strtotime('now')) < 16){
        $textmonthto = date('M',strtotime('now'),);
        }
        else{
        $textmonthto = date('M',strtotime('+1 month'),);
        }
        $textyearfrom = date('Y',strtotime('now'));
        $textyearto = date('Y',strtotime('+1 month'),);

        // $from = $monthfrom.'-16';
        // $to = $monthto.'-15';
        $from = '2022-11-16';
        $to = '2022-12-15';
        $totalcrq = Crq::whereBetween('Due_date', [$from, $to])
                    ->count();
                
        $macrq = Crq::whereBetween('Due_date', [$from, $to])
                ->where('Fix_type','Ma')
                ->where('Status_id','W')
                ->where('ch','3')
                ->count();

        $cccrq = Crq::whereBetween('Due_date', [$from, $to])
                ->where('Status_id','CC')
                ->where('ch','4')
                ->count();
        $tptcrq = Crq::whereBetween('Due_date', [$from, $to])
                ->where('Fix_type','TPT')
                ->where('Status_id','W')
                //->where('ch','5') //value 1,0
                ->count();

        $pkpicrq = Crq::whereBetween('Due_date', [$from, $to])
                ->where('Status_id','P')
                ->where('ch','0')
                ->count();

        $pnokpicrq = Crq::whereBetween('Due_date', [$from, $to])
                ->where('Status_id','P')
                ->whereIn('ch',['3','5'])
                ->count();

        $in24crq = Crq::whereBetween('Due_date', [$from, $to])
                ->where('Status_id','W')
                ->where('ch','1')
                ->count();

        $no24crq = Crq::whereBetween('Due_date', [$from, $to])
                ->where('Status_id','W')
                ->where('ch','2')
                ->count();
        
        $personcrq = Crq::select(Crq::raw('Count(*) AS number'),'close_by')
        ->whereBetween('Due_date', [$from, $to])
        ->whereIn('ch',['0','1','2','3','4','5'])
        ->whereNotNull('Close_by')
        ->groupBy("close_by")
        ->get();

        $prioritycrqP = Crq::select(Crq::raw('Count(*) AS number1'),'Priority')
        ->whereIn('Status_id',['W','C'])
        ->whereBetween('Due_date', [$from, $to])
        //->whereIn('ch',['0','1','2','3','4','5'])
        ->whereNotNull('Priority')
        ->groupBy("Priority")
        //->distinct()
        ->get();

        $prioritycrqWC = Crq::select(Crq::raw('Count(*) AS number2'),'Priority')
        ->whereIn('Status_id',['P','W','C'])
        ->whereBetween('Due_date', [$from, $to])
        //->whereIn('ch',['0','1','2','3','4','5'])
        ->whereNotNull('Priority')
        ->groupBy("Priority")
        //->distinct()
        ->get();

        // echo $personcrq;
        // echo $prioritycrq;
        // exit;
                
        $calcrq = $pkpicrq+$in24crq+$no24crq;

        $KPIALL = 0;
        if ($in24crq != 0) {
                // calculate the percentage
        $KPIALL =  number_format(($in24crq / ($pkpicrq + $in24crq + $no24crq)) * 100, 2, '.', '');
        }    
                


        // if(session('LoggedUser.company') != '#'){
        //     $memGp_id = session('LoggedUser.company');
        //     $where =  $memGp_id;
        // }
        

        // $response = Http::get("http://localhost:9001/api/orderstatusreport?company={$where}");
        // $obj = json_decode($response);
 
        // print_r($obj);

        // duedate-closedate
        // $uts['start'] = strtotime($start);
        // $uts['end'] = strtotime($end);
        // if( $uts['start']!==-1 && $uts['end']!==-1 )
        // {
        //     if( $uts['end'] >= $uts['start'] )
        //     {
        //         $diff =  $uts['end'] - $uts['start'];
        //         if( $years=intval((floor($diff/31104000))) )
        //             $diff = $diff % 31104000;
        //             $str .= $years > 0 ? $years.' Year ' : '';
        //         if( $months=intval((floor($diff/2592000))) )
        //             $diff = $diff % 2592000;
        //             $str .= $months > 0 ? $months.' months ' : '';
        //         if( $days=intval((floor($diff/86400))) )
        //             $diff = $diff % 86400;
        //             $str .= $days > 0 ? $days.' days ' : '';
        //         if( $hours=intval((floor($diff/3600))) )
        //             $diff = $diff % 3600;
        //             $str .= $hours > 0 ? $hours.' hours ' : '';
        //         if( $minutes=intval((floor($diff/60))) )
        //             $diff = $diff % 60;
                
        //             $str .= $minutes > 0 ? $minutes.' minutes ' : '';
        //     }
        // }
        // $p1 = Crq::

        return view('dashboard.index',  compact('prioritycrqWC','prioritycrqP','from','to','totalcrq','macrq','cccrq','tptcrq','pkpicrq','pnokpicrq','in24crq','no24crq','calcrq','KPIALL','personcrq'));
    }

}