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
                                        <a href="#"> <span class="fa fa-heart"></span>
                                        <span  style="color: #3dc4b4; text-align: left;">&nbsp; Add to my Favorites</span></a>
                                     </li>
                                  </ul>

                                  <ul class="pb-3 pt-3 product-details-list ">
                                    <li class="pt-2 product-detail-price">
                                        <span >Price:&nbsp;</span>
                                        <span >{{$product->sale_price}}/- PKR</span>
                                    </li> 
                                    <li class="pt-2 product-detail-price">
                                        <span >QTY:&nbsp; &nbsp;</span>
                                        <span ><input onchange='ChangeCartItemQty(this.value,"{{$product->id}}")' type="number" min="1" step="1" name="qty" id="cart_item_qty" value="{{$product->cart_count}}">
                                            <button class="log-reg-btn" onclick='AddtoCart("{{$product->id}}")' style="float: right; padding: 3px 18px;
                                            float: right;font-size: 15px;"> <i class="fa fa-shopping-cart"></i> Add to Cart</button>
                                        </span>
                                       
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
</script>
@endsection