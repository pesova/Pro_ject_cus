<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, shrink-to-fit=no">
    <meta content="An easy to use web app that helps you record and track daily transactions, Send debt reminders and send offers to your customers" name="description" />
    <meta content="CustomerPayMe" name="author" />
    <title>CustomerPayMe</title>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="/frontend/assets/img/favicon.png">

    <!-- CSS here -->
    <link href="{{ asset('backend/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('frontend/assets/css/payment.css') }}" rel="stylesheet" type="text/css" />

</head>

<body>
    <div class="container-fluid col-lg-4">
        <header class="py-4 text-center">
            <img src="{{ asset('frontend/assets/images/payment/logo.svg')}}" alt="" />
        </header>
        <main>
            @yield('content')
        </main>
    </div>
    <script src="{{ asset('backend/assets/js/vendor.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/parsleyjs/parsley.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/pages/form-validation.init.js') }}"></script>
    <script src="{{ asset('backend/assets/js/app.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/alert.js') }}"></script>
</body>

</html>
