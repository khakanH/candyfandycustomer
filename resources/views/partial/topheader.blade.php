  <!-- ============================================================== -->
        <!-- 1st Topbar header -->
        <!-- ============================================================== -->
        
        <style type="text/css">
                    .sticky {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1001;
          }
        </style>


        <header class="most-topbar">
            <span class="mtb-left"><a class="text-white" href="tel:000 0123 1234">000 0123 1234</a></span>
            <span class="mtb-right text-white">
                <i class="fas fa-user"></i> 
                &nbsp;
                 @if(session('login'))
                    <a class="text-white" href="">{{ucfirst(session('login.customer_name'))}}</a> &nbsp;&nbsp;|&nbsp;&nbsp; <a class="text-white" href="{{route('logout')}}">Logout</a>
                 @else
                    <a class="text-white" href="{{route('login-form')}}"> Log In </a>/
                    <a class="text-white" href="{{route('signup-form')}}"> Sign Up</a>
                 @endif
            </span>
        </header>       

        <!-- ============================================================== -->
        <!-- End 1st Topbar header -->
        <!-- ============================================================== -->

          <!-- ============================================================== -->
        <!-- 2nd Topbar header -->
        <!-- ============================================================== -->
        <header class="topbar" id="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                   


                <div class="topbar-logo">
                   <a href="{{route('home')}}"><img id="topbar-logo-img2x" src="{{config('app.img_url')}}logos/logo-white 2x.png" height="80" alt="Candy-Fandy"></a>
                   <a href="{{route('home')}}"><img id="topbar-logo-img" src="{{config('app.img_url')}}logos/logo-white.png" height="40" alt="Candy-Fandy"></a>
                </div>
                
                 <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i class="ti-more" style="color: black;"></i></a>

                <div class="navbar-collapse collapse" id="navbarSupportedContent" style="border-left: solid lightgray 2.5px;">
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                     <ul class="navbar-nav float-left mr-auto">
                       <li><a class="nav-link {{Request::is('/')?'active':''}}" href="{{route('home')}}">Home</a></li>
                       <li><a class="nav-link {{Request::is('product_list')?'active':''}}"  href="{{route('product_list')}}">Products</a></li>
                       <li><a class="nav-link  {{Request::is('contact-us')?'active':''}}" href="{{route('contact-us')}}">Contact Us</a></li>
                       <li><a class="nav-link {{Request::is('about-us')?'active':''}}" href="{{route('about-us')}}">About Us</a></li>
                    </ul>
                    <!-- ============================================================== -->
                    <!-- Right side toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav float-right">
                        <!-- ============================================================== -->
                        <!-- Search -->
                        <!-- ============================================================== -->
                        <li class="nav-item d-flex header-search">
                                
                                <input type="text" id="product_search_text" class="form-control" placeholder="Search" style="padding-right: 50px;" value="{{isset($search)?(empty($search)?'':$search):''}}">
                                <i class="fa fa-search" onclick="GetProductBySearch()" style="cursor: pointer; font-size: 24px; color: lightgray; margin: 5px 1px 1px 205px; position: absolute;"></i>
                        </li>
                        <!-- ============================================================== -->
                        <!-- User profile and search -->
                        <!-- ============================================================== -->
                        <!-- <li class="nav-item">
                           <div class="columns columns-right btn-group float-right" style="width: 100%;">
                                        <button  class="btn waves-effect waves-light btn-rounded btn-cf-default"><i class="fas fa-shopping-cart"></i></button>
                                       <button class="btn btn-rounded btn-light" style="padding: 1px 15px;"><span id="cart_total_items">{{empty(session('cart_total_item'))?0:session('cart_total_item')}}</span> Items</button>
                                       

                            </div>

                        </li> -->

                        <li class="nav-item dropdown">
                            <div class="columns columns-right btn-group float-right" style="width: 100%;" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <button  class="btn waves-effect waves-light btn-rounded btn-cf-default"><i class="fas fa-shopping-cart"></i></button>
                               <button class="btn btn-rounded btn-light" style="padding: 1px 15px;"><span id="cart_total_items">{{empty(session('cart_total_item'))?0:session('cart_total_item')}}</span> Items</button>
                            </div>
                            <div class="dropdown-menu dropdown-menu-right user-dd animated flipInY  mt-2">
                                <a class="dropdown-item" href="javascript:void(0)">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <img class="card-img-top "
                                            src="../candyfandy theme/assets/images/product/p1.jpg" alt="Card image cap">
                                        </div>
                                        <div class="col-md-8 popover-right">
                                            <div class="amount-qty mb-1"> 
                                                <ul>
                                                    <li class="popover-card-text">Candy </li>
                                                </ul>
                                            </div>
                                            <div class="amount-qty mb-1"> 
                                                <ul>
                                                    <li class="popover-card-text">Lorem ipsum odot dollar... </li>
                                                </ul>
                                            </div>
                                            <div class="amount-qty mb-1"> 
                                                <ul>
                                                    <li class="popover-card-text">Qty: 2 </li>
                                                    <b> <li class="popover-card-text" style="float: right; color: #3DC4B4;;">199 PKR </li></b>
                                                    <div class="clear-both"></div>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </a> 
                                <a class="dropdown-item" href="javascript:void(0)">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <img class="card-img-top "
                                            src="../candyfandy theme/assets/images/product/p1.jpg" alt="Card image cap">
                                        </div>
                                        <div class="col-md-8 popover-right">
                                            <div class="amount-qty mb-1"> 
                                                <ul>
                                                    <li class="popover-card-text">Candy </li>
                                                </ul>
                                            </div>
                                            <div class="amount-qty mb-1"> 
                                                <ul>
                                                    <li class="popover-card-text">Lorem ipsum odot dollar... </li>
                                                </ul>
                                            </div>
                                            <div class="amount-qty mb-1"> 
                                                <ul>
                                                    <li class="popover-card-text">Qty: 2 </li>
                                                    <b> <li class="popover-card-text" style="float: right; color: #3DC4B4;;">199 PKR </li></b>
                                                    <div class="clear-both"></div>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a class="dropdown-item" href="javascript:void(0)">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <img class="card-img-top "
                                            src="../candyfandy theme/assets/images/product/p1.jpg" alt="Card image cap">
                                        </div>
                                        <div class="col-md-8 popover-right">
                                            <div class="amount-qty mb-1"> 
                                                <ul>
                                                    <li class="popover-card-text">Candy </li>
                                                </ul>
                                            </div>
                                            <div class="amount-qty mb-1"> 
                                                <ul>
                                                    <li class="popover-card-text">Lorem ipsum odot dollar... </li>
                                                </ul>
                                            </div>
                                            <div class="amount-qty mb-1"> 
                                                <ul>
                                                    <li class="popover-card-text">Qty: 2 </li>
                                                    <b> <li class="popover-card-text" style="float: right; color: #3DC4B4;;">199 PKR </li></b>
                                                    <div class="clear-both"></div>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <div class="row popover-btns">
                                    <ul>
                                        <li> 
                                            <button class="log-reg-btn cart-bottom-btns">Checkout</button> 
                                            <a href="#" class="popover-link">View Cart</a> 
                                            <Span style="margin-left: 31px;"> Total: &nbsp; <span style="color: #3DC4B4; " >699 PKR</span></span>
                                            <div class="clear-both"></div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <!-- ============================================================== -->
                        <!-- User profile and search -->
                        <!-- ============================================================== -->
                    </ul>
                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End 2nd Topbar header -->
        <!-- ============================================================== -->
      
      <script type="text/javascript">

        window.onscroll = function() {myFunction()};

          var header = document.getElementById("topbar");
          var sticky = header.offsetTop;

          function myFunction() {
            if (window.pageYOffset > sticky) {
              header.classList.add("sticky");
            } else {
              header.classList.remove("sticky");
            }
          }
        function GetProductBySearch() 
        {
          var id  = "<?php echo isset($selected_cate_id)?$selected_cate_id:0 ?>";


          var text = document.getElementById("product_search_text").value.trim();
          
          if (!text) 
          {
              text = "0";
          }
          
         window.location.href = "{{ config('app.url')}}product-by-filter/"+id+"/"+text;

        }
      </script>