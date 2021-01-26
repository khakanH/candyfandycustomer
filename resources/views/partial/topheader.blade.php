  <!-- ============================================================== -->
        <!-- 1st Topbar header -->
        <!-- ============================================================== -->
        
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
        <header class="topbar">
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
                       <li><a class="nav-link {{Request::is('product')?'active':''}}"  href="{{route('product')}}">Products</a></li>
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
                                
                                <input type="text" class="form-control" placeholder="Search" style="padding-right: 50px;">
                                <i class="fa fa-search" style=" font-size: 24px; color: lightgray; margin: 5px 1px 1px 205px; position: absolute;"></i>
                        </li>
                        <!-- ============================================================== -->
                        <!-- User profile and search -->
                        <!-- ============================================================== -->
                        <li class="nav-item">
                           <div class="columns columns-right btn-group float-right" style="width: 100%;">
                                        <button  class="btn waves-effect waves-light btn-rounded btn-cf-default"><i class="fas fa-shopping-cart"></i></button>
                                       <button class="btn btn-rounded btn-light" style="padding: 1px 15px;"><span id="cart_total_items">{{empty(session('cart_total_item'))?0:session('cart_total_item')}}</span> Items</button>
                                       

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
      