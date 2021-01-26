@extends('layout.app')
@section('content')


            
            <section class="page-container">
                <div class="page-content container">
                    <div class="row-wrapper">
                        <div class="row">
                            <div class="col-md-12 search-bar">
                                <input type="text" class="form-control" placeholder="Search" >
                                <a href="#"><i class="fa fa-search" ></i></a>
                            </div>
                        </div>
                        
                         <!--category grids starts here  -->
                        <div class="row  categories-wrapper  mt-5 mb-5">
                            <div class="col">
                              <div class="category-text mt-2" >Category 1</div>
                            </div>
                             <div class="col">
                               <div class="category-text mt-2">Category 2</div>
                             </div>
                            <div class="col">
                              <div class="category-text mt-2">Category 3</div>
                            </div>
                             <div class="col">
                               <div class="category-text mt-2">Category 4</div>
                             </div>
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
                                      <div id="featured-product-slder-btn"  class="carousel slide carousel-multi-item" data-ride="carousel">
                
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
                                                      <div class="col-md-6">
                                                        <center><img class="card-img-top"
                                                      src="{{config('app.img_url')}}{{$key['image']}}" alt="Card image cap" ></center>
                                                      </div>
                                                       <div class="col-md-6 product-page-slider">
                                                        <div class="card-body">
                                                          <p class="card-text">{{$key['name']}}</p>
                                                          <h4 class="card-title"><b>{{$key['sale_price']}}/- PKR</b></h4>
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
                                        <div id="best-seller-slder-btn" class="carousel slide carousel-multi-item" data-ride="carousel">
                
                                      
                                          <!--Slides-->
                                      <div class="carousel-inner" style="overflow: initial;" role="listbox">
                                          @if(count($best_selling_products) == 0)

                                          <center><p>No fbest selling product found</p></center>
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
                                                      <div class="col-md-6">
                                                        <center><img class="card-img-top"
                                                      src="{{config('app.img_url')}}{{$key['image']}}" alt="Card image cap" ></center>
                                                      </div>
                                                       <div class="col-md-6 product-page-slider">
                                                        <div class="card-body">
                                                          <p class="card-text">{{$key['name']}}</p>
                                                          <h4 class="card-title"><b>{{$key['sale_price']}}/- PKR</b></h4>
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
                                                              
                                                              width: 60px; background: #e6e7e9; border: solid darkgray 1px; padding: 4px; height: 100%;">
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
                                 <div class="mt-4">
                                    <!-- row headng starts here -->
                                    <div class="row product-page-row product-row">
                                        <div class="col-md-12  categories-heading product-page-headings">
                                            <h2>Recently Viewed </h2>
                                        </div>
                                    </div>
                                    <!-- row heading ends here -->
                                    <!-- ======================================================== -->
                
                                    <!-- product cards starts here -->
                                    <!--Carousel Wrapper-->
                                    <div class="row">
                                        <div id="recently-viewed-slder-btn" class="carousel slide carousel-multi-item" data-ride="carousel">
                
                                        <!--Indicators-->
                                        <ol class="carousel-indicators">
                                        <!-- <li data-target="#product-categories-slder-btn" data-slide-to="0" class="active"></li>
                                        <li data-target="#product-categories-slder-btn" data-slide-to="1"></li> -->
                                        
                                        </ol>
                                        <!--/.Indicators-->
                    
                                            <!--Slides-->
                                          <div class="carousel-inner" style="overflow: initial;" role="listbox">
                                                <!--First slide-->
                                              <div class="carousel-item active">
                                                  <div class="col-md-12" style="float:left">
                                                      <div class="card mb-2">
                                                          <div class="row">
                                                          <div class="col-md-6"> <img class="card-img-top"
                                                              src="{{config('app.img_url')}}big/img4.jpg" alt="Card image cap">
                                                              </div>
                                                              <div class="col-md-6 product-page-slider">
                                                              <div class="card-body product-page-card-body text-left">
                                                                  <p class="card-text">Candy</p>
                                                                  <h4 class="card-title"><b>199PKR</b></h4>
                                                                  <span class="card-icons">
                                                                      <a href="#"><i class="fas fa-shopping-cart"></i></a>
                                                                      <a href="#"><i class="fas fa-heart"></i></a>
                                                                  </span>
                                                              </div>
                                                              </div>
                                                          </div>
                                                      </div>
                                                  </div>
                                                  <div class="col-md-12" style="float:left">
                                                      <div class="card mb-2">
                                                         <div class="row">
                                                            <div class="col-md-6"> <img class="card-img-top"
                                                                src="{{config('app.img_url')}}big/img4.jpg" alt="Card image cap">
                                                              </div>
                                                              <div class="col-md-6 product-page-slider">
                                                                <div class="card-body product-page-card-body text-left">
                                                                    <p class="card-text">Candy</p>
                                                                    <h4 class="card-title"><b>199PKR</b></h4>
                                                                    <span class="card-icons">
                                                                        <a href="#"><i class="fas fa-shopping-cart"></i></a>
                                                                        <a href="#"><i class="fas fa-heart"></i></a>
                                                                    </span>
                                                                </div>
                                                              </div>
                                                         </div>
                                                      </div>
                                                  </div>
                                              </div>
                                                <!--/.First slide-->
                                                <!-- .second slide starts here -->
                                              <div class="carousel-item">
                                                  <div class="col-md-12" style="float:left">
                                                      <div class="card mb-2">
                                                         <div class="row">
                                                            <div class="col-md-6"> <img class="card-img-top"
                                                                src="{{config('app.img_url')}}big/img4.jpg" alt="Card image cap">
                                                              </div>
                                                              <div class="col-md-6 product-page-slider">
                                                                <div class="card-body product-page-card-body text-left">
                                                                    <p class="card-text">Candy</p>
                                                                    <h4 class="card-title"><b>199PKR</b></h4>
                                                                    <span class="card-icons">
                                                                        <a href="#"><i class="fas fa-shopping-cart"></i></a>
                                                                        <a href="#"><i class="fas fa-heart"></i></a>
                                                                    </span>
                                                                </div>
                                                              </div>
                                                         </div>
                                                      </div>
                                                  </div>
                                                  <div class="col-md-12" style="float:left">
                                                    <div class="card mb-2">
                                                       <div class="row">
                                                          <div class="col-md-6"> <img class="card-img-top"
                                                              src="{{config('app.img_url')}}big/img4.jpg" alt="Card image cap">
                                                            </div>
                                                            <div class="col-md-6 product-page-slider">
                                                              <div class="card-body product-page-card-body text-left">
                                                                  <p class="card-text">Candy</p>
                                                                  <h4 class="card-title"><b>199PKR</b></h4>
                                                                  <span class="card-icons">
                                                                      <a href="#"><i class="fas fa-shopping-cart"></i></a>
                                                                      <a href="#"><i class="fas fa-heart"></i></a>
                                                                  </span>
                                                              </div>
                                                            </div>
                                                       </div>
                                                    </div>
                                                </div>
                                              </div>
                                          </div>
                                      </div>
                                            <!--/.Slides-->
                                        <!--/.Carousel Wrapper-->   
                                        <div class="col-md-12 next-prev-icons">
                                          <!-- controls -->
                                          <div class="controls-top">
                                              <span style="margin-right: 13px;">
                                                  <a class="btn-floating" href="#recently-viewed-slder-btn" data-slide="prev">
                                                      <i class="fas fa-chevron-left"></i>
                                                  </a>
                                                  <a class="btn-floating" href="#recently-viewed-slder-btn" data-slide="next"><i
                                                      class="fas fa-chevron-right"></i>
                                                  </a>
                                              </span>
                                          </div>
                                      </div>
                                    </div>
                                    <!-- product cards ends here -->
                                </div>
                                <!-- recently view ends here -->
                            </div>
                            <!-- left section ends here -->


                        <!-- right section starts here -->
                        <div class="col-md-9 products-list">
                            <!-- row 1 starts here -->
                            <div class="row card-row">
                                @foreach($all_product as $key)
                                <div class="col-md-3 mb-4" style="float:left">
                                    <div class="card mb-2">
                                        <img class="card-img-top"
                                        src="{{config('app.img_url')}}{{$key['image']}}" alt="Card image cap">
                                        <div class="card-body">
                                            <p class="card-text">{{$key['name']}}</p>
                                            <h4 class="card-title"><b>{{$key['sale_price']}}/- PKR</b></h4>
                                            <span class="card-icons">
                                                <a href="#"><i class="fas fa-shopping-cart"></i></a>
                                                <a href="#"><i class="fas fa-heart"></i></a>
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
    function AddtoCart(prod_id)
    {
        
        var FP_cart_btn = document.getElementById("cart_btn"+prod_id);
        var BS_cart_btn = document.getElementById("cart_btn_"+prod_id);

        var FP_cart_item_qty = document.getElementById("cart_item_qty"+prod_id);
        var BS_cart_item_qty = document.getElementById("cart_item_qty_"+prod_id);



        $.ajax({
        type: "GET",
        url: "{{ config('app.url')}}add-to-cart/"+prod_id,
        success: function(data) {
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
        url: "{{ config('app.url')}}change-cart-item-qty/"+prod_id+"/"+qty,
        success: function(data) {
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
</script>
@endsection