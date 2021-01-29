@extends('layout.app')
@section('content')

             <div class="container-fluid" style="padding: 0; margin: 0;">
            <img class="img-responsive" src="{{config('app.img_url')}}background/product2.jpg" style="width:100%" alt="fdsf">
        </div>


            <section class="page-container">
                <div class="page-content container">
                    <div class="row-wrapper">
                       <!--  <div class="row">
                            <div class="col-md-12 search-bar">
                                <input type="text" id="" class="form-control" placeholder="Search" >
                                <a href="javascript:void(0)"><i class="fa fa-search" ></i></a>
                            </div>
                        </div> -->
                        
                         <!--category grids starts here  -->
                        <div class="categories-wrapper  mb-5" id="cate_listing_div" style="display: flex;  float: none; height: 100px; white-space: nowrap; overflow-x:  scroll; overflow-y: hidden; padding-top: 10px; position: relative;">
                            @foreach($category as $key)
                            <div class="col-lg-2" id="scrollHere{{$key['id']}}" style="width: auto !important; max-width: 100% !important;">
                              <div style="width: 100%;" onclick='GetProductByFilter("{{$key['id']}}")' class="category-text mt-2 <?php if ($selected_cate_id == $key['id']): ?>
                                  cate_active
                              <?php endif ?>" >{{$key['name']}}</div>
                            </div>
                            @endforeach

                        </div> 
                         <!-- category grids ends here -->
                         <!-- ========================================================================== -->
                         <!--category two grids starts here -->
                        <div class="row">
                            <!-- left section starts here -->
                            <div class="col-md-3 product-left-bar">
                              
                                <!-- faetured product starts here -->
                                <div class="mt-4">
                                    <!-- row headng starts here -->
                                    <div class="row product-page-row product-row ">
                                        <div class="col-md-12  categories-heading product-page-headings">
                                            <h2>Featured Products </h2>
                                        </div>
                                        
                                    </div>
                                    <!-- row heading ends here -->
                                    <!-- ======================================================== -->
                
                                    <!-- product cards starts here -->
                                    <!--Carousel Wrapper-->
                                    <div class="row">
                                      <div id="featured-product-slder-btn"  class="carousel slide carousel-multi-item" data-ride="carousel" data-interval="10000">
                
                                      <!--Slides-->
                                      <div class="carousel-inner" style="overflow: initial;" role="listbox">
                                          @if(count($featured_product) == 0)

                                          <center><p>No featured product found</p></center>
                                          @else
                                              <!--First slide-->
                                              <?php $a=0; ?>
                                              @for($i = 0; $i < ceil(count($featured_product)/2); $i++ )
                                              <div class="carousel-item <?php if ($i == 0): ?>
                                                  active
                                              <?php endif ?>">
                                                  
                                                  <?php
                                                      $featured_product_list = array_slice($featured_product,$a,2);
                                                  ?>
                                                  @foreach($featured_product_list as $key)
                                                 <div class="col-md-12" style="float:left">
                                                  <div class="card mb-2">
                                                    <div class="row">
                                                      <div class="col-md-5">
                                                        <center><img style="cursor: pointer;" onclick='GetProductDetails("{{$key['id']}}")' class="card-img-top"
                                                      src="{{config('app.img_url')}}{{$key['image']}}" alt="Card image cap" ></center>
                                                      </div>
                                                       <div class="col-md-7 product-page-slider">
                                                        <div class="card-body">
                                                          <a href="{{route('product-detail',[$key['id']])}}">
                                                          <p class="card-text">{{$key['name']}}</p>
                                                          <h4 class="card-title"><b>{{$key['sale_price']}}/- PKR</b></h4>
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
                                                              
                                                              width: 50px; background: #e6e7e9; border: solid darkgray 1px; padding: 4px; height: 100%;">
                                                              <a href="javascript:void(0)"><i class="fas fa-heart"></i></a>
                                                          </span>
                                                      </div>
                                                       </div>
                                                    </div>
                                                      


                                                      
                                                      
                                                  </div>
                                              </div>

                                                  @endforeach
                                         
                                                  <?php $a=$a+2; ?>
                                                  
                                                 
                                              </div>
                                              @endfor
                                              <!--/.First slide-->
                                          @endif
                                      </div>
                                      <!--/.Slides-->
                    

                                      </div>
                                        <!--/.Carousel Wrapper-->   
                                        <div class="col-md-12 next-prev-icons">
                                          <!-- controls -->
                                          <div class="controls-top">
                                              <span style="margin-right: 13px;">
                                                  <a class="btn-floating" href="#featured-product-slder-btn" data-slide="prev">
                                                      <i class="fas fa-chevron-left"></i>
                                                  </a>
                                                  <a class="btn-floating" href="#featured-product-slder-btn" data-slide="next"><i
                                                      class="fas fa-chevron-right"></i>
                                                  </a>
                                              </span>
                                          </div>
                                      </div>
                                    </div>
                                    <!-- product cards ends here -->
                                </div>
                                <!-- featured product ends here -->
                                <!-- =============================================================== -->
                                <!-- best seller starts here -->
                                 <div class="mt-4">
                                    <!-- row headng starts here -->
                                    <div class="row product-page-row product-row ">
                                        <div class="col-md-12  categories-heading product-page-headings">
                                            <h2>Best Seller </h2>
                                        </div>
                                        
                                    </div>
                                    <!-- row heading ends here -->
                                    <!-- ======================================================== -->
                
                                    <!-- product cards starts here -->
                                    <!--Carousel Wrapper-->
                                    <div class="row">
                                        <div id="best-seller-slder-btn" class="carousel slide carousel-multi-item" data-ride="carousel" data-interval="13000">
                
                                      
                                          <!--Slides-->
                                      <div class="carousel-inner" style="overflow: initial;" role="listbox">
                                          @if(count($best_selling_products) == 0)

                                          <center><p>No best selling product found</p></center>
                                          @else
                                              <!--First slide-->
                                              <?php $a=0; ?>
                                              @for($i = 0; $i < ceil(count($best_selling_products)/2); $i++ )
                                              <div class="carousel-item <?php if ($i == 0): ?>
                                                  active
                                              <?php endif ?>">
                                                  
                                                  <?php
                                                      $best_selling_products_list = array_slice($best_selling_products,$a,2);
                                                  ?>
                                                  @foreach($best_selling_products_list as $key)
                                                 <div class="col-md-12" style="float:left">
                                                  <div class="card mb-2">
                                                    <div class="row">
                                                      <div class="col-md-5">
                                                        <center><img style="cursor: pointer;" onclick='GetProductDetails("{{$key['id']}}")' class="card-img-top"
                                                      src="{{config('app.img_url')}}{{$key['image']}}" alt="Card image cap" ></center>
                                                      </div>
                                                       <div class="col-md-7 product-page-slider">
                                                        <div class="card-body">
                                                          <a href="{{route('product-detail',[$key['id']])}}">
                                                          <p class="card-text">{{$key['name']}}</p>
                                                          <h4 class="card-title"><b>{{$key['sale_price']}}/- PKR</b></h4>
                                                        </a>
                                                          <span class="card-icons">
                                                              <a href="javascript:void(0)" onclick='AddtoCart("{{$key['id']}}")'><i id="cart_btn_{{$key['id']}}" class="fas fa-shopping-cart" style="
                                                                  <?php if ($key['cart_count'] != 0): ?>
                                                                  color: #2cabe3;
                                                                  <?php endif ?>
                                                              "></i></a>
                                                              <input onchange='ChangeCartItemQty(this.value,"{{$key['id']}}")' type="number" value="{{$key['cart_count']}}" min="1" step="1" name="cart_item_qty" id="cart_item_qty_{{$key['id']}}" style="
                                                              <?php if ($key['cart_count'] == 0): ?>
                                                               display: none; 
                                                              <?php endif ?>
                                                              
                                                              width: 50px; background: #e6e7e9; border: solid darkgray 1px; padding: 4px; height: 100%;">
                                                              <a href="javascript:void(0)"><i class="fas fa-heart"></i></a>
                                                          </span>
                                                      </div>
                                                       </div>
                                                    </div>
                                                      


                                                      
                                                      
                                                  </div>
                                              </div>

                                                  @endforeach
                                         
                                                  <?php $a=$a+2; ?>
                                                  
                                                 
                                              </div>
                                              @endfor
                                              <!--/.First slide-->
                                          @endif
                                      </div>
                                      <!--/.Slides-->
                                            
                                      </div>
                                        <!--/.Carousel Wrapper-->   
                                        <div class="col-md-12 next-prev-icons">
                                          <!-- controls -->
                                          <div class="controls-top">
                                              <span style="margin-right: 13px;">
                                                  <a class="btn-floating" href="#best-seller-slder-btn" data-slide="prev">
                                                      <i class="fas fa-chevron-left"></i>
                                                  </a>
                                                  <a class="btn-floating" href="#best-seller-slder-btn" data-slide="next"><i
                                                      class="fas fa-chevron-right"></i>
                                                  </a>
                                              </span>
                                          </div>
                                      </div>
                                    </div>
                                    <!-- product cards ends here -->
                                </div>
                                <!-- best seller ends here -->
                                <!-- ============================================================== -->
                                 <!-- recently viewe starts here -->
                              
                                <!-- recently view ends here -->
                            </div>
                            <!-- left section ends here -->


                        <!-- right section starts here -->
                        <div class="col-md-9 products-list">
                            <!-- row 1 starts here -->
                            <div class="row card-row">

                              @if(count($all_product) == 0)
                              <div class="col-lg-12"><center>No Product Found</center></div>
                              @endif

                                @foreach($all_product as $key)
                                <div class="col-md-3 mb-4" style="float:left" >
                                    <div class="card mb-2" >
                                        <img style="cursor: pointer;" onclick='GetProductDetails("{{$key['id']}}")' class="card-img-top"
                                        src="{{config('app.img_url')}}{{$key['image']}}" alt="Card image cap">
                                        <div class="card-body">
                                            <a href="{{route('product-detail',[$key["id"]])}}">
                                              
                                            <p class="card-text">{{$key['name']}}</p>
                                            <h4 class="card-title"><b>{{$key['sale_price']}}/- PKR</b></h4>
                                            </a>
                                            <hr>
                                           <span class="card-icons">
                                                              <a href="javascript:void(0)" onclick='AddtoCart("{{$key['id']}}")'><i id="cart_btn__{{$key['id']}}" class="fas fa-shopping-cart" style="
                                                                  <?php if ($key['cart_count'] != 0): ?>
                                                                  color: #2cabe3;
                                                                  <?php endif ?>
                                                              "></i></a>
                                                              <input onchange='ChangeCartItemQty(this.value,"{{$key['id']}}")' type="number" value="{{$key['cart_count']}}" min="1" step="1" name="cart_item_qty" id="cart_item_qty__{{$key['id']}}" style="
                                                              <?php if ($key['cart_count'] == 0): ?>
                                                               display: none; 
                                                              <?php endif ?>
                                                              
                                                              width: 50px; background: #e6e7e9; border: solid darkgray 1px; padding: 4px; height: 100%;">
                                                              <a href="javascript:void(0)"><i class="fas fa-heart"></i></a>
                                                          </span>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <!-- row1 ends here -->

                        <!-- right section ends here -->
                        </div>
                         <!-- category two grids ends here -->
                         <!-- ========================================================================= -->
                          
                    </div>
                </div>
            </section>  




<script type="text/javascript">

 $(window).on('load', function () {
    setTimeout(function () {
        
      var selected_cate_id = "<?php echo $selected_cate_id  ?>";


      if (selected_cate_id !=0) 
      {
        $('#cate_listing_div').animate({scrollLeft: $('#scrollHere'+selected_cate_id).position().left}, 800);
      }


    });         
});


    function AddtoCart(prod_id)
    {
        
        var FP_cart_btn = document.getElementById("cart_btn"+prod_id);
        var BS_cart_btn = document.getElementById("cart_btn_"+prod_id);
        var AP_cart_btn = document.getElementById("cart_btn__"+prod_id);

        var FP_cart_item_qty = document.getElementById("cart_item_qty"+prod_id);
        var BS_cart_item_qty = document.getElementById("cart_item_qty_"+prod_id);
        var AP_cart_item_qty = document.getElementById("cart_item_qty__"+prod_id);



        $.ajax({
        type: "GET",
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
            
            if (AP_cart_btn && AP_cart_item_qty) 
            {
                document.getElementById("cart_btn__"+prod_id).style.color = "#2cabe3";
                document.getElementById("cart_item_qty__"+prod_id).style.display = "inline-block";
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

                                    if (AP_cart_item_qty) 
                                    {
                                         document.getElementById("cart_item_qty__"+prod_id).value = data['data']['product_count'];
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
        var AP_cart_item_qty = document.getElementById("cart_item_qty__"+prod_id);
        
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
                                   if (FP_cart_item_qty) 
                                    {
                                         document.getElementById("cart_item_qty"+prod_id).value = data['product_count'];
                                    }
                                    if (BS_cart_item_qty) 
                                    {
                                         document.getElementById("cart_item_qty_"+prod_id).value = data['product_count'];
                                    }
                                    if (AP_cart_item_qty) 
                                    {
                                         document.getElementById("cart_item_qty__"+prod_id).value = data['product_count'];
                                    }
                                }



        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('Exception:' + errorThrown);
        }
    });
    }


    function GetProductByFilter(id)
    {
        var text = document.getElementById("product_search_text").value.trim();

        if (!text) 
        {
            text = "0";
        }
        
        window.location.href = "{{ config('app.url')}}product-by-filter/"+id+"/"+text;
    }
    function GetProductDetails(prod_id)
    {
       window.location.href = "{{ config('app.url')}}product-detail/"+prod_id;
    }
</script>
@endsection