@extends('admin.layouts.app')
@section('content')


<div class="page-wrapper">
<div class="page-content container-fluid">
               
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Sale History
                                    <div class="columns columns-right btn-group float-right">

                                    </div>
                                </h4>
                                <br>


                                <div class="table-responsive">
                                    <table class="table dataTablesOptions" style="width:100%; text-align: center;">
                                        <thead class="bg-inverse text-white">
                                            <tr>
                                                
                                                <th  class="text-center" width="2%">#</th>
                                                <th width="10%">Order Number</th>
                                                <th width="15%">Payment Type</th>
                                                <th width="15%">Payment Status</th>
                                                <th width="10%">Order Amount</th>
                                                <th width="10%">Delivery Fee</th>
                                                <th width="5%">Discount</th>
                                                <th width="10%">Total Bill</th>
                                                <th width="10%">Total Items</th>
                                                <th width="15%">Date</th>
                                            </tr>
                                        </thead>
                                        <tbody id="saleTBody">
                                           @foreach($sales as $key)
                                            <tr id="cate{{$key['id']}}">
                                                <td  class="text-center">{{$loop->iteration}}</td>
                                                <td>{{$key['order_number']}}</td>
                                                <td>{{$key['payment_type']}}</td>
                                                <td>{{$key['is_paid']}}</td>
                                                <td>{{$key['order_amount']}}</td>
                                                <td>{{$key['delivery_fee']}}</td>
                                                <td>{{$key['discount']}}</td>
                                                <td>{{$key['total_paid_amount']}}</td>
                                                <td>{{$key['total_item']}}</td>
                                                <td>{{date('M d, Y',strtotime($key['created_at']))}}</td>
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
