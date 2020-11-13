@extends('layout.frontbase')
@section("custom_css")
<link href="/frontend/assets/css/about.css" rel="stylesheet" type="text/css" />
<link href="/frontend/assets/css/contact-us.css" rel="stylesheet" type="text/css" />
<style>
    form .error {
        color: #ff0000;
    }

    form textarea {
        height: unset;
    }
</style>
@stop
@section('content')
<section id="">
    <!-- About: Heading Section -->
    <div class="about_main">
        <div class="about-background-left">
            <img src="/frontend/assets/images/bg_vector_1.svg" alt="">
            <img src="/frontend/assets/images/bg_vector_2.svg" alt="">
        </div>
        <div class="container">
            <section id="about-header">
                <div class="about-content">
                    <div class="about-heading">
                        <h1>Helping small businesses <br>collect Money</h1>
                        <p class="about-heading-caption">We help small businesses collect money and automatically send
                            them reminders when it's time to pay.</p>
                    </div>
                    {{-- <div class="p-b-40 text-center">
                        <a class="welcome-btn play-store-btn mr-2 mb-2" href="#"><img
                                src="/frontend/assets/img/bg-img/bt-1.png" alt=""></a>
                        <a class="welcome-btn app-store-btn mr-2 mb-2" href="#"><img
                                src="/frontend/assets/img/bg-img/bt-2.png" alt=""></a>
                    </div> --}}
                </div>
            </section>
        </div>
        <div class="about-background-right">
            <img src="/frontend/assets/images/bg_vector_3.svg" alt="">
            <img src="/frontend/assets/images/bg_vector_4.svg" alt="">
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                @if(Session::has('message'))
                <div id="formFeedback" class="d-flex justify-content-center">
                    <div class="alert alert-{{ Session::get('alert-class') }} alert-dismissible fade show">
                        {{ (Session::get('message')) }}

                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                @endif
                <form id="contact_form" action="{{ route('contact.send') }}" method="POST">
                    @csrf
                    <p class="form-head">Let’s Keep in Touch</p>
                    <div class="form-group">
                        <input type="text" name="name" class="form-control name-input" placeholder="Full Name">
                    </div>
                    <div class="form-group">
                        <input type="email" name="email" id="email" class="form-control" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <textarea name="message" id="message" class="form-control" placeholder="Your Message Here"
                            rows="4"></textarea>
                    </div>
                    <div class="form-group">
                        {!! NoCaptcha::renderJs() !!}
                        {!! NoCaptcha::display() !!}
                        @if ($errors->has('g-recaptcha-response'))
                        <span class="help-block">
                            <small class="form-text text-danger">{{ $errors->first('g-recaptcha-response') }}</small>
                        </span>
                        @endif
                    </div>
                    <button class="button"><img src="frontend/assets/img/icon-img/send.svg" alt="icon"
                            class="send">Send</button>
                </form>
            </div>
            <div class="col-lg-6">
                <div>
                    <div class="contact-extra">
                        {{-- <p class="subhead">Whatsapp</p>
                        <p class="subhead-text">09096823115</p> --}}
                        <p class="subhead">Email Us</p>
                        <p class="subhead-text" id="st-1"><a href="mailto:hello@customerpay.me">hello@customerpay.me</a>
                        </p>
                        <p class="subhead">Working Hours: 9 AM - 11 PM</p>
                        <div class="map-area">
                            <iframe class=" map-iframe"
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3067.312858599401!2d-75.628452985209!3d39.755083503537165!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c6fe0b62f2ae5b%3A0xe8a497f5a5daa390!2s2711%20Centerville%20Rd%20%23400%2C%20Wilmington%2C%20DE%2019808%2C%20USA!5e0!3m2!1sen!2sng!4v1596921181218!5m2!1sen!2sng"
                                rameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false"
                                tabindex="0"></iframe>
                        </div>
                        <p class="subhead">Find us at,</p>
                        <p class="subhead-text subhead-address">2711 Centreville Road, Suite 400, Wilmington, <br />New
                            castle County,<br />
                            Delaware, DE 19808</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection


@section("javascript")
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"
    integrity="sha512-UdIMMlVx0HEynClOIFSyOrPggomfhBKJE28LKl8yR3ghkgugPnG6iLfRfHwushZl1MOPSY6TsuBDGPK2X4zYKg=="
    crossorigin="anonymous"></script>
<script>
    $(function() {
  $('#contact_form').validate({
    rules: {
      name: 'required',
      subject: 'required',
      email: {
        required: true,
        email: true
      },
      message: {
        required: true,
        minlength: 20
      }
    },
    messages: {
        name: 'Please enter your full name',
        subject: {
            required: 'Please provide a password',
            minlength: 'Your message should be at least 20 characters long'
        },
        email: 'Please enter a valid email address',
    },
    submitHandler: function(form) {
      form.submit();
    }
  });
});
</script>

@if(Session::has('message'))
<script>
    $('#formFeedback').scrollTop(1);
</script>
@endif
@stop