@extends('layout.app')
@section('content')
<br>
<br>
<section class="page-container">
                <div class="page-content container">
                    <div class="row-wrapper">
                       
                         <!-- two product details starts here -->
                        <div class="row">
                            <!-- left section starts here -->
                            <div class="col-md-4 product-left-bar">
                                <img class="card-img-top img-fluid"
                                            src="{{config('app.img_url')}}{{$product->image}}" alt="Card image cap">
                            </div>
                            <!-- right section starts here -->
                            <div class="col-md-8 ">
                              <div class="product-detail-right ">
                                  <ul class="pb-3 product-details-ul product-details-list">
                                      <li>
                                          <h2 class="m-0">{{$product->name}}</h2>
                                      </li>
                                        <br>
                                        <a href="javascript:void(0)" onclick='MarkItemFavorite("{{$product->id}}")' style=" 
                                                        <?php if (!empty($product->favorite_id)): ?>
                                                            color: red;
                                                        <?php endif; ?>"
                                                     id="fav_btn{{$product->id}}"> <span class="fa fa-heart"></span>
                                        <span id="fav_text"  style="color: #3dc4b4; text-align: left;">&nbsp; 
                                        <?php if (empty($product->favorite_id)): ?>
                                        Add to my Favorites
                                        <?php else: ?>
                                        Remove from my Favorites
                                        <?php endif; ?>

                                        </span></a>
                                     </li>
                                  </ul>

                                  <ul class="pb-3 pt-3 product-details-list ">
                                    <li class="pt-2 product-detail-price">
                                        <span >Price:&nbsp;</span>
                                        <span >{{$product->sale_price}}/- PKR</span>
                                    </li> 
                                    <li class="pt-2 product-detail-price">
                                       
                                        <span id="item_qty_span" style="<?php if ($product->cart_count == 0): ?>
                                            visibility: hidden;
                                        <?php endif ?> ">QTY:&nbsp; &nbsp;
                                        <input onchange='ChangeCartItemQty(this.value,"{{$product->id}}")' type="number" min="1" step="1" name="qty" id="cart_item_qty" value="{{$product->cart_count}}">
                                        </span>

                                            <button class="log-reg-btn" onclick='AddtoCart("{{$product->id}}")' style="float: right; padding: 3px 18px;
                                            float: right;font-size: 15px;"> <i class="fa fa-shopping-cart"></i> Add to Cart</button>
                                       
                                    </li>
                                </ul>
                                <ul class="pb-3 pt-3 ">
                                    <li class="pt-2 product-detail-price">
                                        <h4>Description:</h4>
                                        <p>{{$product->description}}
                                        </p>
                                    </li>
                                </ul>
                              </div>
                            </div>
                            <!-- product details  ends here -->
                         <!-- ========================================================================= -->
                          
                    </div>
                </div>
            </section>
<script type="text/javascript">
  function AddtoCart(prod_id)
    {
        
        $.ajax({
        type: "GET",
        cache: false,
        url: "{{ config('app.url')}}add-to-cart/"+prod_id,
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
                                    document.getElementById("item_qty_span").style.visibility = "visible";
                                    
                                    document.getElementById("cart_item_qty").value = data['data']['product_count'];
                                    
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
                                  
                                         document.getElementById("cart_item_qty").value = data['product_count'];
                                  
                                }



        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('Exception:' + errorThrown);
        }
    });
    }


     function MarkItemFavorite(prod_id)
    {
        var customer_id = "<?php echo session("login.customer_id") ?>";

        if (!customer_id) 
        {
            alert('Kindly Login First to Mark Item Favorite.');
            return
        }

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
                                            document.getElementById("fav_btn"+prod_id).style.color = "red";
                                            document.getElementById("fav_text").innerHTML = "&nbsp; Remove from my Favorites";
                                    }
                                    else
                                    {
                                            document.getElementById("fav_btn"+prod_id).style.color = "#8898aa";
                                            document.getElementById("fav_text").innerHTML = "&nbsp; Add to my Favorites";

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