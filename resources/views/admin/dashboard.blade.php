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
                                <button class="btn btn-circle btn-danger text-white btn-lg" href="javascript:void(0)">
                                <i class="ti-clipboard"></i>
                            </button>
                                <div class="ml-4" style="width: 38%;">
                                    <h4 class="font-light">Products</h4>
                                    
                                </div>
                                <div class="ml-auto">
                                    <h2 class="display-7 mb-0">23</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card p-2 p-xl-3">
                        <div class="p-xl-3 p-2">
                            <div class="d-flex align-items-center">
                                <button class="btn btn-circle btn-cyan text-white btn-lg" href="javascript:void(0)">
                                <i class="ti-wallet"></i>
                            </button>
                                <div class="ml-4" style="width: 38%;">
                                    <h4 class="font-light">Customers</h4>
                                   
                                </div>
                                <div class="ml-auto">
                                    <h2 class="display-7 mb-0">76</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card p-2 p-xl-3">
                        <div class="p-xl-3 p-2">
                            <div class="d-flex align-items-center">
                                <button class="btn btn-circle btn-warning text-white btn-lg" href="javascript:void(0)">
                                <i class="fas fa-dollar-sign"></i>
                            </button>
                                <div class="ml-4" style="width: 38%;">
                                    <h4 class="font-light">Earnings</h4>
                                    
                                </div>
                                <div class="ml-auto">
                                    <h2 class="display-7 mb-0">83</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>




<div class="row">
                            <div class="col-md-3">
                                <div class="card bg-inverse text-white">
                                    <div class="card-body">
                                        <div class="d-flex no-block align-items-center">
                                            <a href="JavaScript: void(0);"><i class="display-6 cc  text-white" title="ETH"></i></a>
                                            <div class="ml-3 mt-2">
                                                <h4 class="font-medium mb-0">All Orders</h4>
                                                <h5>1000</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-cyan text-white">
                                    <div class="card-body">
                                        <div class="d-flex no-block align-items-center">
                                            <a href="JavaScript: void(0);"><i class="display-6 cc  text-white" title="LTC"></i></a>
                                            <div class="ml-3 mt-2">
                                                <h4 class="font-medium mb-0">Accepted</h4>
                                                <h5>300</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-orange text-white">
                                    <div class="card-body">
                                        <div class="d-flex no-block align-items-center">
                                            <a href="JavaScript: void(0);"><i class="display-6 cc  text-white" title="BTC"></i></a>
                                            <div class="ml-3 mt-2">
                                                <h4 class="font-medium mb-0">Rejected</h4>
                                                <h5>20</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-info text-white">
                                    <div class="card-body">
                                        <div class="d-flex no-block align-items-center">
                                            <a href="JavaScript: void(0);"><i class="display-6 cc  text-white" title="AMP"></i></a>
                                            <div class="ml-3 mt-2">
                                                <h4 class="font-medium mb-0">Completed</h4>
                                                <h5>500</h5>
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
                                <h4 class="card-title">Bar Chart</h4>
                                <div>
                                    <canvas id="bar-chart" height="230"></canvas>
                                </div>
                            </div>
                        </div>
        </div>
        <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Pie Chart</h4>
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
	new Chart(document.getElementById("bar-chart"), {
		type: 'bar',
		data: {
		  labels: ["Africa", "Asia", "Europe", "Latin America", "North America"],
		  datasets: [
			{
			  label: "Population (millions)",
			  backgroundColor: ["#03a9f4", "#e861ff","#08ccce","#e2b35b","#e40503"],
			  data: [8478,6267,5734,4784,1833]
			}
		  ]
		},
		options: {
		  legend: { display: false },
		  title: {
			display: true,
			text: 'Predicted world population (millions) in 2050'
		  }
		}
	});



	new Chart(document.getElementById("pie-chart"), {
		type: 'pie',
		data: {
		  labels: ["Africa", "Asia", "Europe", "Latin America"],
		  datasets: [{
			label: "Population (millions)",
			backgroundColor: ["#36a2eb", "#ff6384","#4bc0c0","#ffcd56","#07b107"],
			data: [2478,2784,3734,2784]
		  }]
		},
		options: {
		  title: {
			display: true,
			text: 'Predicted world population (millions) in 2050'
		  }
		}
	});
});
</script>

@endsection
