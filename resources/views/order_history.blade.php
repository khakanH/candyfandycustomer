@extends('layout.app')
@section('content')


 <style type="text/css">
        .page-container { 
            background: url('public/assets/images/background/cartback-g.jpg') no-repeat left center;
            -moz-background-size: cover;
            -webkit-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
        } 
     
</style>
<section class="page-container" >
                <div class="page-content container">
                    <div class="thankyou-content pt-5 pb-5">
                        <div class="row  white-bg">
                            <div class="col-md-12 col-sm-12">
                               <div class="order-history order-heading profile-heading">
                                    <h2 class="mb-4">Order History</h2>
                                    <div class="history-table" style="overflow-x:auto;">
                                        <table class="table overflow-x">
                                            <thead>
                                              <tr>
                                                <th width="30%">Order</th>
                                                <th width="30%">Date</th>
                                                <th class="text-center" width="10%">Status</th>
                                                <th class="text-center" width="20%">Total</th>
                                                <th class="text-center" width="10%">Action</th>
                                              </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($orders as $key)
                                              @php($status_name = "")
                                              @if($key['order_status'] == 1)
                                              @php($status_name = "New")
                                              @elseif($key['order_status'] == 2)
                                              @php($status_name = "Accepted")
                                              @elseif($key['order_status'] == 3)
                                              @php($status_name = "Ongoing")
                                              @elseif($key['order_status'] == 4)
                                              @php($status_name = "Completed")
                                              @elseif($key['order_status'] == 5)
                                              @php($status_name = "Rejected")
                                              @endif


                                              <tr>
                                                <td>#{{$key['order_number']}}</td>
                                                <td>{{date('d-m-Y',strtotime($key['created_at']))}}</td>
                                                <td class="text-center">{{$status_name}}</td>
                                                <td class="text-center">{{$key['total_paid_amount']}}</td>
                                                <td class="text-center"><a href="javascript:void(0)" onclick='GetOrderHistoryDetails("{{$key['id']}}")'>View</a></td>
                                              </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                              </div> 
                            </div>
                        </div>
                    </div>
                </div>
            </section>  


<script type="text/javascript">
  function GetOrderHistoryDetails(id)
{
        $('#OrderDetailModal').modal('show');
        $('#OrderDetailModalLabel').html('Order Details');

        document.getElementById('OrderDetailModal').style.backgroundColor="rgba(0,0,0,0.8)";
        document.getElementById('OrderDetailModalDialog').style.paddingTop="0px";
        document.getElementById('OrderDetailModalData').style.padding="20px 20px 0px 20px";

         $.ajax({
            type: "GET",
            cache: false,
            url: "{{ config('app.url')}}get-order-details/"+id,
            beforeSend:function(){

            },
            success: function(data) {
                
              $('#OrderDetailModalData').html(data);

            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Exception:' + errorThrown);
            }
        });


}
</script>
@endsection