<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Product;
use App\Models\Orders;
use App\Models\OrderDetails;

use DB;

class OrderController extends Controller
{

    public function __construct(Request $request)
    {   
    }



    public function Index(Request $request)
    {	
      try 
        {
            $user_id = session("admin_login.user_id");

            $user_info = $this->checkUserAvailbility($user_id,$request);

            $orders = Orders::where('order_status',1)->orderBy('created_at','asc')->get();

            // foreach ($orders as $key)
            // {
            //     foreach($key->order_details as $key_)
            //     {
            //         echo $key_;
            //     }
            // }
            // exit();
            return view('admin.order',compact('orders'));
        } 
        catch (Exception $e) 
        {
            return response()->json($e,500);
        }
    }


    


    public function AcceptOrder(Request $request,$id)
    {   try 
        {
            $user_id = session("admin_login.user_id");

            $user_info = $this->checkUserAvailbility($user_id,$request);

            $orders = Orders::where('id',$id)->update(array('order_status'=>2));


        } 
        catch (Exception $e) 
        {
            return response()->json($e,500);
        }
    }

    public function RejectOrder(Request $request,$id)
    {   try 
        {
            $user_id = session("admin_login.user_id");

            $user_info = $this->checkUserAvailbility($user_id,$request);

            $orders = Orders::where('id',$id)->update(array('order_status'=>5,'cancel_type'=>1));


        } 
        catch (Exception $e) 
        {
            return response()->json($e,500);
        }
    }

    public function CompleteOrder(Request $request,$id)
    {   try 
        {
            $user_id = session("admin_login.user_id");

            $user_info = $this->checkUserAvailbility($user_id,$request);

            $get_order_item = OrderDetails::where('order_id',$id)->get();

            foreach ($get_order_item as $key) 
            {
                $prod = Product::where('id',$key['product_id'])->first();
                Product::where('id',$key['product_id'])->update(array('stock'=>$prod->stock - $key['quantity']));
            }


            $orders = Orders::where('id',$id)->update(array('order_status'=>4,'completed_time'=>date('Y-m-d H:i:s')));


        } 
        catch (Exception $e) 
        {
            return response()->json($e,500);
        }
    }















    // $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$
    // $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$
    // $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$
    // $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$


















    public function NewOrders(Request $request)
    {   
        try 
        {
           
            $user_id = session("admin_login.user_id");

            $user_info = $this->checkUserAvailbility($user_id,$request);

            $orders = Orders::where('order_status',1)->orderBy('created_at','asc')->get();

            if(count($orders) == 0):
            ?>
            <br>
              <center><h6>No New Order Found!</h6></center>
            <br>
            <?php 
            else:

            foreach($orders as $key):
            ?>
              
             <div class="col-lg-12">
              <div class="card bd-0 border" id="Order<?php echo $key['id'] ?>">
                <div class="card-header text-white bg-dark">
                 <span style="float: left;"> Order Number: <?php echo $key['order_number'] ?></span>


                 <button class="btn btn-danger"  style="float: right; height: 40px; padding: 10px;" onclick='RejectOrder("<?php echo $key['id'] ?>")'> Reject</button >
                 <button class="btn btn-info"  style="float: right; margin-right:10px; height: 40px; padding: 10px;" onclick='AcceptOrder("<?php echo $key['id'] ?>")'> Accept</button >
               
                </div>
                <div id="order_details_div<?php echo $key['id'] ?>" class="card-body">

                  <div class="card-body">


                    <div class="row">
                      <div class="col-md">
                        <label class="tx-uppercase tx-13 tx-bold">Customer Information</label>
                          <p class="justify-content-between">
                          <span>Customer Name: </span>
                          <span><?php echo $key['customer_name'] ?></span>
                        </p>
                        <p class="justify-content-between">
                          <span>Customer Phone: </span>
                          <span><?php echo $key['customer_phone'] ?></span>
                        </p>
                        
                        <p class="justify-content-between">
                          <span>Delivery Address:</span>
                          <span><?php echo $key['delivery_address'] ?></span>
                        </p>
                          
                       
                      </div><!-- col -->
                      
                      <div class="col-md">
                        <label class="tx-uppercase tx-13 tx-bold mg-b-20">Order Information</label>
                        <p class="d-flex justify-content-between">
                          <span>Order Number: </span>
                          <span><?php echo $key['order_number'] ?></span>
                        </p>
                        <p class="d-flex justify-content-between">
                          <span>Order Time: </span>
                          <span><?php echo date('M d, Y h:i a',strtotime($key['created_at'])) ?></span>
                        </p>
                        
                        <p class="d-flex justify-content-between">
                          <span>Payment Method</span>
                          <span><?php echo $key->payment_method_name['name'] ?></span>
                        </p>
                        <p class="d-flex justify-content-between">
                          <span></span>
                          <?php if($key['is_paid'] == 1): ?>
                          <span class="fa fa-check-circle tx-20 text-success"> Paid</span>
                          <?php else: ?>
                          <span class="fa fa-times-circle tx-20 text-danger"> Unpaid</span>
                          <?php endif; ?>
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
                    
                     <?php foreach($key->order_details as $key_): ?>
                    <tr>
                        <td style="vertical-align: middle; text-align: left; padding-left: 30px;"><sub class="tx-teal" style="font-size: 13px;"><?php echo $key_['quantity'] ?>x</sub> 
                           &nbsp;<?php echo $key_['product_name'] ?>
                          <br>
                        </td>
                        <!-- <td style="vertical-align: middle;"><?php echo $key_['restaurant_product_price'] ?></td> -->
                        <!-- <td style="vertical-align: middle;"><?php echo $key_['quantity'] ?></td> -->
                        <td style="vertical-align: middle;"><?php echo $key_['subtotal'] ?></td>
                    </tr>

                    <?php endforeach;?>

                    </tbody>
                  </table>
                </div>


                <table id="order_calculation_summary" class="table" style="width: 50%; float: right;">
                  <tbody>
                    <tr><th class="tx-left">Order Amount:</th><td class="tx-center"><?php echo number_format($key['order_amount'],2) ?></td></tr>
                    <tr><th class="tx-left">Discount:</th><td class="tx-center"><?php echo number_format($key['discount'],2) ?></td></tr>
                    <tr><th class="tx-left">Delivery Fee:</th><td class="tx-center"><?php echo number_format($key['delivery_fee'],2) ?></td></tr>
                    <tr><th class="tx-left">Total Bill:</th><td class="tx-center"><?php echo number_format($key['total_paid_amount'],2) ?></td></tr>
                  </tbody>
                </table>


                </div><!-- card-body -->
              </div><!-- card -->
            </div>
                 <br>
              <?php
                endforeach;
                endif;

        }
        catch (Exception $e) 
        {
            return response()->json($e,500);
        }
    }













    // $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$
    // $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$
    // $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$
    // $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$















    public function AcceptedOrderList(Request $request)
    {   
        try 
        {
           
            $user_id = session("admin_login.user_id");

            $user_info = $this->checkUserAvailbility($user_id,$request);

            $orders = Orders::where('order_status',2)->orderBy('created_at','asc')->get();

            if(count($orders) == 0):
            ?>
            <br>
              <center><h6>No Accepted Order Found!</h6></center>
            <br>
            <?php 
            else:
            ?>
                <div id="accordion" class="accordion">
            <?php
            foreach($orders as $key):
            ?>
              
             <div class="col-lg-12">
              <div class="card bd-0 border" id="Order<?php echo $key['id'] ?>">
                

                <div class="card-header text-white bg-dark" id="heading<?php echo $key['id'] ?>">
                <button class="btn btn-link" data-toggle="collapse" data-target="#collapse<?php echo $key['id'] ?>" aria-expanded="true" aria-controls="collapse<?php echo $key['id'] ?>">Order Number: <?php echo $key['order_number'] ?></button>
                
                 <button class="btn btn-info"  style="float: right; margin-right:10px; height: 40px; padding: 10px;" onclick='CompleteOrder("<?php echo $key['id'] ?>")'> Complete Order</button >
               
                </div>




                <div id="collapse<?php echo $key['id'] ?>" class="collapse" aria-labelledby="heading<?php echo $key['id'] ?>" data-parent="#accordion">

                  <div class="card-body">


                    <div class="row">
                      <div class="col-md">
                        <label class="tx-uppercase tx-13 tx-bold">Customer Information</label>
                                   <p class="justify-content-between">
                          <span>Customer Name: </span>
                          <span><?php echo $key['customer_name'] ?></span>
                        </p>
                        <p class="justify-content-between">
                          <span>Customer Phone: </span>
                          <span><?php echo $key['customer_phone'] ?></span>
                        </p>
                        
                        <p class="justify-content-between">
                          <span>Delivery Address:</span>
                          <span><?php echo $key['delivery_address'] ?></span>
                        </p>     
                       
                      </div><!-- col -->
                      
                      <div class="col-md">
                        <label class="tx-uppercase tx-13 tx-bold mg-b-20">Order Information</label>
                        <p class="d-flex justify-content-between">
                          <span>Order Number: </span>
                          <span><?php echo $key['order_number'] ?></span>
                        </p>
                        <p class="d-flex justify-content-between">
                          <span>Order Time: </span>
                          <span><?php echo date('M d,Y h:i a',strtotime($key['created_at'])) ?></span>
                        </p>
                        
                        <p class="d-flex justify-content-between">
                          <span>Payment Method</span>
                          <span><?php echo $key->payment_method_name['name'] ?></span>
                        </p>
                        <p class="d-flex justify-content-between">
                          <span></span>
                          <?php if($key['is_paid'] == 1): ?>
                          <span class="fa fa-check-circle tx-20 text-success"> Paid</span>
                          <?php else: ?>
                          <span class="fa fa-times-circle tx-20 text-danger"> Unpaid</span>
                          <?php endif; ?>
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
                    
                     <?php foreach($key->order_details as $key_): ?>
                    <tr>
                        <td style="vertical-align: middle; text-align: left; padding-left: 30px;"><sub class="tx-teal" style="font-size: 13px;"><?php echo $key_['quantity'] ?>x</sub> 
                           &nbsp;<?php echo $key_['product_name'] ?>
                          <br>
                        </td>
                        <!-- <td style="vertical-align: middle;"><?php echo $key_['restaurant_product_price'] ?></td> -->
                        <!-- <td style="vertical-align: middle;"><?php echo $key_['quantity'] ?></td> -->
                        <td style="vertical-align: middle;"><?php echo $key_['subtotal'] ?></td>
                    </tr>

                    <?php endforeach;?>

                    </tbody>
                  </table>
                </div>


                <table id="order_calculation_summary" class="table" style="width: 50%; float: right;">
                  <tbody>
                    <tr><th class="tx-left">Order Amount:</th><td class="tx-center"><?php echo number_format($key['order_amount'],2) ?></td></tr>
                    <tr><th class="tx-left">Discount:</th><td class="tx-center"><?php echo number_format($key['discount'],2) ?></td></tr>
                    <tr><th class="tx-left">Delivery Fee:</th><td class="tx-center"><?php echo number_format($key['delivery_fee'],2) ?></td></tr>
                    <tr><th class="tx-left">Total Bill:</th><td class="tx-center"><?php echo number_format($key['total_paid_amount'],2) ?></td></tr>
                  </tbody>
                </table>


                </div><!-- card-body -->
              </div><!-- card -->
            </div>
                 <br>
              <?php
                endforeach;
              ?>
                </div>
              <?php
                endif;

        }
        catch (Exception $e) 
        {
            return response()->json($e,500);
        }
    }













    // $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$
    // $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$
    // $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$
    // $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$















    public function RejectedOrderList(Request $request)
    {   
        try 
        {
           
            $user_id = session("admin_login.user_id");

            $user_info = $this->checkUserAvailbility($user_id,$request);

            $orders = Orders::where('order_status',5)->orderBy('created_at','asc')->get();

            if(count($orders) == 0):
            ?>
            <br>
              <center><h6>No Rejected Order Found!</h6></center>
            <br>
            <?php 
            else:
            ?>
                <div id="accordion" class="accordion">
            <?php    
            foreach($orders as $key):
            ?>
              
             <div class="col-lg-12">
              <div class="card bd-0 border" id="Order<?php echo $key['id'] ?>">


               <div class="card-header text-white bg-dark" id="heading<?php echo $key['id'] ?>">
                <button class="btn btn-link" data-toggle="collapse" data-target="#collapse<?php echo $key['id'] ?>" aria-expanded="true" aria-controls="collapse<?php echo $key['id'] ?>">Order Number: <?php echo $key['order_number'] ?></button>
                
                
               
                </div>




                <div id="collapse<?php echo $key['id'] ?>" class="collapse" aria-labelledby="heading<?php echo $key['id'] ?>" data-parent="#accordion">


                  <div class="card-body">


                    <div class="row">
                      <div class="col-md">
                        <label class="tx-uppercase tx-13 tx-bold">Customer Information</label>
                                   <p class="justify-content-between">
                          <span>Customer Name: </span>
                          <span><?php echo $key['customer_name'] ?></span>
                        </p>
                        <p class="justify-content-between">
                          <span>Customer Phone: </span>
                          <span><?php echo $key['customer_phone'] ?></span>
                        </p>
                        
                        <p class="justify-content-between">
                          <span>Delivery Address:</span>
                          <span><?php echo $key['delivery_address'] ?></span>
                        </p>     
                       
                      </div><!-- col -->
                      
                      <div class="col-md">
                        <label class="tx-uppercase tx-13 tx-bold mg-b-20">Order Information</label>
                        <p class="d-flex justify-content-between">
                          <span>Order Number: </span>
                          <span><?php echo $key['order_number'] ?></span>
                        </p>
                        <p class="d-flex justify-content-between">
                          <span>Order Time: </span>
                          <span><?php echo date('M d,Y h:i a',strtotime($key['created_at'])) ?></span>
                        </p>
                        
                        <p class="d-flex justify-content-between">
                          <span>Payment Method</span>
                          <span><?php echo $key->payment_method_name['name'] ?></span>
                        </p>
                        <p class="d-flex justify-content-between">
                          <span></span>
                          <?php if($key['is_paid'] == 1): ?>
                          <span class="fa fa-check-circle tx-20 text-success"> Paid</span>
                          <?php else: ?>
                          <span class="fa fa-times-circle tx-20 text-danger"> Unpaid</span>
                          <?php endif; ?>
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
                    
                     <?php foreach($key->order_details as $key_): ?>
                    <tr>
                        <td style="vertical-align: middle; text-align: left; padding-left: 30px;"><sub class="tx-teal" style="font-size: 13px;"><?php echo $key_['quantity'] ?>x</sub> 
                           &nbsp;<?php echo $key_['product_name'] ?>
                          <br>
                        </td>
                        <!-- <td style="vertical-align: middle;"><?php echo $key_['restaurant_product_price'] ?></td> -->
                        <!-- <td style="vertical-align: middle;"><?php echo $key_['quantity'] ?></td> -->
                        <td style="vertical-align: middle;"><?php echo $key_['subtotal'] ?></td>
                    </tr>

                    <?php endforeach;?>

                    </tbody>
                  </table>
                </div>


                <table id="order_calculation_summary" class="table" style="width: 50%; float: right;">
                  <tbody>
                    <tr><th class="tx-left">Order Amount:</th><td class="tx-center"><?php echo number_format($key['order_amount'],2) ?></td></tr>
                    <tr><th class="tx-left">Discount:</th><td class="tx-center"><?php echo number_format($key['discount'],2) ?></td></tr>
                    <tr><th class="tx-left">Delivery Fee:</th><td class="tx-center"><?php echo number_format($key['delivery_fee'],2) ?></td></tr>
                    <tr><th class="tx-left">Total Bill:</th><td class="tx-center"><?php echo number_format($key['total_paid_amount'],2) ?></td></tr>
                  </tbody>
                </table>


                </div><!-- card-body -->
              </div><!-- card -->
            </div>
                 <br>
              <?php
                endforeach;
                ?>
                </div>
                <?php
                endif;

        }
        catch (Exception $e) 
        {
            return response()->json($e,500);
        }
    }














    // $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$
    // $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$
    // $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$
    // $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$















    public function CompletedOrderList(Request $request)
    {   
        try 
        {
           
            $user_id = session("admin_login.user_id");

            $user_info = $this->checkUserAvailbility($user_id,$request);

            $orders = Orders::where('order_status',4)->orderBy('completed_time','desc')->get();

            if(count($orders) == 0):
            ?>
            <br>
              <center><h6>No Rejected Order Found!</h6></center>
            <br>
            <?php 
            else:
            ?>
                <div id="accordion" class="accordion">
            <?php   
            foreach($orders as $key):
            ?>
              
             <div class="col-lg-12">
              <div class="card bd-0 border" id="Order<?php echo $key['id'] ?>">
                     
               <div class="card-header text-white bg-dark" id="heading<?php echo $key['id'] ?>">
                <button class="btn btn-link" data-toggle="collapse" data-target="#collapse<?php echo $key['id'] ?>" aria-expanded="true" aria-controls="collapse<?php echo $key['id'] ?>">Order Number: <?php echo $key['order_number'] ?></button>
                
                
               
                </div>




                <div id="collapse<?php echo $key['id'] ?>" class="collapse" aria-labelledby="heading<?php echo $key['id'] ?>" data-parent="#accordion">

                  <div class="card-body">


                    <div class="row">
                      <div class="col-md">
                        <label class="tx-uppercase tx-13 tx-bold">Customer Information</label>
                            
                                   <p class="justify-content-between">
                          <span>Customer Name: </span>
                          <span><?php echo $key['customer_name'] ?></span>
                        </p>
                        <p class="justify-content-between">
                          <span>Customer Phone: </span>
                          <span><?php echo $key['customer_phone'] ?></span>
                        </p>
                        
                        <p class="justify-content-between">
                          <span>Delivery Address:</span>
                          <span><?php echo $key['delivery_address'] ?></span>
                        </p>
                      </div><!-- col -->
                      
                      <div class="col-md">
                        <label class="tx-uppercase tx-13 tx-bold mg-b-20">Order Information</label>
                        <p class="d-flex justify-content-between">
                          <span>Order Number: </span>
                          <span><?php echo $key['order_number'] ?></span>
                        </p>
                        <p class="d-flex justify-content-between">
                          <span>Order Time: </span>
                          <span><?php echo date('M d,Y h:i a',strtotime($key['created_at'])) ?></span>
                        </p>
                        
                        <p class="d-flex justify-content-between">
                          <span>Payment Method</span>
                          <span><?php echo $key->payment_method_name['name'] ?></span>
                        </p>
                        <p class="d-flex justify-content-between">
                          <span></span>
                          <?php if($key['is_paid'] == 1): ?>
                          <span class="fa fa-check-circle tx-20 text-success"> Paid</span>
                          <?php else: ?>
                          <span class="fa fa-times-circle tx-20 text-danger"> Unpaid</span>
                          <?php endif; ?>
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
                    
                     <?php foreach($key->order_details as $key_): ?>
                    <tr>
                        <td style="vertical-align: middle; text-align: left; padding-left: 30px;"><sub class="tx-teal" style="font-size: 13px;"><?php echo $key_['quantity'] ?>x</sub> 
                           &nbsp;<?php echo $key_['product_name'] ?>
                          <br>
                        </td>
                        <!-- <td style="vertical-align: middle;"><?php echo $key_['restaurant_product_price'] ?></td> -->
                        <!-- <td style="vertical-align: middle;"><?php echo $key_['quantity'] ?></td> -->
                        <td style="vertical-align: middle;"><?php echo $key_['subtotal'] ?></td>
                    </tr>

                    <?php endforeach;?>

                    </tbody>
                  </table>
                </div>


                <table id="order_calculation_summary" class="table" style="width: 50%; float: right;">
                  <tbody>
                    <tr><th class="tx-left">Order Amount:</th><td class="tx-center"><?php echo number_format($key['order_amount'],2) ?></td></tr>
                    <tr><th class="tx-left">Discount:</th><td class="tx-center"><?php echo number_format($key['discount'],2) ?></td></tr>
                    <tr><th class="tx-left">Delivery Fee:</th><td class="tx-center"><?php echo number_format($key['delivery_fee'],2) ?></td></tr>
                    <tr><th class="tx-left">Total Bill:</th><td class="tx-center"><?php echo number_format($key['total_paid_amount'],2) ?></td></tr>
                  </tbody>
                </table>


                </div><!-- card-body -->
              </div><!-- card -->
            </div>
                 <br>
              <?php
                endforeach;
                ?>
                </div>
                <?php   
                endif;

        }
        catch (Exception $e) 
        {
            return response()->json($e,500);
        }
    }
















    // $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$
    // $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$
    // $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$
    // $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$


















    public function SearchOrder(Request $request,$search)
    {   
        try 
        {
           
            $user_id = session("admin_login.user_id");

            $user_info = $this->checkUserAvailbility($user_id,$request);

            $orders = Orders::where('order_number','like','%'.$search.'%')->orderBy('created_at','desc')->get();

            if(count($orders) == 0):
            ?>
            <br>
              <center><h6>No Order Found!</h6></center>
            <br>
            <?php 
            else:

            foreach($orders as $key):
            ?>
              
             <div class="col-lg-12">
              <div class="card bd-0 border" id="Order<?php echo $key['id'] ?>">
                <div class="card-header text-white bg-dark">
                 <span style="float: left;"> Order Number: <?php echo $key['order_number'] ?></span>&nbsp;&nbsp;|&nbsp;&nbsp;<span> Order Status: <?php echo ($key['order_status']==1)? "New Order" : ( ($key['order_status']==2)? "Accepted" : (($key['order_status']==3)? "Ongoing" : (($key['order_status']==4)? "Completed": (($key['order_status']==5)? "Rejected": "" )))) ?></span>

                    <?php if($key['order_status']==1): ?>

                 <button class="btn btn-danger"  style="float: right; height: 40px; padding: 10px;" onclick='RejectOrder("<?php echo $key['id'] ?>")'> Reject</button >
                 <button class="btn btn-info"  style="float: right; margin-right:10px; height: 40px; padding: 10px;" onclick='AcceptOrder("<?php echo $key['id'] ?>")'> Accept</button >

                    <?php elseif($key['order_status']==2): ?>

                    <button class="btn btn-info"  style="float: right; margin-right:10px; height: 40px; padding: 10px;" onclick='CompleteOrder("<?php echo $key['id'] ?>")'> Complete Order</button >
                    
                    <?php elseif($key['order_status']==3): ?>
                    <?php elseif($key['order_status']==4): ?>
                    <?php elseif($key['order_status']==5): ?>
                    <?php else: ?>
                    <?php endif; ?>
                    
               
                </div>
                <div id="order_details_div<?php echo $key['id'] ?>" class="card-body">

                  <div class="card-body">


                    <div class="row">
                      <div class="col-md">
                        <label class="tx-uppercase tx-13 tx-bold">Customer Information</label>
                                   <p class="justify-content-between">
                          <span>Customer Name: </span>
                          <span><?php echo $key['customer_name'] ?></span>
                        </p>
                        <p class="justify-content-between">
                          <span>Customer Phone: </span>
                          <span><?php echo $key['customer_phone'] ?></span>
                        </p>
                        
                        <p class="justify-content-between">
                          <span>Delivery Address:</span>
                          <span><?php echo $key['delivery_address'] ?></span>
                        </p>     
                       
                      </div><!-- col -->
                      
                      <div class="col-md">
                        <label class="tx-uppercase tx-13 tx-bold mg-b-20">Order Information</label>
                        <p class="d-flex justify-content-between">
                          <span>Order Number: </span>
                          <span><?php echo $key['order_number'] ?></span>
                        </p>
                        <p class="d-flex justify-content-between">
                          <span>Order Time: </span>
                          <span><?php echo date('M d,Y h:i a',strtotime($key['created_at'])) ?></span>
                        </p>
                        
                        <p class="d-flex justify-content-between">
                          <span>Payment Method</span>
                          <span><?php echo $key->payment_method_name['name'] ?></span>
                        </p>
                        <p class="d-flex justify-content-between">
                          <span></span>
                          <?php if($key['is_paid'] == 1): ?>
                          <span class="fa fa-check-circle tx-20 text-success"> Paid</span>
                          <?php else: ?>
                          <span class="fa fa-times-circle tx-20 text-danger"> Unpaid</span>
                          <?php endif; ?>
                        </p>
                      </div>
                    </div>

                  </div>
                   <div class="table-responsive">
                    <table class="table">
                      <thead style="text-align: center;">
                        <tr>
                            <th class="wd-20p"style="text-align: left;" >Product</th>
                            <th class="wd-10p">SubTotal</th>
                        </tr>
                    </thead>
                    <tbody style="vertical-align: middle; text-align: center;">
                    
                     <?php foreach($key->order_details as $key_): ?>
                    <tr>
                        <td style="vertical-align: middle; text-align: left; padding-left: 30px;"><sub class="tx-teal" style="font-size: 13px;"><?php echo $key_['quantity'] ?>x</sub> 
                           &nbsp;<?php echo $key_['product_name'] ?>
                          <br>
                        </td>
                        
                        <td style="vertical-align: middle;"><?php echo $key_['subtotal'] ?></td>
                    </tr>

                    <?php endforeach;?>

                    </tbody>
                  </table>
                </div>


                <table id="order_calculation_summary" class="table" style="width: 50%; float: right;">
                  <tbody>
                    <tr><th class="tx-left">Order Amount:</th><td class="tx-center"><?php echo number_format($key['order_amount'],2) ?></td></tr>
                    <tr><th class="tx-left">Discount:</th><td class="tx-center"><?php echo number_format($key['discount'],2) ?></td></tr>
                    <tr><th class="tx-left">Delivery Fee:</th><td class="tx-center"><?php echo number_format($key['delivery_fee'],2) ?></td></tr>
                    <tr><th class="tx-left">Total Bill:</th><td class="tx-center"><?php echo number_format($key['total_paid_amount'],2) ?></td></tr>
                  </tbody>
                </table>


                </div><!-- card-body -->
              </div><!-- card -->
            </div>
                 <br>
              <?php
                endforeach;
                endif;

        }
        catch (Exception $e) 
        {
            return response()->json($e,500);
        }
    }


































    public function checkUserAvailbility($id,$request)
    {   

       
        $user = Admin::where('id',$id)->where('is_blocked',0)->first();


        if ($user == "") 
        {   

            if($request->ajax()) 
            {
                return response()->json(['status'=>"0",'msg' => 'Session expired'],401);
            }
            else
            {
                $request->session()->put("failed","Something went wrong.");
                header('Location:'.url('signout'));
            }
            
            exit();
        }
        else
        {   
            return $user;
        }
    }
    


}
    