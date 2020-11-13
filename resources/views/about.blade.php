@extends('layout.frontbase')
@section("custom_css")
<link href="/frontend/assets/css/about.css" rel="stylesheet" type="text/css" />
@stop

@section('content')

<section id="main ">
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
                        <h1>Helping small businesses track payments and collect debt quickly and efficiently.</h1>
                        {{-- <p class="about-heading-caption">CustomerPayMe helps business owners send overdue invoice
                            reminders, manage daily transactions/debt collection, and
                            provides a unique way of pushing unique sales messaging directly to their customers.</p> --}}
                    </div>

                </div>
            </section>
        </div>
        <div class="about-background-right">
            <img src="/frontend/assets/images/bg_vector_3.svg" alt="">
            <img src="/frontend/assets/images/bg_vector_4.svg" alt="">
        </div>
    </div>

    <!-- About: Main Profile -->
    <div class="container ">

        <section id="about-profile">
            <div class="about-profile-image">
                <img src="/frontend/assets/images/Happy-Market-Woman 1.png" alt="our_company">
            </div>
            <div class="about-profile-content">
                <h2 class="about-profile-content-heading d-flex justify-content-center justify-content-md-start">Our Company</h2>
                <p> CustomerPayMe helps business owners send overdue invoice
                    reminders, manage daily transactions/debt collection, and
                    provides a unique way of pushing unique sales messaging directly to their customers.</p>
            </div>
        </section>
    </div>

    <!-- Feature Area -->
    <div class="feature-area section-padding-100-50" id="feature">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="section-heading text-center">
                        <h4>CustomerPayMe Features</h4>
                        <p>This solution helps business owners send overdue invoice reminders, manage daily
                            transactions/debt collection, and provides a unique way of pushing unique sales messaging
                            directly to their customers.</p>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <!-- Single Feature area -->
                <div class="col-md-6 col-lg-4">
                    <div class="single-feature-area text-center">
                        <!-- Feature Icon -->
                        <div class="feature-icon">
                            <img src="/frontend/assets/img/icon-img/4.svg" alt="">
                        </div>
                        <!-- Single Feature Text -->
                        <div class="feature-content-text">
                            <h4>Multi-Lingual</h4>
                            <p class="mb-0">Our app is available in various languages. Trusted by over various users
                                across
                                the globe</p>
                        </div>
                    </div>
                </div>

                <!-- Single Feature area -->
                <div class="col-md-6 col-lg-4">
                    <div class="single-feature-area text-center">
                        <!-- Feature Icon -->
                        <div class="feature-icon">
                            <img src="/frontend/assets/img/icon-img/5.svg" alt="">
                        </div>
                        <!-- Single Feature Text -->
                        <div class="feature-content-text">
                            <h4>Quick Ledgers</h4>
                            <p class="mb-0">Save precious hours by updating daily business accounts in minutes.</p>
                        </div>
                    </div>
                </div>

                <!-- Single Feature area -->
                <div class="col-md-6 col-lg-4">
                    <div class="single-feature-area text-center">
                        <!-- Feature Icon -->
                        <div class="feature-icon">
                            <img src="/frontend/assets/img/icon-img/9.svg" alt="">
                        </div>
                        <!-- Single Feature Text -->
                        <div class="feature-content-text">
                            <h4>Free SMS Reminders</h4>
                            <p class="mb-0">Manage daily transactions/debt collections and send customers quick SMS
                                reminders</p>
                        </div>
                    </div>
                </div>

                <!-- Single Feature area -->
                <!-- <div class="col-md-6 col-lg-4">
                  <div class="single-feature-area text-center wow fadeInUp" data-wow-delay="0.4s">
                      <!-- Feature Icon
                      <div class="feature-icon">
                          <img src="assets/img/icon-img/6.svg" alt="">
                      </div>
                      <!-- Single Feature Text
                      <div class="feature-content-text">
                          <h4>Drag &amp; Drop Building</h4>
                          <p class="mb-0">Add, delete and move elements around on the front end of your website.</p>
                      </div>
                  </div>
              </div> -->

                <!-- Single Feature area -->
                <!-- <div class="col-md-6 col-lg-4">
                  <div class="single-feature-area text-center wow fadeInUp" data-wow-delay="0.8s">
                      <!-- Feature Icon
                      <div class="feature-icon">
                          <img src="assets/img/icon-img/7.svg" alt="">
                      </div>
                      <!-- Single Feature Text
                      <div class="feature-content-text">
                          <h4>Drag &amp; Drop Building</h4>
                          <p class="mb-0">Add, delete and move elements around on the front end of your website.</p>
                      </div>
                  </div>
              </div> -->

                <!-- Single Feature area -->
                <!-- <div class="col-md-6 col-lg-4">
                  <div class="single-feature-area text-center wow fadeInUp" data-wow-delay="0.8s">
                      <!-- Feature Icon
                      <div class="feature-icon">
                          <img src="assets/img/icon-img/8.svg" alt="">
                      </div>
                      <!-- Single Feature Text
                      <div class="feature-content-text">
                          <h4>Drag &amp; Drop Building</h4>
                          <p class="mb-0">Add, delete and move elements around on the front end of your website.</p>
                      </div>
                  </div>
              </div> -->
            </div>
        </div>
    </div>
    <!-- Feature Area -->


    <!-- About: Mission  -->


    <div class="container">
        <section id="about-mission">
            <div class="about-mission-heading">
                <h2>We're on a mission to help the world<br> to be a better place.</h2>
            </div>
        </section>
    </div>

    <!-- About: Collage -->

    <div class="container">
        <section id="about-collage">
        <div class="about-collage-images">
                <img id="collage_2" src="/frontend/assets/images/collage_4.jpg" alt="collage_2">
                <img id="collage_5" src="/frontend/assets/images/collage_6.jpg" alt="collage_5">
            </div>
            <div class="about-collage-images">
                <img id="collage_2" src="/frontend/assets/images/collage_2.jpg" alt="collage_2">
                <img id="collage_5" src="/frontend/assets/images/collage_1.jpg" alt="collage_5">
            </div>
            <div class="about-collage-images">
                <img id="collage_2" src="/frontend/assets/images/collage_3.jpg" alt="collage_2">
                <img id="collage_5" src="/frontend/assets/images/collage_5.jpg" alt="collage_5">
            </div>
        </section>
    </div>

    <!-- Client Feedback Area -->
    <div class="client-feedback-area section-padding-100" id="client">
        <div class="container">
            <div class="row justify-content-center mb-0">
                <div class="col-lg-7">
                    <div class="section-heading text-center testimonials">
                        <h4>Testimonials</h4>
                        <p>Our users are happy with us. Here are some of the feedback we have gotten so far</p>
                        <hr class="testimonial-line">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="client-silder owl-carousel">
                        <!-- Single Slider -->
                        <div class="row align-items-center">
                            <div class="col-sm-8">
                                <!-- Client Content -->
                                {{-- <div class="testimonial-img-container">
                                <img src="/frontend/assets/images/kadet pic.jpeg" alt=""
                                    class="testimonial-img img-fluid">
                            </div> --}}
                                <div class="client-desc client-mt-50 testimonial__text">
                                    <p>I have been using this app for three months now and i must confess, it has really
                                        changed
                                        the way and see and manage my businesses, assistants and customers. The analytics
                                        feature gets me
                                        the most. I never knew running multiple business could be this easy</p>

                                    <h4>Angel Collins</h4>
                                </div>
                            </div>
                        </div>

                        <!-- Single Slider -->
                        <div class="row align-items-center">
                            <div class="col-sm-8">
                                <!-- Client Content -->
                                {{-- <div class="testimonial-img-container">
                                <img src="/frontend/assets/images/kadet pic.jpeg" alt=""
                                    class="testimonial-img img-fluid">
                            </div> --}}
                                <div class="client-desc client-mt-50 testimonial__text">
                                    <p>Remotely control my businesses and business assistants is a feature I have really been
                                        looking for.
                                        I have finally found an app that meets all my needs. Thanks makers of MyCustomer
                                    </p>

                                    <h4>Bitrus Samuel</h4>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Client Feedback Area -->

    <!-- Footer Styling Begins -->

    <section id="footer-background">
        <img src="/frontend/assets/images/background.svg" alt="">
    </section>
</section>

@endsection


@section("javascript")


@stop