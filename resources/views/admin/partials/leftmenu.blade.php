<aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <br>
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark" href="{{route('dashboard')}}" aria-expanded="false">
                                <i class="mdi mdi-av-timer"></i>
                                <span class="hide-menu">Dashboard</span> 
                            </a>
                        </li>

                       <?php

                            $menus = (new App\Helpers\MenuHelper)->getMenu();
                        ?>


                        <div class="devider"></div>
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{route('signout')}}" aria-expanded="false">
                                <i class="mdi mdi-adjust text-danger"></i>
                                <span class="hide-menu">Logout</span>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
