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
      .cart-content{
            background: url('public/assets/images/cart/cart-zigzag.png') no-repeat center center;
            border: none;
            /* height: 100vh; */
            -moz-background-size: cover;
            -webkit-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
            min-height: 600px;
        }
         .arrow > .error{
            color: red !important;
            margin: 7px;
        }
 </style>
 <section class="page-container">
                <div class="page-content container">
                    <br><br>
                    <section class="checkout-content">
                        <div class="row">
                           
                            <div class="col-md-7  checkout-form mb-5">
                                 <center>
                                    @if(session('success'))
                                                <p class="text-success pulse animated">{{ session('success') }}</p>
                                                {{ session()->forget('success') }}
                                                @elseif(session('failed'))
                                                <p class="text-danger pulse animated">{{ session('failed') }}</p>
                                                {{ session()->forget('failed') }}
                                    @endif
                                    </center>
                                 <form action="{{route('place-order')}}" method="post" name="checkoutForm" class="mt-1"> 
                                        @csrf
                                        <span class='arrow'>
                                        <label class='error'></label>
                                        </span>
                                        <br>
                                <h4 >1. Shipping Details</h4>
                                <div class="form-content">
                                    
                                        <div class="row">
                                            <label for="name" class="mt-2">Full Name*</label>
                                            <input type="text" class="form-control  mb-2" name="name" value="{{$customer_info->name}}">
                                        </div>
    
                                        <div class="row">
                                            <label for="adress" class="mt-2">Address*</label>
                                            <textarea class="form-control mb-2" name="address" rows="4">{{$customer_info->address}}</textarea>
                                        </div>
    
                                        
                                        <div class="row">
                                            <label for="c-number" class="mt-2">Contact Number*</label>
                                            <input type="number" class="form-control  mb-2" name="phone" value="{{$customer_info->phone}}" >
                                        </div>
                                </div>
                                <div class="payment">
                                    <h4 class="mt-5">2. Payment Method*</h4>

                                    @foreach($payment_method as $key)
                                    <input class="radioinput" type="radio" <?php if ($loop->first): ?>
                                        checked
                                    <?php endif ?> id="pay{{$key['id']}}" name="payment" value="{{$key['id']}}">
                                    <label for="pay{{$key['id']}}">&nbsp;{{$key['name']}}</label><br>
                                    @endforeach
                                   <div class="mt-4 p-0">
                                    <button class="log-reg-btn">Place Order</button>
                                   </div>
                                </div>
                        </form>
                            </div>

                            <div class="col-md-5 order-row">
                              <div class="order-content">
                                <div class="order-heading pt-4 pb-2">
                                    <h5>Order Summary</h5>
                                </div>
                                <div class="order-summary">
                                    <div class="amount-qty order-history-content mb-1"> 
                                        <div class="mb-2">
                                            <ul>
                                                <li>Total: </li>
                                                <li style="float: right;">{{$cart_info->total_price}} PKR</li>
                                            </ul>
                                        </div>
                                        <div class="mb-2">
                                            <ul>
                                                <li>Shipping: </li>
                                                <li style="float: right;">{{$shipping_discount->shipping_fee}} PKR</li>
                                            </ul>
                                        </div>
                                        <div class="mb-3">
                                            <ul>
                                                <li>Discount: </li>
                                                <li style="float: right;">{{$shipping_discount->discount}} %</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="amount-qty sub-total mt-3">
                                        <ul>
                                            <li>Sub Total: </li>
                                            <li style="float: right; color: #231f20;"><b>{{ number_format($cart_info->all_total,1)}} PKR</b></li>
                                        </ul>
                                        <div class="mt-4 view-cart-link">
                                            <a href="{{route('cart')}}"> View Cart</a>
                                        </div>
                                    </div>
                                </div>
                              </div>
                            </div>
                        </div>
                    </section>
                </div>
            </section> 



<script type="text/javascript">
        $(function() {
        $("form[name='checkoutForm']").validate({
             errorPlacement: function(label, element) {
        label.addClass('arrow');
        label.insertBefore(element);
    },
    wrapper: 'span',

    rules: {
    
      name: {
        required: true,
      },
      address: {
        required: true,
      },
      phone: {
        required: true,
      },
     payment:{
        required:true,
     },
    },
    messages: {
     
      name: {
        required: "Please fill this field",
      },
      address: {
        required: "Please fill this field",
      },
      phone: {
        required: "Please fill this field",
      },
      
    },
    submitHandler: function(form) {

        form.submit();
    }
  });
  });



</script>
@endsection