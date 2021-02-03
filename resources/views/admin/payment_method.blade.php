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

        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Payment Methods
                <div class="columns columns-right btn-group float-right">
                                       <button type="button" class="btn waves-effect waves-light btn-rounded btn-success" onclick="AddPaymentMethod()"><i class="mr-2 mdi mdi-plus-circle"></i> Add Payment Method</button>

                                    </div></h4>
                <br>

                <div class="table-responsive">
                                    <table class="table dataTablesOptions" id="example" style="width:100%">
                                        <thead class="bg-inverse text-white">
                                            <tr>
                                                
                                                <th  class="text-center" width="5%">#</th>
                                                <th width="25%">Name</th>
                                                <th width="10%">Status</th>
                                                <th width="10%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="paymentTBody">
                                           @foreach($payment as $key)
                                           <tr id="payment{{$key['id']}}">
                                               
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$key['name']}}</td>
                                                <td>
                                                    <input type="hidden" id="payment-is-show-value<?php echo $key['id'] ?>" value="<?php echo $key['is_show'] ?>">
                                                    <div  onclick='ChangePaymentAvailability("<?php echo $key['id'] ?>")' class="bootstrap-switch-mini bootstrap-switch bootstrap-switch-wrapper bootstrap-switch-animate bootstrap-switch-off" style="width: 68px;">
                                                        <div id="payment-switch<?php echo $key['id'] ?>" class="bootstrap-switch-container" style="width: 99px;
                                                         <?php if ($key['is_show'] == 1): ?>
                                                             margin-left: 0px;
                                                         <?php else: ?>
                                                             margin-left: -33px;
                                                         <?php endif; ?>

                                                         ">
                                                            <span class="bootstrap-switch-handle-on bootstrap-switch-primary" style="width: 33px;">ON</span>
                                                            <span class="bootstrap-switch-label" style="width: 33px;">&nbsp;</span>
                                                            <span class="bootstrap-switch-handle-off bootstrap-switch-default" style="width: 33px;">OFF</span>
                                                            <input type="checkbox" checked="" data-size="mini">
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a class="btn btn-primary" href="javascript:void(0)" onclick='EditPayment("<?php echo $key['id']?>","<?php echo $key['name']?>")'><i class="fa fa-edit tx-15"></i></a>&nbsp;&nbsp;&nbsp;
                                                </td>

                                           </tr>
                                           @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                




                                
            </div>
        </div>

                
</div>
</div>


@endsection
<script type="text/javascript">
     function AddPaymentMethod()
    {
        document.getElementById('payment_name').value = "";
        document.getElementById('payment_id').value = "";
        $('#PaymentModal').modal('show');
        $('#PaymentModalLabel').html('Add New Payment Method');

        document.getElementById('PaymentModal').style.backgroundColor="rgba(0,0,0,0.8)";
        document.getElementById('PaymentModalDialog').style.paddingTop="0px";
        document.getElementById('PaymentModalData').style.padding="20px 20px 0px 20px";
    }



    function EditPayment(id,name)
    {
        document.getElementById('payment_name').value = name;
        document.getElementById('payment_id').value = id;
        $('#PaymentModal').modal('show');
        $('#PaymentModalLabel').html('Edit Payment');

        document.getElementById('PaymentModal').style.backgroundColor="rgba(0,0,0,0.8)";
        document.getElementById('PaymentModalDialog').style.paddingTop="0px";
        document.getElementById('PaymentModalData').style.padding="20px 20px 0px 20px";
    }

    function ChangePaymentAvailability(id)
    {   
        var val = document.getElementById("payment-is-show-value"+id).value;

        if (val == 1) 
        {
            document.getElementById("payment-switch"+id).style.marginLeft = "-33px";
            document.getElementById("payment-is-show-value"+id).value = 0;
            var switch_val = 0;
        }
        else
        {
            document.getElementById("payment-switch"+id).style.marginLeft = "0px";
            document.getElementById("payment-is-show-value"+id).value = 1;
            var switch_val = 1;
        }


            $.ajax({
            type: "GET",
            cache: false,
            url: "{{ config('app.url')}}admin/change-payment-method-availability/"+id+"/"+switch_val,
            success: function(data) {
                

                get_status = data['status'];
                get_msg    = data['msg'];

                                if (get_status == "0") 
                                {

                                 document.getElementById('toast').style.visibility = "visible";
                                    document.getElementById('toast').className = "alert alert-danger alert-rounded fadeIn animated";
                                    document.getElementById('toastMsg').innerHTML = get_msg;


                                     setTimeout(function() {
                                    document.getElementById('toast').style.visibility = "hidden";

                                }, 5000);

                                }
                                else
                                {
                                    document.getElementById('toast').style.visibility = "visible";
                                    document.getElementById('toast').className = "alert alert-success alert-rounded fadeIn animated";
                                    document.getElementById('toastMsg').innerHTML =  get_msg;


                                     setTimeout(function() {
                                    document.getElementById('toast').style.visibility = "hidden";

                                }, 5000);


                                }

            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Exception:' + errorThrown);
            }
        });


    }
</script>
