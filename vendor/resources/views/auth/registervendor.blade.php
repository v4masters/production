<!DOCTYPE html>

<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

  <title>Register Basic Evyapari</title>

  <meta name="description" content="" />
   @include('includes.header_script')
  <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }} " />
    <!-- Helpers -->


</head>

<body>
  <!-- Content -->

 <div class="container-xxl flex-grow-1 container-p-y">
    <div class="authentication-wrapper authentication-basic container-p-y">
      <div class="authentication-inner">
        <!-- Register -->
        <div class="card">
          <div class="card-body">
            <!-- Logo -->
            <div class="app-brand justify-content-center">
              <a href="index.html" class="app-brand-link gap-2">
                <span class="app-brand-logo demo">

                </span>
                <img src="{{Storage::disk('s3')->url('site_img/evyapari-logo.png')}}" alt="Logo" width="150">
              </a>
            </div>
            <!-- /Logo -->
            <h4 class="mb-3 text-center">Vendor Signup</h4>
            <form id="formAuthentication" class="mb-3" action="{{url('/') }}/register"  method="POST">
              @csrf
              @if ($errors->any())
              <div class="alert alert-danger">
                <ul>
                  @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
              @endif

             @if(session('success'))
            <div class="alert alert-primary">
            {{ session('success') }}
            </div>
            @endif



              <div class="mb-3">
                <label class="form-label"> Name</label>
                <input type="text" class="form-control" id="username" name="username"  placeholder=" Name" autofocus required />
              </div>
              <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Email" required/>
              </div>
              <div class="mb-3">
                <label class="form-label">Mobile No.</label>
                <input type="number" class="form-control" minlength="10" id="phone_no" name="phone_no" placeholder="Mobile No." required/>
              </div>
              <div class="mb-3">
                <label class="form-label">State</label>
               
                 <select class="form-select" id="form-select-md-brand" data-placeholder="Select" name="state" required>

                                                         <option selected disabled value="">Select</option>
                                                        <option value="0">N/A </option>
                                                        @foreach($state as $key => $state)

                                                        <option value="{{$state->state_code.','.$state->state}}">{{$state->state}}</option>

                                                        @endforeach

                                                    </select>
                                                    
              </div>
                  <div class="mb-3">
                 <label class="form-label">Zipcode</label>
                 <input type="number" class="form-control" minlength="6"  maxlength="6" name="pincode" id="pincode" placeholder="Zipcode" required/>
              </div>
                 <div class="mb-3">
                  <label class="form-label">Address</label>
                  <input type="text" class="form-control" name="address" id="address" placeholder="Address" required/>
              </div>
                  <div class="mb-3">
                    <label class="form-label">GST No.</label>
                  <input type="text" class="form-control" name="gst_no" id="gst_no" placeholder="GST No." required/>
              </div>
                 <div class="mb-3 form-password-toggle">
                                    <div class="d-flex justify-content-between">
                                        <label class="form-label" for="new_pass">Password</label>
                                    </div>
                                    <div class="input-group input-group-merge">
                                        <input type="password" id="new_pass" onblur="CheckPassword(this.value)" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" required />
                                        <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                    </div>
                                </div>
                                <div class="mb-3 form-password-toggle">
                                    <div class="d-flex justify-content-between">
                                        <label class="form-label" for="con_pass">Confirm Password</label>
                                    </div>
                                    <div class="input-group input-group-merge">
                                        <input type="password" id="con_pass" class="form-control" name="password_confirmation" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" required />
                                        <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                    </div>
                                    
                                    			<span class="pass_match_error" id="message" style="color:red;display:none;"></span>
					                  
                                </div>
              <div class="mb-3">
                <button class="btn btn-primary d-grid w-100" type="submit">Register</button>
              </div>
            </form>
            <div><a href="{{url('login')}}">Login Here!</a></div>

          </div>
        </div>
      
      </div>
    </div>
  </div>

    @include('includes.footer_script')
    
    <script>
   
        
        
$('#con_pass').on('keyup', function () {
  if ($('#new_pass').val() != $('#con_pass').val()) {
    $('#message').html('Passwords do not match.').css("display","block");
  } else 
  {
    $('#message').html('').css("display","none");
  }
});



// function CheckPassword(newpas) 
// { 
// var passw = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/;
// if(newpas.match(passw)) 
// { 
// return true;
// }
// else
// { 
// return false;
// }
// }




// //Submit regForm
//  $('#regForm').submit(function(e) {
//  e.preventDefault();
 
//  alert('j');
   
//   var newpas=document.getElementById('new_pass').value;  
//   var conpass=document.getElementById('con_pass').value;  

     
     
//   if(CheckPassword(newpas)==false || CheckPassword(conpass)==false)
//   {
//   $('#message').html('Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.').css("display","block");    
//     }
//     else
//     {
//       document.getElementById('regForm').submit();
    
//     }
// })

    </script>
</body>

</html>
</body>

</html>