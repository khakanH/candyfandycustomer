@extends('layout.app')
@section('content')



            <figure id='backing'>
            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1280 504" preserveAspectRatio="xMinYMin meet" >
                <image style="width: 100%; height: auto;" xlink:href="{{config('app.img_url')}}big/home-img.png">
                </image>
                <a xlink:href="{{route('product_list')}}"><rect x="580" y="365" width="120" height="40" fill="#fff" opacity="0.00"/></a>
                </svg>
            </figure> 
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== --> 
            <div class="page-content container">
                <!-- product categories starts here -->
                <div class="products-container">
                    <!-- row headng starts here -->
                    <div class="row product-row">
                        <div class="col-md-3 col-sm-6  col-6 categories-heading"><h2>Product Categories </h2></div>
                        <div class="col-md-9 col-sm-6  col-6 next-prev-icons">
                            <!-- controls -->
                            <div class="controls-top">
                                <span>
                                    <a class="btn-floating" href="#product-categories-slder-btn" data-slide="prev">
                                        <i class="fas fa-chevron-left"></i>
                                    </a>
                                    <a class="btn-floating" href="#product-categories-slder-btn" data-slide="next"><i
                                        class="fas fa-chevron-right"></i>
                                    </a>
                                </span>
                                <!--/.Controls-->
                                <hr style="color: #f2f3f4; margin: 0; font-size: 3px;">
                            </div>
                        </div>
                    </div>
                    <!-- row heading ends here -->
                    <!-- ======================================================== -->

                    <!-- product cards starts here -->
                    <!--Carousel Wrapper-->
                    <div class="row card-row">
                        <div id="product-categories-slder-btn" class="carousel slide carousel-multi-item" data-ride="carousel" data-interval="10000">

    
                            <!--Slides-->
                            <div class="carousel-inner" style="overflow: initial;" role="listbox">
                                @if(count($category) == 0)

                                <center><p>No category found</p></center>
                                @else
                                    <!--First slide-->
                                    <?php $a=0; ?>
                                    @for($i = 0; $i < ceil(count($category)/4); $i++ )
                                    <div class="carousel-item <?php if ($i == 0): ?>
                                        active
                                    <?php endif ?>">
                                        
                                        <?php
                                            $cate_list = array_slice($category,$a,4);
                                        ?>
                                        @foreach($cate_list as $key)
                                        <div class="col-md-3" style="float:left;">
                                            <div class="" style="margin-right: 35px; margin-left: 35px;">
                                                <div style="cursor: pointer;" onclick='GetProductByFilter("{{$key['id']}}")'>
                                                <center><img class="rounded-circle card-img-top"
                                                src="{{config('app.img_url')}}{{$key['icon']}}" style="width: 110px; height: 110px;" alt="Card image cap"></center>
                                                <div class="text-center mt-2">
                                                    <p class="card-text">{{$key['name']}}</p>
                                                </div>
                                                </div>
                                            

                                            </div>
                                        </div>

                                        @endforeach

                                        @if(count($cate_list) < 4)
                                        @foreach($cate_list as $div)
                                            <div class="col-md-3" style="float:left; margin-right: 35px; margin-left: 35px;">
                                            <div class="container" style="">
                                                <center><img  class="rounded-circle card-img-top"
                                                src="" style="width: 110px; height: 110px; visibility: hidden;" alt="Card image cap"></center>
                                                <div class="text-center">
                                                    <p class="card-text"></p>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach

                                        @endif


                                        <?php $a=$a+4; ?>
                                        
                                       
                                    </div>
                                    @endfor
                                    <!--/.First slide-->
                                @endif
                            </div>
                            <!--/.Slides-->
                        
                        </div>
                        <!--/.Carousel Wrapper-->   
                    </div>
                    <!-- product cards ends here -->
                </div>
                <!-- product categories ends here -->

                <!-- Feature product starts here -->
                <div class="products-container">
                    <!-- row headng starts here -->
                    <div class="row product-row">
                        <div class="col-md-3 col-sm-6  col-6 categories-heading"><h2>Featured Products </h2></div>
                        <div class="col-md-9 col-sm-6  col-6 next-prev-icons">
                            <!-- controls -->
                            <div class="controls-top">
                                <span>
                                    <a class="btn-floating" href="#feature-product-slder-btn" data-slide="prev">
                                        <i class="fas fa-chevron-left"></i>
                                    </a>
                                    <a class="btn-floating" href="#feature-product-slder-btn" data-slide="next"><i
                                        class="fas fa-chevron-right"></i>
                                    </a>
                                </span>
                                <!--/.Controls-->
                                <hr style="color: #f2f3f4; margin: 0; font-size: 3px;">
                            </div>
                        </div>
                    </div>
                    <!-- row heading ends here -->
                    <!-- ======================================================== -->

                    <!-- product cards starts here -->
                    <!--Carousel Wrapper-->
                    <div class="row card-row">
                        <div id="feature-product-slder-btn" class="carousel slide carousel-multi-item" data-ride="carousel">

                        <!--Slides-->
                            <div class="carousel-inner" style="overflow: initial;" role="listbox">
                                @if(count($featured_product) == 0)

                                <center><p>No featured product found</p></center>
                                @else
                                    <!--First slide-->
                                    <?php $a=0; ?>
                                    @for($i = 0; $i < ceil(count($featured_product)/4); $i++ )
                                    <div class="carousel-item <?php if ($i == 0): ?>
                                        active
                                    <?php endif ?>">
                                        
                                        <?php
                                            $featured_product_list = array_slice($featured_product,$a,4);
                                        ?>
                                        @foreach($featured_product_list as $key)
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
                                                    <a href="javascript:void(0)"><i class="fas fa-heart"></i></a>
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                        @endforeach


                                        @if(count($featured_product_list) < 4)
                                        @for($i=0; $i< (4-count($featured_product_list)); $i++)
                                            <div class="col-md-3" style="float:left">
                                                <div class="card" style="padding-left: 16px;padding-right: 16px; box-shadow: none;">
                                                    <img class="card-img-top"
                                                    src=""  alt="Card image cap" style="width: 208px; visibility: hidden;">
                                                  
                                                </div>
                                            </div>
                                        @endfor

                                        @endif


                                        <?php $a=$a+4; ?>
                                        
                                       
                                    </div>
                                    @endfor
                                    <!--/.First slide-->
                                @endif
                            </div>
                        <!--/.Slides-->
                        
                        </div>
                        <!--/.Carousel Wrapper-->   
                    </div>
                    <!-- product cards ends here -->
                </div>
                <!-- Feature product ends here -->

                <!-- Best Seller starts here -->
                <div class="products-container">
                    <!-- row headng starts here -->
                    <div class="row product-row">
                        <div class="col-md-3 col-sm-6  col-6 categories-heading"><h2>Best Seller </h2></div>
                        <div class="col-md-9 col-sm-6  col-6 next-prev-icons">
                            <!-- controls -->
                            <div class="controls-top">
                                <span>
                                    <a class="btn-floating" href="#best-seller-slider-btn" data-slide="prev">
                                        <i class="fas fa-chevron-left"></i>
                                    </a>
                                    <a class="btn-floating" href="#best-seller-slider-btn" data-slide="next"><i
                                        class="fas fa-chevron-right"></i>
                                    </a>
                                </span>
                                <!--/.Controls-->
                                <hr style="color: #f2f3f4; margin: 0; font-size: 3px;">
                            </div>
                        </div>
                    </div>
                    <!-- row heading ends here -->
                    <!-- ======================================================== -->

                    <!-- product cards starts here -->
                    <!--Carousel Wrapper-->
                    <div class="row card-row">
                        <div id="best-seller-slider-btn" class="carousel slide carousel-multi-item" data-ride="carousel">

                           
                            <!--Slides-->
                            <div class="carousel-inner" style="overflow: initial;" role="listbox">
                                @if(count($best_selling_products) == 0)

                                <center><p>No best selling product found</p></center>
                                @else
                                    <!--First slide-->
                                    <?php $a=0; ?>
                                    @for($i = 0; $i < ceil(count($best_selling_products)/4); $i++ )
                                    <div class="carousel-item <?php if ($i == 0): ?>
                                        active
                                    <?php endif ?>">
                                        
                                        <?php
                                            $best_selling_products_list = array_slice($best_selling_products,$a,4);
                                        ?>
                                        @foreach($best_selling_products_list as $key)
                                       <div class="col-md-3" style="float:left">
                                        <div class="card mb-2">
                                            <center><img style="cursor: pointer;" onclick='GetProductDetails("{{$key['id']}}")'  class="card-img-top"
                                            src="{{config('app.img_url')}}{{$key['image']}}" alt="Card image cap"></center>
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
                                                    
                                                    width: 60px; background: #e6e7e9; border: solid darkgray 1px; padding: 4px; height: 100%;">
                                                    <a href="javascript:void(0)"><i class="fas fa-heart"></i></a>
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                        @endforeach


                                        @if(count($best_selling_products_list) < 4)
                                        @for($i=0; $i< (4-count($best_selling_products_list)); $i++)
                                            <div class="col-md-3" style="float:left">
                                                <div class="card" style="padding-left: 16px;padding-right: 16px; box-shadow: none;">
                                                    <img class="card-img-top"
                                                    src=""  alt="Card image cap" style="width: 208px; visibility: hidden;">
                                                  
                                                </div>
                                            </div>
                                        @endfor

                                        @endif


                                        <?php $a=$a+4; ?>
                                        
                                       
                                    </div>
                                    @endfor
                                    <!--/.First slide-->
                                @endif
                            </div>
                        <!--/.Slides-->

                        
                        </div>
                        <!--/.Carousel Wrapper-->   
                    </div>
                    <!-- product cards ends here -->
                </div>
                <!-- Best seller ends here -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
           


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
