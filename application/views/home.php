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
                <button class="bg-white" onclick="window.location.href='<?php echo base_url(); ?>locksmith/signup'">Signup as Locksmith </button>
                <button class="bg-dark" onclick="window.location.href='<?php echo base_url(); ?>customer/signup'">Signup as Customer</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </header>

    <section class="top_section">
      <div class="container">
        <div class="col-md-6 first_top">
          <div class="main_title">
            <h1>GET YOU LOCKS</h1>
            <h3>fixed by professionals near you</h3>
          </div>
        </div>
        <div class="col-md-6 sec_top">
          <div class="form_main">
            <div class="become">
              <div class="img_form">
                <img src="<?php echo base_url(); ?>assets/img/rim-lock.png"> 
              </div>
              <div class="text_form">
                <h3> Customer</h3>
                <span><a href="<?php echo base_url(); ?>customer/signup">Sign Up <i class="fa fa-angle-right" aria-hidden="true"></i></a></span>
              </div>   
            </div>
            <div class="or_opt">
              <span>OR</span>
            </div>
            <div class="become">
              <div class="img_form">
                <img src="<?php echo base_url(); ?>assets/img/rim-lock.png"> 
              </div>
              <div class="text_form">
                <h3> Locksmith</h3>
                <span><a href="<?php echo base_url(); ?>locksmith/signup">Sign Up <i class="fa fa-angle-right" aria-hidden="true"></i></a></span>
              </div>   
            </div>
            <form action="<?php echo base_url(); ?>" method="post">
              <div class="field first">
                <div class="col-md-6 no-padding">
                  <input type="text" name="name[]" placeholder="First Name">
                </div>
                <div class="col-md-6 no-padding">
                  <input type="text" name="name[]" placeholder="Last Name">
                </div>
              </div>
              <div class="field">
                <input type="email" name="email" placeholder="Email">
              </div>
              <div class="field">
                <input type="password" name="password" placeholder="Create Password">
              </div>
              <div class="field">
                <input type="text" name="contact_no" placeholder="Phone">
              </div>
              <div class="field">
                <input type="text" name="city" placeholder="City">
              </div>
              <div class="field">
                <input type="text" name="invite_code" placeholder="Invite Code (Optional)">
              </div>
              <div class="field">
                <input type="Submit" name="submit" value="SIGN UP TO LOCK">
              </div>
              <div class="field">
                <P>Or <a href="<?php echo base_url(); ?>customer/signup">sign up</a> with your Customer account.</P>
              </div>
              <div class="field">
                <span>
                  By proceeding, I agree that Working or its representatives may contact me by email, phone, or SMS (including by automatic telephone dialing system) at the email address or number I provide, including for marketing purposes. I have read and understand the relevant.
                </span>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>

    <section class="banner-top">
      <div class="overlay_need"></div>
      <div class="container"></div>
    </section>

    <section class="offers">
      <div class="container">
        <div class="col-md-4">
          <div class="offer_wrap">
            <div class="image_offer">
              <img src="<?php echo base_url(); ?>assets/img/lock-unlock-icon.png">
            </div>
            <div class="text-offer">
              <h2>Easiest way around</h2>
              <p>
                One tap and a car comes directly to you. Hop inâ€”your Working knows exactly where to go. And when you get there, just step out. Payment is completely seamless.
              </p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="offer_wrap">
            <div class="image_offer">
              <img src="<?php echo base_url(); ?>assets/img/lock-unlock-icon.png">
            </div>
            <div class="text-offer">
              <h2>Easiest way around</h2>
              <p>
                One tap and a car comes directly to you. Hop inâ€”your Working knows exactly where to go. And when you get there, just step out. Payment is completely seamless.
              </p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="offer_wrap">
            <div class="image_offer">
              <img src="<?php echo base_url(); ?>assets/img/lock-unlock-icon.png">
            </div>
            <div class="text-offer">
              <h2>Easiest way around</h2>
              <p>
                One tap and a car comes directly to you. Hop inâ€”your Working knows exactly where to go. And when you get there, just step out. Payment is completely seamless.
              </p>
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="offer_btn">
            <button class="btn">
              Reason To Customer <i class="fa fa-angle-right" aria-hidden="true"></i>
            </button>
          </div>
        </div>
      </div>
    </section>

    <section class="driver_need">
      <div class="overlay_need"></div>
      <div class="container">
        <h2>Working when you want</h2>       
        <h3>Make what you need</h3> 
        <p>
          Working with Locksmith is flexible and rewarding, helping Working meet their career and financial goals.
        </p>
        <button class="btn"> Reason To Working <i class="fa fa-angle-right" aria-hidden="true"></i></button>
      </div>
    </section>

    <section class="free-estimate">
      <div class="container">
        <div class="col-md-5 no-padding">
          <div class="estimated">
            <h3>Pricing</h3>
            <h2>Get locksmith estimate</h2>

            <div class="wrap_fields">
              <div class="fare-estimate"></div>
              <div class="fieds_input">
                <div class="first_field">
                  <input type="" name="" placeholder="Enter pickup Location">
                  <div class="location_pick">
                    <a href="#"><i class="fa fa-location-arrow" aria-hidden="true"></i></a>
                  </div>
                </div>
                <div class="sec_field">
                  <input type="" name="" placeholder="Lock type">
                  <div class="submit_locate">
                    <a href="#"><i class="fa fa-check" aria-hidden="true"></i></a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-7">
          <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d5183934.613098158!2d7.479783551757793!3d50.62306559855753!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2suk!4v1490288734399" width="100%" height="500" frameborder="0" style="border:0" allowfullscreen></iframe>
        </div>
      </div>
    </section>

    <section class="app_interface">
      <div class="container">
        <div class="col-md-8 no-padding">
          <img src="<?php echo base_url(); ?>assets/img/desk.jpg">
        </div>
        <div class="col-md-4 no-padding bg-white">
          <div class="app_text">
            <h3>The new app</h3>
            <h2>Gets you there faster</h2>
            <p>The updated Locksmith app is rolling out now to cities around the world. And itâ€™s filled with new features that make getting where you want to go faster and easier.</p>

            <button class="btn"> Reason To Working <i class="fa fa-angle-right" aria-hidden="true"></i></button>
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
            <button class="bg-white" onclick="window.location.href='<?php echo base_url(); ?>locksmith/signup'">Signup as Locksmith</button>
          </div>
          <div class="col-md-4">
            <button class="bg-dark" onclick="window.location.href='<?php echo base_url(); ?>customer/signup'">Signup as Customer</button>
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