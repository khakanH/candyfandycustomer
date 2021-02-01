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
    <br>
    <br>
                <div class="page-content container">
                    <div class="thankyou-content pt-5 pb-5">
                        <div class="row thankyou-row">
                            <div class="col-md-8">
                               <div class="thankyou-heading ">
                                    <h2>Thankyou For Shopping with Us!</h2>
                                    <p>Your order will be delivered in 3-4 working days.</p>
                                    <b><a href="{{route('home')}}" class="back-link ">Back To Home Page</a></b>
                               </div> 
                            </div>
                            <div class="col-md-4 thankyou-img">
                                <img src="{{config('app.img_url')}}thankyou/thanku.png" style="float: right;" alt="">
                            </div>
                        </div>
                    </div>
                </div>
    <br>
    <br>
    <br>
    <br>
    <br>

</section>  
@endsection