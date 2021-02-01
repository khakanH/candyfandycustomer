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
                 <div class="card" >
                            <div class="card-body">
                                <h4 class="card-title">Orders</h4>

                                <div class="row">
                                  <div class="col-lg-4">
                                    <div class="input-group">
                                       <input type="text" name="order_search_text" placeholder="Enter Order Number" class="form-control" onfocusout="SearchOrder(this.value)">
                                        <div class="input-group-append">
                                            <button class="btn btn-info" type="button"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                  </div>
                                </div>

                            <div id="orderSearchDiv" class="mt-4 mb-1">
                              
                            </div>

                            <div id="OrderListDiv">
                                  

                                <ul class="nav nav-pills mt-4 mb-1">
                                    <li class=" nav-item"> <a href="#navpills-1" class="nav-link active" data-toggle="tab" aria-expanded="false">New Orders</a> </li>
                                    <li class="nav-item"> <a href="#navpills-2" class="nav-link" data-toggle="tab" aria-expanded="false" onclick="GetAcceptedOrder()">Accepted Orders</a> </li>
                                    <li class="nav-item"> <a href="#navpills-3" class="nav-link" data-toggle="tab" aria-expanded="true" onclick="GetCompletedOrder()">Completed Orders</a> </li>
                                     <li class="nav-item"> <a href="#navpills-4" class="nav-link" data-toggle="tab" aria-expanded="true" onclick="GetRejectedOrder()">Rejected Orders</a> </li>
                                </ul>
                                <div class="tab-content border p-4" style="min-height: 320px;">
                                    <div id="navpills-1" class="tab-pane active">
                                        






















              <div class="row">
                <div class="col-lg-12">
                  <button style="float: right; margin-right: 20px;" onclick="RefreshOrderList()" class="btn btn-success"><i class="mr-2 mdi mdi-refresh"></i> Refresh Orders</button>
                </div>
              </div>
              <br>

              <div id="newOrdersDiv">
                
            @if(count($orders) == 0)
            <br>
              <center><h6>No New Order Found!</h6></center>
            <br>
            @else

              @foreach($orders as $key)
              
             <div class="col-lg-12">
              <div class="card bd-0 border" id="Order{{$key['id']}}">
                <div class="card-header text-white bg-dark">
                 <span style="float: left;"> Order Number: {{$key['order_number']}}</span>


                 <button class="btn btn-danger"  style="float: right; height: 40px; padding: 10px;" onclick='RejectOrder("{{$key['id']}}")'> Reject</button >
                 <button class="btn btn-info"  style="float: right; margin-right:10px; height: 40px; padding: 10px;" onclick='AcceptOrder("{{$key['id']}}")'> Accept</button >
               
                </div>
                <div id="order_details_div{{$key['id']}}" class="card-body">

                  <div class="card-body">


                    <div class="row">
                      <div class="col-md">
                        <label class="tx-uppercase tx-13 tx-bold">Customer Information</label>
                        <p class="justify-content-between">
                          <span>Customer Name: </span>
                          <span>{{$key['customer_name']}}</span>
                        </p>
                        <p class="justify-content-between">
                          <span>Customer Phone: </span>
                          <span>{{$key['customer_phone']}}</span>
                        </p>
                        
                        <p class="justify-content-between">
                          <span>Delivery Address:</span>
                          <span>{{$key['delivery_address']}}</span>
                        </p>
                       
                      </div><!-- col -->
                      
                      <div class="col-md">
                        <label class="tx-uppercase tx-13 tx-bold mg-b-20">Order Information</label>
                        <p class="d-flex justify-content-between">
                          <span>Order Number: </span>
                          <span>{{$key['order_number']}}</span>
                        </p>
                        <p class="d-flex justify-content-between">
                          <span>Order Time: </span>
                          <span>{{date('M d, Y h:i a',strtotime($key['created_at']))}}</span>
                        </p>
                        
                        <p class="d-flex justify-content-between">
                          <span>Payment Method:</span>
                          <span>{{$key['payment_type']}}</span>
                        </p>
                        <p class="d-flex justify-content-between">
                          <span></span>
                          @if($key['is_paid'] == 1)
                          <span class="fa fa-check-circle tx-20 text-success"> Paid</span>
                          @else
                          <span class="fa fa-times-circle tx-20 text-danger"> Unpaid</span>
                          @endif
                        </p>
                      </div>
                    </div>

                  </div>
                   <div class="table-responsive">
                    <table class="table">
                      <thead style="text-align: center;">
                        <tr>
                            <th class="wd-20p"style="text-align: left;" >Product</th>
                            <!-- <th class="wd-10p">Price</th> -->
                            <!-- <th class="wd-10p">Quantity</th> -->
                            <th class="wd-10p">SubTotal</th>
                        </tr>
                    </thead>
                    <tbody style="vertical-align: middle; text-align: center;">
                    
                     @foreach($key->order_details as $key_)
                    <tr>
                        <td style="vertical-align: middle; text-align: left; padding-left: 30px;"><sub class="tx-teal" style="font-size: 13px;">{{$key_['quantity']}}x</sub> 
                           &nbsp;{{$key_['product_name']}}
                          <br>
                        </td>
                        <!-- <td style="vertical-align: middle;">{{$key_['restaurant_product_price']}}</td> -->
                        <!-- <td style="vertical-align: middle;">{{$key_['quantity']}}</td> -->
                        <td style="vertical-align: middle;">{{$key_['subtotal']}}</td>
                    </tr>

                    @endforeach

                    </tbody>
                  </table>
                </div>


                <table id="order_calculation_summary" class="table" style="width: 50%; float: right;">
                  <tbody>
                    <tr><th class="tx-left">Order Amount:</th><td class="tx-center">{{number_format($key['order_amount'],2)}}</td></tr>
                    <tr><th class="tx-left">Discount:</th><td class="tx-center">{{number_format($key['discount'],2)}}</td></tr>
                    <tr><th class="tx-left">Delivery Fee:</th><td class="tx-center">{{number_format($key['delivery_fee'],2)}}</td></tr>
                    <tr><th class="tx-left">Total Bill:</th><td class="tx-center">{{number_format($key['total_paid_amount'],2)}}</td></tr>
                  </tbody>
                </table>


                </div><!-- card-body -->
              </div><!-- card -->
            </div>
                 <br>
              @endforeach
              @endif

              </div>












































                                    </div>
                                    <div id="navpills-2" class="tab-pane">
                                        
                                        

                                    </div>
                                    <div id="navpills-3" class="tab-pane">
                                        
                                    </div>
                                    <div id="navpills-4" class="tab-pane">
                                        
                                    </div>
                                </div>
                               
                            </div>
                          </div>
                        </div>

</div>
</div>



@endsection
    
<script type="text/javascript">
  
    function RefreshOrderList()
    {

            $.ajax({
            type: "GET",
            url: "{{ config('app.url')}}admin/get-new-order",
            beforeSend: function(){
            
                  $('#newOrdersDiv').html('<center><div class="spinner-grow text-dark" role="status"><span class="sr-only">Loading...</span></div></center>');
                  
            },
            success: function(data) {
                  $('#newOrdersDiv').html(data);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Exception:' + errorThrown);
            }
          });
       
    }

    function AcceptOrder(id)
    {
      $.ajax({
            type: "GET",
            url: "{{ config('app.url')}}admin/accept-order/"+id,
            beforeSend: function(){
            
                  document.getElementById('Order'+id).style.display="none";
                  
            },
            success: function(data) {
                
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Exception:' + errorThrown);
            }
          });
    }
  
    function RejectOrder(id)
    {
      $.ajax({
            type: "GET",
            url: "{{ config('app.url')}}admin/reject-order/"+id,
            beforeSend: function(){
            
                  document.getElementById('Order'+id).style.display="none";
                  
            },
            success: function(data) {
                 
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Exception:' + errorThrown);
            }
          });
    }

    function CompleteOrder(id)
    {
      $.ajax({
            type: "GET",
            url: "{{ config('app.url')}}admin/complete-order/"+id,
            beforeSend: function(){
            
                  document.getElementById('Order'+id).style.display="none";
                  
            },
            success: function(data) {
                 
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Exception:' + errorThrown);
            }
          });
    }
    
    function GetAcceptedOrder()
    {
      $.ajax({
                  type: "GET",
                  url: "{{ config('app.url')}}admin/get-accepted-order",
                  beforeSend: function(){
                  
                        $('#navpills-2').html('<center><div class="spinner-grow text-dark" role="status"><span class="sr-only">Loading...</span></div></center>');
                        
                  },
                  success: function(data) {
                       $('#navpills-2').html(data);
                  },
                  error: function(jqXHR, textStatus, errorThrown) {
                      alert('Exception:' + errorThrown);
                  }
                });
    }
    
    function GetCompletedOrder()
    {
      $.ajax({
                  type: "GET",
                  url: "{{ config('app.url')}}admin/get-completed-order",
                  beforeSend: function(){
                  
                        $('#navpills-3').html('<center><div class="spinner-grow text-dark" role="status"><span class="sr-only">Loading...</span></div></center>');
                        
                  },
                  success: function(data) {
                       $('#navpills-3').html(data);
                  },
                  error: function(jqXHR, textStatus, errorThrown) {
                      alert('Exception:' + errorThrown);
                  }
                });
    } 
    function GetRejectedOrder()
    {
      $.ajax({
                  type: "GET",
                  url: "{{ config('app.url')}}admin/get-rejected-order",
                  beforeSend: function(){
                  
                        $('#navpills-4').html('<center><div class="spinner-grow text-dark" role="status"><span class="sr-only">Loading...</span></div></center>');
                        
                  },
                  success: function(data) {
                       $('#navpills-4').html(data);
                  },
                  error: function(jqXHR, textStatus, errorThrown) {
                      alert('Exception:' + errorThrown);
                  }
                });
    }

    function SearchOrder(val)
    {
      var val = val.trim();
      
      if (!val) 
      {
        document.getElementById("orderSearchDiv").innerHTML = "";
        document.getElementById("OrderListDiv").style.display= "block";
        return;
      }
      else
      {
        document.getElementById("OrderListDiv").style.display= "none";
        $.ajax({
                  type: "GET",
                  url: "{{ config('app.url')}}admin/search-order/"+val,
                  beforeSend: function(){
                  
                        $('#orderSearchDiv').html('<center><div class="spinner-grow text-dark" role="status"><span class="sr-only">Loading...</span></div></center>');
                        
                  },
                  success: function(data) {
                       $('#orderSearchDiv').html(data);
                  },
                  error: function(jqXHR, textStatus, errorThrown) {
                      alert('Exception:' + errorThrown);
                  }
                });
      }
      
    }
</script>
