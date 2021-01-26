@extends('layout.app')
@section('content')
<style type="text/css">
         .page-container { 
            background: url('public/assets/images/background/register.jpg') no-repeat center center ;
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
                                   <h3>Register Your Account</h3>
                                   <form action="{{route('signup')}}" method="post" name="signupForm" class="mt-4"> 
                                    @csrf
                                    <span class='arrow'>
                                    <label class='error'></label>
                                    </span>
                                    <br>
                                        <label for="name" class="mt-3">Name*</label>
                                        <input type="text" name="name" id="name" class="form-control  mb-2" required >

                                       <label for="emailadress" class="mt-3">Email Address*</label>
                                        <input type="email" name="email" id="email" class="form-control  mb-2" required >

                                        <label for="password" class="mt-3">Password*</label>
                                        <input type="password" name="password" id="password" class="form-control mb-2"  required >

                                        
                                        <label for="password" class="mt-3">Confirm Password*</label>
                                        <input type="password" name="confirm_password" id="confirm_password" class="form-control mb-2"  required >
                                        <div class="mt-3 link-btn-wrapper ">
                                            <button class="log-reg-btn">Create</button> <span >Already have an account?&nbsp; <a href="{{route('login-form')}}">Sign In</a></span>
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
        $("form[name='signupForm']").validate({
             errorPlacement: function(label, element) {
        label.addClass('arrow');
        label.insertBefore(element);
    },
    wrapper: 'span',

    rules: {
      name: {
        required: true,
      },
      email: {
        required: true,
        emailFormat: true,
         remote: {
                    url: "{{ config('app.url')}}check-email-registration",
                    type: "get",
                  }
      },
      password: {
        required: true,
        minlength: 5,
      },
       confirm_password: {
        required : true,
        equalTo: "#password"


      },
    },
    messages: {
      name: {
        required: "Please fill this field",
      },
      email: {
        required: "Please fill this field",
      },
      password: {
        required: "Please fill this field",
        minlength: "Please fill this field with minimum 5 characters",
      },
      confirm_password: {
        required : "Please fill this field",
        equalTo  :"Password Mismatch",

      },
    },
    submitHandler: function(form) {

        form.submit();
    }
  });
  });
</script>

@endsection