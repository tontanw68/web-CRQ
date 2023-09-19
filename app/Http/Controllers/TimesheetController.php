<?php

namespace App\Http\Controllers;

use App\Models\Crq;
use App\Models\Customer;
use App\Models\Lookup;
use App\Models\Timesheet;
use Illuminate\Http\Request;

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

        if ($name == "Admin") {        //Admin----
            $where[] = ['user_login', '<>', $name];
        } else {
            $where[] = ['user_login', '=', $name];
        }
        // Edit By Pluk Query Join table
        $data = Timesheet::where($where)
            ->where('Date', 'Like', '2023%')
            ->orderBy('Date', 'DESC')
            ->get();

        // $data = Timesheet::where($where)
        //         ->orderBy('Date','DESC')
        //         ->get();
        //DDL
        $customer = Customer::where('Usergroup_id', '=', 'Cus')
            ->get(); //show data

        $crq_id = Crq::select('CRQ_id')
            ->orderBy('CRQ_id', 'DESC')
            ->get();

        $lookup = Lookup::where('lookup_type', '=', 'TS_cat')
            ->orderBy('Lookup_description', 'DESC')
            ->get();

        $lookup_type = Lookup::where('lookup_type', '=', 'Expense')
            ->orderBy('Lookup_description', 'DESC')
            ->get();

        // $data = Timesheet::where()
        //         ->join('company', 'member.memGp_id', '=', 'company.company_id')
        //         ->orderBy('member.mem_update_datetime')
        //        ->get(['member.*', 'company.company_name']);

        // $data2 = Member::where($where)
        //     ->orderBy('mem_update_datetime')
        //     ->get();

        //     $cus = Timesheet::all();
        //     return view('timesheet',['customer'=>$cus]); 

        return view('timesheet', compact('data', 'customer', 'crq_id', 'lookup', 'lookup_type'));
    }

    public function adddata(Request $request)
    {
        $user_login = $request->input('User_login');
        $date = $request->input('dateadd');
        $customer_name = $request->input('customer_name');
        $crq_id = $request->input('crq_id');
        $category = $request->input('category');
        $project = $request->input('project');
        $activity = $request->input('activity');
        $normal_usagetime = $request->input('normal_usagetime');
        $start_ot = $request->input('start_ot');
        $end_ot = $request->input('end_ot');
        $OT = $request->input('OT');
        $Total = $request->input('Total');
        $expense = $request->input('expense');
        $expense2 = $request->input('expense2');
        $starttime = $start_ot;
        $stoptime = $end_ot;
        //$TS_id = $request->input('TS_id');
//-------------------------------------------

        if ($stoptime == "00:00") {
            $stoptime = "24:00";
            $diff = (strtotime($stoptime) - strtotime($starttime));
            $totalot = $diff / 60;
            $OT = sprintf("%02d:%02d", floor($totalot / 60), $totalot % 60);
        } elseif ($stoptime == "00:30") {
            $stoptime = "24:30";
            $diff = (strtotime($stoptime) - strtotime($starttime));
            $totalot = $diff / 60;
            $OT = sprintf("%02d:%02d", floor($totalot / 60), $totalot % 60);
        } elseif ($stoptime == "01:00") {
            $diff = "25"-$starttime;
            $totalot = $diff * 60;
            $OT = sprintf("%02d:%02d", floor($totalot / 60), $totalot % 60);
        } elseif ($stoptime == "01:30") {
            $diff = "25.5"-$starttime;
            $totalot = $diff * 60;
            $OT = sprintf("%02d:%02d", floor($totalot / 60), $totalot % 60);
        } elseif ($stoptime == "02:00") {
            $diff = "26"-$starttime;
            $totalot = $diff * 60;
            $OT = sprintf("%02d:%02d", floor($totalot / 60), $totalot % 60);
        } else {
            $diff = (strtotime($stoptime) - strtotime($starttime));
            $totalot = $diff / 60;
            $OT = sprintf("%02d:%02d", floor($totalot / 60), $totalot % 60);
        }

        function sum_time()
        {
            $i = 0;
            foreach (func_get_args() as $time) {
                sscanf($time, '%d:%d', $hour, $min);
                $i += $hour * 60 + $min;
            }
            if ($h = floor($i / 60)) {
                $i %= 60;
            }
            return sprintf('%02d:%02d', $h, $i);
        }
        //echo sum_time($Normal_usagetime, $OT);
        $Total = sum_time($normal_usagetime, $OT);

        if ($OT == "00:00") {
            $OT = "";
        }
        if ($date == "" || $customer_name == "" || $category == "" || $activity == "") {
            echo "<script>alert('กรุณากรอกข้อมูลให้ครบ');window.location ='timesheet.php';</script>";
        } else {

            //--insert data
            $insert = Timesheet::insert([
                'User_login' => session('LoggedUser.user_login'),
                'Date' => $date,
                'Customer_name' => $customer_name,
                'CRQ_id' => $crq_id,
                'Category' => $category,
                'Project' => $project,
                'Activity' => $activity,
                'Normal_usagetime' => $normal_usagetime,
                'Start_ot' => $start_ot,
                'End_ot' => $end_ot,
                'OT'=>$OT,
                'Total'=>$Total,
                'Expense' => $expense,
                'Expense2' => $expense2,
            ]);

            
            return redirect()->back()->with('status','เพิ่มข้อมูลเรียบร้อย');
            //return response()->json(['status'=>'ทำการเพิ่มสำเร็จ!']);
        }
        //dd($validator);

        # code...
        // $validator = $request->validate([
        //         'dateadd' => 'required|max:191',
        //         'user_login' => 'required|max:191',
        //         'customer_name' => 'required|max:191',
        //         'crq_id' => 'max:191',
        //         'category' => 'required|max:191',
        //         // 'project' => 'required|max:191',
        //         'activity' => 'required|max:255',
        //         'normal_usagetime' => 'required|max:191',
        //         // 'start_ot' => 'required|max:191',
        //         // 'end_ot' => 'required|max:191',
        //         // 'expense' => 'required|max:191',
        //         // 'expense2' => 'required|max:191'
        // ]);

        // if($validator->fails())
        // {
        //    dd($validator);
        // }
        // else
        // {
        //     console.log(respone);
        //     exit;
        // }

        // return redirect('/timesheet')->with('success', 'Add success');

        
    }
    // public function insert()
    //     {
    //         $insert = Timesheet::all();
    //         return view('timesheet')
    //         ->with('insert',$insert);
            
    //     }

    public function edit($TS_id)
    {
        $data = Timesheet::find($TS_id);
        
        if($data)
        {
            return response()->json([
                'status'=>200,
                'message'=>$data,
            ]);
        }
        else{
            return response()->json([
                'status'=>404,
                'message'=>'Error noww',
            ]);
        }
        //return view('timesheet', compact('data','TS_id'));
        return view('timesheet', with('data',$data,'TS_id'));
    }

    public $timestamps = false;
    public function update(Request $request, $TS_id)
    {
        $TS_id = $request->input('data_id');
        $data = Timesheet::find($TS_id);

        $data->Date = $request->dateup;
        $data->Customer_name = $request->customer_name;
        $data->CRQ_id = $request->crq_id;
        $data->Category = $request->category;
        $data->Project = $request->project;
        $data->Activity = $request->activity;
        $data->Normal_usagetime = $request->normal_usagetime;
        $data->Start_ot = $request->start_ot;
        $data->End_ot = $request->end_ot;
        $data->OT = $request->OT;
        $data->Total = $request->normal_usagetime;
        $data->Expense = $request->expense;
        $data->Expense2 = $request->expense2;

        $data->update();
        //return response()->json(['status'=>'ทำการอัปเดตสำเร็จ!']);
        return redirect('/timesheet');
        
        //$user_login = $request->input('User_login');

        // $data->Date = $request->input('dateup');
        // $data->Customer_name = $request->input('customer_name');
        // $data->CRQ_id = $request->input('crq_id');
        // $data->Category = $request->input('category');
        // $data->Project = $request->input('project');
        // $data->Activity = $request->input('activity');
        // $data->Normal_usagetime = $request->input('normal_usagetime');
        // $data->Start_ot = $request->input('start_ot');
        // $data->End_ot = $request->input('end_ot');
        // $data->OT = $request->input('OT');
        // $data->Total = $request->input('Total');
        // $data->Expense = $request->input('expense');
        // $data->Expense2 = $request->input('expense2');

        // $data->update();
        // return redirect('/timesheet');
    }

    // public function destroy($TS_id)
    // {
    //     $data = Timesheet::find($TS_id);
    //     $data->delete();
    //     return redirect()->back()->with('Deleted Successfully');
    // }

    // public $delete_id;
    // protected $listeners = ['deleteConfirmed'=>'deleteData'];
    // public function deleteConfirmation($TS_id)
    // {
    //     $this->delete_id = $TS_id;
    //     $this->dispatchBrowserEvent('show-delete-confirmation');
    // }

    // public function deleteData()
    // {
    //     $data = Timesheet::where('TS_id', $this->delete_id)->first();
    //     $data->delete();

    //     $this->dispatchBrowserEvent('dataDeleted');
    // }

    public function delete($TS_id)
    {
        $del = Timesheet::findOrFail($TS_id);
        $del->delete();
        return response()->json(['status'=>'ทำการลบสำเร็จ!']);
    }

    // public function fetchdata()
    // {
    //     $data = Timesheet::all();
    //     return response()->json(
    //         [
    //             'data' => $data,
    //         ]
    //     );
    // }
}

