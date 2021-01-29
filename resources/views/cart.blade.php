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
      .cart-content{
            background: url('public/assets/images/cart/cart-zigzag.png') no-repeat center center;
            border: none;
            /* height: 100vh; */
            -moz-background-size: cover;
            -webkit-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
            min-height: 600px;
        }
 </style>
 <!-- cart  content starts here -->
            <section class="page-container">
                <div class="page-content container">
                    <div class="row-wrapper">
                     
                        <!-- cart content starts here -->
                        <section class="cart-content" style="width: 100%;">
                            <div class="">

                                <div class="cart-content-container">
                                @if(count($cart_detail) == 0)
                                <h2>Shopping Cart is Empty</h2>
                                <h4>You have no items in your shopping cart</h4>
                                @else
                                    <p>Item (<span  id="cart_item_count1">{{count($cart_detail)}}</span>)</p>
                                    @foreach($cart_detail as $key)
                                            <div id="cart_item{{$key['id']}}" class="cart-row mb-3" style="width: 100%; display: inline-block;">
                                            

                                                            
                                                            <span style="color: red; margin-left: auto; margin-right: 0; float: right; cursor: pointer;"  class="close" href="javascript:void(0)" onclick='DeleteCartItem("{{$key['id']}}","{{$key['product_id']}}")'><i class="fas fa-times"></i></span>
                                                        

                                                      <div class="row">
                                                        <div class="col-md-3">
                                                          <center> <img style="" class="card-img-top cart-img"
                                                            src="{{config('app.img_url')}}{{$key['product_image']}}" alt="Card image cap"></center>
                                                        </div>
                                                        <div class="col-md-9">
                                                           <div class="card-body cart-card-body" style="">
                                                                  <span class="card-text">{{$key['product_name']}}</span>
                                                             
                                                                <div class="amount-qty mt-3" style="margin-right: auto; margin-left: auto;">
                                                                    <ul>
                                                                      
                                                                        <li class="card-text">Price: &nbsp;</li>
                                                                        <li class="card-title cart-card-title">{{$key['product_price']}}/- PKR</li>
                                                                    </ul>
                                                                </div>
                                                                <div class="amount-qty">
                                                                    <ul>
                                                                        <li class="card-text">QTY: &nbsp;</li>
                                                                        <li ><input onchange='ChangeCartItemQty(this.value,"{{$key['product_id']}}")' type="number" value="{{$key['product_quantity']}}" min="1" step="1" name="cart_item_qty" id="cart_item_qty{{$key['product_id']}}"></li>
                                                                  <br>
                                                                  <br>
                                                                 <li class="card-text">Subtotal: &nbsp;</li>
                                                                 <li class="card-title" ><b id="cart_item_subtotal{{$key['product_id']}}">{{$key['product_subtotal']}} PKR</b></li>
                                                                    </ul>
                                                             
                                                                </div>
                                                            </div>
                                                             
                                                        </div>
                                                      </div>


                                                
                                            </div>
                                    @endforeach
                                @endif
                                </div>
                            </div>
                           
                        </section>
                         <!-- cart bottom starts here -->

                         @if(count($cart_detail) != 0)
                        <section class="cart-bottom">
                            <div class="row cart-bottom-container">
                                <div class="col-md-12 ">
                                    <div class="card-body cart-card-body cart-bottom-right" >
                                         <div class="amount-qty mb-1"> 
                                             <ul>
                                                 <li class="card-text">Shipping: &nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
                                                 <li class="card-title" >0 PKR</li>
                                             </ul>
                                         </div>
                                         <div class="amount-qty mb-1"> 
                                            <ul>
                                                <li class="card-text">Discount: &nbsp;&nbsp;&nbsp;&nbsp;
                                                   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
                                                <li class="card-title" >0 PKR</li>
                                            </ul>
                                        </div>
                                        <div class="amount-qty "> 
                                            <ul>
                                                <li class="card-text">Sub Total: &nbsp;&nbsp;&nbsp;&nbsp;
                                                   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
                                                <li class="card-title" ><b id="cart_total_price1">{{$cart->total_price}} PKR</b></li>
                                            </ul>
                                        </div>
                                        
                                     </div>
                                     <div class="clear-both"></div>
                                </div>
                            </div>
                            <div class="row  cart-bottom-container-btns">
                                <div class="col-md-4">
                                    <div class="card-body cart-card-body cart-bottom-left">
                                         <div class="amount-qty">
                                             <ul>
                                                 <li class="card-text">No of Items: &nbsp;</li>
                                                 <li class="card-title cart-card-title" id="cart_item_count2">{{count($cart_detail)}}</li>
                                             </ul>
                                         </div>
                                         <div class="amount-qty">
                                             <ul>
                                                <li class="card-title cart-card-title mb-0" id="cart_total_price2">{{$cart->total_price}} PKR</li>
                                             </ul>
                                         </div>
                                        
                                     </div>
                                </div>
                                <div class="col-md-8  link-btn-wrapper cart-btns">
                                    <a href="#" class="log-reg-btn text-white cart-bottom-btns">Checkout</a> 
                                    <a href="{{route('product_list')}}" class="log-reg-btn text-white cart-bottom-btns">Continue Shopping</a> 
                                </div>
                             </div>
                        </section>
                        @endif
                        <!-- cart bottom ends here -->
                    </div>
                </div><br>
<br>
<br>
<br>
            </section> 
            <!-- cart content ends here -->



<script type="text/javascript">

    function ChangeCartItemQty(qty,prod_id)
    {   
        qty = parseInt(qty);

        if (!qty || qty <= 0) 
        {   
            alert("Please enter a valid quantity");
            return;
        }

        
        $.ajax({
        type: "GET",
        url: "{{ config('app.url')}}change-cart-item-qty/"+prod_id+"/"+qty,
        beforeSend: function(){
                            $('#LoadingModal').modal('show');
                        },
        success: function(data) {
                            $('#LoadingModal').modal('hide');
                get_status = data['status'];
                get_msg    = data['msg'];

                                if (get_status == "0") 
                                {
                                    alert(get_msg);                                
                                }
                                else
                                {
                                         document.getElementById("cart_item_qty"+prod_id).value = data['product_count'];
                                        document.getElementById("cart_total_price1").innerHTML = data['cart_total_price']+ " PKR";
                                         document.getElementById("cart_total_price2").innerHTML = data['cart_total_price']+ " PKR";
                                          document.getElementById("cart_item_subtotal"+prod_id).innerHTML = data['cart_item_subtotal']+ " PKR";
                                   
                                }



        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('Exception:' + errorThrown);
        }
    });
    }


    function DeleteCartItem(cart_id,prod_id)
    {   
        
        $.ajax({
        type: "GET",
        url: "{{ config('app.url')}}delete-cart-item/"+prod_id,
        beforeSend: function(){
                            $('#LoadingModal').modal('show');
                        },
        success: function(data) {
                            $('#LoadingModal').modal('hide');
                get_status = data['status'];
                get_msg    = data['msg'];

                                if (get_status == "0") 
                                {
                                    alert(get_msg);                                
                                }
                                else
                                {
                                         document.getElementById("cart_item"+cart_id).style.display = "none";
                                         document.getElementById("cart_total_items").innerHTML = data['total_item_count'];
                                        document.getElementById("cart_item_count1").innerHTML =data['total_item_count'];  
                                        document.getElementById("cart_item_count2").innerHTML =data['total_item_count'];  
                                         document.getElementById("cart_total_price1").innerHTML = data['cart_total_price']+ " PKR";
                                          document.getElementById("cart_total_price2").innerHTML = data['cart_total_price']+ " PKR";
                                }



        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('Exception:' + errorThrown);
        }
    });
    }

</script>
@endsection

