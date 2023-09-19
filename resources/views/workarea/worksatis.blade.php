@extends('layouts.app')
@section('style')
    <link href="assets/plugins/vectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet" />
    {{-- <link href="assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" /> --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet" />
    <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.1/dist/sweetalert2.all.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.1/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.all.min.js"></script>
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>

    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="jquery.checkboxall-1.0.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        .text-wrap {
            white-space: normal;
        }
    </style>
@endsection

@section('wrapper')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="card radius-10">
                <div class="col-xl-12 col-lg-5">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3" style="background-color: azure">
                            <h6 class="m-0 font-weight-bold text-primary"><strong>รอประเมิน (จำนวน {{ $data->count()}} รายการ)</strong></h6>
                        </div>
                        <div id="success_message"></div>

                        <div class="card-body">
                            <div class="" style="display: flex; flex-wrap: wrap;">
                                <form method="get" action="{{ url('/workall') }}" id="myForm" style="width: 50%;
                                padding: 20px;
                                box-sizing: border-box;">
                                    @csrf
                                    {{-- @method('PUT') --}}
                                    <div class="form-group row ">
                                        <label class="col-4 col-form-label"><b>เริ่มวันที่</b></label>
                                        <label class="col-8 col-form-label"><b>ถึงวันที่</b></label>
                                        <div class="col-4">
                                            <input type="date" class="form-control" name="startdate" id="startdate"
                                                value="date('Y-m-d')">
                                        </div>
                                        <div class="col-4">
                                            <input type="date" class="form-control" name="enddate" id="enddate"
                                                value="date('Y-m-d')">
                                        </div>
                                        <div class="col-2">
                                            <button type="reset" value="clear" onclick="resetForm();"
                                                class="w3-button w3-round-xxlarge"
                                                style="background-color: rgb(233, 97, 97)">รีเซ็ต
                                                <i class="fa-solid fa-rotate-right"></i></button>
                                        </div>
                                    </div><br />
                                    <div class="form-group row">
                                        <div class="col-2">
                                            <button type="submit" value="Submit" name="search"
                                                class="w3-button w3-round-xxlarge"
                                                style="background-color: rgb(74, 226, 175)">ค้นหา <i
                                                    class="fa-solid fa-magnifying-glass"></i></button>
                                        </div>

                                    </div>
                                </form>
                                <form method="get" action="{{ url('/workwait') }}" id="myForm" style="width: 50%;
                                padding: 20px;
                                box-sizing: border-box;">
                                    @csrf
                                    {{-- @method('PUT') --}}
                                    <div class="form-group row ">
                                        <label class="col-4 col-form-label"><b>บริษัท</b></label>
                                        <label class="col-8 col-form-label"><b>ผู้ปิดงาน</b></label>
                                        <div class="col-4">
                                            {{-- <label class="col-12 col-form-label" for="exampleInputDate"><b>บริษัท</b></label> --}}
                                                <select class="form-control  form-select mb-3" id="filtername"
                                                    name="filtername" class="input-sm">
                                                    <option selected></option>
                                                    @foreach ($user as $cus)
                                                        <option value="{{ $cus->User_login }}">
                                                            {{ $cus->User_login }}
                                                        </option>
                                                    @endforeach
                                                </select> 
                                        </div>
                                        <div class="col-4">
                                            <select class="form-control  form-select mb-3" id="filterclosename"
                                                    name="filterclosename" class="input-sm">
                                                    <option selected></option>
                                                    @foreach ($closename as $cus)
                                                        <option value="{{ $cus->Close_by }}">
                                                            {{ $cus->Close_by }}
                                                        </option>
                                                    @endforeach
                                                </select> 
                                        </div>
                                        <div class="col-2">
                                            <button type="reset" value="clear" onclick="resetForm();"
                                                class="w3-button w3-round-xxlarge"
                                                style="background-color: rgb(233, 97, 97)">รีเซ็ต
                                                <i class="fa-solid fa-rotate-right"></i></button>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-2">
                                            <button type="submit" value="Submit" name="filtersearch"
                                                class="w3-button w3-round-xxlarge"
                                                style="background-color: rgb(74, 226, 175)">ค้นหา <i
                                                    class="fa-solid fa-magnifying-glass"></i></button>
                                        </div>

                                    </div>
                                </form>
                            </div>
                            <div class="d-flex align-items-center">
                                @if (session('LoggedUser.department') != 'Cus')
                                <div class="dropdown ms-auto">
                                    {{-- @foreach ($data as $row) --}}
                                    {{-- <button type="submit" value="Submit" name="newstatus" id="newstatus" class="w3-button w3-round-xlarge" data-bs-toggle="dropdown"
                                        style="background-color: rgb(156, 191, 231)">เลือกสถานะงาน</button> --}}
                                    <button type="submit" value="Submit" name="newstatus" id="newstatus"
                                        class="w3-button btn-primary w3-round btn-sm newstatus" data-bs-toggle="dropdown"
                                        style="font-size: 12px">อัปเดตสถานะ</button>
                                    <ul class="dropdown-menu">
                                        <li><button class="dropdown-item workwaitcrq" href="javascript:;" id="workwaitcrq"
                                                value="">รอประเมิน</button>
                                        </li>
                                        <li><button class="dropdown-item closecrq" href="javascript:;" id="closecrq"
                                                value="">ปิด</button>
                                        </li>

                                        </li>
                                    </ul>

                                </div>@else
                                @endif
                            </div>
                            <div class="table-responsive">
                                <table id="timesheet" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            @if (session('LoggedUser.department') != 'Cus')
                                                <th class="mob"><input type="checkbox" value="all" id="select-all"
                                                        name="selectAll"> All <label class="" for=""></label>
                                                </th>
                                            @else
                                            @endif
                                            <th>CRQ</th>
                                            <th>ประเภทบริการ</th>
                                            @if (session('LoggedUser.department') != 'Cus')
                                            <th>ความสำคัญของงาน</th>
                                            @else
                                            @endif
                                            <th>บริการ</th>
                                            <th>วันแจ้ง</th>
                                            <th>แจ้งโดย</th>
                                            <th>บริษัท</th>
                                            <th>รายละเอียดเพิ่มเติม</th>
                                            @if (session('LoggedUser.department') != 'Cus')
                                                <th>ผู้รับงาน</th>
                                                <th>ผู้ปิดงาน</th>
                                            @else
                                            @endif
                                            <th>สถานะงาน</th>
                                            {{-- <th hidden>สถานะงาน</th> --}}
                                            {{-- <th>ภาพประกอบ</th> --}}
                                            @if (session('LoggedUser.department') == 'Cus')
                                            <th>ตัวเลือก</th>
                                            @else
                                            @endif

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($data->count())
                                            @foreach ($data as $row)
                                                <tr id="tr_{{ $row->CRQ_id }}">
                                                    {{-- ? 'checked':'' --}}
                                                    <input type="hidden" id="Edit_ws_id" name="Edit_ws_id">
                                                    @if (session('LoggedUser.department') != 'Cus')
                                                        <td><input type="checkbox" class="sub_chk" name="checked[]"
                                                                id="master" data-id={{ $row->CRQ_id }} /></td>
                                                    @else
                                                    @endif
                                                    <td class="text-truncate" style="max-width: 200px;">
                                                        <button class="dropdown-item detail" value="{{ $row->CRQ_id }}">
                                                            {{ $row->CRQ_id }}</button>
                                                    </td>
                                                    <td>@if($row->SV_cat == 'P')
                                                        <span>แจ้งปัญหา(Problem)</span>
                                                    @elseif($row->SV_cat == 'B')
                                                        <span>ขอยืม(Borrow)</span>
                                                    @elseif($row->SV_cat == 'R')
                                                        <span>ขอเพิ่ม/แก้ไข(Request)</span>
                                                    @elseif($row->SV_cat == 'T')
                                                        <span>อบรม (Training)</span>
                                                    @elseif($row->SV_cat == 'O')
                                                        <span>อื่นๆ(Others)</span>
                                                    @elseif($row->SV_cat == 'Q')
                                                        <span>ใบเสนอราคา</span>
                                                    @elseif($row->SV_cat == 'Add')
                                                        <span>เพิ่มรหัสพนักงานขายใหม่</span>
                                                    @elseif($row->SV_cat == 'Change')
                                                        <span>เปลี่ยนรหัสพนักงานขายใหม่</span>
                                                    @elseif($row->SV_cat == 'CC')
                                                        <span>ยกเลิกรหัสพนักงานขาย</span>
                                                    @endif</td>
                                                    <td>@if($row->Priority == 'P1')
                                                        <span>Problem ปิดวันนี้</span>
                                                    @elseif($row->SV_cat == 'P24')
                                                        <span>Problem ปิดวันนี้</span>
                                                    @elseif($row->SV_cat == 'PD')
                                                        <span>Problem ตาม Due</span>
                                                    @elseif($row->SV_cat == 'R1')
                                                        <span>Request ปิดวันนี้</span>
                                                    @elseif($row->SV_cat == 'R24')
                                                        <span>Request ปิดวันนี้</span>
                                                    @elseif($row->SV_cat == 'RD')
                                                        <span>Request ตาม Due</span>
                                                    @endif</td>
                                                    <td>{{ $row->Service }}</td>
                                                    <td>{{ $row->Request_datetime }}</td>
                                                    <td class="text-truncate" style="max-width: 100px;">
                                                        <text class="dropdown-item"
                                                            value="{{ $row->Request_by }}">{{ $row->Request_by }}</text>
                                                    </td>
                                                    <td>{{ $row->User_login }} </td>
                                                    <td class="text-truncate" style="max-width: 200px;">
                                                        <button class="dropdown-item detail" id="detail"
                                                            value="{{ $row->CRQ_id }}"> {{ $row->Issue }}</button>
                                                    </td>
                                                    @if (session('LoggedUser.department') != 'Cus')
                                                        <td>{{ $row->Assign_by }} </td>
                                                        <td>{{ $row->Close_by }} </td>
                                                    @else
                                                    @endif
                                                    <td>
                                                        @if ($row->Status_id == 'N')
                                                            <span class="w3-button w3-yellow w3-round-xlarge">
                                                                รอจ่ายงาน</span>
                                                        @elseif($row->Status_id == 'P')
                                                            <span class="w3-button w3-round-xlarge"
                                                                style="background-color: SandyBrown"> ดำเนินงาน</span>
                                                        @elseif($row->Status_id == 'W')
                                                            <span class="w3-button w3-round-xlarge"
                                                                style="background-color: MediumAquamarine">รอประเมิน</span>
                                                        @elseif($row->Status_id == 'C')
                                                            <span class="w3-button w3-round-xlarge"
                                                                style="background-color: LimeGreen"> เสร็จแล้ว</span>
                                                        @elseif($row->Status_id == 'CC')
                                                            <span class="w3-button w3-red w3-round-xlarge">
                                                                งานถูกยกเลิก</span>
                                                        @endif

                                                    </td>
                                                    {{-- <td><a class="img-link img-link-zoom-in img-thumb img-lightbox imagemodal"
                                                        id="imagemodal"><img src="img/{{ $row->p_img }} " width="100"
                                                            style="padding-bottom:20px" /></a></td> --}}
                                                    @if (session('LoggedUser.department') == 'Cus')
                                                        <td>
                                                            <button type="button"
                                                                class="w3-button w3-round btn-sm addsatis" id="addsatis"
                                                                style="background-color: rgb(119, 205, 102)"
                                                                value="{{ $row->CRQ_id }}"><i
                                                                    class="fa-solid fa-pen-to-square"></i> ประเมิน</button>
                                                            {{-- <button type="button"
                                                                class="w3-button w3-round btn-danger btn-sm sendjob"
                                                                id="sendjob"
                                                                value="{{ $row->CRQ_id }}"><i class="fa-solid fa-trash-can"></i> ปิดงาน</button> --}}

                                                        </td>
                                                    @else
                                                    @endif


                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            @if (session('LoggedUser.department') != 'Cus')
                                                <th class="mob"><input type="checkbox" value="all" id="select-all"
                                                        name="selectAll"> All <label class=""
                                                        for=""></label>
                                                </th>
                                            @else
                                            @endif
                                            <th>CRQ</th>
                                            <th>ประเภทบริการ</th>
                                            @if (session('LoggedUser.department') != 'Cus')
                                            <th>ความสำคัญของงาน</th>
                                            @else
                                            @endif
                                            <th>บริการ</th>
                                            <th>วันแจ้ง</th>
                                            <th>แจ้งโดย</th>
                                            <th>บริษัท</th>
                                            <th>รายละเอียดเพิ่มเติม</th>
                                            @if (session('LoggedUser.department') != 'Cus')
                                                <th>ผู้รับงาน</th>
                                                <th>ผู้ปิดงาน</th>
                                            @else
                                            @endif
                                            <th>สถานะงาน</th>
                                            {{-- <th hidden>สถานะงาน</th> --}}
                                            {{-- <th>ภาพประกอบ</th> --}}
                                            @if (session('LoggedUser.department') == 'Cus')
                                            <th>ตัวเลือก</th>
                                            @else
                                            @endif

                                        </tr>
                                        
                                    </tfoot>
                                    
                                </table>
                                {{-- <div>
                                {{ $data->links() }}</div> --}}
                            </div>
                            
                        </div>
                        
                    </div>
                    
                </div>
            </div>
        </div>
    </div>

    <!-- edit crq Modal-->
    <div class="modal fade" id="editsatisModel" style="z-index:9999999;" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color: rgb(252, 253, 171)">
                    <h5 class="modal-title" id="exampleModalLabel">ฟอร์มปิดงานและสอบถามความพึงพอใจในการให้บริการ</h5>
                    <button class="close" type="button" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">X</span>
                    </button>
                </div>
                <div id="success_message"></div>
                <div class="modal-body">
                    @foreach ($data as $row)
                        <form method="POST" action="{{ url('update-satis/' . $row->CRQ_id) }}">
                    @endforeach
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="satisid" name="satisid">
                    <div class="form-group row">
                        <label class="col-12 col-form-label" for="exampleInputDate"><b>CRQ หมายเลข</b></label>
                        <div class="col-5">
                            <input class="form-control col-md-5" id="satis_id" name="satis_id" class="satis_id"
                                readonly>
                            </input>
                        </div>
                    </div>
                    <br />
                    <div class="form-group">
                        <label for="formGroupExampleInput"><strong>รายละเอียดเพิ่มเติม</strong></label>
                        <textarea name="satis_issue" Class="form-control" id="satis_issue" readonly></textarea>
                    </div> <br />
                    <div class="form-group">
                        <label class="col-12 col-form-label"
                            for="exampleInputDate"><b>ระดับความพึงพอใจในการให้บริการครั้งนี้</b></label>
                        <div class="col-5">
                            <select class="form-control col-md-5 form-select mb-3" id="edit_level" name="edit_level"
                                class="input-sm" required>
                                <option selected></option>
                                @foreach ($level_satis as $level)
                                    <option value="{{ $level->Lookup_code }}">
                                        {{ $level->Lookup_description }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <br />
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label for="validationactivity" class="col-12 col-form-label"><b>ข้อแนะนำเพิ่มเติม
                                    (เขียนได้ไม่ยั้งเลยครับ)</b></label>
                            <textarea name="edit_comment" class="activity form-control" id="edit_comment" required></textarea>
                            <div class="invalid-feedback">โปรดระบุรายละเอียด</div>
                        </div>
                    </div><br />
                    <div class="from-group" hidden>
                        <label class="col-12 col-form-label" for="SV_cat"><b>สถานะงาน</b></label>
                        @foreach ($lookupsatis as $look)
                            <input class="form-control form-select mb-3" style="width:230px;" id="edit_status"
                                name="edit_status" class="input-sm" value="{{ $look->Lookup_code }}" required readonly>
                            {{-- {{ $look->Lookup_description }} --}}{{ $look->Lookup_code }}
                        @endforeach
                    </div>
                    <div class="modal-footer">
                        <button id="updatecrq" type="submit" class="btn btn-primary" name="updatesatis">ตกลง</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                    </div>
                    </form>
                    {{-- @endforeach --}}
                </div>
            </div>
        </div>
    </div>
    <!-- End edit crq Modal-->
    <!-- Detail Job Modal-->
    <div class="modal fade" id="DetailModel" style="z-index:9999999;" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color: skyblue">
                    <h5 class="modal-title" id="exampleModalLabel">รายละเอียด</h5>
                    <button class="close" type="button" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">X</span>
                    </button>
                </div>
                <div id="success_message"></div>
                <div class="modal-body">
                    @foreach ($data as $row)
                        <form method="POST"
                            action="{{ url('/crq-data/' . $row->CRQ_id) }}>
@endforeach
                        @csrf
                        @method('PUT')
                        <input type="hidden"
                            id="detail_data_id" name="detail_data_id">
                            <div class="form-group">
                                <label for="formGroupExampleInput"><strong>CRQ หมายเลข</strong></label>
                                <input type="text" class="form-control" name="detail_id" id="detail_id" readonly>
                            </div><br />
                            <div class="form-group">
                                <label for="formGroupExampleInput"><strong>ลูกค้า</strong></label>
                                <input type="text" class="form-control" name="detail_customer" id="detail_customer"
                                    readonly>
                            </div><br />
                            <div class="form-group">
                                <label for="formGroupExampleInput"><strong>รายละเอียดเพิ่มเติม</strong></label>
                                <textarea name="detail_issue" Class="form-control" id="detail_issue" readonly></textarea>
                            </div><br />
                            <div class="form-group">
                                <label for="formGroupExampleInput"><strong>แจ้งโดย</strong></label>
                                <input type="text" class="form-control" name="detail_rqby" id="detail_rqby" readonly>
                            </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                </div>
                </form>
                {{-- @endforeach --}}
            </div>
        </div>
    </div>
    <!-- End Detail Job Modal-->
    <!-- sendjob Modal-->
    <div class="modal fade" id="sendjobModel" style="z-index:9999999;" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color: rgb(243, 92, 92)">
                    <h5 class="modal-title" id="exampleModalLabel">หน้าปิดงาน</h5>
                    <button class="close" type="button" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">X</span>
                    </button>
                </div>
                <div id="success_message"></div>
                <div class="modal-body">
                    @foreach ($data as $row)
                        <form action="{{ url('/crq-updatesendjob/' . $row->CRQ_id) }}" method="POST">
                    @endforeach
                    @csrf
                    @method('PUT')

                    <input type="hidden" id="sendjob_data_id" name="sendjob_data_id">
                    <div class="form-group">
                        <label for="formGroupExampleInput"><b>CRQ หมายเลข</b></label>
                        <input type="text" class="form-control" name="CRQ_id" id="CRQ_id" readonly>
                    </div><br />
                    <div class="form-group">
                        <label for="formGroupExampleInput"><b>ลูกค้า</b></label>
                        <input type="text" class="form-control" name="sendjob_cus" id="sendjob_cus" readonly>
                    </div><br />
                    <div class="form-group">
                        <label for="formGroupExampleInput"><b>รายละเอียดเพิ่มเติม</b></label>
                        <textarea name="sendjob_issue" Class="form-control" id="sendjob_issue" readonly></textarea>
                    </div><br />

                    <div class="from-group">
                        <label class="col-12 col-form-label" for="SV_cat"><b>สถานะงาน</b></label>
                        <select class="form-control form-select mb-3" style="width:230px;" id="wait_status"
                            name="wait_status" class="input-sm" required>
                            <option selected></option>
                            @foreach ($lookupP as $look)
                                <option value="{{ $look->Lookup_code }}">
                                    {{ $look->Lookup_description }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <br />
                    <div hidden>
                        <input type="text" id="sendjob_Assigndate" name="sendjob_Assigndate" value="('Y-m-d H:i:s')">
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" name="sendjob_update"
                            id="sendjob_update"">ตกลง</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                    </div>
                    </form>
                    {{-- @endforeach --}}
                </div>
            </div>
        </div>
    </div>
    <!-- End sendjob Modal-->
@endsection

@section('script')
    <script src="assets/plugins/vectormap/jquery-jvectormap-2.0.2.min.js"></script>
    <script src="assets/plugins/vectormap/jquery-jvectormap-world-mill-en.js"></script>
    <script src="assets/plugins/chartjs/js/Chart.min.js"></script>
    <script src="assets/plugins/chartjs/js/Chart.extension.js"></script>
    <script src="assets/plugins/jquery.easy-pie-chart/jquery.easypiechart.min.js"></script>
    <script src="assets/js/index.js"></script>
    <script>
        $(document).ready(function() {
            $('#timesheet').DataTable({
                "order": [
                    [1, "desc"]
                ]
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            var table = $('#example2').DataTable({
                lengthChange: false,
                buttons: ['copy', 'excel', 'pdf', 'print']
            });

            table.buttons().container()
                .appendTo('#example2_wrapper .col-md-4:eq(0)');
        });
    </script>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            //details
            $(document).on('click', '.detail', function(e) {
                e.preventDefault();
                var CRQ_id = $(this).val();
                //alert(CRQ_id);
                $('#DetailModel').modal('show');

                $.ajax({
                    type: "GET",
                    url: "/crq-data/" + CRQ_id,
                    success: function(response) {
                        console.log(response);
                        if (response.status == 404) {
                            $('#success_message').html("");
                            $('#success_message').addClass('alert alert-danger');
                            $('#success_message').text(response.message);
                        } else {
                            $('#detail_id').val(response.message.CRQ_id);
                            $('#detail_customer').val(response.message.User_login);
                            $('#detail_issue').val(response.message.Issue);
                            $('#detail_rqby').val(response.message.Request_by);
                            $('#detail_data_id').val(CRQ_id);

                            // $('#edit_category').val(response.message.Category);
                            // $('#edit_project').val(response.message.Project);
                        }
                    }
                });
            });

            //edit satis
            $(document).on('click', '.addsatis', function(e) {
                e.preventDefault();
                var CRQ_id = $(this).val();
                //alert(CRQ_id);
                $('#editsatisModel').modal('show');
                //alert("eieiei");
                $.ajax({
                    type: "GET",
                    url: "/edit-satis/" + CRQ_id,
                    success: function(response) {
                        console.log(response);
                        if (response.status == 404) {
                            $('#success_message').html("");
                            $('#success_message').addClass('alert alert-danger');
                            $('#success_message').text(response.message);
                        } else {
                            $('#satis_id').val(response.message.CRQ_id);
                            $('#edit_level').val(response.message.Satis_level);
                            $('#edit_comment').val(response.message.Satis_comment);
                            //$('#edit_status').val(response.message.Status_id);
                            $('#satis_issue').val(response.message.Issue);
                            $('#satisid').val(CRQ_id);
                        }
                    }
                });
            });

            //update satis
            $(document).on('click', '.updatesatis', function(e) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                e.preventDefault();
                var CRQ_id = $('#satisid').val();
                //var CRQ_id = $(this).val();
                //alert(CRQ_id);
                var data = {
                    'Satis_level': $('#edit_level').val(),
                    'Satis_comment': $('#edit_comment').val(),
                    'Status_id': $('#edit_status').val(),
                    //'Due_date': $('#wait_duedate').val(),
                }
                $.ajax({
                    type: "PUT",
                    url: "/update-satis/" + CRQ_id,
                    data: data,
                    dataType: "json",

                    success: function(response) {
                        console.log(response);
                        if (response.status == 400) {
                            $('#success_message').html("");
                            $('#success_message').addClass('alert alert-danger');
                            $('#success_message').text(response.message);
                        } else {

                        }
                    }
                });
            });

            //sendjob-edit
            $(document).on('click', '.sendjob', function(e) {
                e.preventDefault();
                var CRQ_id = $(this).val();
                //alert(CRQ_id);
                $('#sendjobModel').modal('show');
                //alert("eieiei");
                $.ajax({
                    type: "GET",
                    url: "/crq-sendjob/" + CRQ_id,
                    success: function(response) {
                        console.log(response);
                        if (response.status == 404) {
                            $('#success_message').html("");
                            $('#success_message').addClass('alert alert-danger');
                            $('#success_message').text(response.message);
                        } else {
                            $('#CRQ_id').val(response.message.CRQ_id);
                            $('#sendjob_SV_cat').val(response.message.SV_cat);
                            $('#sendjob_cus').val(response.message.User_login);
                            $('#sendjob_issue').val(response.message.Issue);
                            $('#wait_duedate').val(response.message.Due_date);
                            $('#sendjob_Assigndate').val(response.message.Assign_datetime);
                            $('#sendjob_SV_system').val(response.message.SV_system);
                            $('#sendjob_SV_eqip').val(response.message.SV_eqip);
                            $('#sendjobto').val(response.message.Assign_by);
                            $('#sendjob_Fix').val(response.message.Fix_type);
                            $('#wait_status').val(response.message.Status_id);
                            $('#sendjob_data_id').val(CRQ_id);
                            // $('#edit_category').val(response.message.Category);
                            // $('#edit_project').val(response.message.Project);
                        }
                    }
                });
            });

            //sendjob-update
            $(document).on('click', '.sendjob_update', function(e) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                // console.log('btn click');
                // Swal.fire({
                //     text: "Successful!",
                //     type: 'success',
                //     icon: "success",
                //     showCloseButton: true
                // })
                e.preventDefault();
                var CRQ_id = $('#sendjob_data_id').val();
                //var CRQ_id = $(this).val();
                //alert(CRQ_id);
                var data = {
                    'Assign_datetime': $('#Assign_datetime').val(),
                    //'Request_datetime': $('#edit_date').val(),
                    'Due_date': $('#wait_duedate').val(),
                    //'Request_by': $('#edit_Request_by').val(),
                    'User_login': $('#sendjob_cus').val(),
                    //'Customer_tel': $('#edit_Customer_tel').val(),
                    //'Service': $('#edit_Service').val(),
                    'SV_cat': $('#sendjob_SV_cat').val(),
                    'SV_system': $('#sendjob_SV_system').val(),
                    'SV_eqip': $('#sendjob_SV_eqip').val(),
                    //'p_img': $('#edit_p_img').val(),
                    'Issue': $('#sendjob_issue').val(),
                    'Assign_by': $('#sendjobto').val(),
                    'Fix_type': $('#sendjob_Fix').val(),
                }

                $.ajax({
                    type: "PUT",
                    url: "/crq-updatesendjob/" + CRQ_id,
                    data: data,
                    dataType: "json",

                    success: function(response) {
                        console.log(response);
                        if (response.status == 400) {
                            $('#success_message').html("");
                            $('#success_message').addClass('alert alert-danger');
                            $('#success_message').text(response.message);
                        } else {

                        }
                    }
                });
            });
            //update chk
            $(document).on('click', '.closecrq', function(e) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                e.preventDefault();
                $(document).on('click', '.master', function(x) {
                    x.preventDefault();
                    if ($(this).is(':checked', true)) {
                        $(".sub_chk").prop('checked', true);
                    } else {
                        $(".sub_chk").prop('checked', false);
                    }
                    var CRQ_id = $('#sendjob_data_id').val();
                    //var CRQ_id = $(this).val();
                    //alert(CRQ_id);
                    var data = {
                        // 'Status_id' => 'C',
                        // 'Status_id': $('#sendjob_Fix').val(),
                    }

                    $.ajax({
                        type: "PUT",
                        url: "/crq-updatesendjob/" + CRQ_id,
                        data: data,
                        dataType: "json",

                        success: function(response) {
                            console.log(response);
                            if (response.status == 400) {
                                $('#success_message').html("");
                                $('#success_message').addClass('alert alert-danger');
                                $('#success_message').text(response.message);
                            } else {

                            }
                        }
                    });
                });
            });
        });
    </script>
    //check box
    {{-- <script type="text/javascript">
        $(document).ready(function () {
        $('#master').on('click', function(e) {
          if($(this).is(':checked',true))  
          {
              $(".sub_chk").prop('checked', true);  
          } else {  
              $(".sub_chk").prop('checked',false);  
          }  
        });
 
        $('.closecrq').on('click', function(e) {
            alert("Please select row.");
            var allVals = [];  
            $(".sub_chk:checked").each(function() {  
                allVals.push($(this).attr('data-id'));
            });  
            if(allVals.length <=0)  
            {  
                alert("Please select row.");  
            }  else {  
                var check = confirm("ยืนยันการทำรายการ?");  
                if(check == true){  
                    var join_selected_values = allVals.join(","); 
                    $.ajax({
                        url: $(this).data('url'),
                        type: 'PUT',
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: 'ids='+join_selected_values,
                        success: function (data) {
                            if (data['success']) {
                                $(".sub_chk:checked").each(function() {  
                                    // $(this).parents("tr").remove();
                                    var data = {
                                        'Status_id': $('#')
                                    }
                                });
                                alert(data['success']);
                            } else if (data['error']) {
                                alert(data['error']);
                            } else {
                                alert('Whoops Something went wrong!!');
                            }
                        },
                        error: function (data) {
                            alert(data.responseText);
                        }
                    });
                  $.each(allVals, function( index, value ) {
                    //   $('table tr').filter("[data-row-id='" + value + "']").remove();
                  });
                }  
            }  
        });
    </script> --}}

    <script src="assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
    <script src="assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#example').DataTable({
                "order": [
                    [2, "desc"]
                ]
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            var table = $('#example2').DataTable({
                lengthChange: false,
                buttons: ['copy', 'excel', 'pdf', 'print']
            });

            table.buttons().container()
                .appendTo('#example2_wrapper .col-md-6:eq(0)');
        });
    </script>
    <script src="assets/plugins/input-tags/js/tagsinput.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>

    <!-- Page JS Plugins -->
    <script src="js/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="js/plugins/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page JS Code -->
    <script src="js/pages/be_tables_datatables.min.js"></script>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>


    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="js/app.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <!-- <script src="js/demo/chart-pie-demo.js"></script> -->

    <!-- Page level plugins -->
    <!-- <script src="vendor/datatables/jquery.dataTables.js"></script> -->
    <script src="vendor/datatables/dataTables.bootstrap4.js"></script>
    <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

    {{-- <script>
        $(document).ready(function () {
        $('#dtBasicExample').DataTable();
        $('.dataTables_length').addClass('bs-select');
    });
    </script> --}}
    <script src="{{ asset('js/plugins/TableCheckAll.js') }}"></script>
    <script type="text/javascript">
        function CheckAll(obj) {
            var row = obj.parentNode.parentNode;
            var inputs = row.getElementsByTagName("input");
            for (var i = 0; i < inputs.length; i++) {
                if (inputs[i].type == "checkbox") {
                    inputs[i].checked = obj.checked;
                }
            }
        }
    </script>
    <script>
        $(document).ready(function() {
            $('#select-all').click(function() {
                $('input[type="checkbox"]').prop('checked', this.checked);
            })
        });
        // $(document).ready(function() {
        //     $('#select-all').checkboxall();
        //     })
    </script>
@endsection
