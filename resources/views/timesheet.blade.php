@extends('layouts.app')
@section('style')
    <link href="assets/plugins/vectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.1/sweetalert2.js" rel="stylesheet" />
    <link rel="stylesheet" href="sweetalert2.min.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.1/dist/sweetalert2.all.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.1/dist/sweetalert2.min.css" rel="stylesheet" />
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    
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
                            <h6 class="m-0 font-weight-bold text-primary"><strong>Timesheet</strong></h6>

                        </div>
                        <div id="success_message"></div>
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="dropdown ms-auto">

                                    <a class="dropdown-toggle dropdown-toggle-nocaret" href="#"
                                        data-bs-toggle="dropdown"><i
                                            class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="javascript:;" data-bs-toggle="modal"
                                                data-bs-target="#exampleScrollableModal">เพิ่มข้อมูล</a>
                                        </li>
                                        <li><a class="dropdown-item" href="javascript:;">Another action</a>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li><a class="dropdown-item" href="javascript:;">Something else here</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table id="timesheet" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>วันที่</th>
                                            <th>ผู้ใช้</th>
                                            <th>ลูกค้า</th>
                                            <th>CRQ</th>
                                            <th>ประเภท</th>
                                            <th>โปรเจค</th>
                                            <th>สิ่งที่ทำ</th>
                                            <th>จำนวนชั่วโมง</th>
                                            <th>แก้ไข/ลบ</th>

                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($data as $row)
                                            <tr>
                                                <input type="hidden" class="hiddelete_id" value="{{ $row->TS_id }}">
                                                <td>{{ $row->Date }}</td>
                                                <td>{{ $row->User_login }}</td>
                                                <td>{{ $row->Customer_name }}</td>
                                                <td>{{ $row->CRQ_id }}</td>
                                                <td>{{ $row->Category }}</td>
                                                <td class="text-wrap">{{ $row->Project }}</td>
                                                <td class="text-wrap">{{ $row->Activity }}</td>
                                                <td>{{ $row->Normal_usagetime }}</td>
                                                <td>
                                                    {{-- <a href="{{ url('Edit/'.$row->TS_id) }}" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#EditModal" >แก้ไข</a> --}}

                                                    <button type="button" class="btn btn-warning edit_data btn-sm"
                                                        value={{ $row->TS_id }}>แก้ไข</button>

                                                    {{-- <a href="{{ url('delete-data/'.$row->TS_id) }}" class="delete_btn_ajax btn btn-danger btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#" id="#delete" class="delete_id_value" >ลบ</a> --}}

                                                    <button type="button"
                                                        class="btn btn-danger servideletebtn btn-sm">ลบ</button>
                                                </td>


                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>วันที่</th>
                                            <th>ผู้ใช้</th>
                                            <th>ลูกค้า</th>
                                            <th>CRQ</th>
                                            <th>ประเภท</th>
                                            <th>โปรเจค</th>
                                            <th>สิ่งที่ทำ</th>
                                            <th>จำนวนชั่วโมง</th>
                                            <th>แก้ไข/ลบ</th>


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
    <div class="modal fade" id="exampleScrollableModal" tabindex="-1" aria-hidden="true">
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
                    <form method="POST" action="{{ route('adddata') }}"class="row g-3 ">
                        @csrf
                        <div class="col-md-12">
                            <label for="validationdate" class="form-label">วันที่</label>
                            <input type="date" class="date form-control" name="dateadd" id="validationdate" required>
                        </div>
                        <div class="col-md-12">
                            <label for="validationcustomer" class="form-label">ลูกค้า</label>

                            <select name="customer_name" class="customer_name form-select mb-3"
                                aria-label="Default select example" class="form-control" id="validationcustomer" required>
                                <option selected></option>
                                @foreach ($customer as $value)
                                    <option value="{{ $value->User_login }}">{{ $value->User_login }}</option>
                                @endforeach
                            </select>

                            <div class="invalid-feedback">โปรดระบุลูกค้า</div>
                        </div>
                        <div class="col-md-12">
                            <label for="validationcrq" class="form-label">หมายเลขCRQ</label>

                            <select name="crq_id" class="crq_id form-select mb-3" aria-label="Default select example"
                                class="form-control">
                                <option selected></option>
                                @foreach ($crq_id as $no)
                                    <option value="{{ $no->CRQ_id }}">{{ $no->CRQ_id }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label for="validationtype" class="form-label">ประเภท</label>
                            <select name="category" class="category form-select mb-3" aria-label="Default select example "
                                class="form-control" id="category" style="width:230px;" required
                                oninvalid="this.setCustomValidity('โปรดกรอกข้อมูลให้ครบ')" oninput="setCustomValidity('')"
                                required>
                                <option selected></option>
                                @foreach ($lookup as $type)
                                    <option id="category" name="category" value="{{ $type->Lookup_description }}">
                                        {{ $type->Lookup_description }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">โปรดระบุประเภท</div>
                        </div>
                        <div class="col-md-12" id="project" style="display: none">
                            <label for="validationtime" class="project form-label">โปรเจค</label>
                            <input type="text" class="form-control" id="project" name="project"
                                onChange="changetextbox()">
                        </div>

                        <div class="col-md-12">
                            <label for="validationactivity" class="form-label">สิ่งที่ทำ</label>
                            <textarea type="" name="activity" class="activity form-control" id="validationactivity" required></textarea>
                            <div class="invalid-feedback">โปรดระบุสิ่งที่ทำ</div>
                        </div>
                        <div class="col-md-12">
                            <label for="validationtime" class="form-label">จำนวนชั่วโมง</label>
                            <input type="text" name="normal_usagetime" class="normal_usagetime	form-control"
                                id="validationtime" placeholder="00:00" pattern="([01]?[0-9]|2[0-3]):[0-5][0-9]"
                                title="รูปแบบ = 00:00">
                            <div class="invalid-feedback">โปรดระบุจำนวนชั่วโมงให้ถูกต้อง</div>
                        </div>
                        <div class="col-md-12">
                            <label for="validationtime" class="start_ot form-label">เริ่ม OT</label>
                            <input type="text" name="start_ot" class="form-control" placeholder="00:00" pattern="([01]?[0-9]|2[0-3]):[0-5][0-9]"
                            title="รูปแบบ = 00:00">
                        </div>
                        <div class="col-md-12">
                            <label for="validationtime" class="end_ot form-label">จบ OT</label>
                            <input type="text" name="end_ot" class="form-control" placeholder="00:00" pattern="([01]?[0-9]|2[0-3]):[0-5][0-9]"
                            title="รูปแบบ = 00:00">
                        </div>
                        <label for="validationtime" class="form-label">ค่าใช้จ่าย</label>
                        <div class="col-md-6">
                            <label for="validationtime" class="form-label">ประเภท</label>
                            <select name="expense" class="expense form-select mb-3" aria-label="Default select example"
                                class="form-control">
                                <option selected></option>
                                @foreach ($lookup_type as $type)
                                    <option value="{{ $type->Lookup_description }}">
                                        {{ $type->Lookup_description }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="validationtime" class="form-label">จำนวน</label>
                            <input type="text" name="expense2" class="expense2 form-control">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-primary add_timesheet" id="adddata">บันทึกข้อมูล</button>
                </div>
                </form>

            </div>
        </div>
    </div>
    {{-- Form Edit --}}
    <div class="modal fade" id="EditModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header" style="background-color:palegoldenrod">
                    <h5 class="modal-title">แก้ไขข้อมูล</h5>
                    @error('dateadd')
                        <div class="alert  border-0 border-start border-5 border-danger alert-dismissible fade show">
                            <div>พบปัญหาระหว่างการบันทึกข้อมูลกรุณาตรวจสอบข้อมูลให้ถูกต้อง !!!</div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @enderror
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ url('update/' . $row->TS_id) }}" id="EditModal2" class="row g-3 ">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="edit_data_id" name="data_id">
                        <div class="col-md-12">
                            <label for="validationdate" class="form-label">วันที่</label>
                            {{-- @foreach ($da as $in) --}}
                            <input type="date" value="" class="date form-control" name="dateup"
                                id="edit_date" required>
                            {{-- @endforeach --}}
                        </div>

                        <div class="col-md-12">
                            <label for="validationcustomer" class="form-label">ลูกค้า</label>
                            <select name="customer_name" class="customer_name form-select mb-3"
                                aria-label="Default select example" class="form-control" id="edit_customername" required>
                                <option selected></option>
                                @foreach ($customer as $value)
                                    <option value="{{ $value->Customer_name }}">{{ $value->Customer_name }}
                                    </option>
                                @endforeach
                            </select>

                            <div class="invalid-feedback">โปรดระบุลูกค้า</div>
                        </div>
                        <div class="col-md-12">
                            <label for="validationcrq" class="form-label">หมายเลขCRQ</label>

                            <select name="crq_id" class="crq_id form-select mb-3" aria-label="Default select example"
                                class="form-control" id="edit_crq_id">
                                <option selected></option>
                                @foreach ($crq_id as $no)
                                    <option value="{{ $no->CRQ_id }}">{{ $no->CRQ_id }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label for="validationtype" class="form-label">ประเภท</label>
                            <select name="category"class="category form-select mb-3" aria-label="Default select example"
                                class="form-control" id="edit_category" onChange="changetextbox()" required>
                                <option selected></option>
                                @foreach ($lookup as $type)
                                    <option onChange="changetextbox()" value="{{ $type->Lookup_description }}">
                                        {{ $type->Lookup_description }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">โปรดระบุประเภท</div>
                        </div>
                        <div class="col-md-12" id="TextProject">
                            <label for="validationtime" class="project form-label">โปรเจค</label>
                            <input type="text" class="form-control" id="edit_project" name="project">
                        </div>

                        <div class="col-md-12">
                            <label for="validationactivity" class="form-label">สิ่งที่ทำ</label>
                            <textarea type="" name="activity" class="activity form-control" id="edit_activity" required></textarea>
                            <div class="invalid-feedback">โปรดระบุสิ่งที่ทำ</div>
                        </div>
                        <div class="col-md-12">
                            <label for="validationtime" class="form-label">จำนวนชั่วโมง</label>
                            <input type="text" name="normal_usagetime" class="normal_usagetime	form-control"
                                id="edit_normal_usagetime" placeholder="00:00" pattern="([01]?[0-9]|2[0-3]):[0-5][0-9]"
                                title="รูปแบบ = 00:00" required>
                            <div class="invalid-feedback">โปรดระบุจำนวนชั่วโมงให้ถูกต้อง</div>
                        </div>
                        <div class="col-md-12">
                            <label for="validationtime" class="start_ot form-label">เริ่ม OT</label>
                            <input type="text" name="start_ot" class="form-control" id="edit_start_ot" placeholder="00:00" pattern="([01]?[0-9]|2[0-3]):[0-5][0-9]"
                            title="รูปแบบ = 00:00">
                        </div>
                        <div class="col-md-12">
                            <label for="validationtime" class="end_ot form-label">จบ OT</label>
                            <input type="text" name="end_ot" class="form-control" id="edit_end_ot" placeholder="00:00" pattern="([01]?[0-9]|2[0-3]):[0-5][0-9]"
                            title="รูปแบบ = 00:00">
                        </div>
                        <label for="validationtime" class="form-label">ค่าใช้จ่าย</label>
                        <div class="col-md-6">
                            <label for="validationtime" class="form-label">ประเภท</label>
                            <select name="expense" id="edit_expense" class="expense form-select mb-3"
                                aria-label="Default select example" class="form-control">
                                <option selected></option>
                                @foreach ($lookup_type as $type)
                                    <option value="{{ $type->Lookup_description }}">
                                        {{ $type->Lookup_description }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="validationtime" class="form-label">จำนวน</label>
                            <input type="text" name="expense2" id="edit_expense2" class="expense2 form-control">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-primary add_timesheet" id="updatedata">บันทึกการแก้ไข</button>
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
    {{-- <script>
		// Example starter JavaScript for disabling form submissions if there are invalid fields
			(function () {
			  'use strict'

			  // Fetch all the forms we want to apply custom Bootstrap validation styles to
			  var forms = document.querySelectorAll('.needs-validation')

			  // Loop over them and prevent submission
			  Array.prototype.slice.call(forms)
				.forEach(function (form) {
				  form.addEventListener('submit', function (event) {
					if (!form.checkValidity()) {
					  event.preventDefault()
					  event.stopPropagation()
					}

					form.classList.add('was-validated')
				  }, false)
				})
			})()
	</script> --}}
    <script src="assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
    <script src="assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
    {{-- <script>
		$(document).ready(function() {
            
			$(document).on('click','.add_timesheet', function(e){
            e.preventDefault();
            // console.log("Test");
            var data = {
                'date' : $('.date').val(),
                'user_login' : $('.user_login').val(),
                'customer_name' : $('.customer_name').val(),
                'crq_id' : $('.crq_id').val(),
                'category' : $('.category').val(),
                'project' : $('.project').val(),
                'activity' : $('.activity').val(),
                'normal_usagetime' : $('.normal_usagetime').val(),
                'start_ot' : $('.start_ot').val(),
                'end_ot' : $('.end_ot').val(),
                'expense' : $('.expense').val(),
                'expense2' : $('.expense2').val(),

            }
            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });
            $.ajax({
                type: "POST",
                url: "timesheet",
                data:  data,
                datatype: "json",
                success: function (response) {
                    console.log(response);

                }

            })

            });
		  });
	</script> --}}
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
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"
        integrity="sha256-lSjKY0/srUM9BE3dPm+c4fBo1dky2v27Gdjm2uoZaL0=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.1/sweetalert2.min.css"></script>
    <script>
        //test
        $('#adddata').on('click', function(e) {
            console.log('btn click');
            Swal.fire({
                title: '',
                text: "Insert Successful!",
                type: 'success',
                icon: "success",
                showCloseButton: true
            })
        })
        //----------------------------------------------------------------
        // $(document).ready(function() {
        //     //add
        //     $(document).on("click", "#adddata", function() {
        //         var title = $('#title').val();
        //         var description = $('#description').val();
        //         $.ajax({
        //             url: "/timesheet",
        //             type: "POST",
        //             catch: false,
        //             data: {
        //                 User_login: User_login,
        //                 Date: Date,
        //                 Customer_name: Customer_name,
        //                 CRQ_id: CRQ_id,
        //                 category: category,
        //                 project: project,
        //                 Activity: Activity,
        //                 Normal_usagetime: Normal_usagetime,
        //                 Start_ot: Start_ot,
        //                 End_ot: End_ot,
        //                 Expense: Expense,
        //                 Expense2: Expense

        //             },
        //             success: function(dataResult) {
        //                 var dataResult = JSON.parse(dataResult);
        //                 if (dataResult.status == 1) {
        //                     $('#exampleScrollableModal').modal().hide();
        //                     swal("Setting Updated!", {
        //                         icon: "success",
        //                     }).then((result) => {
        //                         location.reload();
        //                     });
        //                 }
        //             }
        //         });
        //     });
        // });
    </script>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // fetchData();

            //Edit
            $(document).on('click', '.edit_data', function(e) {
                e.preventDefault();
                var TS_id = $(this).val();
                //console.log(TS_id);
                $('#EditModal').modal('show');
                $.ajax({
                    type: "GET",
                    url: "/edit-data/" + TS_id,
                    success: function(response) {
                        console.log(response);
                        if (response.status == 404) {
                            $('#success_message').html("");
                            $('#success_message').addClass('alert alert-danger');
                            $('#success_message').text(response.message);
                        } else {
                            $('#edit_date').val(response.message.Date);
                            $('#edit_customername').val(response.message.Customer_name);
                            $('#edit_crq_id').val(response.message.CRQ_id);
                            $('#edit_category').val(response.message.Category);
                            $('#edit_project').val(response.message.Project);
                            $('#edit_activity').val(response.message.Activity);
                            $('#edit_normal_usagetime').val(response.message.Normal_usagetime);
                            $('#edit_start_ot').val(response.message.Start_ot);
                            $('#edit_end_ot').val(response.message.End_ot);
                            $('#edit_expense').val(response.message.Expense);
                            $('#edit_expense2').val(response.message.Expense2);
                            $('#edit_data_id').val(TS_id);
                        }
                    }
                });
            });

            //Update
            $(document).on('click', '.updatedata', function(e) {
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
                var TS_id = $('#edit_data_id').val();
                var data = {
                    'Date': $('#edit_date').val(),
                    'Customer_name': $('#edit_customername').val(),
                    'CRQ_id': $('#edit_crq_id').val(),
                    'Category': $('#edit_category').val(),
                    'Project': $('#edit_project').val(),
                    'Activity': $('#edit_activity').val(),
                    'Normal_usagetime': $('#edit_normal_usagetime').val(),
                    'Start_ot': $('#edit_start_ot').val(),
                    'End_ot': $('#edit_end_ot').val(),
                    'Expense': $('#edit_expense').val(),
                    'Expense2': $('#edit_expense2').val(),
                }

                $.ajax({
                    type: "PUT",
                    url: "/update/" + TS_id,
                    data: data,
                    dataType: "json",

                    success: function(response) {
                        //console.log(response);
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
    </script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        //alert delete
        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('.servideletebtn').click(function(e) {
                e.preventDefault();

                var delete_id = $(this).closest("tr").find('.hiddelete_id').val();
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
                            "id": delete_id,
                        };
                        $.ajax({
                            type: "DELETE",
                            url: "/service-delete/" + delete_id,
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
    <script type="text/javascript">
        $("#category").click(
            function() {

                $("#project").show();

                // if (document.getElementById("category").value == "P" || document.getElementById(
                //         "category").value == "D") {
                //     document.getElementById("project").hidden = '';
                //     document.getElementById("TextProject").hidden = '';
                //     document.getElementById("project").disabled = '';
                // } else {
                //     document.getElementById("project").hidden = 'true';
                //     document.getElementById("TextProject").hidden = 'true';
                //     document.getElementById("project").disabled = 'true';
                // }
            })

        $("#edit_category").click(
            function() {
                $("#TextProject").show();
                $("#edit_project").show();
            }
        )
    </script>
@endsection
