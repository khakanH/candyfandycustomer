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
       .arrow > .error{
            color: red !important;
            margin: 7px;
        }
 </style>

     <section class="page-container" >
                <div class="page-content container">
                    <div class="thankyou-content pt-5 pb-5">
                       
                        <div class="row thankyou-row profile-row">
                       <div class="col-md-12 profile-heading"> <h2 class="mb-4">{{ucfirst($customer_info->name)}}</h2></div>  
                            <div class="col-md-6 pb-4" style="border-bottom: solid gray 1px;">
                                <center>
                                    @if(session('success'))
                                                <p class="text-success pulse animated">{{ session('success') }}</p>
                                                {{ session()->forget('success') }}
                                                @elseif(session('failed'))
                                                <p class="text-danger pulse animated">{{ session('failed') }}</p>
                                                {{ session()->forget('failed') }}
                                    @endif
                                    </center>
                                    <div class="profile-heading ">
                                    <div>
                                        <b><p>Account Information</p></b> 
                                    </div>
                                    <form action="{{route('save-profile')}}" method="post" name="profileForm"> 
                                        @csrf
                                         <span class='arrow'>
                                        <label class='error'></label>
                                        </span>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-5 p-0">
                                                <label for="name" class="mt-2">Name*</label>
                                                <input type="text" id="name" name="name" class="form-control mb-2" value="{{$customer_info->name}}">
                                            </div>
                                            <div class="col-md-1"></div>
                                            <div class="col-md-6 p-0">
                                            <label for="email" class="mt-2">Email*</label>
                                            <input type="email" name="email" id="email" class="form-control  mb-2" value="{{$customer_info->email}}">
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <label for="phone" class="mt-2">Contact Number*</label>
                                             <input type="number" name="phone" id="phone" class="form-control  mb-2" value="{{$customer_info->phone}}">
                                        </div>
                                        <div class="row">
                                            <label for="address" class="mt-2">Address*</label>
                                            <textarea class="form-control  mb-2" name="address" id="address" rows="4">{{$customer_info->address}}</textarea>
                                        </div>
                                        
                                    <button type="submit" class="log-reg-btn mt-5" style="margin-left: -16px;">Submit</button> 
                                    </form>
                               </div>


                            </div>
                            <div class="col-md-1"><br><br></div>
                            <div class="col-md-5">
                              <div class="profile-heading">
                                        <b><p>Order History</p></b> 
                              </div>
                              <br>

                              <div class="history-table p-0" style="overflow-x:auto;">
                                        <table class="table overflow-x ">
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
                                            <tfoot>
                                              <tr>
                                                <td colspan="5"><a href="{{route('order_history')}}">View More..</a></td>
                                              </tr>
                                            </tfoot>
                                        </table>
                                    </div>

                            </div>
                        </div>
                    </div>
                </div>
            </section> 
<script type="text/javascript">
     $.validator.addMethod('emailFormat', function(value, element) {
        return this.optional(element) || (value.match(/^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$/));
    },
    'Please enter a valid email address');
            $(function() {
        $("form[name='profileForm']").validate({
             errorPlacement: function(label, element) {
        label.addClass('arrow');
        label.insertBefore(element);
    },
    wrapper: 'span',

    rules: {
    
      name: {
        required: true,
      },
      address: {
        required: true,
      },
      phone: {
        required: true,
      },
      email: {
        required: true,
        emailFormat: true,
      },
     
    },
    messages: {
     
      name: {
        required: "Please fill this field",
      },
      address: {
        required: "Please fill this field",
      },
      phone: {
        required: "Please fill this field",
      },
       email: {
        required: "Please fill this field",
      },
      
    },
    submitHandler: function(form) {

        form.submit();
    }
  });
  });

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