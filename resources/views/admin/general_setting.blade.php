@extends('admin.layouts.app')
@section('content')



<div class="page-wrapper">
<div class="page-content container-fluid">
    <center>
    @if(session('success'))
    <p class="text-success pulse animated">{{ session('success') }}</p>
    {{ session()->forget('success') }}
    @elseif(session('failed'))
    <p class="text-danger pulse animated">{{ session('failed') }}</p>
    {{ session()->forget('failed') }}
    @endif
    </center>

    <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">General Settings
                                   
                                </h4>
                                <br>

                                    <h5><b>Contact Info</b></h5>
                                    <hr style="color: #f2f3f4; margin: 0;">
                                    <form method="post" action="{{route('save-general-setting')}}">
                                        @csrf
                                        <span class='arrow'>
                                        <label class='error'></label>
                                        </span>

                                        <div class="row">
                                          <div class="col-lg-6"> 
                                            <label>Contact Number:</label>
                                            <input type="number" id="phone" name="phone" class="form-control" value="{{$setting->phone}}" required></div>
                                          <div class="col-lg-6"> 
                                            <label>Email Address:</label>
                                           <input type="email" id="email" name="email" class="form-control" value="{{$setting->email}}" required>
                                          </div>
                                        </div>
                                        <br>

                                        <div class="row">
                                          <div class="col-lg-6"> 
                                            <label>Website:</label>
                                            <input type="text" id="website" name="website" class="form-control" value="{{$setting->website}}" required></div>
                                          <div class="col-lg-6"> 
                                            <label>Location:</label>
                                           <input type="text" id="location" name="location" class="form-control" value="{{$setting->location}}" required>
                                          </div>
                                        </div>
                                        <br>

                                        
                                    
                                    
                                    <h5><b>Order Discount/Shipping Fee</b></h5>
                                    <hr style="color: #f2f3f4; margin: 0;">
                                    <br>
                                        <div class="row">
                                          <div class="col-lg-6"> 
                                            <label>Shipping Fee:</label>
                                            <input type="number" id="shipping" name="shipping" class="form-control" value="{{$setting->shipping_fee}}" required></div>
                                          <div class="col-lg-6"> 
                                            <label>Discount:</label>
                                           <input type="number" id="discount" min="0" max="100" name="discount" class="form-control" value="{{$setting->discount}}" required>
                                          </div>
                                        </div>
                                        <br>

                                        <div class="row">
                                            <div class="col-lg-10"></div>
                                            <div class="col-lg-2"><button style="width: 100%;" type="submit" class="btn btn-info">Save</button></div>
                                        </div>
                                    </form>


                               




                                
                            </div>
                        </div>

                
</div>
</div>


@endsection
