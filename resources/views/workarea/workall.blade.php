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
                            <h6 class="m-0 font-weight-bold text-primary"><strong>งานทั้งหมด (จำนวน {{ $data->count()}} รายการ)</strong></h6>
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
                                        <label class="col-10 col-form-label"><b>เริ่มวันที่ - ถึงวันที่ (วันแจ้ง)</b></label>
                                        {{-- <label class="col-10 col-form-label"><b>ถึงวันที่</b></label> --}}
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
                                <form method="get" action="{{ url('/workall') }}" id="myForm" style="width: 50%;
                                padding: 20px;
                                box-sizing: border-box;">
                                    @csrf
                                    {{-- @method('PUT') --}}
                                    <div class="form-group row ">
                                        <label class="col-10 col-form-label"><b>เริ่มวันที่ - ถึงวันที่ (วันปิดงาน)</b></label>
                                        {{-- <label class="col-10 col-form-label"><b>ถึงวันที่</b></label> --}}
                                        <div class="col-4">
                                            <input type="date" class="form-control" name="startdate1" id="startdate1"
                                                value="date('Y-m-d')">
                                        </div>
                                        <div class="col-4">
                                            <input type="date" class="form-control" name="enddate1" id="enddate1"
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
                                
                            </div>
                            <form method="get" action="{{ url('/workall') }}" id="myForm">
                                    @csrf
                                    {{-- @method('PUT') --}}
                                    <div class="form-group row ">
                                        <label class="col-2 col-form-label"><b>บริษัท</b></label>
                                        <label class="col-10 col-form-label"><b>ผู้ปิดงาน</b></label>
                                        <div class="col-2">
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
                                        <div class="col-2">
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
                                            <th>วันปิดงาน</th>
                                            <th>แจ้งโดย</th>
                                            <th>บริษัท</th>
                                            <th>รายละเอียดเพิ่มเติม</th>
                                            @if (session('LoggedUser.department') != 'Cus')
                                                <th>ผู้รับงาน</th>
                                                <th>ผู้ปิดงาน</th>             
                                            @else
                                            @endif

                                            @if(session('LoggedUser.department') != 'Cus')
                                            <th>วิธีแก้ไข</th>
                                            @else
                                            @endif
                                            <th>สถานะงาน</th>
                                            {{-- <th hidden>สถานะงาน</th> --}}
                                            <th>ภาพประกอบ</th>
                                           

                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($data as $row)
                                        <tr>

                                            <td class="text-truncate" style="max-width: 200px;">
                                                <button class="dropdown-item detail" 
                                                    id="detail"
                                                    value="{{ $row->CRQ_id }}"> {{ $row->CRQ_id }}</button></td>
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
                                            <td>{{ $row->Close_datetime }}</td>
                                            <td class="text-truncate" style="max-width: 100px;">
                                               <text class="dropdown-item" 
                                               value="{{ $row->Request_by }}">{{ $row->Request_by }}</text></td>
                                            <td>{{ $row->User_login }}</td>
                                            <td class="text-truncate" style="max-width: 200px;">
                                                <button class="dropdown-item detail" 
                                                    id="detail"
                                                    value="{{ $row->CRQ_id }}"> {{ $row->Issue }}</button>
                                            </td>
                                            @if(session('LoggedUser.department') != 'Cus')
                                            <td>{{ $row->Assign_by }}</td>
                                            <td>{{ $row->Close_by }} </td>
                                            @else
                                            @endif
                                            @if(session('LoggedUser.department') != 'Cus')
                                            <td class="text-truncate" style="max-width: 200px;"><a class="dropdown-item" >{{ $row->Note }}</td>
                                            @else
                                            @endif
                                            <td>
                                                @if($row->Status_id == 'N')
                                                <span class="w3-button w3-yellow w3-round-xlarge"> รอจ่ายงาน</span>
                                                @elseif($row->Status_id == 'P')
                                                <span class="w3-button w3-round-xlarge" style="background-color: SandyBrown"> ดำเนินงาน</span>
                                                @elseif($row->Status_id == 'W')
                                                <span class="w3-button w3-round-xlarge" style="background-color: MediumAquamarine"> รอประเมิน</span>
                                                @elseif($row->Status_id == 'C')
                                                <span class="w3-button w3-round-xlarge" style="background-color: LimeGreen"> เสร็จแล้ว</span>
                                                @elseif($row->Status_id == 'CC')
                                                <span class="w3-button w3-red w3-round-xlarge"> งานถูกยกเลิก</span>
                                                
                                                @endif
                                            </td>
                                            <td><a class="img-link img-link-zoom-in img-thumb img-lightbox imagemodal"
                                                id="imagemodal"><img src="img/{{ $row->p_img }} " width="100"
                                                    style="padding-bottom:20px" /></a></td>
                                            {{-- <td>

                                                <button type="button"
                                                    class="w3-button w3-round btn-sm sendjob" style="background-color: SandyBrown" id="sendjob" 
                                                    value="{{ $row->CRQ_id }}">ส่งต่องาน</button>

                                                <button type="button"
                                                    class="w3-button w3-red w3-round btn-sm closejob" id="closejob" 
                                                    value="{{ $row->CRQ_id }}">ปิดงาน</button>
                                            </td> --}}

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
                                            <th>วันปิดงาน</th>
                                            <th>แจ้งโดย</th>
                                            <th>บริษัท</th>
                                            <th>รายละเอียดเพิ่มเติม</th>
                                            @if (session('LoggedUser.department') != 'Cus')
                                                <th>ผู้รับงาน</th>
                                                <th>ผู้ปิดงาน</th>
                                            @else
                                            @endif
                                            @if(session('LoggedUser.department') != 'Cus')
                                            <th>วิธีแก้ไข</th>
                                            @else
                                            @endif
                                            <th>สถานะงาน</th>
                                            {{-- <th hidden>สถานะงาน</th> --}}
                                            <th>ภาพประกอบ</th>

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
                @foreach($data as $row )
                <form method="POST" action="{{ url('/crq-data/' . $row->CRQ_id) }}>
                    @endforeach
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="detail_data_id" name="detail_data_id">
                    <div class="form-group">
                        <label for="formGroupExampleInput"><strong>CRQ หมายเลข</strong></label>
                        <input type="text" class="form-control"  name="detail_id"
                            id="detail_id" readonly>
                    </div><br/>
                    <div class="form-group">
                        <label for="formGroupExampleInput"><strong>ลูกค้า</strong></label>
                        <input type="text" class="form-control"
                            name="detail_customer" id="detail_customer" readonly>
                    </div><br/>
                    <div class="form-group">
                        <label for="formGroupExampleInput"><strong>แจ้งโดย</strong></label>
                        <input type="text" class="form-control"
                            name="detail_Request_by" id="detail_Request_by" readonly>
                    </div><br/>
                    <div class="form-group">
                        <label for="formGroupExampleInput"><strong>รายละเอียดเพิ่มเติม</strong></label>
                        <textarea name="detail_issue" Class="form-control" id="detail_issue" readonly></textarea>
                    </div><br/>
                    @if(session('LoggedUser.department') != 'Cus')
                    <div class="form-group">
                        <label for="formGroupExampleInput"><strong>วิธีแก้ไข</strong></label>
                        <textarea name="detail_note" Class="form-control" id="detail_note" readonly></textarea>
                    </div>
                    @else
                    @endif
                    {{-- @endforeach --}}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>
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
            //alert("eieiei");
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
                        $('#detail_Request_by').val(response.message.Request_by);
                        $('#detail_issue').val(response.message.Issue);
                        $('#detail_note').val(response.message.Note);
                        $('#detail_data_id').val(CRQ_id)
                        // $('#edit_category').val(response.message.Category);
                        // $('#edit_project').val(response.message.Project);
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
