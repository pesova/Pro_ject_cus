@extends('layout.frontbase')
@section("custom_css")
<link href="/frontend/assets/css/faq.css" rel="stylesheet" type="text/css" />
@stop



@section('content')

<!-- top section -->
<section id="main" class="faq-top">
    <div class="container">
        <div class="faq-top__content text-center">
            <h1 class="faq-top__title">Frequently Asked Questions</h1>
            <input type="search" name="search-faq" id="search-faq" class="form-control"
                placeholder="Search for a question" aria-placeholder="Search for a question">
            <button class="faq-top__btn dissapear">Search</button>
        </div>
    </div>
    <!-- background vectors -->
    <div class="faq-bg__left">
        <img src="/frontend/assets/img/faq-bg/orange-cutout.png" alt="orange-cutout"
            class="faq-bg__orange-cutout img-fluid">
        <img src="/frontend/assets/img/faq-bg/yellow-cutout.png" alt="yellow-cutout"
            class="faq-bg__yellow-cutout img-fluid">
    </div>
    <div class="faq-bg__right">
        <img src="/frontend/assets/img/faq-bg/blue-cutout.png" alt="blue-cutout" class="faq-bg__blue-cutout img-fluid">
        <img src="/frontend/assets/img/faq-bg/orange-triangle-cutout.png" alt="orange-triangle-cutout"
            class="faq-bg__orange-triangle-cutout img-fluid">
    </div>
</section>
<!-- questions in accordion -->
<section class="faq">
    <div class="container faq__accordion">
        <div class="nothing-box">
            <img src="/frontend/assets/images/no-result-search.png" alt="">
        </div>
        <div class="accordion" id="faq__accordion">
            <!-- Question one -->
            <div class="card">
                <div class="card-header" id="headingOne">
                    <button class="faq__btn collapsed" type="button" data-toggle="collapse" aria-expanded="true"
                        data-target="#questionOne" aria-expanded="false" aria-controls="questionOne">
                        <h2 class="faq__title mb-0">What is CustomerPayMe?</h2>
                        <i class="fas fa-angle-up"></i>
                    </button>
                </div>
                <!-- Question one body -->
                <div id="questionOne" class="collapse show" aria-labelledby="headingOne" data-parent="#faq__accordion">
                    <div class="card-body">
                        <p class="faq__content">CustomerPayMe is solution that helps business owners send overdue
                            invoice reminders, manage debt collection and provides a unique way of documenting sales
                            directly from single or multiple busineses</p>
                    </div>
                </div>
            </div>

            <!-- Question two -->
            <div class="card">
                <div class="card-header" id="headingTwo">
                    <button class="faq__btn collapsed" type="button" data-toggle="collapse" data-target="#questionTwo"
                        aria-expanded="false" aria-controls="questionTwo">
                        <h2 class="faq__title mb-0">Why should I use CustomerPayMe?</h2>
                        <i class="fas fa-angle-up"></i>
                    </button>
                </div>
                <!-- Question two body -->
                <div id="questionTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#faq__accordion">
                    <div class="card-body">
                        <p class="faq__content">It helps you manage your expenses and keep
                            track of your
                            customers and Debtors without using papers. You can do this on the go and optimize your
                            time.</p>
                    </div>
                </div>
            </div>
            <!-- Question three -->
            <div class="card">
                <div class="card-header" id="headingThree">
                    <button class="faq__btn collapsed" type="button" data-toggle="collapse" data-target="#questionThree"
                        aria-expanded="false" aria-controls="questionThree">
                        <h2 class="faq__title mb-0">How can I download the app?</h2>
                        <i class="fas fa-angle-up"></i>
                    </button>
                </div>
                <!-- Question three body-->
                <div id="questionThree" class="collapse" aria-labelledby="headingThree" data-parent="#faq__accordion">
                    <div class="card-body">
                        <p class="faq__content">The app is available on <a href="">Google PlayStore</a></p>
                    </div>
                </div>
            </div>

            <!-- Question six -->
            <div class="card">
                <div class="card-header" id="headingSix">
                    <button class="faq__btn collapsed" type="button" data-toggle="collapse" data-target="#questionSix"
                        aria-expanded="false" aria-controls="questionSix">
                        <h2 class="faq__title mb-0">
                            How do I get started with the “My Customer” app?
                        </h2>
                        <i class="fas fa-angle-up"></i>
                    </button>
                </div>
                <!-- Question six body -->
                <div id="questionSix" class="collapse" aria-labelledby="headingSix" data-parent="#faq__accordion">
                    <div class="card-body">
                        <p class="faq__content">
                            Download the Android application for free clicking this <a href="#">Link</a> to Google Play.
                            If you cannot
                            access Google Play from your computer, please access it from your Android smartphone/ tablet
                            and search for “CustomerPayMe App”
                        </p>
                    </div>
                </div>
            </div>
            <!-- Question seven -->
            <div class="card">
                <div class="card-header" id="headingSeven">
                    <button class="faq__btn collapsed" type="button" data-toggle="collapse" data-target="#questionSeven"
                        aria-expanded="false" aria-controls="questionSeven">
                        <h2 class="faq__title mb-0">
                            Is there a Desktop version of My Customer App?
                        </h2>
                        <i class="fas fa-angle-up"></i>
                    </button>
                </div>
                <!-- Question seven body -->
                <div id="questionSeven" class="collapse" aria-labelledby="headingSeven" data-parent="#faq__accordion">
                    <div class="card-body">
                        <p class="faq__content">
                            The CustomerPayMe App does not have a Desktop Version yet but can be accessed via the web
                            https://customerpay.me
                        </p>
                    </div>
                </div>
            </div>

            <!-- Question nine  -->
            <div class="card">
                <div class="card-header" id="headingNine">
                    <button class="faq__btn collapsed" type="button" data-toggle="collapse" data-target="#questionNine"
                        aria-expanded="false" aria-controls="questionNine">
                        <h2 class="faq__title mb-0">
                            Can I back up my data and restore all settings?
                        </h2>
                        <i class="fas fa-angle-up"></i>
                    </button>
                </div>
                <!-- Question Nine body -->
                <div id="questionNine" class="collapse" aria-labelledby="headingNine" data-parent="#faq__accordion">
                    <div class="card-body">
                        <p class="faq__content">
                            Since the application is installed through the Google Play store, it can be backed up by
                            synchronizing with your Google account.
                        </p>
                    </div>
                </div>
            </div>
            <!-- Question Ten  -->
            <div class="card">
                <div class="card-header" id="headingTen">
                    <button class="faq__btn collapsed" type="button" data-toggle="collapse" data-target="#questionTen"
                        aria-expanded="false" aria-controls="questionTen">
                        <h2 class="faq__title mb-0">
                            Where can I get more help?
                        </h2>
                        <i class="fas fa-angle-up"></i>
                    </button>
                </div>
                <!-- Question Ten body -->
                <div id="questionTen" class="collapse" aria-labelledby="headingTen" data-parent="#faq__accordion">
                    <div class="card-body">
                        <p class="faq__content">
                            You can send us a mail at hello@customerpay.me
                        </p>
                    </div>
                </div>
            </div>
            <!-- Question Eleven  -->
            <div class="card">
                <div class="card-header" id="headingEleven">
                    <button class="faq__btn collapsed" type="button" data-toggle="collapse"
                        data-target="#questionEleven" aria-expanded="false" aria-controls="questionEleven">
                        <h2 class="faq__title mb-0">
                            Do I need to create an account to use the services?
                        </h2>
                        <i class="fas fa-angle-up"></i>
                    </button>
                </div>
                <!-- Question Eleven body -->
                <div id="questionEleven" class="collapse" aria-labelledby="headingEleven" data-parent="#faq__accordion">
                    <div class="card-body">
                        <p class="faq__content">
                            Yes, you would have to create an account
                        </p>
                    </div>
                </div>
            </div>
            <!-- Question Twelve  -->
            <div class="card">
                <div class="card-header" id="headingTwelve">
                    <button class="faq__btn collapsed" type="button" data-toggle="collapse"
                        data-target="#questionTwelve" aria-expanded="false" aria-controls="questionTwelve">
                        <h2 class="faq__title mb-0">
                            Is CustomerPayMe a free service?
                        </h2>
                        <i class="fas fa-angle-up"></i>
                    </button>
                </div>
                <!-- Question Twelve body -->
                <div id="questionTwelve" class="collapse" aria-labelledby="headingTwelve" data-parent="#faq__accordion">
                    <div class="card-body">
                        <p class="faq__content">
                            Yes, it is.
                        </p>
                    </div>
                </div>
            </div>
            <!-- Question Thirteen  -->
            <div class="card">
                <div class="card-header" id="headingThirteen">
                    <button class="faq__btn collapsed" type="button" data-toggle="collapse"
                        data-target="#questionThirteen" aria-expanded="false" aria-controls="questionThirteen">
                        <h2 class="faq__title mb-0">
                            Do I need to pay for a subscription in order to use the app?
                        </h2>
                        <i class="fas fa-angle-up"></i>
                    </button>
                </div>
                <!-- Question Thirteen body -->
                <div id="questionThirteen" class="collapse" aria-labelledby="headingThirteen"
                    data-parent="#faq__accordion">
                    <div class="card-body">
                        <p class="faq__content">
                            The only thing you need to do is to sign up, and this is free
                        </p>
                    </div>
                </div>
            </div>

            <!-- Question Fifteen  -->
            <div class="card">
                <div class="card-header" id="headingFifteen">
                    <button class="faq__btn collapsed" type="button" data-toggle="collapse"
                        data-target="#questionFifteen" aria-expanded="false" aria-controls="questionFifteen">
                        <h2 class="faq__title mb-0">
                            Will there be a deadline for the debtor to pay up?
                        </h2>
                        <i class="fas fa-angle-up"></i>
                    </button>
                </div>
                <!-- Question Fifteen body -->
                <div id="questionFifteen" class="collapse" aria-labelledby="headingFifteen"
                    data-parent="#faq__accordion">
                    <div class="card-body">
                        <p class="faq__content">
                            Yes, it can be set while creating the debt.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Question Seventeen  -->
            <div class="card">
                <div class="card-header" id="headingSeventeen">
                    <button class="faq__btn collapsed" type="button" data-toggle="collapse"
                        data-target="#questionSeventeen" aria-expanded="false" aria-controls="questionSeventeen">
                        <h2 class="faq__title mb-0">
                            Can this app be used in every country?
                        </h2>
                        <i class="fas fa-angle-up"></i>
                    </button>
                </div>
                <!-- Question  Seventeen  body -->
                <div id="questionSeventeen" class="collapse" aria-labelledby="headingSeventeen"
                    data-parent="#faq__accordion">
                    <div class="card-body">
                        <p class="faq__content">
                            Yes, the only thing you need to do is to download and install the app on PlayStore.
                        </p>
                    </div>
                </div>
            </div>
            <!-- Question Eighteen  -->
            <div class="card">
                <div class="card-header" id="headingEighteen">
                    <button class="faq__btn collapsed" type="button" data-toggle="collapse"
                        data-target="#questionEighteen" aria-expanded="false" aria-controls="questionEighteen">
                        <h2 class="faq__title mb-0">
                            Do I still need to have a paper ledger handy just in case my phone gets stolen or lost?
                        </h2>
                        <i class="fas fa-angle-up"></i>
                    </button>
                </div>
                <!-- Question  Eighteen  body -->
                <div id="questionEighteen" class="collapse" aria-labelledby="headingEighteen"
                    data-parent="#faq__accordion">
                    <div class="card-body">
                        <p class="faq__content">
                            There will be no need for that, all your information will be stored on cloud and retrieved
                            once you re-download the app.

                        </p>
                    </div>
                </div>
            </div>
            <!-- Question Nineteen  -->
            <div class="card">
                <div class="card-header" id="headingNineteen">
                    <button class="faq__btn collapsed" type="button" data-toggle="collapse"
                        data-target="#questionNineteen" aria-expanded="false" aria-controls="questionNineteen">
                        <h2 class="faq__title mb-0">
                            Who can use CustomerPayMe App?
                        </h2>
                        <i class="fas fa-angle-up"></i>
                    </button>
                </div>
                <!-- Question  Nineteen  body -->
                <div id="questionNineteen" class="collapse" aria-labelledby="headingNinetteen"
                    data-parent="#faq__accordion">
                    <div class="card-body">
                        <p class="faq__content">
                            All owners of small and medium-scale businesses who possess a smartphone
                        </p>
                    </div>
                </div>
            </div>
            <!-- Question Twenty  -->
            <div class="card">
                <div class="card-header" id="headingTwenty">
                    <button class="faq__btn collapsed" type="button" data-toggle="collapse"
                        data-target="#questionTwenty" aria-expanded="false" aria-controls="questionTwenty">
                        <h2 class="faq__title mb-0">
                            Must I be online to use the app or can it be used offline?
                        </h2>
                        <i class="fas fa-angle-up"></i>
                    </button>
                </div>
                <!-- Question  Twenty  body -->
                <div id="questionTwenty" class="collapse" aria-labelledby="headingTwenty" data-parent="#faq__accordion">
                    <div class="card-body">
                        <p class="faq__content">
                            The app can be used offline and online. Offline usage is immediately synchronized once the
                            user comes online
                        </p>
                    </div>
                </div>
            </div>

            <!-- Question Twentythree  -->
            <div class="card">
                <div class="card-header" id="headingTwentythree">
                    <button class="faq__btn collapsed" type="button" data-toggle="collapse"
                        data-target="#questionTwentythree" aria-expanded="false" aria-controls="questionTwentythree">
                        <h2 class="faq__title mb-0">
                            How do I know who is on my list of debts?
                        </h2>
                        <i class="fas fa-angle-up"></i>
                    </button>
                </div>
                <!-- Question  Twentythree  body -->
                <div id="questionTwentythree" class="collapse" aria-labelledby="headingTwentythree"
                    data-parent="#faq__accordion">
                    <div class="card-body">
                        <p class="faq__content">
                            The app keeps a debt history which notifies you of pending collections and recent (today's)
                            debt
                        </p>
                    </div>
                </div>
            </div>
            <!-- Question Twentyfour  -->
            <div class="card">
                <div class="card-header" id="headingTwentyfour">
                    <button class="faq__btn collapsed" type="button" data-toggle="collapse"
                        data-target="#questionTwentyfour" aria-expanded="false" aria-controls="questionTwentyfour">
                        <h2 class="faq__title mb-0">
                            How secured are transaction details on the app?
                        </h2>
                        <i class="fas fa-angle-up"></i>
                    </button>
                </div>
                <!-- Question  Twentyfour  body -->
                <div id="questionTwentyfour" class="collapse" aria-labelledby="headingTwentyfour"
                    data-parent="#faq__accordion">
                    <div class="card-body">
                        <p class="faq__content">
                            The app requires log in which enables users to create and use a unique password, other
                            sensitive details such as phone numbers are authenticated using OTP
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection


@section("javascript")
<script src="/frontend/assets/js/faq.js"></script>
@stop