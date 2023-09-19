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
                            <h6 class="m-0 font-weight-bold text-primary"><strong>Master DropDownList</strong></h6>
                        </div>
                        
                        <div id="success_message"></div>

                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="dropdown ms-auto">

                                    <a class="dropdown-toggle dropdown-toggle-nocaret" href="#"
                                        data-bs-toggle="modal" data-bs-target="#insertDDLModal" ><i class="fas fa-file-medical" style="font-size:30px"></i>
                                    </a>
                                    {{-- <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="javascript:;" data-bs-toggle="modal"
                                                data-bs-target="#insertDDLModal">เพิ่มข้อมูล</a>
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
                                            <th>ID</th>
                                            <th>ประเภท</th>
                                            <th>อักษรย่อ</th>
                                            <th>รายละเอียด</th>
                                            <th>ตัวเลือก</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($data as $row)
                                                <tr>
                                                <input type="hidden" class="hiddelete_id" value="{{ $row->TS_id }}">
                                                <td>{{ $row->TS_id }} </td>
                                                <td>{{ $row->Lookup_type }} </td>
                                                <td>{{ $row->Lookup_code }} </td>
                                                <td style="width: 30%" >{{ $row->Lookup_description }} </td>
                                                <td>
                                                    <button type="button"
                                                        class="w3-button btn-warning w3-round btn-sm editddl" id="editddl"
                                                        value="{{ $row->TS_id }}"  style="font-size: 12px"><i class="fa-solid fa-pen-to-square"></i> Edit</button>
                                                    <button type="button" class="w3-button btn-info w3-round btn-sm viewddl"
                                                        id="viewddl" value="{{ $row->TS_id }}"><i class="fa-solid fa-eye"></i> View</button>

                                                    <button type="button" class="w3-button btn-danger w3-round btn-sm deleteddl"
                                                        id="deleteddl" value="{{ $row->TS_id }}"><i class="fa-solid fa-trash-can"></i> Delete</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>ID</th>
                                            <th>ประเภท</th>
                                            <th>อักษรย่อ</th>
                                            <th>รายละเอียด</th>
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
    <div class="modal fade" id="insertDDLModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header" style="background-color: skyblue">
                    <h5 class="modal-title">เพิ่มข้อมูล</h5>
                    {{-- @error('dateadd')
                        <div class="alert  border-0 border-start border-5 border-danger alert-dismissible fade show">
                            <div>พบปัญหาระหว่างการบันทึกข้อมูลกรุณาตรวจสอบข้อมูลให้ถูกต้อง !!!</div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @enderror --}}
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('addddl') }}"class="row g-3" enctype="multipart/form-data">
                        @csrf
                        <div class="from-group">
                            <div class="col-md-7">
                                <label for="SV_cat" class="col-12 col-form-label"><b>ประเภท</b></label>
                                <input class="form-control " {{-- ลูกศร  form-select mb-3--}} style="width:230px;"
                                    id="Lookup_type" name="Lookup_type" placeholder="เพิ่มประเภท" required>
                                    {{-- <option selected>---เลือกประเภท---</option>
                                    @foreach ($lookup as $look)
                                        <option value="{{ $look->Lookup_type }}">
                                            {{ $look->Lookup_type }}
                                        </option>
                                    @endforeach --}}
                                </input>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-7">
                            <label class="col-12 col-form-label"><b>อักษรย่อ</b></label>                          
                                <input type="text" class="form-control" name="Lookup_code" id="Lookup_code"
                                    placeholder="อักษรย่อ" required>
                            </div>
                        </div><br />

                        <div class="form-group">
                            <div class="col-md-12">
                            <label class="col-form-label"><b>รายละเอียด</b></label>                          
                                <textarea type="text" class="form-control" name="Lookup_description" rows="2"
                                    placeholder="รายละเอียด" required></textarea>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-primary addddl" id="addddl">บันทึกข้อมูล</button>
                </div>
                </form>

            </div>
        </div>
    </div>
    <!-- end insert Modal-->
<!-- Edit Form Modal -->
<div class="modal fade" id="editDDLModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header" style="background-color: palegoldenrod">
                <h5 class="modal-title">แก้ไขข้อมูล</h5>
                {{-- @error('dateadd')
                    <div class="alert  border-0 border-start border-5 border-danger alert-dismissible fade show">
                        <div>พบปัญหาระหว่างการบันทึกข้อมูลกรุณาตรวจสอบข้อมูลให้ถูกต้อง !!!</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @enderror --}}
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @foreach($data as $row)
                <form method="POST" action="{{ url('ddl-update/' . $row->TS_id) }}">
                    @endforeach
                    @csrf
                    @method('PUT')
                    <input type="hidden"
                        id="Edit_ddl_id" name="Edit_ddl_id">
                    <div class="from-group">
                        <div class="col-md-7">
                            <label for="SV_cat" class="col-12 col-form-label"><b>Lookup_type</b></label>
                            <select class="form-control form-select mb-3" {{-- ลูกศร --}} style="width:230px;"
                                id="edit_Lookup_type" name="edit_Lookup_type" placeholder="เลือกประเภท" required>
                                <option selected>---เลือกประเภท---</option>
                                @foreach ($lookup as $look)
                                    <option value="{{ $look->Lookup_type }}">
                                        {{ $look->Lookup_type }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-7">
                        <label class="col-12 col-form-label"><b>Lookup_code</b></label>                          
                            <input type="text" class="form-control" name="edit_Lookup_code" id="edit_Lookup_code"
                                placeholder="อักษรย่อ">
                        </div>
                    </div><br />

                    <div class="form-group">
                        <div class="col-12">
                        <label class="col-form-label"><b>Lookup_description</b></label>                          
                            <textarea type="text" class="form-control" name="edit_Lookup_description" id="edit_Lookup_description" rows="2"
                                placeholder="รายละเอียด" required></textarea>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                <button type="submit" class="btn btn-primary ddlupdate" id="ddlupdate">บันทึกข้อมูล</button>
            </div>
            </form>

        </div>
    </div>
</div>
<!-- end Edit Modal-->
    <!-- Detail Job Modal-->
    <div class="modal fade" id="detailddlModel" style="z-index:9999999;" role="dialog">
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
                            action="{{ url('/detail/' . $row->ID) }}>
                        @endforeach
                        @csrf
                        @method('PUT')
                        <input type="hidden"
                            id="details_data_id" name="details_data_id">
                            <div class="form-group">
                                <label for="formGroupExampleInput"><strong>CRQ หมายเลข</strong></label>
                                <input type="text" class="form-control" name="detail_Lookup_type" id="detail_Lookup_type" readonly>
                            </div><br />
                            <div class="form-group">
                                <label for="formGroupExampleInput"><strong>อักษรย่อ</strong></strong></label>
                                <input type="text" class="form-control" name="detail_Lookup_code" id="detail_Lookup_code"
                                    readonly>
                            </div><br />
                            <div class="form-group">
                                <label for="formGroupExampleInput"><strong>รายละเอียด</strong></label>
                                <textarea name="detail_Lookup_description" Class="form-control" id="detail_Lookup_description" readonly></textarea>
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
            $(document).on('click', '.viewddl', function(e) {
                e.preventDefault();
                var ID = $(this).val();
                //var Lookup_type = $('#details_data_id').val();
                //alert(ID);
                $('#detailddlModel').modal('show');

                $.ajax({
                    type: "GET",
                    url: "/detail/" + ID,
                    success: function(response) {
                        console.log(response);
                        if (response.status == 404) {
                            $('#success_message').html("");
                            $('#success_message').addClass('alert alert-danger');
                            $('#success_message').text(response.message);
                        } else {
                            $('#detail_Lookup_type').val(response.message.Lookup_type);
                            $('#detail_Lookup_code').val(response.message.Lookup_code);
                            $('#detail_Lookup_description').val(response.message.Lookup_description);
                            $('#details_data_id').val(ID);

                            // $('#edit_category').val(response.message.Category);
                            // $('#edit_project').val(response.message.Project);
                        }
                    }
                });
            });

            //edit
            $(document).on('click', '.editddl', function(e) {
                e.preventDefault();
                var TS_id = $(this).val();
                //alert(TS_id);
                $('#editDDLModal').modal('show');
                //alert("eieiei");
                $.ajax({
                    type: "GET",
                    url: "/ddl-edit/" + TS_id,
                    success: function(response) {
                        console.log(response);
                        if (response.status == 404) {
                            $('#success_message').html("");
                            $('#success_message').addClass('alert alert-danger');
                            $('#success_message').text(response.message);
                        } else {
                            //$('#CRQ_id').val(response.message.TS_id);
                            $('#edit_Lookup_type').val(response.message.Lookup_type);
                            $('#edit_Lookup_code').val(response.message.Lookup_code);
                            $('#edit_Lookup_description').val(response.message.Lookup_description);

                            $('#Edit_ddl_id').val(TS_id);
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
                }
                alert("อัปเดตข้อมูลสำเร็จ");
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

            //delete
            $(document).on('click', '.deleteddl', function(e) {
                e.preventDefault();

                var TS_id = $(this).closest("tr").find('.hiddelete_id').val();
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
                            "id": TS_id,
                        };
                        $.ajax({
                            type: "DELETE",
                            url: "/ddl-delete/" + TS_id,
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
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
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
