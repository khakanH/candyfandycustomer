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
 <!-- cart  content starts here -->
            <section class="page-container">
                <div class="page-content container">
                    <div class="row-wrapper">
                     
                        <!-- cart content starts here -->
                        <section class="cart-content">
                            <div class="row">

                                <div class="cart-content-container">
                                @if($cart == "")
                                <h2>Shopping Cart is Empty</h2>
                                <h4>You have no items in your shopping cart</h4>
                                <br><br><br><br><br><br><br><br>
                                @else
                                    <p>Item ({{count($cart_detail)}})</p>
                                    <div class="row mb-3">
                                        @foreach($cart_detail as $key)
                                        <div class="col-md-12 mb-3">
                                            <div class="row cart-row">
                                                <div class="col-md-9">
                                                    <div class="row">
                                                        <div class="col-md-2 p-0"> <img class="card-img-top cart-img"
                                                            src="{{config('app.img_url')}}{{$key['product_image']}}" alt="Card image cap">
                                                        </div>
                                                          
                                                        <div class="col-md-10">
                                                            <div class="card-body cart-card-body">
                                                               <div class="text mb-3">
                                                                    <p style="margin-top: -5px;">{{$key['product_name']}}</p>
                                                                   
                                                               </div>
                                                                <div class="amount-qty">
                                                                    <ul>
                                                                        <li class="card-text">Price: &nbsp;</li>
                                                                        <li class="card-title cart-card-title">{{$key['product_price']}}/- PKR</li>
                                                                    </ul>
                                                                </div>
                                                                <div class="amount-qty">
                                                                    <ul>
                                                                        <li class="card-text">QTY: &nbsp;</li>
                                                                        <li ><input onchange='ChangeCartItemQty(this.value,"{{$key['product_id']}}")' type="number" value="{{$key['product_quantity']}}" min="1" step="1" name="cart_item_qty" id="cart_item_qty{{$key['product_id']}}"></li>
                                                                    </ul>
                                                                </div>
                                                               
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="card-body cart-card-body cart-card-right">
                                                        <div class="text mb-3">
                                                            <a href="#"><i class="fas fa-times"></i></a>
                                                        </div>
                                                         <div class="amount-qty mt-5"> 
                                                             <ul>
                                                                 <li class="card-text">Subtotal: &nbsp;</li>
                                                                 <li class="card-title" ><b>{{$key['product_subtotal']}} PKR</b></li>
                                                             </ul>
                                                         </div>
                                                        
                                                     </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                 
                                @endif
                                </div>
                            </div>
                           
                        </section>
                         <!-- cart bottom starts here -->

                         @if($cart != "")
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
                                                <li class="card-title" ><b>{{$cart->total_price}} PKR</b></li>
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
                                                 <li class="card-title cart-card-title">{{count($cart_detail)}}</li>
                                             </ul>
                                         </div>
                                         <div class="amount-qty">
                                             <ul>
                                                <li class="card-title cart-card-title mb-0">{{$cart->total_price}} PKR</li>
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
                                   
                                   
                                }



        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('Exception:' + errorThrown);
        }
    });
    }

</script>
@endsection

