{{-- inherits base markup --}}
@extends('layout.base')

{{-- add in the basic styling : check the contents of these stylesheets later --}}
@section("custom_css")
  <link rel="stylesheet" href="{{asset('backend/assets/css/singleCustomer.css')}}">
@stop


{{-- yield body content --}}

@section('content')
<div class="content">

    <div class="container-fluid">
        {{-- start of page title --}}
        <div class="row page-title">
            <div class="col-md-12">
                <h4 class="mb-1 mt-0 float-left">Create New Customer</h4>
                <a href="/admin" class="btn btn-primary float-right" >
                    Go Back {{-- &nbsp;<i class="fa fa-plus my-float"></i> --}}
                </a>
            </div>
        </div>
         {{-- end of page title --}}

         {{-- start of content section --}}
         <div class="row contentrow">
             {{--start of person profile--}}
             <div class="col-lg-3 col-md-4 col-sm-5" id="h1IdTop">
                 <div class="card">
                     <div class="card-body text-center text-muted">
                         <img src="../../backend/assets/images/users/avatar-7.jpg" alt="Customer 1" class="img-fluid rounded-circle">
                         <h4>John Doe</h4>
                         <h5 class="cust-email">johndoe@doetech.com</h5>
                         this is a very very large junk of rubbush that i am just foing to type in the hopes that it casue seomth
                         ing dofferent to hppen to my file ebvery single godammmn time.
                     </div>
                     <div class="address">
                         <h5>House Address</h5>
                         <p class="customer-address">1975, Boring Lane, San <br>Francisco, California, United<br> States - 94108</p>
                     </div>
                 </div>
             </div>
             {{--end of person profile--}}
             <div class="col-lg-9 col-md-8 col-sm-7">
                 {{-- start of card --}}
                <div class="card">
                    <div class="card-body">
                        <form class="form-horizontal" role="form">
                            <div class="form-group">
                              <label class="col-lg-3 control-label">Full Name:</label>
                              <div class="col-lg-8">
                                <input class="form-control" type="text" placeholder="John Doe" maxlength="30" value="{{old('name')}}" required name="name">
                              </div>
                            </div>

                            <div class="form-group">
                              <label class="col-lg-3 control-label">Email:</label>
                              <div class="col-lg-8">
                                <input class="form-control" type="text" placeholder="example@gmail.com" value="{{old('email')}}" name="email" required>
                              </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label">Tel:</label>
                                <div class="col-lg-8">
                                  <input class="form-control" type="phone" id="phone" placeholder="2348127277467" value="{{old('phone_number')}}" maxlength="16" name="phone_number" required>
                                </div>
                              </div>
                              <div class="form-group">
                                <div class="col-md-8">
                                    <select class="form-control" required>
                                        <option selected="">Customer Type</option>
                                        <option>Good Debtor</option>
                                        <option>Bad Debtor</option>
                                        <option>Doesn't Owe</option>                                        
                                      </select>
                                  </div>                                
                              </div>  
                              <div class="form-group">
                                <div class="col-md-8">
                                    <select class="form-control" required>
                                        <option selected="">Status</option>
                                        <option class="text-danger">Has Debt</option>
                                        <option class="text-success">No Debt</option>                                        
                                      </select>
                                  </div>                                
                              </div>                                                           
                              
                            <div class="form-group">
                              <label class="col-md-3 control-label green-border-focus">House Adddress</label>
                              <div class="col-md-8">                                
                                <textarea class="form-control " placeholder="1975, Boring Lane, San
                                Francisco, California, United
                                States - 94108" maxlength="50" rows="3"></textarea>
                                
                              </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-md-3 control-label">Short Comment</label>
                                <div class="col-md-8">
                                  <input class="form-control" type="text" maxlength="100" value="{{old('comment')}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-8">
                                    <input type="file"  id="main-input" class="form-control form-input form-style-base">                                        
                                  </div>                                
                              </div>

                            <div class="form-group">
                              <label class="col-md-3 control-label"></label>
                              <div class="col-md-8">
                                <input type="button" class="btn btn-primary" value="Save Changes">
                                <span></span>
                                <input type="reset" class="btn btn-default" value="Cancel">
                              </div>
                            </div>
                          </form>

                        {{--customer basic info end--}}
                    </div>
                </div>
                <!-- end card --> 
        </div>
         {{--End of person profile--}}
         </div>

    
        
        {{--end of column--}}
    </div>
</div>

@endsection

@section("javascript")
   <script src="/backend/assets/build/js/intlTelInput.js"></script>
   <script>
   //phone Number format
   var input = document.querySelector("#phone");
   var test = window.intlTelInput(input, {
       separateDialCode: true,
       initialCountry: "auto",
       geoIpLookup: function (success) {
           // Get your api-key at https://ipdata.co/
           fetch("https://ipinfo.io?token={{env('GEOLOCATION_API_KEY')}}")
               .then(function (response) {
                   if (!response.ok) return success("");
                   return response.json();
               })
               .then(function (ipdata) {
                   success(ipdata.country);
               }).catch(function () {
               success("NG");
           });
       },
       utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/utils.min.js",
   });

    $("#phone").keyup(() => {
        if ($("#phone").val().charAt(0) == 0) {
            $("#phone").val($("#phone").val().substring(1));
        }
    });

    $("#submitForm").submit((e) => {
        e.preventDefault();
        const dialCode = test.getSelectedCountryData().dialCode;
        if ($("#phone").val().charAt(0) == 0) {
            $("#phone").val($("#phone").val().substring(1));
        }
        $("#phone_number").val(dialCode + $("#phone").val());
        $("#submitForm").off('submit').submit();
    });
   </script>
@stop
