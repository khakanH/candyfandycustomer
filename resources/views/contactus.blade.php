@extends('layout.app')
@section('content')
 <style type="text/css">
        .page-container { 
            background: url('public/assets/images/background/contactus.png') no-repeat center center ;
            /* height: 100vh; */
            -moz-background-size: cover;
            -webkit-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
        } 
    </style>
  <section class="page-container">
                <div class="page-content container">
                    <div class="row-wrapper">
                        <div class="row">
                            <div class="col-md-8">
                               <div class="form-heading">
                                    <h1>Leave us a Message</h1>
                               </div>
                                <form action="">
                                    <div class="field-wrapper">
                                        <form action="">
                                            <input type="text" class="form-control mb-2" placeholder="Name" required >
                                            <input type="email" class="form-control  mb-2" placeholder="Email" required >
                                            <textarea id="subject" class="form-control" name="subject" placeholder="Enter Message" required ></textarea>
                                        </form>
                                    </div>
                                    <button class="send-btn mt-2">Send</button>   
                                </form>
                                <!-- <input type="text" class="form-control" placeholder="Name" required style="padding:25px 50px 25px 20px; "> -->
                            </div>
                            <div class="col-md-4">
                                <div class="form-heading">
                                    <h1>Find Us</h1>
                               </div>
                               <div class="contact-detail">
                                    <ul>
                                        <li class="mb-2"><i class="far fa-envelope"></i><span>
                                            <a href="mailto:{{$gs_info['gs_email']}}">{{$gs_info['gs_email']}}</a></span></li>
                                        <li class="mb-2"><i class="fa fa-phone"></i></i><span >
                                            <a href="tel:{{$gs_info['gs_phone']}}">{{$gs_info['gs_phone']}}</a></li>
                                        <li class="mb-2"><i class="fas fa-globe"></i><span>
                                            <a href="http://{{$gs_info['gs_website']}}" target="_blank">{{$gs_info['gs_website']}}</a></span></li>
                                        <li><i class="fas fa-map-marker-alt"></i><span ><a href="#">{{$gs_info['gs_location']}}</a></span></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>  


@endsection