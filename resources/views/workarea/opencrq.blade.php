@extends('layouts.app')

@section('style')
    <link href="assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <!-- Bootstrap DatePicker -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" type="text/css" />
    
@endsection

@section('wrapper')
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">

            <div class="container-fluid">

                <!-- Approach -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3" style="background-color: azure">
                        <h6 class="m-0 font-weight-bold text-primary">แบบฟอร์ม เปิด CRQ </h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ url('insert') }}" method="POST"  class="forms-sample" ">
                            @csrf
                             {{ csrf_field() }}
                            <div hidden class="form-group">
                                <label for="exampleInputDate"><b>ซ่อนเก็บชื่อวันเวลา</b></label>
                                <input type="text" name="Assign_datetime" id="Assign_datetime" value="('Y-m-d H:i:s')">
                                <!-- <input type="text" class="form-control" id="exampleInputName1" style="width:230px;" NAME="Assign_by" value=""> -->
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-form-label"><b>วันที่แจ้ง</b></label>
                                <div class="col-3">
                                    <input type="date" class="form-control" NAME="date2" required>
                                </div>
                                <div class="col-3">
                                    <input type="time" class="form-control" NAME="time2" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-12 col-form-label"><b>Due date</b></label>
                                <div class="col-3">
                                    <input type="date" class="form-control" name="duedate" id="duedate" required>
                                </div>
                            </div>
                            {{-- <br/> --}}
                            <div class="form-group row">
                                <label class="col-12 col-form-label" for="exampleInputName1"><b>ผู้แจ้ง (Requestor)</b></label>
                                <div class="col-5">
                                    <input type="text" class="form-control" name="Request_by" id="exampleInputName1"
                                        placeholder="ชื่อผู้แจ้ง">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-12 col-form-label"><b>บริษัท</b></label>
                                <div class="col-5">
                                    <select class="form-control col-md-5 form-select mb-3" id="User_login" name="User_login">
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
                                    <input type="text" class="form-control col-md-5" name="Customer_tel"
                                        placeholder="เบอร์ติดต่อ" required>
                                </div>
                            </div>
                            {{-- <br/> --}}
                            <div class="form-row">
                                <div class="col-2">
                                    <label for="exampleInputDate"><b>บริการ (Service)</b></label>
                                    <select class="form-control form-select mb-3" name="Service" class="input-sm" required>
                                        <option selected></option>
                                @foreach ($lookup as $look)
                                    <option value="{{ $look->Lookup_code }}">
                                        {{ $look->Lookup_description }}
                                    </option>
                                @endforeach
                                    </select>
                                </div>
                                <div class="col">
                                    <label for="SV_cat"><b>ประเภทบริการ (Service Categories)</b></label>
                                    <select class="form-control form-select mb-3" id="SV_cat" name="SV_cat" class="input-sm" required>
                                        <option selected></option>
                                @foreach ($lookup1 as $look)
                                    <option value="{{ $look->Lookup_code }}">
                                        {{ $look->Lookup_description }}
                                    </option>
                                @endforeach
                                    </select>
                                </div>
                                <div class="col">
                                    <label for="SV_system"><b>ระบบ (System)</b></label>
                                    <select class="form-control form-select mb-3" id="SV_system" name="SV_system" class="input-sm" required>
                                        <option selected></option>
                                @foreach ($lookup2 as $look)
                                    <option value="{{ $look->Lookup_code }}">
                                        {{ $look->Lookup_description }}
                                    </option>
                                @endforeach>
                                    </select>
                                </div>
                                <div class="col-3">
                                    <label for="SV_eqip"><b>อุปกรณ์ (Equipments)</b></label>
                                    <select class="form-control form-select mb-3" id="SV_eqip" name="SV_eqip" class="input-sm" required>
                                        <option selected></option>
                                        @foreach ($lookup3 as $look)
                                            <option value="{{ $look->Lookup_code }}">
                                                {{ $look->Lookup_description }}
                                            </option>
                                        @endforeach>
                                    </select>
                                </div>
                            </div>
                            {{-- <br /> --}}
                            <div class="form-row">
                                <label class="col-12 col-form-label"><b>อัพโหลดไฟล์ภาพ</b></label>
                                <div class="col-7">
                                    <!-- Populating custom file input label with the selected filename (data-toggle="custom-file-input" is initialized in Helpers.coreBootstrapCustomFileInput()) -->
                                    <label class="custom-file-label " for="example-file-input-custom">เลือกรูปภาพ</label>
                                    <input type="file" name="p_img" multiple="multiple"
                                        class="custom-file-input form-control" id="example-file-input-custom"
                                        name="example-file-input-custom" data-toggle="custom-file-input">  
                                </div>
                            </div><br />
                            <div class="form-group row">
                                <label class="col-12 col-form-label" for="exampleTextarea1"><b>รายละเอียดเพิ่มเติม</b></label>
                                <div class="col-7">
                                    <textarea name="Issue" class="form-control col-md-12" id="exampleTextarea1" rows="2" required></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-form-label" for="exampleInputDate"><b>มอบหมายงาน</b></label>
                                <div class="col-3">
                                    <select class="form-control form-select mb-3" id="Assign_by" name="Assign_by" class="input-sm">
                                        <option selected></option>
                                        @foreach ($workto as $work)
                                            <option value="{{ $work->User_login }}">
                                                {{ $work->User_login }}
                                            </option>
                                        @endforeach>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-form-label" for="exampleFormControlInput"><b>วิธีแก้ไข</b></label>
                                <div class="col-3">
                                    <select name="Fix_type" class="form-control form-select mb-3" id="exampleFormControlSelect1"
                                        style="width:230px;" required
                                        oninvalid="this.setCustomValidity('โปรดกรอกข้อมูลให้ครบ')"
                                        oninput="setCustomValidity('')">
                                        <option selected></option>
                                        @foreach ($lookup4 as $look)
                                            <option value="{{ $look->Lookup_code }}">
                                                {{ $look->Lookup_description }}
                                            </option>
                                        @endforeach>

                                    </select>
                                <div />
                            </div>
                                <br/>
                        </form>

                    </div>
                    <div class="form-row"> 
                        {{-- btn-outline --}}
                        <div class="col">
                            <button type="submit" value="Submit" name="btnaddcrq" id="addcrq"
                                class="btn btn-success btn-lg btn-block " style="opacity: 0.7">ยืนยัน</button> 
                        </div>
                        <div class="col">
                            <button type="reset" value="clear" name="btncancle"
                                class="btn btn-danger btn-lg btn-block" style="opacity: 0.7">ยกเลิก</button>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <!--end page wrapper -->
    @endsection

    @section('script')
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

    <!-- Bootstrap DatePicker -->
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js" type="text/javascript"></script>
    
    <script type="text/javascript">
        $(function () {
            $('#duedate').datepicker({
                format: "dd/mm/yyyy"
            });
        });
    </script> --}}
    @endsection
