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
                        <div class=" white-bg">
                            <div class="order-history order-heading ">
                                <h2 class="mb-2 mx-3 fav-heading">My Favourites</h2>
                                <div class="row card-row">
                                @if(count($fav_product) == 0)
                                    <h3 style="">Your favorite list is empty</h3>
                                @endif 
                                        
                                   

                                    @foreach($fav_product as $key)
                                   <div class="col-md-3" style="float:left">
                                        <div class="card mb-2">
                                            <center><img style="cursor: pointer;" onclick='GetProductDetails("{{$key['id']}}")'  class="card-img-top"
                                            src="{{config('app.img_url')}}{{$key['image']}}" alt="Card image cap" ></center>
                                            <div class="card-body">
                                                 <a href="{{route('product-detail',[$key['id']])}}">
                                                <p class="card-text">{{$key['name']}}</p>
                                                <h4 class="card-title"><b>{{$key['sale_price']}}/- PKR</b>
                                                </h4>
                                                </a>
                                                <span class="card-icons">
                                                    <a href="javascript:void(0)" onclick='AddtoCart("{{$key['id']}}")'><i id="cart_btn{{$key['id']}}" class="fas fa-shopping-cart" style="
                                                        <?php if ($key['cart_count'] != 0): ?>
                                                        color: #2cabe3;
                                                        <?php endif ?>
                                                    "></i></a>
                                                    <input onchange='ChangeCartItemQty(this.value,"{{$key['id']}}")' type="number" value="{{$key['cart_count']}}" min="1" step="1" name="cart_item_qty" id="cart_item_qty{{$key['id']}}" style="
                                                    <?php if ($key['cart_count'] == 0): ?>
                                                     display: none; 
                                                    <?php endif ?>
                                                    
                                                    width: 60px; background: #e6e7e9; border: solid darkgray 1px; padding: 4px; height: 100%;">
                                                    <a href="javascript:void(0)" onclick='MarkItemFavorite("{{$key['id']}}")' style=" 
                                                        <?php if (!empty($key['favorite_id'])): ?>
                                                            color: red;
                                                        <?php endif; ?>"
                                                     id="fav_btn{{$key['id']}}"><i  class="fas fa-heart"></i></a>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                    




                                </div>
                            </div>       
                        </div>
                    </div>
                </div>
            </section>  




            <script type="text/javascript">
    function AddtoCart(prod_id)
    {
        
        var FP_cart_btn = document.getElementById("cart_btn"+prod_id);
        var BS_cart_btn = document.getElementById("cart_btn_"+prod_id);

        var FP_cart_item_qty = document.getElementById("cart_item_qty"+prod_id);
        var BS_cart_item_qty = document.getElementById("cart_item_qty_"+prod_id);



        $.ajax({
        type: "GET",
        cache: false,
        url: "{{ config('app.url')}}add-to-cart/"+prod_id,
        beforeSend: function(){
                            $('#LoadingModal').modal('show');
                        },
        success: function(data) {
                            $('#LoadingModal').modal('hide');

            if (FP_cart_btn && FP_cart_item_qty) 
            {
                document.getElementById("cart_btn"+prod_id).style.color = "#2cabe3";
                document.getElementById("cart_item_qty"+prod_id).style.display = "inline-block";
            }

            if (BS_cart_btn && BS_cart_item_qty) 
            {
                document.getElementById("cart_btn_"+prod_id).style.color = "#2cabe3";
                document.getElementById("cart_item_qty_"+prod_id).style.display = "inline-block";
            }
            



                get_status = data['status'];
                get_msg    = data['msg'];

                                if (get_status == "0") 
                                {
                                    alert(get_msg);                                
                                }
                                else
                                {   
                                    if (FP_cart_item_qty) 
                                    {
                                         document.getElementById("cart_item_qty"+prod_id).value = data['data']['product_count'];
                                    }
                                    if (BS_cart_item_qty) 
                                    {
                                         document.getElementById("cart_item_qty_"+prod_id).value = data['data']['product_count'];
                                    }
                                    
                                    document.getElementById("cart_total_items").innerHTML = data['data']['total_item_count'];

                                }



        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('Exception:' + errorThrown);
        }
    });





    }


    function ChangeCartItemQty(qty,prod_id)
    {   
        qty = parseInt(qty);

        if (!qty || qty <= 0) 
        {   
            alert("Please enter a valid quantity");
            return;
        }

        var FP_cart_item_qty = document.getElementById("cart_item_qty"+prod_id);
        var BS_cart_item_qty = document.getElementById("cart_item_qty_"+prod_id);
        
        $.ajax({
        type: "GET",
        cache: false,
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
                                   if (FP_cart_item_qty) 
                                    {
                                         document.getElementById("cart_item_qty"+prod_id).value = data['product_count'];
                                    }
                                    if (BS_cart_item_qty) 
                                    {
                                         document.getElementById("cart_item_qty_"+prod_id).value = data['product_count'];
                                    }
                                }



        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('Exception:' + errorThrown);
        }
    });
    }











    function GetProductDetails(prod_id)
    {
       window.location.href = "{{ config('app.url')}}product-detail/"+prod_id;
    }



    function MarkItemFavorite(prod_id)
    {
        var customer_id = "<?php echo session("login.customer_id") ?>";

        if (!customer_id) 
        {
            alert('Kindly Login First to Mark Item Favorite.');
            return
        }

        var FP_fav_btn = document.getElementById("fav_btn"+prod_id);
        var BS_fav_btn = document.getElementById("fav_btn_"+prod_id);


        $.ajax({
        type: "GET",
        cache: false,
        url: "{{ config('app.url')}}mark-item-favorite/"+prod_id,
        beforeSend: function(){
                            $('#LoadingModal').modal('show');
                        },
        success: function(data) {
                            $('#LoadingModal').modal('hide');
                get_status = data['status'];
                get_msg    = data['msg'];

                                if (get_status == "1") 
                                {
                                    if (data['toggle'] == 1) 
                                    {
                                        if (FP_fav_btn) 
                                        {
                                            document.getElementById("fav_btn"+prod_id).style.color = "red";
                                        }

                                        if (BS_fav_btn) 
                                        {
                                            document.getElementById("fav_btn_"+prod_id).style.color = "red";
                                        }
                                    }
                                    else
                                    {
                                        if (FP_fav_btn) 
                                        {
                                            document.getElementById("fav_btn"+prod_id).style.color = "#8898aa";
                                        }

                                        if (BS_fav_btn) 
                                        {
                                            document.getElementById("fav_btn_"+prod_id).style.color = "#8898aa";
                                        }
                                    }
                                }



        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('Exception:' + errorThrown);
        }
    });



    }



</script>

@endsection