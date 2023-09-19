<?php

namespace App\Http\Controllers;

// Model 
use App\Models\Crq;
use App\Models\Customer;
use App\Models\Lookup;
use App\Models\Timesheet;
use App\Models\Comment;
use App\Models\Satisfaction;
// end

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class WorkareaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){

    }

    public function opencrq(Request $request) {

        $customer = Customer::where('Usergroup_id', '=', 'Cus')
            ->get();
        $lookup = Lookup::where('lookup_type', '=', 'Service')
            ->orderBy('Lookup_description' , 'DESC')
            ->get();
        $lookup1 = Lookup::where('lookup_type', '=', 'SV_cat')
            ->orderBy('Lookup_description' , 'DESC')
            ->get();
        $lookup2 = Lookup::where('lookup_type', '=', 'SV_system')
            //->orderBy('Lookup_description' , 'DESC')
            ->get();
        $lookup3 = Lookup::where('lookup_type', '=', 'SV_eqip')
            //->orderBy('Lookup_description' , 'DESC')
            ->get();
        $workto = Customer::where('Usergroup_id', '=', 'Su')
            ->get();
        $lookup4 = Lookup::where('lookup_type', '=', 'Fix_type')
            //->orderBy('Lookup_description' , 'DESC')
            ->get();

        return view('workarea.opencrq', compact('customer','lookup','lookup1','lookup2','lookup3','workto','lookup4'));
    }

    public function addworkwait(Request $request)
    {
        // $fileNames = [];
        // foreach($request->file('file') as $image)
        // {
        //     $imageName = $image->getClientOriginalName();
        //     $image->move(public_path().'/images/',$imageName);
        //     $fileNames[] = $imageName;
        // }

        // $p_img = json_encode($fileNames);
        // Crq::create(['p_img'=>$p_img]);

        //ดึงข้อมูลจากฟอร์ม
        // $date2 = $_POST['date2'];
	    // $time2 = $_POST['time2'];
        // $Assign_datetime = "$date2 $time2";
        $Assign_datetime = $request->input('$Assign_datetime');
        // $Request_datetime = "$date2 $time2";
        //$duedate = $_POST['duedate'];
        // $Request_datetime = $request->input('Request_datetime');
        $Request_by = $request->input('Request_by');
        $User_login = $request->input('User_login');
        $Customer_tel = $request->input('Customer_tel');
        $Service = $request->input('Service');
        $SV_cat = $request->input('SV_cat');
        // $SV_system = $request->input('SV_system');
        // $SV_eqip = $request->input('SV_eqip');
        $p_img = $request->input('p_img');
        $Issue = $request->input('Issue');
        // $Assign_by = $request->input('Assign_by');
        // $Fix_type = $request->input('Fix_type');

        $insert = Crq::insert([
            'Assign_datetime' => $Assign_datetime,
            //'Request_datetime' => $Request_datetime,
            //'Due_date' => $duedate,
            'Request_by' => $Request_by,
            'User_login' => session('LoggedUser.user_login'),
            'Customer_tel' => $Customer_tel,
            'Service' => $Service,
            'SV_cat' => $SV_cat,
            //'SV_system' => $SV_system,
            //'SV_eqip' => $SV_eqip,
            'p_img' => $p_img,
            'Issue' => $Issue,
            //'Assign_by' => $Assign_by,
            //'Fix_type' => $Fix_type,
            'Status_id' => 'N',
            'Ch' => 0,
          ]);
        echo "<script>alert('เพิ่มข้อมูลสำเร็จ');window.location ='workwait.php';</script>";
        return redirect()->back()->with('status','เพิ่มข้อมูลเรียบร้อย');
        //return redirect('/workwait');
    }

    public function addsatis(Request $request)
    {
        $Assign_datetime = $request->input('$Assign_datetime');
        $Request_by = $request->input('Request_by');
        $User_login = $request->input('User_login');

        $insert = Crq::insert([
            'Assign_datetime' => $Assign_datetime,
            'p_img' => $p_img,
            'Issue' => $Issue,
            'Status_id' => 'C',
            'Ch' => 0,
          ]);
        echo "<script>alert('เพิ่มข้อมูลสำเร็จ');window.location ='worksatis.php';</script>";
        return redirect()->back()->with('status','เพิ่มข้อมูลเรียบร้อย');
        //return redirect('/workwait');
    }

    public function updatesatis(Request $request, $CRQ_id)
    {
        $CRQ_id = $request->input('satisid');
        $data = Crq::find($CRQ_id);

        $data->Satis_level = $request->edit_level;
        $data->Satis_comment = $request->edit_comment;
        $data->Status_id = $request->edit_status;

        $data->update();
        //return response()->json(['status'=>'ทำการอัปเดตสำเร็จ!']);
        return redirect()->back()->with('status','อัปเดตข้อมูลเรียบร้อย');
    }
    public function crq_update(Request $request, $CRQ_id)
    {
        $CRQ_id = $request->input('editcrq_id');
        $data = Crq::find($CRQ_id);

        //$data->Request_datetime = $request->{'edit_date,edit_time'};
       // $data->Request_datetime = $request->edit_time;
        //$data->Due_date = $request->edit_duedate;
        $data->Request_by = $request->edit_Requestbyy;
        //$data->User_login = $request->edit_User_login;
        $data->Customer_tel = $request->edit_Customer_tel;
        $data->Service = $request->edit_Service;
        $data->SV_cat = $request->edit_SV_cat;
        //$data->SV_system = $request->edit_SV_system;
        //$data->SV_eqip = $request->edit_SV_eqip;
        $data->p_img = $request->edit_p_img;
        $data->Issue = $request->edit_Issue;
        //$data->Assign_by = $request->edit_Assign_by;
        //$data->Fix_type = $request->edit_Fix_type;

        $data->update();
        //return response()->json(['status'=>'ทำการอัปเดตสำเร็จ!']);
        return redirect()->back()->with('status','อัปเดตข้อมูลเรียบร้อย');
    }

    public function updatesendjob(Request $request, $CRQ_id)
    {
        $CRQ_id = $request->input('sendjob_data_id');
        $data = Crq::find($CRQ_id);

        //$data->Request_datetime = $request->{'edit_date,edit_time'};
        $data->Assign_datetime = $request->Assign_datetime;
        $data->Due_date = $request->wait_duedate;
        $data->Third_party = $request->master;
        $data->User_login = $request->sendjob_cus;
        //$data->Customer_tel = $request->edit_Customer_tel;
        $data->Priority = $request->sendjob_SV_cat2;
        $data->SV_cat = $request->sendjob_SV_cat;
        $data->SV_system = $request->sendjob_SV_system;
        $data->SV_eqip = $request->sendjob_SV_eqip;
        //$data->p_img = $request->edit_p_img;
        $data->Issue = $request->sendjob_issue;
        $data->Assign_by = $request->sendjobto;
        $data->Fix_type = $request->sendjob_Fix;
        $data->Status_id = $request->wait_status;

        $data->update();
        //return response()->json(['status'=>'ทำการอัปเดตสำเร็จ!']);
        return redirect('/worknow');
    }

    public function addcrq(Request $request)
    {
        //ดึงข้อมูลจากฟอร์ม
        $date2 = $_POST['date2'];
	    $time2 = $_POST['time2'];
        // $Assign_datetime = "$date2 $time2";
        $Assign_datetime = $request->input('$Assign_datetime');
        $Request_datetime = "$date2 $time2";
        $duedate = $_POST['duedate'];
        // $Request_datetime = $request->input('Request_datetime');
        $Request_by = $request->input('Request_by');
        $User_login = $request->input('User_login');
        $Customer_tel = $request->input('Customer_tel');
        $Service = $request->input('Service');
        $SV_cat = $request->input('SV_cat');
        $SV_system = $request->input('SV_system');
        $SV_eqip = $request->input('SV_eqip');
        $p_img = $request->input('p_img');
        $Issue = $request->input('Issue');
        $Assign_by = $request->input('Assign_by');
        $Fix_type = $request->input('Fix_type');
        $Status_id = $request->input('Status_id');

        $insert = Crq::insert([
            'Assign_datetime' => $Assign_datetime,
            'Request_datetime' => $Request_datetime,
            'Due_date' => $duedate,
            'Request_by' => $Request_by,
            'User_login' => $User_login,
            'Customer_tel' => $Customer_tel,
            'Service' => $Service,
            'SV_cat' => $SV_cat,
            'SV_system' => $SV_system,
            'SV_eqip' => $SV_eqip,
            'p_img' => $p_img,
            'Issue' => $Issue,
            'Assign_by' => $Assign_by,
            'Fix_type' => $Fix_type,
            'Status_id' => 'P',
            'Ch' => 0,
          ]);

        return redirect('/worknow');
    }

    public function edit($CRQ_id)
    {
        $data = Crq::find($CRQ_id);
        
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
        return view('workarea.worknow','workarea.workwait', with('data',$data,'CRQ_id'));
    }

    //public $timestamps = false;
    public function updatecrq(Request $request, $CRQ_id)
    {
        $CRQ_id = $request->input('editcrq_data_id');
        $data = Crq::find($CRQ_id);

        //$data->Request_datetime = $request->{'edit_date,edit_time'};
       // $data->Request_datetime = $request->edit_time;
        //$data->Due_date = $request->edit_duedate;
        $data->Third_party = $request->is_finished;
        $data->Request_by = $request->edit_Request_by;
        $data->User_login = $request->edit_User_login;
        $data->Customer_tel = $request->edit_Customer_tel;
        $data->Service = $request->edit_Service;
        $data->SV_cat = $request->edit_SV_cat;
        $data->Priority = $request->edit_SV_cat2;
        $data->SV_system = $request->edit_SV_system;
        $data->SV_eqip = $request->edit_SV_eqip;
        $data->p_img = $request->edit_p_img;
        $data->Issue = $request->edit_Issue_;
        $data->Assign_by = $request->edit_Assign_by;
        $data->Fix_type = $request->edit_Fix_type;

        $data->update();
        //return response()->json(['status'=>'ทำการอัปเดตสำเร็จ!']);
        return redirect()->back()->with('status','อัปเดตข้อมูลเรียบร้อย');
    }

    public function worknow(Request $request) {

        $name = session('LoggedUser.user_login');
        $log = session('LoggedUser.department');
        //$where[] = ['user_login', '=', $name];

        if ($log == "Dev" || $log == "Sup" || $log == "Sale") {        //Admin----
            //$where[] = ['user_login', '<>', $name];
            $where[] = ['Status_id','=','P'];

        } else {
            $where[] = ['user_login', '=', $name];
            $where[] = ['Status_id','=','P'];
        }

        $data = Crq::where($where)
            //->where('Status_id','=','P')
            ->orderBy('CRQ_id', 'DESC')
            ->get();
        $sendto = Customer::whereIn('Usergroup_id',['Su','Ad'])
            //->and('Usergroup_id', '=', 'Ad')
            ->get();
        $lookup = Lookup::where('lookup_type', '=', 'Fix_type')
            ->whereIn('Lookup_code',['R','O'])
            //->orderBy('Lookup_description' , 'DESC')
            ->get();
        $lookup1 = Lookup::where('Lookup_type', '=', 'Job_status')
            ->whereIn('lookup_code',['W','CC']) //P
            ->orderBy('Lookup_description' , 'DESC')
            ->get();
        $lookupcat2 = Lookup::where('Lookup_type', '=', 'SV_cat')
            ->whereIn('Lookup_code',['P1','P24','PD','R1','R24','RD'])
            //->orderBy('Lookup_description' , 'DESC')
            ->get();
       

        //edit crq
        $customer = Customer::where('Usergroup_id', '=', 'Cus')
            ->get();
        $lookupser = Lookup::where('lookup_type', '=', 'Service')
            ->orderBy('Lookup_description' , 'DESC')
            ->get();
        $lookupcat = Lookup::where('Lookup_type', '=', 'SV_cat')
            ->whereIn('Lookup_code',['P','B','R','T','O','Q','MA','Add','Change','CC'])
            //->orderBy('Lookup_description' , 'DESC')
            ->get();
        $lookupsys = Lookup::where('lookup_type', '=', 'SV_system')
            //->orderBy('Lookup_description' , 'DESC')
            ->get();
        $lookupeq = Lookup::where('lookup_type', '=', 'SV_eqip')
            //->orderBy('Lookup_description' , 'DESC')
            ->get();
        $workto = Customer::where('Usergroup_id', '=', 'Su')
            ->get();
        $lookupfix = Lookup::where('Lookup_type','=','Fix_type')
            ->whereIn('Lookup_code',['R','O'])
            ->orderBy('Lookup_description' , 'DESC')
            ->get();
        $lookupprob = Lookup::where('lookup_type', '=', 'Prob_type')
            ->get();
        $user = Crq::select('User_login')
             //->groupby('Lookup_type')
             ->where('User_login','!=','')
             ->distinct()
             ->get();
        $asname = Crq::select('Assign_by')
             ->where('Assign_by','!=','NULL')
             ->where('Assign_by','!=','')
             ->distinct()
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
        if($request->filtername){
            $name = $request->filtername;

            $data = Crq::where($where)
                    ->where('User_login','=',$name)
                    ->get();
        }
        if($request->filterasname){
            $name = $request->filterasname;

            $data = Crq::where($where)
                    ->where('Assign_by','=',$name)
                    ->get();
        }
        

        return view('workarea.worknow', compact('asname','user','data','sendto','lookup','lookup1','customer','lookupser','lookupcat','lookupsys','lookupeq','workto','lookupfix','lookupprob','lookupcat2'));
    }

    public function editcrq($CRQ_id) 
    {
        $data = Crq::find($CRQ_id);

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
        
        return view('workarea.worknow','workarea.workall','workarea.workwait', with('data',$data,'CRQ_id'));

        //return response()->json($crq);
    }
    
    public function editsatis($CRQ_id) 
    {
        $data = Crq::find($CRQ_id);

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
        
        return view('workarea.worksatis', with('data',$data,'CRQ_id'));

        //return response()->json($crq);
    }

    public function show($CRQ_id) 
    {
        $data = Crq::find($CRQ_id);

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
        
        return view('workarea.worknow','workarea.workall', with('data',$data,'CRQ_id'));

        //return response()->json($crq);
    }
    
    public function sendjob($CRQ_id) 
    {
        $data = Crq::find($CRQ_id);
        $name = session('LoggedUser.user_login');

        if($data)
        {
            return response()->json([
                'status'=>200,
                'message'=>$data,
                'msg'=>$name,
            ]);
        }
        else{
            return response()->json([
                'status'=>404,
                'message'=>'Error noww',
            ]);
        }
        
        return view('workarea.worknow','workarea.workall','workarea.workwait','workarea.worksatis', with('data',$data,'CRQ_id','name',$name));

        //return response()->json($crq);
    }

    public function sjupdate(Request $request, $CRQ_id)
    {
        $CRQ_id = $request->input('send_id');
        $data = Crq::find($CRQ_id);

        $data->Assign_by = $request->Assign_by;
        $data->Comment = $request->Comment;
        //$data->Service = $request->edit_Service;

        $data->update();
        //return response()->json(['status'=>'ทำการอัปเดตสำเร็จ!']);
        return redirect()->back()->with('status','อัปเดตข้อมูลเรียบร้อย');
    }
    // public function comment(Request $request)
    // {
    //     $CRQ_id = $request->input('CRQ_id');
    //     $Assign_by = $request->input('Assign_by');
    //     $Comment = $request->input('Comment');

    //     $insert = Comment::insert([
    //         'CRQ_id' => $CRQ_id,
    //         'Comment' => $Comment,
    //         'Assign_by' => $Assign_by,
    //     ]);

    //     return redirect()->back()->with('status','เพิ่มข้อมูลเรียบร้อย');
    // }

    //  public function satisfaction(Request $request)
    // {
    //     $CRQ_id = $request->input('CRQ_id');
    //     $Level = $request->input('Level');
    //     $Comment = $request->input('Comment');

    //     $insert = Satisfaction::insert([
    //         'CRQ_id' => $CRQ_id,
    //         'Comment' => $Comment,
    //         'Level' => $Level,
    //     ]);

    //     return redirect()->back()->with('status','เพิ่มข้อมูลเรียบร้อย');
    // }

    public function upclosejobnow(Request $request, $CRQ_id)
    {
        $CRQ_id = $request->input('closejobdataid');
        $status = $request->input('closejob_status');
        $date = $_POST['closejob_date'];
        $Date = now();
	    //$time = $_POST['closejob_time'];
        //$Close_datetime = "$date $time";
        //$Assign_datetime = $request->input('$Assign_datetime');
        $data = Crq::find($CRQ_id);

        $data->Note = $request->closejob_note;
        $data->Fix_type = $request->data_Fixtype;
        $data->Cause = $request->closejob_cos;
        $data->Protect = $request->closejob_security;
        $data->Close_by = $request->closejob_by;
        $data->Close_datetime = $request->closejob_date;
        $data->Close_datetime = $Date;
        $data->Status_id = $request->closejob_status;
        $data->Prob_type = $request->closejob_Prob;

        $data->update();

        if($status == "W"){
            return redirect('/worksatis');
        }else{
            return redirect('/workall');
        }
        //return redirect('/workarea.worksatis');
        //return redirect()->back()->with('status','เพิ่มข้อมูลเรียบร้อย');
    }

    public function closeedit($CRQ_id)
    {
        $data = Crq::find($CRQ_id);
        
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
        return view('workarea.worknow', with('data',$data,'CRQ_id'));
    }

    public $timestamps = false;
    public function closeupdate(Request $request, $CRQ_id)
    {
        $CRQ_id = $request->input('closejob_data_id');
        $data = Crq::find($CRQ_id);

        $data->Close_by = $request->closejob_by;
        $data->Fix_type = $request->data_Fix_type;
        $data->Note = $request->closejob_note;
        $data->Cause = $request->closejob_cos;
        $data->Protect = $request->closejob_security;
        $data->Status_id = $request->closejob_status;

        $data->update();
        //return response()->json(['status'=>'ทำการอัปเดตสำเร็จ!']);
        return redirect('/workarea.worksatis');
    }

    // public function closeupdate(Request $request)
    // {
    //     $CRQ_id = $request->input('CRQ_id');
    //     $Fix_type = $request->input('data_Fix_type');
    //     $Note = $request->input('closejob_note');
    //     $Cause = $request->input('closejob_cos');
    //     $Protect = $request->input('closejob_security');
    //     $Status_id = $request->input('closejob_status');

    //     $insert = Crq::insert([
    //         //'CRQ_id' => $CRQ_id,
    //         'Fix_type' => $Fix_type,
    //         'Note' => $Note,
    //         'Cause' => $Cause,
    //         'Protect' => $Protect,
    //         'Status_id' => $Status_id,

    //     ]);

    //     return redirect()->back()->with('status','เพิ่มข้อมูลเรียบร้อย');
    // }

    public function closejob($CRQ_id) 
    {
        $data = Crq::find($CRQ_id);

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
        
        return view('workarea.worknow','workarea.workall', with('data',$data,'CRQ_id'));

        //return response()->json($crq);
    }


    // public function fetchcrq() {
    //     $crq = Crq::find(CRQ_id);
    //     return response()->json([
    //         'crq'=>$crq,
    //     ]);
    // }
    public function workall(Request $request) {

        $name = session('LoggedUser.user_login');
        $log = session('LoggedUser.department');
        //$where[] = ['user_login', '=', $name];

        if ($log == "Dev" || $log == "Sup" || $log == "Sale") { 
            $where[] = ['user_login', '<>', $name];
            //$where[] = ['Status_id','=','P'];

        } else {
            $where[] = ['user_login', '=', $name];
            //$where[] = ['Status_id','=','P'];
        }

        $data = Crq::where($where)
            ->orderBy('CRQ_id', 'DESC')
            ->get();
        $sendto = Customer::whereIn('Usergroup_id',['Su', 'Ad'])
            //->and('Usergroup_id', '=', 'Ad')
            ->get();
        $lookup = Lookup::where('lookup_type', '=', 'Fix_type')
            ->orderBy('Lookup_description' , 'DESC')
            ->get();
        $lookup1 = Lookup::whereIn('lookup_code',['W','CC'])
            ->get();
        $user = Crq::select('User_login')
            ->where('User_login','!=','NULL')
            ->where('User_login','!=','')
            ->distinct()
            ->get();
        $closename = Crq::select('Close_by')
            ->where('Close_by','!=','NULL')
            ->where('Close_by','!=','')
            ->distinct()
            ->get();
        //filter วันแจ้งงาน
        if($request->startdate){
            $start = $request->startdate;
            $end = $request->enddate;
        
            $data = Crq::where($where)
                        ->where('Request_datetime','>=',$start)
                        ->where('Request_datetime','<=',$end)
                        ->get();
        }
        //filter วันปิดงาน
        if($request->startdate1){
            $start1 = $request->startdate1;
            $end1 = $request->enddate1;
        
            $data = Crq::where($where)
                        ->where('Close_datetime','>=',$start1)
                        ->where('Close_datetime','<=',$end1)
                        ->get();
        }
        //filter บริษัท
        if($request->filtername){
            $name = $request->filtername;

            $data = Crq::where($where)
                    ->where('User_login','=',$name)
                    ->get();
        }
        //filter ผู้ปิดงาน
        if($request->filterclosename){
            $name = $request->filterclosename;

            $data = Crq::where($where)
                    ->where('Close_by','=',$name)
                    ->get();
        }

        return view('workarea.workall', compact('user','closename','data','sendto','lookup','lookup1'));
    }

    public function workwait(Request $request) {

        $name = session('LoggedUser.user_login');
        $log = session('LoggedUser.department');
        //$where[] = ['user_login', '=', $name];

        if ($log == "Dev" || $log == "Sup" || $log == "Sale") { 
            //$where[] = ['user_login', '<>', $name];
            $where[] = ['Status_id','=','N'];

        } else {
            $where[] = ['user_login', '=', $name];
            $where[] = ['Status_id','=','N'];
        }

        $data = Crq::where($where)
            //->where('Status_id','=','P')
            ->orderBy('CRQ_id', 'DESC')
            ->get();
        $sendto = Customer::whereIn('Usergroup_id',['Su', 'Ad'])
            //->and('Usergroup_id', '=', 'Ad')
            ->get();
        $lookup = Lookup::where('lookup_type', '=', 'Fix_type')
            ->orderBy('Lookup_description' , 'DESC')
            ->get();
        $lookupP = Lookup::where('Lookup_type','=','Job_status') 
            ->whereIn('Lookup_code',['N'])
            ->orderBy('Lookup_description' , 'DESC')
            ->get();
        

         //insert cus
         //$lookup11 = Lookup::query("SELECT * FROM lookup WHERE Lookup_type = 'Job_status' AND Lookup_code IN ('W','CC')")
            //$lookup11 = Lookup::where('Lookup_code','=','P','or','Lookup_code','=','R')
            $lookup11 = Lookup::where('Lookup_type','=','SV_cat')
            ->whereIn('Lookup_code',['P','B','R','T','O','Q','MA','Add','Change','CC'])
            //->orderBy('Lookup_description' , 'ASC')
            ->get();

        //edit crq
        $customer = Customer::where('Usergroup_id', '=', 'Cus')
            ->get();
        $lookupser = Lookup::where('lookup_type', '=', 'Service')
            ->orderBy('Lookup_description' , 'DESC')
            ->get();
        $lookupcat = Lookup::where('Lookup_type', '=', 'SV_cat')
            ->whereIn('Lookup_code',['R','Q','P','T','B','O','MA'])
            //->orderBy('Lookup_description' , 'DESC')
            ->get();
        $lookupcat2 = Lookup::where('Lookup_type', '=', 'SV_cat')
            ->whereIn('Lookup_code',['P1','P24','PD','R1','R24','RD'])
            //->orderBy('Lookup_description' , 'DESC')
            ->get();
        $lookupsys = Lookup::where('lookup_type', '=', 'SV_system')
            //->orderBy('Lookup_description' , 'DESC')
            ->get();
        $lookupeq = Lookup::where('lookup_type', '=', 'SV_eqip')
            //->orderBy('Lookup_description' , 'DESC')
            ->get();
        $workto = Customer::where('Usergroup_id', '=', 'Su')
            ->get();
        $lookupfix = Lookup::where('Lookup_type','=','Fix_type')
            ->whereIn('Lookup_code',['R','O'])
            ->orderBy('Lookup_description' , 'DESC')
            ->get();
        $user = Crq::select('User_login')
            //->groupby('Lookup_type')
            ->where('User_login','!=','')
            ->distinct()
            ->get();
        // $typename = Lookup::where('Lookup_type','=','SV_cat')
        //     ->whereIn('Lookup_code',['R','P','B','T','O','MA','Q','Add','Change','CC'])
        //     ->orderBy('Lookup_description' , 'DESC')
        //     ->get();
       $typename = Crq::select('SV_cat')
            ->where('SV_cat','!=','NULL')
            ->where('SV_cat','!=','')
            ->distinct()
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
       if($request->filtername){
           $name = $request->filtername;

           $data = Crq::where($where)
                   ->where('User_login','=',$name)
                   ->get();
       }
       if($request->filtertype){
           $name = $request->filtertype;

           $data = Crq::where($where)
                   ->where('SV_cat','=',$name)
                   ->get();
       }

        return view('workarea.workwait', compact('user','typename','data','sendto','lookup','lookupP','customer','lookupser','lookupcat','lookupsys','lookupeq','workto','lookupfix','lookup11','lookupcat2'));
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
        $sendto = Customer::whereIn('Usergroup_id', ['Su','Ad'])
            //->and('Usergroup_id', '=', 'Ad')
            ->get();
        $lookup = Lookup::where('lookup_type', '=', 'Fix_type')
            ->orderBy('Lookup_description' , 'DESC')
            ->get();
        $lookupP = Lookup::where('Lookup_type','=','Job_status')
            ->whereIn('Lookup_code', ['C'])
            ->orderBy('Lookup_description' , 'DESC')
            ->get();
        $level_satis = Lookup::where('Lookup_type','=','level_satisfaction')
            //->where('Lookup_type','=','SV_cat')
            //->orderBy('Lookup_description' , 'DESC')
            ->get();
        $lookupsatis = Lookup::where('Lookup_type','=','Job_status')
            ->whereIn('Lookup_code', ['C'])
            ->get();

         //insert cus
         //$lookup11 = Lookup::query("SELECT * FROM lookup WHERE Lookup_type = 'Job_status' AND Lookup_code IN ('W','CC')")
            //$lookup11 = Lookup::where('Lookup_code','=','P','or','Lookup_code','=','R')
        $lookup11 = Lookup::where('Lookup_type','=','SV_cat')
            //->where('Lookup_type','=','SV_cat')
            ->orderBy('Lookup_description' , 'DESC')
            ->get();
        $lookup1 = Lookup::whereIn('lookup_code',['W','CC'])
            ->orderBy('Lookup_description' , 'DESC')
            ->get();

        //edit crq
        $customer = Customer::where('Usergroup_id', '=', 'Cus')
            ->get();
        $lookupser = Lookup::where('lookup_type', '=', 'Service')
            ->orderBy('Lookup_description' , 'DESC')
            ->get();
        $lookupcat = Lookup::where('lookup_type', '=', 'SV_cat')
            ->orderBy('Lookup_description' , 'DESC')
            ->get();
        $lookupsys = Lookup::where('lookup_type', '=', 'SV_system')
            //->orderBy('Lookup_description' , 'DESC')
            ->get();
        $lookupeq = Lookup::where('lookup_type', '=', 'SV_eqip')
            //->orderBy('Lookup_description' , 'DESC')
            ->get();
        $workto = Customer::where('Usergroup_id', '=', 'Su')
            ->get();
        $lookupfix = Lookup::where('lookup_type', '=', 'Fix_type')
            //->orderBy('Lookup_description' , 'DESC')
            ->get();
        $user = Crq::select('User_login')
            ->where('User_login','!=','NULL')
            ->where('User_login','!=','')
            ->distinct()
            ->get();
        $closename = Crq::select('Close_by')
            ->where('Close_by','!=','NULL')
            ->where('Close_by','!=','')
            ->distinct()
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
        //filter บริษัท
        if($request->filtername){
            $name = $request->filtername;

            $data = Crq::where($where)
                    ->where('User_login','=',$name)
                    ->get();
        }
        //filter ผู้ปิดงาน
        if($request->filterclosename){
            $name = $request->filterclosename;

            $data = Crq::where($where)
                    ->where('Close_by','=',$name)
                    ->get();
        }
        return view('workarea.worksatis', compact('user','closename','result','data','sendto','lookup','lookupP','customer','lookupser','lookupcat','lookupsys','lookupeq','workto','lookupfix','lookup11','lookup1','level_satis','lookupsatis'));
    }

    public function masterDDL(Request $request) {

        $name = session('LoggedUser.user_login');
        //$where[] = ['user_login', '=', $name];

        if ($name == "Admin") {        //Admin----
            $where[] = ['user_login', '<>', $name];

        } else {
            $where[] = ['user_login', '=', $name];
        }

        $data = Lookup::orderBy('TS_id', 'DESC')
            //->where('')
            //->
            ->get();
        // $data = Lookup::all();
            //->where('Status_id','=','P')
            //->orderBy('TS_id', 'DESC')
            //->get();
        // $sendto = Customer::whereIn('Usergroup_id',['Su', 'Ad'])
        //     //->and('Usergroup_id', '=', 'Ad')
        //     ->get();
        $lookup = Lookup::select('Lookup_type')
             //->groupby('Lookup_type')
             ->distinct()
             ->get();
        
        // $lookupP = Lookup::where('Lookup_type','=','Job_status') 
        //     ->whereIn('Lookup_code',['P'])
        //     ->orderBy('Lookup_description' , 'DESC')
        //     ->get();
        

        //  //insert cus
        //  //$lookup11 = Lookup::query("SELECT * FROM lookup WHERE Lookup_type = 'Job_status' AND Lookup_code IN ('W','CC')")
        //     //$lookup11 = Lookup::where('Lookup_code','=','P','or','Lookup_code','=','R')
        //     $lookup11 = Lookup::where('Lookup_type','=','SV_cat')
        //     ->whereIn('Lookup_code',['P','B','R','T','O'])
        //     ->orderBy('Lookup_description' , 'DESC')
        //     ->get();

        // //edit crq
        // $customer = Customer::where('Usergroup_id', '=', 'Cus')
        //     ->get();
        // $lookupser = Lookup::where('lookup_type', '=', 'Service')
        //     ->orderBy('Lookup_description' , 'DESC')
        //     ->get();
        // $lookupcat = Lookup::where('lookup_type', '=', 'SV_cat')
        //     ->orderBy('Lookup_description' , 'DESC')
        //     ->get();
        // $lookupsys = Lookup::where('lookup_type', '=', 'SV_system')
        //     //->orderBy('Lookup_description' , 'DESC')
        //     ->get();
        // $lookupeq = Lookup::where('lookup_type', '=', 'SV_eqip')
        //     //->orderBy('Lookup_description' , 'DESC')
        //     ->get();
        // $workto = Customer::where('Usergroup_id', '=', 'Su')
        //     ->get();
        // $lookupfix = Lookup::where('lookup_type', '=', 'Fix_type')
        //     //->orderBy('Lookup_description' , 'DESC')
        //     ->get();

        return view('workarea.masterDDL', compact('data','lookup'));
    }
        public function detailDDL($TS_id) 
    {
        $data = Lookup::find($TS_id);

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
        
        return view('workarea.masterDDL', with('data',$data,'TS_id'));
    }

    public function addddl(Request $request)
    { 
        $Lookup_type = $request->input('Lookup_type');
        $Lookup_code = $request->input('Lookup_code');
        $Lookup_description = $request->input('Lookup_description');

        $insert = Lookup::insert([
            'Lookup_type' => $Lookup_type,
            'Lookup_code' => $Lookup_code,
            'Lookup_description' => $Lookup_description,
          ]);

        //<script>alert('เพิ่มข้อมูลสำเร็จ');window.location ='masterDDL.php';</script>
        return redirect()->back()->with('status','เพิ่มข้อมูลเรียบร้อย');
        //return redirect('/workwait');
    }
    public function ddl_edit($TS_id) 
    {
        $data = Lookup::find($TS_id);
        $message="Registered successfully";
        if($data)
        {
            return response()->json([
                'status'=>200,
                'message'=>$data,
                'status'=>'อัปเดตสำเร็จ!'
            ]);
        }
        else{
            return response()->json([
                'status'=>404,
                'message'=>'Error noww',
            ]);
        }
        
        //echo "<script>alert('อัปเดตข้อมูลสำเร็จ');window.location ='masterDDL.php';</script>";
        return view('workarea.masterDDL', with('data',$data,'TS_id'),compact('message'));

        //return response()->json($crq);
    }

    public function ddl_update(Request $request, $TS_id)
    {
        $TS_id = $request->input('Edit_ddl_id');
        $data = Lookup::find($TS_id);

        $data->Lookup_type = $request->edit_Lookup_type;
        $data->Lookup_code = $request->edit_Lookup_code;
        $data->Lookup_description = $request->edit_Lookup_description;

        $data->update();

        $message="Registered successfully";
        //return response()->json(['status'=>'ทำการอัปเดตสำเร็จ!']);
        return redirect()->back()->with('alert', 'Updated!');
    }

    public function ddl_delete($TS_id)
    {
        $del = Lookup::findOrFail($TS_id);
        $del->delete();
        return response()->json(['status'=>'ทำการลบสำเร็จ!']);
    }

    public function crq_delete($CRQ_id)
    {
        $del = Crq::findOrFail($CRQ_id);
        $del->delete();
        return response()->json(['status'=>'ทำการลบสำเร็จ!']);
    }

    public function filterdate(Request $request)
    {
    // this->validate($request,[
    // 'start_date' => 'required|date',
    // 'end_date' => 'required|date|before_or_equal:start_date',
    // ]);

    $start = $request->startdate;
    $end = $request->enddate;

    $data = Crq::where('Request_datetime','>=',$start)
                        ->where('Request_datetime','<=',$end);

    return view('workarea.worksatis', compact('data'));
    }

    public function checkbox(Request $request, $TS_id)
    {
        $TS_id = $request->input('Edit_ddl_id');
        $data = Lookup::find($TS_id);

        $data->Lookup_type = $request->edit_Lookup_type;
        $data->Lookup_code = $request->edit_Lookup_code;
        $data->Lookup_description = $request->edit_Lookup_description;

        $data->update();

        $message="Registered successfully";
        //return response()->json(['status'=>'ทำการอัปเดตสำเร็จ!']);
        return redirect()->back()->with('alert', 'Updated!');
    }

}
