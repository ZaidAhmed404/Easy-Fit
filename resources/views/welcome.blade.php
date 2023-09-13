<!DOCTYPE html>
<html lang="en">

<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

<link href="assets/vendor/aos/aos.css" rel="stylesheet">
<link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
<link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
<link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
<link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
<link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

<link href="assets/css/style.css" rel="stylesheet">


<head>
  <title>EasyFit</title>
  <link rel="icon" type="image/x-icon" href="\images\easyfit.png">
</head>

<body>

  <header id="header" class="fixed-top">
    <div class="container d-flex align-items-center justify-content-between">

      <h1 class="logo"><a href="{{ url('/') }}">EasyFit</a></h1>

      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="nav-link scrollto active" href="#hero">Home</a></li>
          <li><a class="nav-link scrollto" href="#about">About</a></li>
          <li><a class="nav-link scrollto" href="#services">Services</a></li>
          @if (Route::has('login'))
          @auth
          <li><a class="getstarted scrollto" href="{{ url('/home') }}">Home</a></li>
          
          @else
          <li><a class="getstarted scrollto" href="{{ route('login') }}">Log in</a></li>
          @if (Route::has('register'))
          <li><a class="getstarted scrollto" href="{{ route('register') }}">Register</a></li>
          @endif
          @endauth
          @endif
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav>

    </div>
  </header>

  <section id="hero" class="d-flex align-items-center">
    <div class="container position-relative" data-aos="fade-up" data-aos-delay="100">
      <div class="row justify-content-center">
        <div class="col-xl-7 col-lg-9 text-center">
          <h1>EasyFit</h1>
          <h2>Conference Management System</h2>
        </div>
      </div>
      <div class="text-center">
        <a href="#about" class="btn-get-started scrollto">Get Started</a>
      </div>

      
      </div>
    </div>
  </section>

  <main id="main">

    <section id="about" class="about">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>About Us</h2>
        </div>

        <div class="row content">
          
            <p>
            EASYFIT is a Web-based Conference Management System (CMS) developed to aid the effective or various organization and management of professional, academic, and technical conferences. The web-based application is an object-oriented and multi-conference platform that is made up of five major actors which are the Superchair, Trackchair, Reviewers, Subreviewer and Authors. Conference organizers in any Anglophone country can subscribe to the platform via the Internet to access and utilize the different features which include abstract and full paper Submissions, Assignment of Papers to Reviewers, and Sending email Notifications to Authors and Reviewers.</p>
            </div>
          

      </div>
    </section>

    <section id="services" class="services section-bg">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>Sevices</h2>
          <p>Everything you may need for your conference.
            
         <br> All in one place. <br>
We have everything you need to organize a conference of any size and complexity!</p>
        </div>

      </div>
      <div class="row icon-boxes">
        <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0" data-aos="zoom-in" data-aos-delay="200">
          <div class="icon-box">
            <h4 class="title">Virtual Conference Solution</h4>
            <p class="description">We designed software that makes it possible to hold a scientific conference of any size virtually or hybridly.</p>
          </div>
        </div>

        <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0" data-aos="zoom-in" data-aos-delay="300">
          <div class="icon-box">
            <h4 class="title">Conference Management</h4>
            <p class="description">EasyFit was designed to help conference organizers cope with the complexity of running an almost arbitrary conference model.</p>
          </div>
        </div>

        <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0" data-aos="zoom-in" data-aos-delay="400">
          <div class="icon-box">
            <h4 class="title">Registration</h4>
            <p class="description">We can create complex registration forms to support your attendee registration and make registration up in running in a few hours.</p>
          </div>
        </div>

        <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0" data-aos="zoom-in" data-aos-delay="500">
          <div class="icon-box">
            <h4 class="title">Smart Slide</h4>
            <p class="description">Our Smart Slide platform allows authors to publish their slides and users to access and/or download the slides before and after the conference.</p>
          </div>
        </div>

    </section>



  </main>
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <script src="assets/js/main.js"></script>

</body>

</html>