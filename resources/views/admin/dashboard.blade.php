@extends('admin.layouts.app')
@section('content')


<div class="page-wrapper">
<div class="page-content container-fluid">
                <center>
                        @if(session('success'))
                        <p class="text-success pulse animated">{{ session('success') }}</p>
                        {{ session()->forget('success') }}
                        @elseif(session('failed'))
                        <p class="text-danger pulse animated">{{ session('failed') }}</p>
                        {{ session()->forget('failed') }}
                        @endif
                </center>


                <div class="card-group">
                    <div class="card p-2 p-xl-3">
                        <div class="p-xl-3 p-2">
                            <div class="d-flex align-items-center">
                                <a class="btn btn-circle btn-danger text-white btn-lg" href="{{route('product')}}">
                                <i class="ti-clipboard"></i>
                            </a>
                                <div class="ml-4" style="width: 38%;">
                                    <h4 class="font-light">Products</h4>
                                    
                                </div>

                                <div class="ml-auto">
                                    <h2 class="display-7 mb-0">{{$product}}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card p-2 p-xl-3">
                        <div class="p-xl-3 p-2">
                            <div class="d-flex align-items-center">
                                <button class="btn btn-circle btn-cyan text-white btn-lg" href="javascript:void(0)">
                                <i class="ti-user"></i>
                            </button>
                                <div class="ml-4" style="width: 38%;">
                                    <h4 class="font-light">Customers</h4>
                                   
                                </div>
                                <div class="ml-auto">
                                    <h2 class="display-7 mb-0">{{$customer}}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card p-2 p-xl-3">
                        <div class="p-xl-3 p-2">
                            <div class="d-flex align-items-center">
                                <a class="btn btn-circle btn-warning text-white btn-lg" href="{{route('sale')}}">
                                <i class="fas fa-dollar-sign"></i>
                            </a>
                                <div class="ml-4" style="width: 38%;">
                                    <h4 class="font-light">Earnings</h4>
                                    
                                </div>
                                <div class="ml-auto">
                                    <h2 class="display-7 mb-0">{{number_format($earning,2)}}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>




<div class="row">
                            <div class="col-md-3">
                                <div class="card bg-inverse text-white">
                                    <div class="card-body" style="cursor: pointer;"  onclick="location.href='{{route("order",['1'])}}';">
                                        <div class="d-flex no-block align-items-center">
                                            <a href="JavaScript: void(0);"><i class="display-6 cc  text-white" title="ETH"></i></a>
                                            <div class="ml-3 mt-2">
                                                <h4 class="font-medium mb-0">All Orders</h4>
                                                <h5>{{$all_orders}}</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-cyan text-white">
                                    <div class="card-body" style="cursor: pointer;" onclick="location.href='{{route("order",['2'])}}';">
                                
                                        <div class="d-flex no-block align-items-center">
                                            <a href="JavaScript: void(0);"><i class="display-6 cc  text-white" title="LTC"></i></a>
                                            <div class="ml-3 mt-2">
                                                <h4 class="font-medium mb-0">Accepted</h4>
                                                <h5>{{$accepted}}</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-danger text-white">
                                    <div class="card-body" style="cursor: pointer;" onclick="location.href='{{route("order",['5'])}}';">
                                        <div class="d-flex no-block align-items-center">
                                            <a href="JavaScript: void(0);"><i class="display-6 cc  text-white" title="BTC"></i></a>
                                            <div class="ml-3 mt-2">
                                                <h4 class="font-medium mb-0">Rejected</h4>
                                                <h5>{{$rejected}}</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-success text-white">
                                    <div class="card-body" style="cursor: pointer;" onclick="location.href='{{route("order",['4'])}}';">
                                        <div class="d-flex no-block align-items-center">
                                            <a href="JavaScript: void(0);"><i class="display-6 cc  text-white" title="AMP"></i></a>
                                            <div class="ml-3 mt-2">
                                                <h4 class="font-medium mb-0">Completed</h4>
                                                <h5>{{$completed}}</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
    </div>



    <div class="row">
    	<div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Monthly Sale Stats</h4>
                                <div>
                                    <canvas id="bar-chart" height="230"></canvas>
                                </div>
                            </div>
                        </div>
        </div>
        <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Top Products</h4>
                                <div>
                                    <canvas id="pie-chart" height="230"></canvas>
                                </div>
                            </div>
                        </div>
        </div>
    </div>            



    



</div>
</div>

    <script src="{{asset('assets/libs/jquery/dist/jquery.min.js')}}"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>

<script type="text/javascript">
	
	$(function () {
    "use strict";
	// Bar chart
        var sale = <?php echo '["' . implode('", "', $monthly_sale) . '"]' ?>;

	   var ctx = document.getElementById("bar-chart");
                  if (ctx) {
                    var myChart = new Chart(ctx, {
                      type: 'bar',
                      data: {
                        labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul","Aug","Sep","Oct","Nov","Dec"],
                        type: 'line',
                        defaultFontFamily: 'Poppins',
                        datasets: [{
                          // data: [25,23,16,17,18,12,15,15,19,17,15,14],
                          data: sale,
                          label: "Sale",
                          backgroundColor: ["#289884", "#2dab95","#32bea6","#46c4ae","#5acbb7","#6fd1c0","#84d8c9","#98ded2","#ade5db","#c1ebe4","#d6f2ed","#eaf8f6"],
                        },]
                      },
                      options: {
                        responsive: true,
                        tooltips: {
                          mode: 'index',
                          titleFontSize: 12,
                          titleFontColor: '#fff',
                          bodyFontColor: '#fff',
                          backgroundColor: '#000',
                          titleFontFamily: 'Poppins',
                          bodyFontFamily: 'Poppins',
                          cornerRadius: 3,
                          intersect: false,
                        },
                        legend: {
                          display: false,
                          position: 'top',
                          labels: {
                            usePointStyle: true,
                            fontFamily: 'Poppins',
                          },


                        },
                        scales: {
                          xAxes: [{
                            display: true,
                            gridLines: {
                              display: false,
                              drawBorder: false
                            },
                            scaleLabel: {
                              display: false,
                              labelString: 'Month'
                            },
                            ticks: {
                              fontFamily: "Poppins"
                            }
                          }],
                          yAxes: [{
                            display: true,
                            gridLines: {
                              display: true,
                              drawBorder: true
                            },
                            scaleLabel: {
                              display: true,
                              labelString: 'Sales',
                              fontFamily: "Poppins"
                            },
                            ticks: {
                              fontFamily: "Poppins",
                              beginAtZero: true,  
                              suggestedMin: 0,
                              suggestedMax: "<?php echo max($monthly_sale)+(max($monthly_sale)/10); ?>",
                            }
                          }]
                        },
                        title: {
                          display: false,
                        }
                      }
                    });
                  }



    var p_name = <?php echo '["' . implode('", "', $top_product_name) . '"]' ?>;
    var p_count = <?php echo '["' . implode('", "', $top_product_count) . '"]' ?>;

	new Chart(document.getElementById("pie-chart"), {
		type: 'pie',
		data: {
		  labels: p_name,
		  datasets: [{
			label: "Population (millions)",
			backgroundColor: ["#32bea6", "#46c4ae","#5acbb7","#6fd1c0","#84d8c9"],
			data: p_count
		  }]
		},
		options: {
		  title: {
			display: true,
			text: 'Most Selling Products'
		  }
		}
	});
});
</script>

@endsection
