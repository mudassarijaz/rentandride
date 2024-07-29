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
    
    <section class="login-form">
      <div class="wrap_form">
        <h2 class="text-center logo">
          LOCK <span class="color-blue">MASTER</span>
        </h2>

        <p class="bar_design"><span>Sign Up As Locksmith</span></p>

        <form role="form" action="<?php echo base_url(); ?>locksmith/signup" method="post">
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
            <?php if ( isset( $usererror ) ) : ?>
              <div class="help-block with-errors" style="color:red;margin-bottom:15px;margin-top:-15px;"><?php echo $usererror; ?></div>
            <?php endif; ?>
          </div>
          <div class="field">
            <input type="password" name="password" placeholder="Create Password">
          </div>
          <div class="field">
            <select name="experience" class="form-control" style="width:100%;padding:8px 18px;font-size:14px;margin-bottom:24px;
    background:#FFFFFF;border:1px solid #E5E5E4;border-radius:0px;outline:none;color:#000000;height:50px;">
              <option value="0">Experience</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
              <option value="6">6</option>
              <option value="7">7</option>
              <option value="8">8</option>
              <option value="9">9</option>
              <option value="10">10</option>
              <option value="11">11</option>
              <option value="12">12</option>
              <option value="13">13</option>
              <option value="14">14</option>
              <option value="15">15</option>
              <option value="16">16</option>
              <option value="17">17</option>
              <option value="18">18</option>
              <option value="19">19</option>
              <option value="20">18</option>
              <option value="21">20+</option>
            </select>
          </div>
          <div class="field">
            <input type="text" name="contact_no" placeholder="Phone">
          </div>
          <div class="field">
            <input type="text" name="city" placeholder="City">
          </div>
          <div class="field">
            <input type="text" name="address" placeholder="Address">
          </div>
          <div class="field">
            <input type="Submit" name="submit" value="SIGN UP TO LOCK">
          </div>
        </form>
        <hr>
      </div>
    </section>

    <style type="text/css">
      header, .inyourcity{
        display: none;
      }
      footer{
        display: none;
      }
    </style>

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