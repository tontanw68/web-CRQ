@extends('layouts.app')
@section('style')
    <link href="assets/plugins/vectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet" />
    <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.1/dist/sweetalert2.all.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.1/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.all.min.js"></script>
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>

    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

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
                            <h6 class="m-0 font-weight-bold text-primary"><strong>งานระหว่างดำเนินการ (จำนวน
                                    {{ $data->count() }} รายการ)</strong></h6>
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
                                        <label class="col-8 col-form-label"><b>ผู้รับงาน</b></label>
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
                                            <select class="form-control  form-select mb-3" id="filterasname"
                                                    name="filterasname" class="input-sm">
                                                    <option selected></option>
                                                    @foreach ($asname as $cus)
                                                        <option value="{{ $cus->Assign_by }}">
                                                            {{ $cus->Assign_by }}
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
                            <div class="table-responsive">
                                <table id="timesheet" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
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
                                                
                                            @else
                                            @endif
                                            <th>สถานะงาน</th>
                                            {{-- <th hidden>สถานะงาน</th> --}}
                                            <th>ภาพประกอบ</th>
                                            @if (session('LoggedUser.department') != 'Cus')
                                                <th>ตัวเลือก</th>
                                            @else
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($data as $row)
                                            <tr>

                                                <td class="text-truncate" style="max-width: 200px;">
                                                    <button class="dropdown-item detail" id="detail"
                                                        value="{{ $row->CRQ_id }}"> {{ $row->CRQ_id }}</button>
                                                </td>
                                                <td>
                                                    @if ($row->SV_cat == 'P')
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
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($row->Priority == 'P1')
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
                                                    @endif
                                                </td>

                                                <td>{{ $row->Service }}</td>
                                                <td>{{ $row->Request_datetime }} </td>
                                                <td>{{ $row->Request_by }} </td>

                                                <td>{{ $row->User_login }} </td>

                                                <td class="text-truncate" style="max-width: 200px;">
                                                    <button class="dropdown-item detail" id="detail"
                                                        value="{{ $row->CRQ_id }}"> {{ $row->Issue }}</button>
                                                </td>
                                                @if (session('LoggedUser.department') != 'Cus')
                                                    <td>{{ $row->Assign_by }} </td>
                                                @else
                                                @endif
                                                <td>
                                                    @if ($row->Status_id == 'N')
                                                        <span class="w3-button w3-yellow w3-round-xlarge">รอจ่ายงาน </span>
                                                    @elseif($row->Status_id == 'P')
                                                        <span class="w3-button w3-round-xlarge"
                                                            style="background-color: SandyBrown"> ดำเนินงาน</span>
                                                    @elseif($row->Status_id == 'W')
                                                        <span class="w3-button w3-round-xlarge"
                                                            style="background-color: MediumAquamarine"> รอประเมิน</span>
                                                    @elseif($row->Status_id == 'C')
                                                        <span class="w3-button w3-round-xlarge"
                                                            style="background-color: LimeGreen"> เสร็จแล้ว</span>
                                                    @elseif($row->Status_id == 'CC')
                                                        <span class="w3-button w3-red w3-round-xlarge"> งานถูกยกเลิก</span>
                                                    @endif
                                                    {{-- <div class="btn-group">
                                                    <button
                                                        class="btn btn-alt-danger btn-rounded btn-block dropdown-toggle"
                                                        type="button" data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <a class="fas fa-cog fa-spin"></a>
                                                    </button> --}}
                                                </td>
                                                <td><a class="img-link img-link-zoom-in img-thumb img-lightbox imagemodal"
                                                        id="imagemodal"><img src="img/{{ $row->p_img }} "
                                                            width="100" style="padding-bottom:20px" /></a></td>
                                                @if (session('LoggedUser.department') != 'Cus')
                                                    <td>
                                                        <div class="dropdown btn-sm">
                                                            <a class="dropdown-toggle dropdown-toggle-nocaret"
                                                                href="#" data-bs-toggle="dropdown"><i
                                                                    class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
                                                            </a>
                                                            <ul class="dropdown-menu">
                                                                <li><button class="dropdown-item editcrq"
                                                                        href="javascript:;" id="editcrq"
                                                                        value="{{ $row->CRQ_id }}">แก้ไขข้อมูล</button>
                                                                </li>
                                                                <li><button class="dropdown-item sendjob"
                                                                        href="javascript:;" id="sendjob"
                                                                        value="{{ $row->CRQ_id }}">ส่งงานต่อ</button>
                                                                </li>
                                                                <li><button class="dropdown-item closejob"
                                                                        href="javascript:;" id="closejob"
                                                                        value="{{ $row->CRQ_id }}">ปิดงาน</button>
                                                                </li>

                                                            </ul>
                                                        </div>

                                                        {{-- <button type="button"
                                                        class="w3-button w3-yellow w3-round btn-sm editcrq" id="editcrq"
                                                        value="{{ $row->CRQ_id }}" style="font-size: 12px">แก้ไข</button>

                                                    <button type="button" class="w3-button w3-round btn-sm sendjob"
                                                        style="background-color: SandyBrown" id="sendjob"
                                                        value="{{ $row->CRQ_id }}">ส่งต่องาน</button>

                                                    <button type="button" class="w3-button w3-red w3-round btn-sm closejob"
                                                        id="closejob" value="{{ $row->CRQ_id }}">ปิดงาน</button> --}}


                                                    </td>
                                                @else
                                                @endif


                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
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
                                                
                                            @else
                                            @endif
                                            <th>สถานะงาน</th>
                                            {{-- <th hidden>สถานะงาน</th> --}}
                                            <th>ภาพประกอบ</th>
                                            @if (session('LoggedUser.department') != 'Cus')
                                                <th>ตัวเลือก</th>
                                            @else
                                            @endif
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- edit crq Modal-->
    <div class="modal fade" id="editcrqModel" style="z-index:9999999;" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color: rgb(252, 253, 171)">
                    <h5 class="modal-title" id="exampleModalLabel">แก้ไขข้อมูล CRQ.</h5>
                    {{-- <input class="col-2" id="headedit" value="{{ $row->CRQ_id }}" readonly></input> --}}
                    <button class="close" type="button" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">X</span>
                    </button>
                </div>
                <div id="success_message"></div>
                <div class="modal-body">
                    @foreach ($data as $row)
                        <form method="POST" action="{{ url('update-crq/' . $row->CRQ_id) }}">
                    @endforeach
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="editcrq_data_id" name="editcrq_data_id">
                    {{-- <div class="form-group row">
                            <label class="col-12 col-form-label">วันที่แจ้ง</label>
                            <div class="col-5">
                                <input type="date" class="form-control" NAME="edit_date" id="edit_date">
                            </div>
                            <div class="col-5">
                                <input type="time" class="form-control" NAME="edit_time" id="edit_time">
                            </div>
                        </div> --}}

                    {{-- <div class="form-group row">
                            <label class="col-12 col-form-label">Due date</label>
                            <div class="col-5">
                                <input type="date" class="form-control" name="edit_duedate" 
                                id="edit_duedate">
                            </div>
                        </div> --}}
                    <div class="form-group row">
                        <label class="col-12 col-form-label"><b>CRQ หมายเลข</b></label>
                        <div class="col-5">
                            <input type="text" class="form-control" name="CRQ_id" id="CRQ_id" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-form-label" for="exampleInputName1"><b>ผู้แจ้ง (Requestor)</b></label>
                        <div class="col-5">
                            <input type="text" class="form-control" name="edit_Request_by" id="edit_Request_by"
                                placeholder="ชื่อผู้แจ้ง">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-12 col-form-label" for="exampleInputDate"><b>บริษัท</b></label>
                        <div class="col-5">
                            <select class="form-control col-md-5 form-select mb-3" id="edit_User_login"
                                name="edit_User_login" class="input-sm">
                                <option selected></option>
                                @foreach ($customer as $cus)
                                    <option value="{{ $cus->User_login }}">
                                        {{ $cus->User_login }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-12 col-form-label"><b>เบอร์ติดต่อ (Tel./ Ext.)</b></label>
                        <div class="col-5">
                            <input type="text" class="form-control col-md-5" name="edit_Customer_tel"
                                id="edit_Customer_tel" placeholder="เบอร์ติดต่อ">
                        </div>
                    </div>
                    {{-- <br/> --}}
                    <div class="form-group row">
                        <div class="col-6">
                            <label class="col-12 col-form-label"><b>บริการ <br />
                                    (Service)</b></label>

                            <select class="form-control form-select mb-3" name="edit_Service" id="edit_Service"
                                class="input-sm">
                                <option selected></option>
                                @foreach ($lookupser as $look)
                                    <option value="{{ $look->Lookup_code }}">
                                        {{ $look->Lookup_description }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="col-12 col-form-label"><b>ประเภทบริการ(Service Categories)</b></label>
                            <select class="form-control form-select mb-3" id="edit_SV_cat" name="edit_SV_cat"
                                class="input-sm">
                                <option selected></option>
                                @foreach ($lookupcat as $look)
                                    <option value="{{ $look->Lookup_code }}">
                                        {{ $look->Lookup_description }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-6">
                            <label class="col-12 col-form-label"><b>ความสำคัญของงาน(Priority)</b></label>
                            <select class="form-control form-select mb-3" id="edit_SV_cat2" name="edit_SV_cat2"
                                class="input-sm">
                                <option selected>ไม่ระบุ</option>
                                @foreach ($lookupcat2 as $look)
                                    <option value="{{ $look->Lookup_code }}">
                                        {{ $look->Lookup_description }}
                                    </option>
                                @endforeach>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-5">
                            <label class="col-12 col-form-label"><b>ระบบ (System)</b></label>
                            <select class="form-control form-select mb-3" id="edit_SV_system" name="edit_SV_system"
                                class="input-sm">
                                <option selected></option>
                                @foreach ($lookupsys as $look)
                                    <option value="{{ $look->Lookup_code }}">
                                        {{ $look->Lookup_description }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-5">
                            <label class="col-12 col-form-label"><b>อุปกรณ์ (Equipments)</b></label>
                            <select class="form-control form-select mb-3" id="edit_SV_eqip" name="edit_SV_eqip"
                                class="input-sm">
                                <option selected></option>
                                @foreach ($lookupeq as $look)
                                    <option value="{{ $look->Lookup_code }}">
                                        {{ $look->Lookup_description }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <label class="col-12 col-form-label"><b>อัพโหลดไฟล์ภาพ</b></label>
                        <div class="col-7">
                            <!-- Populating custom file input label with the selected filename (data-toggle="custom-file-input" is initialized in Helpers.coreBootstrapCustomFileInput()) -->
                            <input type="file" name="edit_p_img" multiple="multiple"
                                class="custom-file-input form-control" id="edit_p_img" name="example-file-input-custom"
                                data-toggle="custom-file-input">
                            {{-- <label class="custom-file-label " for="example-file-input-custom">เลือกรูปภาพ</label> --}}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-12 col-form-label" for="exampleTextarea1"><b>รายละเอียดเพิ่มเติม</b></label>
                        <div class="col-12">
                            <textarea name="edit_Issue_" class="form-control col-md-12" id="edit_Issue_" rows="2"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-form-label" for="exampleInputDate"><b>มอบหมายงาน</b></label>
                        <div class="col-5">
                            <select class="form-control form-select mb-3" id="edit_Assign_by" name="edit_Assign_by"
                                class="input-sm">
                                <option selected></option>
                                @foreach ($workto as $work)
                                    <option value="{{ $work->User_login }}">
                                        {{ $work->User_login }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-form-label" for="exampleFormControlInput"><b>วิธีแก้ไข</b></label>
                        <div class="col-3">
                            <select name="edit_Fix_type" class="form-control form-select mb-3" id="edit_Fix_type" " required oninvalid="this.setCustomValidity('โปรดกรอกข้อมูลให้ครบ')"
                                    oninput="setCustomValidity('')">
                                    <option selected></option>
                                     @foreach ($lookupfix as $look)
                                <option value="{{ $look->Lookup_code }}">
                                    {{ $look->Lookup_description }}
                                </option>
                                @endforeach

                            </select>
                        </div>
                    </div>
                    <br />
                    <div class="from-group">
                        <div class="form-check {{ $errors->has('is_finished') ? 'is-invalid' : '' }}">
                            <input type="checkbox" class="form-check-input" value="1"
                                {{ old('is_finished') == 1 ? 'checked' : '' }} name="is_finished" id="is_finished">
                            <label class="form-check-label" for="is_finished"><b>Third Party</b></label>
                            {{-- <input type="checkbox" class="sub_chk" name="checked[]" id="Third_Party" value="Third_Party" {{ in_array('Third_Party', $row) ? 'checked' : '' }} > <b>Third Party</b> --}}
                        </div>
                    </div><br />
                    <div class="modal-footer">
                        <button id="updatecrq" type="Submit" class="btn btn-primary" name="updatecrq">ตกลง</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                    </div>
                    </form>
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
                            {{-- @foreach ($data as $row) --}}
                            <div class="form-group">
                                <label for="formGroupExampleInput"><strong>CRQ หมายเลข</strong></label>

                                <input type="text" class="form-control" name="detail_id" id="detail_id" readonly>
                                {{-- @endforeach --}}
                            </div><br />
                            <div class="form-group">
                                <label for="formGroupExampleInput"><strong>ลูกค้า</strong></label>
                                {{-- @foreach ($data as $row) --}}
                                <input type="text" class="form-control" name="detail_customer" id="detail_customer"
                                    readonly>
                                {{-- @endforeach --}}
                            </div><br />
                            <div class="form-group">
                                <label for="formGroupExampleInput"><strong>รายละเอียดเพิ่มเติม</strong></label>
                                {{-- @foreach ($data as $row) --}}
                                <textarea name="detail_issue" Class="form-control" id="detail_issue" readonly></textarea>
                                {{-- @endforeach --}}
                            </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
                </form>

            </div>
        </div>
    </div>
    <!-- End Detail Job Modal-->
    <!-- sendjob Modal-->
    <div class="modal fade" id="sjModel" style="z-index:9999999;" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color: rgb(230, 167, 112)">
                    <h5 class="modal-title" id="exampleModalLabel">หน้ามอบงาน</h5>
                    <button class="close" type="button" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">X</span>
                    </button>
                </div>
                <div id="success_message"></div>
                <div class="modal-body">
                    @foreach ($data as $row)
                        <form action="{{ url('/sjupdate/' . $row->CRQ_id) }}" method="POST">
                    @endforeach
                    @csrf
                    @method('PUT')

                    <input type="hidden" id="send_id" name="send_id">
                    <div class="form-group">
                        <label for="formGroupExampleInput"><b>CRQ หมายเลข</b></label>
                        <input type="text" class="form-control" name="sendjob_CRQ_id" id="sendjob_CRQ_id" readonly>
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
                        <label for="formGroupExampleInput"><b>มอบหมาย</b></label>
                        <select class="form-control form-select mb-3" style="width:230px;" name="Assign_by"
                            id="Assign_by" required oninvalid="this.setCustomValidity('โปรดกรอกข้อมูลให้ครบ')"
                            oninput="setCustomValidity('')">
                            <option selected></option>
                            @foreach ($sendto as $cus)
                                <option value="{{ $cus->User_login }}">
                                    {{ $cus->User_login }}
                                </option>
                            @endforeach
                        </select>
                    </div><br />
                    <div class="from-group">
                        <label for="formGroupExampleInput"><b>เหตุผล</b></label>
                        <textarea name="Comment" class="form-control" id="Comment" style="width:300px;" required
                            oninvalid="this.setCustomValidity('โปรดกรอกข้อมูลให้ครบ')" oninput="setCustomValidity('')"></textarea>
                    </div><br />
                    <div hidden>
                        <input type="text" id="Assign_datetime" name="data-Assign_datetime" value="('Y-m-d H:i:s')">
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" name="senddata" id="senddata">ตกลง</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End sendjob Modal-->
    <!-- Closejob Modal-->
    <div class="modal fade" id="closejobModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: rgb(235, 104, 104)">
                    <h5 class="modal-title" id="exampleModalLabel">หน้าปิดงาน</h5>
                    <button class="close" type="button" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">X</span>
                    </button>
                </div>
                <div id="success_message"></div>
                <div class="modal-body">
                    @foreach ($data as $row)
                        <form method="POST" action="{{ url('/upclosejobnow/' . $row->CRQ_id) }}" id="myform">
                    @endforeach
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="closejobdataid" name="closejobdataid">
                    {{-- <div hidden class="form-group">
                        <label for="exampleInputDate">ซ่อนเก็บชื่อวันเวลา</label>
                        <input type="text" name="Assign_datetime" value="{{ date("Y-m-d H:i:s") }}">
                
                    </div> --}}
                    <div class="form-group">
                        <label for="formGroupExampleInput"><b>CRQ หมายเลข</b></label>
                        <input type="text" class="form-control" name="closejob_crqno" id="closejob_crqno" readonly>
                    </div><br />
                    <div class="form-group">
                        <label for="formGroupExampleInput"><b>ลูกค้า</b></label>
                        <input type="text" class="form-control" name="closejob_cus" id="closejob_cus" readonly>
                    </div><br />
                    <div class="form-group">
                        <label for="formGroupExampleInput"><b>ผู้ปิดงาน</b></label>
                        {{-- @foreach ($name as $call) --}}
                        <input type="text" class="form-control" name="closejob_by" id="closejob_by" value=""
                            readonly>
                        {{-- @endforeach --}}
                    </div><br />
                    <div class="form-group">
                        <label for="formGroupExampleInput"><b>รายละเอียดเพิ่มเติม</b></label>
                        <textarea name="closejob_issue" Class="form-control" id="closejob_issue" readonly></textarea>
                    </div><br />
                    <div class="form-group">
                        <label for="formGroupExampleInput"><b>ประเภทปัญหา</b></label>
                        <select name="closejob_Prob" class="form-control form-select mb-3" id="closejob_Prob"
                            style="width:230px;" required oninvalid="this.setCustomValidity('โปรดกรอกข้อมูลให้ครบ')"
                            oninput="setCustomValidity('')">
                            <option selected></option>
                            @foreach ($lookupprob as $look)
                                <option value="{{ $look->Lookup_code }}">
                                    {{ $look->Lookup_description }}
                                </option>
                            @endforeach
                        </select>
                    </div><br />
                    <div class="form-group">
                        <label for="exampleFormControlInput"><b>วิธีแก้ไข</b></label>
                        <select name="data_Fixtype" class="form-control form-select mb-3" id="data_Fixtype"
                            style="width:230px;" required oninvalid="this.setCustomValidity('โปรดกรอกข้อมูลให้ครบ')"
                            oninput="setCustomValidity('')">
                            <option selected></option>
                            @foreach ($lookup as $look)
                                <option value="{{ $look->Lookup_code }}">
                                    {{ $look->Lookup_description }}
                                </option>
                            @endforeach
                        </select><br />
                        <div class="from-group">
                            <input type="checkbox" class="form-check-input" value="1" name="checked[]"
                                id="master"> <b>Third Party</b>
                        </div><br />
                        <div class="form-group">
                            <label for="exampleFormControlInput1"><b>รายละเอียดการแก้ไข</b></label>
                            <textarea name="closejob_note" class="form-control" id="closejob_note" style="width:300px;" required
                                oninvalid="this.setCustomValidity('โปรดกรอกข้อมูลให้ครบ')" oninput="setCustomValidity('')"></textarea>
                        </div><br />
                        <div class="form-group">
                            <label for="exampleFormControlInput1"><b>สาเหตุ</b></label>
                            <textarea name="closejob_cos" class="form-control" id="closejob_cos" style="width:300px;" required
                                oninvalid="this.setCustomValidity('โปรดกรอกข้อมูลให้ครบ')" oninput="setCustomValidity('')"></textarea>
                        </div><br />
                        <div class="form-group">
                            <label for="exampleFormControlInput1"><b>วิธีป้องกัน</b></label>
                            <textarea name="closejob_security" class="form-control" id="closejob_security" style="width:300px;" required
                                oninvalid="this.setCustomValidity('โปรดกรอกข้อมูลให้ครบ')" oninput="setCustomValidity('')"></textarea>
                        </div><br />
                        <div class="form-group" hidden>
                            <label class="col-12 col-form-label"><b>วันที่ปิดงาน</b></label>
                            
                                <input type="date" class="form-control" name="closejob_date" id="closejob_date" value="">{{ date('Y-m-d H:i:s') }}

                                <!-- <input type="datetime-local" class="form-control" name="closejob_date" id="closejob_date" value="{{ now()->format('Y-m-d\TH:i:s') }}"> -->
                            
                            <!-- {{-- <div class="col-5">
                                <input type="time" class="form-control" name="closejob_time" required>
                            </div> --}} -->
                        </div><br />
                        <div class="form-group">
                            <label for="exampleFormControlInput1"><b>สถานะงาน</b></label>
                            <select name="closejob_status" class="form-control form-select mb-3" id="closejob_status"
                                style="width:230px;" required oninvalid="this.setCustomValidity('โปรดกรอกข้อมูลให้ครบ')"
                                oninput="setCustomValidity('')">
                                <option selected></option>
                                @foreach ($lookup1 as $look1)
                                    <option value="{{ $look1->Lookup_code }}">
                                        {{ $look1->Lookup_description }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div hidden>
                            <input type="text" id="Assign_datetime" name="Assign_datetime">
                            <input type="text" name="data-Close_datetime" value="date('Y-m-d H:i:s')">

                        </div><br />

                        <div class="modal-footer">
                            <button id="closejobupdate" type="submit" class="btn btn-primary"
                                name="closejobupdate">ตกลง</button>
                            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">ยกเลิก</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Closejob Modal-->
@endsection

@section('script')
    <script src="assets/plugins/vectormap/jquery-jvectormap-2.0.2.min.js"></script>
    <script src="assets/plugins/vectormap/jquery-jvectormap-world-mill-en.js"></script>
    <script src="assets/plugins/chartjs/js/Chart.min.js"></script>
    <script src="assets/plugins/chartjs/js/Chart.extension.js"></script>
    <script src="assets/plugins/jquery.easy-pie-chart/jquery.easypiechart.min.js"></script>
    <script src="assets/js/index.js"></script>
    <script src="assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
    <script src="assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
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
                .appendTo('#example2_wrapper .col-md-6:eq(0)');
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
                            $('#detail_data_id').val(CRQ_id);

                            // $('#edit_category').val(response.message.Category);
                            // $('#edit_project').val(response.message.Project);
                        }
                    }
                });
            });

            //Update
            $(document).on('click', '.updatecrq', function(e) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                e.preventDefault();
                var CRQ_id = $('#editcrq_data_id').val();
                var data = {
                    //'Assign_datetime': $('#Assign_datetime').val(),
                    //'Due_date': $('#edit_duedate').val(),
                    'Third_party': $('#is_finished').val(),
                    'Request_by': $('#edit_Request_by').val(),
                    'User_login': $('#edit_User_login').val(),
                    'Customer_tel': $('#edit_Customer_tel').val(),
                    'Service': $('#edit_Service').val(),
                    'SV_cat': $('#edit_SV_cat').val(),
                    'Priority': $('#edit_SV_cat2').val(),
                    'SV_system': $('#edit_SV_system').val(),
                    'SV_eqip': $('#edit_SV_eqip').val(),
                    'p_img': $('#edit_p_img').val(),
                    'Issue': $('#edit_Issue_').val(),
                    'Assign_by': $('#edit_Assign_by').val(),
                    'Fix_type': $('#edit_Fix_type').val(),
                }

                $.ajax({
                    type: "PUT",
                    url: "/update-crq/" + CRQ_id,
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

            //edit-sendjob
            $(document).on('click', '.sendjob', function(e) {
                e.preventDefault();
                var CRQ_id = $(this).val();
                //alert(CRQ_id);
                $('#sjModel').modal('show');
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
                            $('#sendjob_CRQ_id').val(response.message.CRQ_id);
                            $('#sendjob_cus').val(response.message.User_login);
                            $('#sendjob_issue').val(response.message.Issue);
                            $('#Assign_by').val(response.message.Assign_by);
                            $('#Comment').val(response.message.Comment);
                            //$('#sendjobto').val(response.message.);
                            $('#send_id').val(CRQ_id)
                            // $('#edit_category').val(response.message.Category);
                            // $('#edit_project').val(response.message.Project);
                        }
                    }
                });
            });

            //update-sendjob
            $(document).on('click', '.senddata', function(e) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                e.preventDefault();
                var CRQ_id = $('#send_id').val();
                //var CRQ_id = $(this).val();
                //alert(CRQ_id);
                var data = {
                    //'User_login': $('#sendjob_cus').val(),
                    'Assign_by': $('#Assign_by').val(),
                    'Comment': $('#Comment').val(),

                }

                $.ajax({
                    type: "PUT",
                    url: "/sjupdate/" + CRQ_id,
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

            //edit-closejob
            $(document).on('click', '.closejob', function(e) {
                e.preventDefault();
                var CRQ_id = $(this).val();
                //alert(CRQ_id);
                $('#closejobModel').modal('show');

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
                            $('#Assign_datetime').val(response.message.Assign_datetime);
                            $('#closejob_crqno').val(response.message.CRQ_id);
                            $('#closejob_cus').val(response.message.User_login);
                            $('#is_finished').val(response.message.Third_party);
                            $('#closejob_issue').val(response.message.Issue);
                            $('#closejob_Prob').val(response.message.Prob_type);
                            $('#data_Fixtype').val(response.message.Fix_type);
                            $('#closejob_note').val(response.message.Note);
                            $('#closejob_cos').val(response.message.Cause);
                            $('#closejob_security').val(response.message.Protect);
                            $('#closejob_status').val(response.message.Status_id);
                            // (session('LoggedUser.department') != 'Cus')
                            $('#closejob_by').val(response.msg);
                            $('#closejob_date').val(response.message.Close_datetime);
                            $('#closejobdataid').val(CRQ_id);
                            // $('#edit_category').val(response.message.Category);
                            // $('#edit_project').val(response.message.Project);
                        }
                    }
                });
            });


            //update-closejob
            $(document).on('click', '.closejobupdate', function(e) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                e.preventDefault();
                var CRQ_id = $('#closejobdataid').val();
                //alert(CRQ_id);
                var data = {

                    'Fix_type': $('#data_Fixtype').val(),
                    'Note': $('#closejob_note').val(),
                    'Cause': $('#closejob_cos').val(),
                    'Protect': $('#closejob_security').val(),
                    'Close_by': $('#closejob_by').val(),
                    //'Close_datetime': $('#closejob_date').val(),
                    'Status_id': $('#closejob_status').val(),
                    'Prob_type': $('#closejob_Prob').val(),
                    'Third_party': $('#is_finished').val(),

                }

                $.ajax({
                    type: "PUT",
                    url: "/upclosejobnow/" + CRQ_id,
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
        // $(document).on('click', '.imagemodal', function (e) { 
        //     e.preventDefault();
        //     var img = $(this).val();
        //     //alert(img)
        //     $('#imagemodal').modal('show');
        // });
    </script>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            //Edit-crq --------------------------
            $(document).on('click', '.editcrq', function(e) {
                e.preventDefault();
                var CRQ_id = $(this).val();
                //alert(CRQ_id);
                //console.log(TS_id);
                $('#editcrqModel').modal('show');
                $.ajax({
                    type: "GET",
                    url: "/editcrq-data/" + CRQ_id,
                    success: function(response) {
                        console.log(response);
                        if (response.status == 404) {
                            $('#success_message').html("");
                            $('#success_message').addClass('alert alert-danger');
                            $('#success_message').text(response.message);
                        } else {

                            // $date2 = $_POST['date2'];
                            // $time2 = $_POST['time2'];
                            // $Request_datetime = "$edit_date $edit_time";
                            // $duedate = $_POST['duedate'];                                               

                            //$('#headedit').val(response.message.CRQ_id);
                            //$('#Assign_datetime').val(response.message.Assign_datetime);
                            $('#is_finished').val(response.message.Third_party);
                            $('#CRQ_id').val(response.message.CRQ_id);
                            $('#edit_Request_by').val(response.message.Request_by);
                            $('#edit_User_login').val(response.message.User_login);
                            $('#edit_Customer_tel').val(response.message.Customer_tel);
                            $('#edit_Service').val(response.message.Service);
                            $('#edit_SV_cat').val(response.message.SV_cat);
                            $('#edit_SV_cat2').val(response.message.Priority);
                            $('#edit_SV_system').val(response.message.SV_system);
                            $('#edit_SV_eqip').val(response.message.SV_eqip);

                            $('#edit_Issue_').val(response.message.Issue);
                            $('#edit_Assign_by').val(response.message.Assign_by);
                            $('#edit_Fix_type').val(response.message.Fix_type);
                            $('#edit_p_img').val(response.message.p_img);
                            $('#editcrq_data_id').val(CRQ_id);
                        }
                    }
                });
            });
        });
    </script>
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
@endsection
