@extends("layouts.app")
@section("style")
		<link href="assets/plugins/input-tags/css/tagsinput.css" rel="stylesheet" />
		@endsection
@section("wrapper")
	<div class="page-wrapper">
		<div class="page-content">
			<div class="row">
			<div class="col-10">
				
			<h6 class="mb-0 text-uppercase">ค่า KPI ประจำวันที่ {{ $from }} - {{ $to }} </h6>
			</div>
			<div class="col-2">
			<input type="month" value="" class="form-control">
		</div>
	</div>
			<hr/>
			<div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
				<div class="col">
					<div class="card radius-10 overflow-hidden">
						<div class="card-body">
							<div class="d-flex align-items-center">
								<div>
									<p class="mb-0">CRQ ทั้งหมด (รายเดือน)</p>
									<h5 class="mb-0">{{ $totalcrq }}</h5>
								</div>
								<div class="ms-auto">	<i class='bx bx-cart font-30'></i>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col">
					<div class="card radius-10 overflow-hidden">
						<div class="card-body">
							<div class="d-flex align-items-center">
								<div>
									<p class="mb-0">MAINTENANCE (MA)</p>
									<h5 class="mb-0">{{ $macrq }}</h5>
								</div>
								<div class="ms-auto">	<i class='bx bx-wallet font-30'></i>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col">
					<div class="card radius-10 overflow-hidden">
						<div class="card-body">
							<div class="d-flex align-items-center">
								<div>
									<p class="mb-0">CANCEL (ยกเลิก)</p>
									<h5 class="mb-0">{{ $cccrq }}</h5>
								</div>
								<div class="ms-auto">	<i class='bx bx-bulb font-30'></i>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col">
					<div class="card radius-10 overflow-hidden">
						<div class="card-body">
							<div class="d-flex align-items-center">
								<div>
									<p class="mb-0">TPT (THIRD PARTY)</p>
									<h5 class="mb-0">{{ $tptcrq }}</h5>
								</div>
								<div class="ms-auto">	<i class='bx bx-chat font-30'></i>
								</div>
							</div>
						</div>
					</div>
				</div>
				@if (session('LoggedUser.department') != 'Cus')
				<div class="col">
					<div class="card radius-10 overflow-hidden">
						<div class="card-body">
							<div class="d-flex align-items-center">
								<div>
									<p class="mb-0">ยังไม่ปิด (นับ KPI)</p>
									<h5 class="mb-0">{{ $pkpicrq }}</h5>
								</div>
								<div class="ms-auto">	<i class='bx bx-cart font-30'></i>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col">
					<div class="card radius-10 overflow-hidden">
						<div class="card-body">
							<div class="d-flex align-items-center">
								<div>
									<p class="mb-0">ยังไม่ปิด (ไม่นับ KPI)</p>
									<h5 class="mb-0">{{ $pnokpicrq }}</h5>
								</div>
								<div class="ms-auto">	<i class='bx bx-wallet font-30'></i>
								</div>
							</div>
						</div>
					</div>
				</div>
				@else
                @endif
				<div class="col">
					<div class="card radius-10 overflow-hidden">
						<div class="card-body">
							<div class="d-flex align-items-center">
								<div>
									<p class="mb-0">CRQ นำมาคำนวณทั้งหมด</p>
									<h5 class="mb-0">{{ $calcrq }}</h5>
								</div>
								<div class="ms-auto">	<i class='bx bx-bulb font-30'></i>
								</div>
							</div>
						</div>
					</div>
				</div>
				@if (session('LoggedUser.department') != 'Cus')
				<div class="col">
					<div class="card radius-10 overflow-hidden">
						<div class="card-body">
							<div class="d-flex align-items-center">
								<div>
									<p class="mb-0">KPI ทั้งหมด</p>
									<h5 class="mb-0">{{ $KPIALL }}</h5>
								</div>
								<div class="ms-auto">	<i class='bx bx-chat font-30'></i>
								</div>
							</div>
						</div>
					</div>
				</div>
				@else
                @endif
				<div class="col">
					<div class="card radius-10 overflow-hidden">
						<div class="card-body">
							<div class="d-flex align-items-center">
								<div>
									<p class="mb-0">ปิดภายใน 24 ชม.</p>
									<h5 class="mb-0">{{ $in24crq }}</h5>
								</div>
								<div class="ms-auto">	<i class='bx bx-chat font-30'></i>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col">
					<div class="card radius-10 overflow-hidden">
						<div class="card-body">
							<div class="d-flex align-items-center">
								<div>
									<p class="mb-0">ปิดเกิน 24 ชม.</p>
									<h5 class="mb-0">{{ $no24crq }}</h5>
								</div>
								<div class="ms-auto">	<i class='bx bx-chat font-30'></i>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!--end row-->
			@if (session('LoggedUser.department') != 'Cus')
			<div class="container">
				<div class="row">
				  <div class="col">
					<h6 class="mb-0 text-uppercase">KPI รายบุคคล</h6>
					<hr/>
					<div class="card" style="height: 25rem">
						<div class="card-body">
							@foreach ($personcrq as $object)
							@php
							$i = 0;
							
							$colors = ['success','info','warning','danger','primary'];
							shuffle($colors);
							@endphp
							@foreach ($colors as $id)
							@if($i < 1)
							<p>{{ $object->close_by }} : {{ $object->number }}ใบ</p>
							<div class="progress" style="height:7px;">
								<div class="progress-bar progress-bar-striped bg-{{$id}} progress-bar-animated" role="progressbar" aria-valuenow="{{ $object->number }}" aria-valuemin="0" aria-valuemax="{{ $calcrq }}" style="width: {{ number_format(($object->number/$calcrq)* 100, 2, '.', '') }}%"></div>
							</div>
							@php
							$i++
							@endphp
							@else
							@endif 
							@endforeach 
							@endforeach	

						</div>
					</div>
				
				  </div>
				  <div class="col">
					<h6 class="mb-0 text-uppercase">KPI ตามแผนก</h6>
					<hr/>
					<div class="card">
						<div class="card-body">
							<div class="chart-container1">
								<canvas id="chartkpi"></canvas>
								<p></p>
							</div>
						</div>
					</div>
				  </div>
				</div>
				
		</div>
		@else
        @endif

			<div class="container">
				<div class="row">
				  <div class="col">
					<h6 class="mb-0 text-uppercase">KPI ความสำคัญของงาน</h6>
					<hr/>
					<div class="card" style="height: 25rem">
						<div class="card-body">
							
							
							{{-- @foreach ($prioritycrqWC as $obj) --}}
							@php
							$i = 0;
							
							$colors = ['success','info','warning','danger','primary'];
							shuffle($colors);
							
							@endphp
							@foreach ($prioritycrqP as $object)
							@foreach ($colors as $id)
							
							@if($i < 1)
							<p>{{ $object->Priority }} : /{{ $object->number1 }} ใบ</p>
							<div class="progress" style="height:7px;">
								<div class="progress-bar progress-bar-striped bg-{{$id}} progress-bar-animated" role="progressbar" aria-valuenow="{{ $object->number1 }}" aria-valuemin="0" aria-valuemax="{{ $calcrq }}" style="width: {{ number_format(($object->number1/$calcrq)* 100, 2, '.', '') }}%"></div>
							</div>
							@php
							$i++
							@endphp
							@else
							@endif 
							@endforeach 
							@endforeach
							{{-- @endforeach	 --}}

						</div>
					</div>
				
				  </div>
				  <div class="col">
					<h6 class="mb-0 text-uppercase">KPI ตามแผนก</h6>
					<hr/>
					<div class="card">
						<div class="card-body">
							<div class="chart-container1">
								<canvas id="chartkpi"></canvas>
								<p></p>
							</div>
						</div>
					</div>
				  </div>
				</div>
				
		</div>
		
@endsection

@section("script")
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.0/dist/chart.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
{{-- <script src="assets/plugins/chartjs/js/Chart.min.js"></script> --}}
{{-- <script src="assets/plugins/chartjs/js/chartjs-custom.js"></script> --}}
{{-- <script src="assets/js/widgets.js"></script> --}}
<script src="assets/plugins/input-tags/js/tagsinput.js"></script>



<script>
	datapoint = [{{ $pkpicrq }}, {{ $no24crq}}, {{$in24crq}}];
	new Chart(document.getElementById("chartkpi"), {
		type: 'doughnut',
		data: {
			labels: ["ยังไม่ปิดนับ KPI", " เกิน 24 ชั่วโมง", " ไม่เกิน 24 ชั่วโมง"],
			datasets: [{
				// label: ["ยังไม่ปิดนับ KPI", " เกิน 24 ชั่วโมง", " ไม่เกิน 24 ชั่วโมง"],
				backgroundColor: ["#F8C471", "#4e73df", "#1cc88a"],
				data: [{{ $pkpicrq }}, {{ $no24crq}}, {{$in24crq}}]
			}]
		},
		
		plugins: [ChartDataLabels],
		options: {
			plugins:{
				tooltip:{
					enabaled: false
				},
				datalabels: {
					formatter: function(value, context) {
						function totalSum(total, datapoint){
							return total + datapoint;
						}
						// console.log(context);
						const totalvalue = datapoint.reduce(totalSum, 0);
						return value + ' ใบ : ' + Math.round(value / totalvalue *100) + '%';
					}
				}
				

			},
			maintainAspectRatio: false,
			title: {
				// display: true,
			}
		}
	});
</script>
@endsection
