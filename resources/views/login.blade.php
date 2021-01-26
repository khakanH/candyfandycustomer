@extends('layout.app')
@section('content')
<style type="text/css">
         .page-container { 
            background: url('public/assets/images/background/login.jpg') no-repeat center center ;
            /* height: 100vh; */
            -moz-background-size: cover;
            -webkit-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
        } 
         .arrow > .error{
            color: red !important;
        }
 </style>
  
            <section class="page-container">
                <div class="page-content container">
                    <div class="row-wrapper">
                        <div class="row">
                            <div class="col-md-8 col-sm-12 col-md-ofset-4">
                                <div class="form-wrapper">
                                    <center>
                                    @if(session('success'))
                                                <p class="text-success pulse animated">{{ session('success') }}</p>
                                                {{ session()->forget('success') }}
                                                @elseif(session('failed'))
                                                <p class="text-danger pulse animated">{{ session('failed') }}</p>
                                                {{ session()->forget('failed') }}
                                    @endif
                                    </center>
                                   <h3>Login</h3>
                                    <form action="{{route('login')}}" method="post" name="loginForm" class="mt-4"> 
                                    @csrf
                                    <span class='arrow'>
                                    <label class='error'></label>
                                    </span>
                                    <br>
                                       <label for="emailadress" class="mt-3">Email Address*</label>
                                        <input type="email" name="email" id="email" class="form-control  mb-2" required value="{{old('email')}}">

                                        <label for="password" class="mt-3">Password*</label>
                                        <input type="password" name="password" id="password" class="form-control mb-2"  required value="{{old('password')}}">
                                        <div class="mt-3 link-btn-wrapper ">
                                            <button type="submit" class="log-reg-btn">Login</button> <a href="#">Forgot your password?</a>
                                        </div>

                                        <div class="bottom-link-btn-wrapper">
                                           <p>Don't have an account?</p>
                                           <a href="{{route('signup-form')}}"><button type="button" class="log-reg-btn">Register</button></a>
                                        </div>
                                   </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section> 

<script type="text/javascript">
      $.validator.addMethod('emailFormat', function(value, element) {
        return this.optional(element) || (value.match(/^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$/));
    },
    'Please enter a valid email address');
        $(function() {
        $("form[name='loginForm']").validate({
             errorPlacement: function(label, element) {
        label.addClass('arrow');
        label.insertBefore(element);
    },
    wrapper: 'span',

    rules: {
    
      email: {
        required: true,
        emailFormat: true,
      },
      password: {
        required: true,
      },
     
    },
    messages: {
     
      email: {
        required: "Please fill this field",
      },
      password: {
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