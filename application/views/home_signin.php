<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>LOCK MASTERS </title>

    <!-- Bootstrap Core CSS - Uses Bootswatch Flatly Theme: http://bootswatch.com/flatly/ -->
    <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?php echo base_url(); ?>assets/css/font-awesome.css" rel="stylesheet" type="text/css">
    <link href='//fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
    <link href='//fonts.googleapis.com/css?family=Raleway' rel='stylesheet' >


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body id="page-top" class="index">
    <!-- header -->
    <header class="header">
      <div class="container-fluid no-padding">
        <div class="col-md-8 left_side">
          <div class="menu_bar col-md-1">
            <span class="toggle_menu">  <i class="fa fa-bars" aria-hidden="true"></i></span>
          </div>
          <div class="logo col-md-4 no-padding">
            <h1>Lock <span class="color-blue">Masters</span></h1>
          </div>
          <div class="col-md-7 desk_menu">
            <ul class="navigate">
              <li>
                <a href="#">Locksmiths</a>
              </li>
              <li>
                <a href="#">CUSTOMERS</a>
              </li>
              <li>
                <a href="#">How It Works</a>
              </li>
            </ul>
          </div>
        </div>
        <div class="col-md-4 ">
          <div class="right_side ">
            <div class="col-md-6 ">
              <ul class="help navigate pull-right">
                <li>
                  <a href="#">Help</a>
                  <a href="<?php echo base_url(); ?>sign-in">Sign in</a>
                </li>
              </ul>
            </div>
            <div class="col-md-6 set_padding xs_padding">
              <div class="col-md-10 no-padding  btn_top">
                <button class="header_driver">BECOME A LOCKSMITH</button>
              </div>
              <div class="col-md-2 text-right no-padding map_location">
                <a href="#" class="map_locate"><i class="fa fa-map-marker" aria-hidden="true"></i></a>
                <div class="location_point">
                  <h3>London</h3>
                  <p>we use your location to customize the information you see</p>
                  <button class="change_loc">Change Location <i class="fa fa-angle-right" aria-hidden="true"></i></button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="overlay-bg"></div>
        <div class="menu_sidebar col-md-4">
          <div class="top_menu">
            <div class="col-md-2 menu_bar">
              <span class="close_menu toggle_menu">
                <img src="<?php echo base_url(); ?>assets/img/cross.png">
              </span>
            </div>
            <div class="col-md-10 no-padding logo_listing">
              <div class="col-md-12 no-padding">
                <div class="col-md-9  logo-menu">
                  <h1>Lock <span class="color-blue">Masters</span></h1>
                </div>
                <div class="col-md-3 login no-padding text-right">
                  <a href="<?php echo base_url(); ?>sign-in"><i class="fa fa-user-circle-o" aria-hidden="true"></i> Sign In </a>
                </div>
              </div>
              <div class="col-md-12 signup-btn">
                <button class="bg-white">Signup as Locksmith </button>
                <button class="bg-dark">Signup as Customer</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </header>

    <section class="top_section signin">
      <div class="container">
        <div class="col-md-6 col-xs-12">
          <div class="text-offer">
            <h2>Easiest way around</h2>
            <p>
              One tap and a car comes directly to you. Hop inâ€”your Working knows exactly where to go. And when you get there, just step out. Payment is completely seamless.
            </p>
            <button class="btn" onclick="window.location.href='<?php echo base_url(); ?>user/login'">
              Locksmith sign in  <i class="fa fa-angle-right" aria-hidden="true"></i>
            </button>
          </div>
        </div>
        <div class="col-md-6 col-xs-12">
          <div class="text-offer">
            <h2>Easiest way around</h2>
            <p>
              One tap and a car comes directly to you. Hop inâ€”your Working knows exactly where to go. And when you get there, just step out. Payment is completely seamless.
            </p>
            <button class="btn" onclick="window.location.href='<?php echo base_url(); ?>customer/login'">
              Customer Sign in <i class="fa fa-angle-right" aria-hidden="true"></i>
            </button>
          </div>
        </div>
      </div>
    </section>
    <section class="inyourcity">
      <div class="container">
        <div class="col-md-6">
          <h2>Locker is in <a href="#"><span class="colo-blue">City</span></a></h2>
          <h3>and 560 other cities worldwide</h3>
          <div class="search_city">
            <input type="text" name="" placeholder="Find a city">
            <button class="btn"><i class="fa fa-check" aria-hidden="true"></i></button>
          </div>
        </div>
      </div>
    </section>
    <!-- Footer -->
    <footer>
      <div class="container">
        <div class="top_btn">
          <div class="col-md-4">
            <h1 class="logo-text">Lock <span class="color-blue">Masters</span></h1>
          </div>
          <div class="col-md-4">
            <button class="bg-white">Signup as Locksmith</button>
          </div>
          <div class="col-md-4">
            <button class="bg-dark">Signup as Customer</button>
          </div>
        </div>
        <div class="footer_links">
          <div class="col-md-4">
            <ul>
              <li><a href="#"><i class="fa fa-map-marker" aria-hidden="true"></i> Enter your Location</a></li>
              <li><a href="#"><i class="fa fa-globe" aria-hidden="true"></i> English</a></li>
              <li><a href="#"><i class="fa fa-life-ring" aria-hidden="true"></i> Help</a></li>
              <li>
                <a href="#"><i class="fa fa-facebook" aria-hidden="true"></i> </a>
                <a href="#"><i class="fa fa-twitter" aria-hidden="true"></i> </a>
                <a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i> </a>
                <a href="#"><i class="fa fa-instagram" aria-hidden="true"></i> </a>
              </li>
            </ul>
          </div>
          <div class="col-md-4">
            <ul>
              <li><a href="#"> Lock</a></li>
              <li><a href="#"> Lock</a></li>
              <li><a href="#"> Lock</a></li>
            </ul>
          </div>
        <div class="col-md-4">
          <ul>
            <li><a href="#"> Lock</a></li>
            <li><a href="#"> Lock</a></li>
            <li><a href="#"> Lock</a></li>
          </ul>
        </div>
        </div>
        <div class="play_btn text-center">
          <a href="#">
            <img src="<?php echo base_url(); ?>assets/img/app-store-8c177b28a0.svg" class="" alt="" >
          </a>
          <a href="#">
            <img src="<?php echo base_url(); ?>assets/img/en_badge_web_generic.png" >
          </a>
        </div>
        <div class="copyright">
          <div class="col-md-4">
            <p>Â© 2017 LockMasters Technologies Inc.</p>
          </div>
          <div class="col-md-4">
            <a href="#">Privacy</a>
          </div>
          <div class="col-md-4">
            <a href="#">Terms</a>
          </div>
        </div>
      </div>
    </footer>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/custom.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
  </body>
</html>