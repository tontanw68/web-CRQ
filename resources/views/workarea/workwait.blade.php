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
    {{-- icon --}}
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
                            <h6 class="m-0 font-weight-bold text-primary"><strong>งานใหม่ (รอคิว) (จำนวน {{ $data->count()}} รายการ)</strong></h6>
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
                                        <label class="col-8 col-form-label"><b>ประเภทบริการ</b></label>
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
                                            <select class="form-control  form-select mb-3" id="filtertype"
                                                    name="filtertype" class="input-sm">
                                                    <option selected></option>
                                                    @foreach ($typename as $cus)
                                                        <option value="{{ $cus->SV_cat }}">
                                                            {{ $cus->SV_cat }}
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
                                <div class="dropdown ms-auto">

                                    <ul class="w3-button w3-round-xlarge dropdown-toggle dropdown-toggle-nocaret" href="#"
                                    data-bs-toggle="modal"
                                    data-bs-target="#workwaitModal"><i class="fas fa-file-medical" style="font-size:30px; background-color: MediumAquamarine"></i>
                                    </ul>
                                    {{-- <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="javascript:;" data-bs-toggle="modal"
                                                data-bs-target="#workwaitModal">เพิ่มข้อมูล</a>
                                        </li>
                                        <li><a class="dropdown-item" href="javascript:;">Another action</a>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li><a class="dropdown-item" href="javascript:;">Something else here</a>
                                        </li>
                                    </ul> --}}
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table id="timesheet" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>CRQ</th>
                                            <th>ประเภทบริการ</th>
                                            {{-- @if (session('LoggedUser.department') != 'Cus')
                                            <th>ความสำคัญของงาน</th>
                                            @else
                                            @endif --}}
                                            <th>บริการ</th>
                                            <th>วันแจ้ง</th>
                                            <th>แจ้งโดย</th>
                                            <th>บริษัท</th>
                                            <th>รายละเอียดเพิ่มเติม</th>
                                            {{-- @if (session('LoggedUser.department') != 'Cus')
                                                <th>ผู้รับงาน</th>
                                            @else
                                            @endif --}}
                                            <th>สถานะงาน</th>
                                            {{-- <th hidden>สถานะงาน</th> --}}
                                            <th>ภาพประกอบ</th>
                                            <th>ตัวเลือก</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($data as $row)
                                            <tr>
                                                <input type="hidden" class="hiddelete_crq" value="{{ $row->CRQ_id }}">
                                                <td class="text-truncate" style="max-width: 70px;">
                                                    <button class="dropdown-item detail" id="detail"
                                                        value="{{ $row->CRQ_id }}"> {{ $row->CRQ_id }}</button>
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
                                                {{-- <td>@if($row->Priority == 'P1')
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
                                                @endif</td> --}}
                                                <td>{{ $row->Service }}</td>
                                                <td>{{ $row->Request_datetime }} </td>
                                                <td>{{ $row->Request_by }} </td>

                                                <td>{{ $row->User_login }} </td>

                                                <td class="text-truncate" style="max-width: 200px;">
                                                    <button class="dropdown-item detail" 
                                                        id="detail"
                                                        value="{{ $row->CRQ_id }}"> {{ $row->Issue }}</button>
                                                </td>
                                                {{-- @if (session('LoggedUser.department') != 'Cus')
                                                    <td>{{ $row->Assign_by }} </td>
                                                @else
                                                @endif --}}
                                                <td>
                                                    @if ($row->Status_id == 'N')
                                                        <span class="w3-button w3-yellow w3-round-xlarge">รอจ่ายงาน <i class="fa-solid fa-clock"></i></span>
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

                                                </td>
                                                <td><img src="/images/{{ $row->p_img }}" width="100px"></td>
                                                <td>

                                                    <button type="button"
                                                        class="w3-button btn-warning w3-round btn-sm editcrq" id="editcrq"
                                                        value="{{ $row->CRQ_id }}" style="font-size: 12px"><i class="fa-solid fa-pen-to-square"></i> แก้ไข</button>
                                                    @if (session('LoggedUser.department') != 'Cus')
                                                    <button type="button" class="w3-button btn-primary w3-round btn-sm sendjob"
                                                    id="sendjob" value="{{ $row->CRQ_id }}"><i class="fa-solid fa-share-from-square"></i> ส่งต่องาน</button>
                                                    @else
                                                    @endif
                                                    <button type="button" class="w3-button btn-danger w3-round btn-sm deletecrq"
                                                        id="deletecrq" value="{{ $row->CRQ_id }}"><i class="fa-solid fa-trash-can"></i> ลบ</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>CRQ</th>
                                            <th>ประเภทบริการ</th>
                                            {{-- @if (session('LoggedUser.department') != 'Cus')
                                            <th>ความสำคัญของงาน</th>
                                            @else
                                            @endif --}}
                                            <th>บริการ</th>
                                            <th>วันแจ้ง</th>
                                            <th>แจ้งโดย</th>
                                            <th>บริษัท</th>
                                            <th>รายละเอียดเพิ่มเติม</th>
                                            {{-- @if (session('LoggedUser.department') != 'Cus')
                                                <th>ผู้รับงาน</th>
                                            @else
                                            @endif --}}
                                            <th>สถานะงาน</th>
                                            {{-- <th hidden>สถานะงาน</th> --}}
                                            <th>ภาพประกอบ</th>
                                            <th>ตัวเลือก</th>
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
    <!-- Insert Form Modal -->
    <div class="modal fade" id="workwaitModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header" style="background-color: skyblue">
                    <h5 class="modal-title">เพิ่มข้อมูล</h5>
                    @error('dateadd')
                        <div class="alert  border-0 border-start border-5 border-danger alert-dismissible fade show">
                            <div>พบปัญหาระหว่างการบันทึกข้อมูลกรุณาตรวจสอบข้อมูลให้ถูกต้อง !!!</div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @enderror
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('addworkwait') }}"class="row g-3" enctype="multipart/form-data">
                        @csrf
                        {{-- <div class="form-group row">
                            <div class="col-md-7">
                            <label for="validationdate" class="forcol-12 col-form-labelm-label"><b>วันที่</b></label>
                            <input type="date" style="width:230px;" class="date form-control" name="dateadd" id="validationdate"
                                required></div>
                        </div> --}}
                        <div class="form-group row">
                            <label class="col-12 col-form-label" for="exampleInputName1"><b>ผู้แจ้ง (Requestor)</b></label>
                            <div class="col-7">
                                <input type="text" class="form-control" name="Request_by" id="exampleInputName1"
                                    placeholder="ชื่อผู้แจ้ง">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-form-label"><b>เบอร์ติดต่อ (Tel./ Ext.)</b></label>
                            <div class="col-7">
                                <input type="text" class="form-control col-md-5" name="Customer_tel"
                                    placeholder="เบอร์ติดต่อ" required>
                            </div>
                        </div><br />
                        <div class="form-group row">
                            <label for="validationtype" class="col-12 col-form-label"><b>ประเภทบริการ (Service Categories)</b></label>
                            <div class="col">

                                <select name="SV_cat" class="category form-select mb-3"
                                    aria-label="Default select example " class="form-control" id="SV_cat"
                                    " required
                                    oninvalid="this.setCustomValidity('โปรดกรอกข้อมูลให้ครบ')"
                                    oninput="setCustomValidity('')" required>
                                    <option selected></option>
                                    @foreach ($lookup11 as $type)
                                        <option value="{{ $type->Lookup_code }}">
                                            {{ $type->Lookup_description }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">โปรดระบุประเภท</div>
                            </div>
                        </div>
                        <div class="from-group row">
                            <div class="col-md-12">
                                <label for="SV_cat" class="col-12 col-form-label"><b>บริการ (Service)</b></label>
                                <select class="form-control form-select mb-3" {{-- ลูกศร --}} "
                                    id="Service" name="Service" class="input-sm" required>
                                    <option selected></option>
                                    @foreach ($lookupser as $look)
                                        <option value="{{ $look->Lookup_code }}">
                                            {{ $look->Lookup_description }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                            <label for="validationactivity" class="col-12 col-form-label"><b>อธิบายรายละเอียดเพิ่มเติม</b></label>
                            <textarea name="Issue" class="activity form-control" id="Issue" required></textarea>
                            <div class="invalid-feedback">โปรดระบุรายละเอียด</div>
                            </div>
                        </div><br />
                        <div class="form-group row">
                            <label class="col-12 col-form-label"><b>อัพโหลดไฟล์ภาพ</b></label>
                            <div class="col-md-7">
                                
                                <!-- Populating custom file input label with the selected filename (data-toggle="custom-file-input" is initialized in Helpers.coreBootstrapCustomFileInput()) -->
                                <input type="file" name="file[]" multiple="multiple"
                                    class="custom-file-input form-control" id="example-file-input-custom"
                                    name="example-file-input-custom" data-toggle="custom-file-input">
                                {{-- <label class="custom-file-label " for="example-file-input-custom">เลือกรูปภาพ</label> --}}
                            </div>
                        </div>
                        
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-primary add_workwait" id="addworkwait">บันทึกข้อมูล</button>
                </div>
                </form>

            </div>
        </div>
    </div>
    <!-- end insert Modal-->.
    <!-- edit crq Modal-->
    <div class="modal fade" id="editcrqModel" style="z-index:9999999;" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color: rgb(252, 253, 171)">
                    <h5 class="modal-title" id="exampleModalLabel">แก้ไขข้อมูล CRQ.</h5>
                    <button class="close" type="button" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">X</span>
                    </button>
                </div>
                <div id="success_message"></div>
                <div class="modal-body">
                    @foreach ($data as $row)
                        <form method="POST" action="{{ url('crq-update/' . $row->CRQ_id) }}">
                    @endforeach
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="editcrq_id" name="editcrq_id">
                    <div class="form-group row">
                        <label class="col-12 col-form-label" for="exampleInputName1"><b>ผู้แจ้ง (Requestor)</b></label>
                        <div class="col-5">
                            <input type="text" class="form-control" name="edit_Requestbyy" id="edit_Requestbyy"
                                placeholder="ชื่อผู้แจ้ง">
                        </div>
                    </div><br />

                    <div class="form-group row">
                        <label class="col-12 col-form-label"><b>เบอร์ติดต่อ (Tel./ Ext.)</b></label>
                        <div class="col-5">
                            <input type="text" class="form-control col-md-5" name="edit_Customer_tel"
                                id="edit_Customer_tel" placeholder="เบอร์ติดต่อ">
                        </div>
                    </div><br />
                    <div class="form-group row">
                        <label for="validationtype" class="col-12 col-form-label"><b>ประเภทบริการ (Service Categories)</b></label>
                        <div class="col-md-12">

                            <select name="edit_SV_cat" class="category form-select mb-3"
                                aria-label="Default select example " class="form-control" id="edit_SV_cat"
                                " required oninvalid="this.setCustomValidity('โปรดกรอกข้อมูลให้ครบ')"
                                oninput="setCustomValidity('')" required>
                                <option selected></option>
                                @foreach ($lookup11 as $type)
                                    <option value="{{ $type->Lookup_code }}">
                                        {{ $type->Lookup_description }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">โปรดระบุประเภท</div>
                        </div>
                    </div>

                    <div class="col-12">
                        <label class="col-12 col-form-label"><b>บริการ (Service)</b></label>

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

                    <div class="form-row">
                        <label class="col-12 col-form-label"><b>อัพโหลดไฟล์ภาพ</b></label>
                        <div class="col-7">
                            <!-- Populating custom file input label with the selected filename (data-toggle="custom-file-input" is initialized in Helpers.coreBootstrapCustomFileInput()) -->
                            <input type="file" name="edit_p_img" multiple="multiple"
                                class="custom-file-input form-control" id="edit_p_img" name="example-file-input-custom"
                                data-toggle="custom-file-input">
                            {{-- <label class="custom-file-label " for="example-file-input-custom">เลือกรูปภาพ</label> --}}
                        </div>
                    </div><br />

                    <div class="form-group row">
                        <label class="col-12 col-form-label" for="exampleTextarea1"><b>รายละเอียดเพิ่มเติม</b></label>
                        <div class="col-10">
                            <textarea name="edit_Issue" class="form-control col-md-12" id="edit_Issue" rows="2"></textarea>
                        </div>
                    </div>
                    <br />
                    <div class="modal-footer">
                        <button id="updatecrq" type="submit" class="btn btn-primary" name="updatecrq">ตกลง</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
                            </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
                <div class="modal-header" style="background-color: rgb(91, 196, 223)">
                    <h5 class="modal-title" id="exampleModalLabel">หน้ามอบงาน</h5>
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
                    <div class="form-group row">
                        <div class="col-6">
                            <br />
                            <label for="formGroupExampleInput"><b>Due date</b></label><br />
                            <input type="date" class="form-control" name="wait_duedate" id="wait_duedate"
                                value="('m-d-Y')">
                        </div>
                        <div class="col-6">
                            <label for="SV_cat"><b>ประเภทบริการ (Service Categories)</b></label>
                            <select class="form-control form-select mb-3" id="sendjob_SV_cat" name="sendjob_SV_cat"
                                class="input-sm" required>
                                <option selected></option>
                                {{-- lookupcat --}}
                                @foreach ($lookup11 as $look)
                                    <option value="{{ $look->Lookup_code }}">
                                        {{ $look->Lookup_description }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div><br />
                    <div class="form-group row">
                        <div class="col-6">
                            <label for="SV_system"><b>ความสำคัญของงาน (Priority) </b></label>
                            <select class="form-control form-select mb-3" id="sendjob_SV_cat2" name="sendjob_SV_cat2"
                                class="input-sm" >
                                <option selected>ไม่ระบุ</option>
                                @foreach ($lookupcat2 as $look)
                                    <option value="{{ $look->Lookup_code }}">
                                        {{ $look->Lookup_description }}
                                    </option>
                                @endforeach>
                            </select>
                        </div>
                    </div><br />
                    <div class="form-group row">
                        <div class="col-6">
                            <label for="SV_system"><b>ระบบ (System)</b></label>
                            <select class="form-control form-select mb-3" id="sendjob_SV_system" name="sendjob_SV_system"
                                class="input-sm" >
                                <option selected>ไม่ระบุ</option>
                                @foreach ($lookupsys as $look)
                                    <option value="{{ $look->Lookup_code }}">
                                        {{ $look->Lookup_description }}
                                    </option>
                                @endforeach>
                            </select>
                        </div><br />
                        <div class="col-6">
                            <label for="SV_eqip"><b>อุปกรณ์ (Equipments)</b></label>
                            <select class="form-control form-select mb-3" id="sendjob_SV_eqip" name="sendjob_SV_eqip"
                                class="input-sm">
                                <option selected>ไม่ระบุ</option>
                                @foreach ($lookupeq as $look)
                                    <option value="{{ $look->Lookup_code }}">
                                        {{ $look->Lookup_description }}
                                    </option>
                                @endforeach>
                            </select>
                        </div>
                    </div>
                <div class="from-group row">
                    <div class="col-6">
                        <label class="col-12 col-form-label " for="formGroupExampleInput"><b>มอบหมาย</b></label>
                        <select class="form-control form-select mb-3" " name="sendjobto"
                            id="sendjobto" required oninvalid="this.setCustomValidity('โปรดกรอกข้อมูลให้ครบ')"
                            oninput="setCustomValidity('')">
                            <option selected></option>
                            @foreach ($sendto as $cus)
                                <option value="{{ $cus->User_login }}">
                                    {{ $cus->User_login }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="col-12 col-form-label" for="exampleFormControlInput"><b>วิธีแก้ไข</b></label>
                        <select name="sendjob_Fix" class="form-control form-select mb-3" id="sendjob_Fix"
                             oninvalid="this.setCustomValidity('โปรดกรอกข้อมูลให้ครบ')"
                            oninput="setCustomValidity('')">
                            <option selected>ไม่ระบุ</option>
                            @foreach ($lookupfix as $look)
                                <option value="{{ $look->Lookup_code }}">
                                    {{ $look->Lookup_description }}
                                </option>
                            @endforeach>

                        </select>
                    </div>
                </div>

                    <div class="from-group" hidden>
                        @foreach ($lookupP as $look)
                        <label class="col-12 col-form-label" for="SV_cat"><b>สถานะงาน</b></label>
                        <input class="form-control form-select mb-3" style="width:230px;" id="wait_status"
                            name="wait_status" class="input-sm" value="{{ $look->Lookup_code }}" required>
                            {{-- <option selected></option>
                            @foreach ($lookupP as $look)
                                <option >
                                    {{ $look->Lookup_description }}
                                </option> --}}
                            @endforeach
                    </div>
                    <div class="from-group form-check">
                        <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" value="1" name="checked[]" id="master"> <b>Third Party</b>
                    </label>
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
    {{-- import delete --}}
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> 
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
                            $('#detail_data_id').val(CRQ_id)

                            // $('#edit_category').val(response.message.Category);
                            // $('#edit_project').val(response.message.Project);
                        }
                    }
                });
            });

            //edit
            $(document).on('click', '.editcrq', function(e) {
                e.preventDefault();
                var CRQ_id = $(this).val();
                //alert(CRQ_id);
                $('#editcrqModel').modal('show');
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
                            $('#edit_Requestbyy').val(response.message.Request_by);
                            $('#edit_Customer_tel').val(response.message.Customer_tel);
                            $('#edit_SV_cat').val(response.message.SV_cat);
                            $('#edit_Issue').val(response.message.Issue);
                            $('#edit_Service').val(response.message.Service);
                            $('#edit_p_img').val(response.message.p_img);
                            //$('#sendjob_cus').val(response.message.User_login);

                            //$('#wait_duedate').val(response.message.Due_date);
                            //$('#sendjob_Assigndate').val(response.message.Assign_datetime);
                            //$('#sendjob_SV_system').val(response.message.SV_system);
                            //$('#sendjob_SV_eqip').val(response.message.SV_eqip);
                            //$('#sendjobto').val(response.message.Assign_by);
                            //$('#sendjob_Fix_type').val(response.message.Fix_type);
                            //$('#wait_status').val(response.message.Status_id);
                            $('#editcrq_id').val(CRQ_id);
                            // $('#edit_category').val(response.message.Category);
                            // $('#edit_project').val(response.message.Project);
                        }
                    }
                });
            });

            //update
            $(document).on('click', '.updatecrq', function(e) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                e.preventDefault();
                var CRQ_id = $('#editcrq_id').val();
                //var CRQ_id = $(this).val();
                //alert(CRQ_id);
                var data = {
                    'Request_by': $('#edit_Requestbyy').val(),
                    'Assign_datetime': $('#Assign_datetime').val(),
                    //'Request_datetime': $('#edit_date').val(),
                    //'Due_date': $('#wait_duedate').val(),

                    //'User_login': $('#sendjob_cus').val(),
                    'Customer_tel': $('#edit_Customer_tel').val(),
                    'Service': $('#edit_Service').val(),
                    'SV_cat': $('#edit_SV_cat').val(),
                    //'SV_system': $('#sendjob_SV_system').val(),
                    //'SV_eqip': $('#sendjob_SV_eqip').val(),
                    'p_img': $('#edit_p_img').val(),
                    'Issue': $('#edit_Issue').val(),
                    //'Assign_by': $('#sendjobto').val(),
                    //'Fix_type': $('#sendjob_Fix_type').val(),
                }

                $.ajax({
                    type: "PUT",
                    url: "/crq-update/" + CRQ_id,
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
                            $('#sendjob_SV_cat2').val(response.message.Priority);
                            $('#master').val(response.message.Third_party);
                            $('#sendjobto').val(response.message.Assign_by);
                            //$('#sendjob_Fix').val(response.message.Fix_type);
                            //$('#wait_status').val(response.message.Status_id);
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
                    'Third_party': $('#master').val(),
                    'User_login': $('#sendjob_cus').val(),
                    //'Customer_tel': $('#edit_Customer_tel').val(),
                    'Priority': $('#sendjob_SV_cat2').val(),
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

            //delete
            $(document).on('click', '.deletecrq', function(e) {
                e.preventDefault();

                var CRQ_id = $(this).closest("tr").find('.hiddelete_crq').val();
                //alert(delete_id);
                swal({
                    title: "ยืนยันที่จะลบหรือไม่?",
                    text: "",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,


                }).then((willDelete) => {
                    if (willDelete) {

                        var data = {
                            "_token": $('input[name=_token]').val(),
                            "id": CRQ_id,
                        };
                        $.ajax({
                            type: "DELETE",
                            url: "/crq-delete/" + CRQ_id,
                            data: "data",
                            success: function(response) {
                                swal(response.status, {
                                    icon: "success",

                                }).then((result) => {
                                    location.reload();
                                });

                            }
                        });

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
