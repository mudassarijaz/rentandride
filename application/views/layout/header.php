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
    <link href="<?php echo base_url(); ?>assets/css/dashboard.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="<?php echo base_url(); ?>assets/css/font-awesome.css" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' >

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body id="page-top" class="index">
    <section class="top_bar">
      <div class="container">
        <div class=" logo_warp">
          <a href="#" class="col-md-6">
            <h1>LOCK<span class="color-blue"> MASTER</span></h1>
          </a>
          <div class="col-md-6">
            <div class="dropdown pull-right header_options">
                <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
                  <i class="fa fa-user-circle" aria-hidden="true"></i> <?php if (isset($_SESSION['name'])&&!empty($_SESSION['name'])) { echo $_SESSION['name']; }?>  
                  <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                  <div class="user_name">
                    <div class="user_img">
                      <?php if (isset($_SESSION['image'])&&!empty($_SESSION['image'])) { ?>
                        <img src="<?php echo base_url(); ?>uploads/user/<?php echo $_SESSION['user_id'] . '/' . $_SESSION['image']; ?>" >
                      <?php } else { ?>
                        <img src="<?php echo base_url(); ?>assets/img/person.jpg" >
                      <?php } ?>
                    </div>
                    <div class="user_title">
                      <h4><?php if (isset($_SESSION['name'])&&!empty($_SESSION['name'])) { echo $_SESSION['name']; }?></h4>
                    </div>
                  </div>
                  <li class="active first"><a href="<?php echo base_url(); ?>customer/orders">My Order</a></li>
                  <li><a href="<?php echo base_url(); ?>customer/edit">Edit Profile</a></li>
                  <li><a href="<?php echo base_url(); ?>customer/password">Change Password</a></li>
                  <li><a href="#">Payment</a></li>
                  <li><a href="#">Free Ride</a></li>
                  <li class="red"><a href="<?php echo base_url(); ?>user/logout">Logout</a></li>
                </ul>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="main_data">
      <div class="container">
        <div class="col-md-3 ">
          <div class="left_sidebar">
            <div class="personal_data text-center">
              <div class="img_person">
                <?php if (isset($_SESSION['image'])&&!empty($_SESSION['image'])) { ?>
                  <img src="<?php echo base_url(); ?>uploads/user/<?php echo $_SESSION['user_id'] . '/' . $_SESSION['image']; ?>" >
                <?php } else { ?>
                  <img src="<?php echo base_url(); ?>assets/img/person.jpg" >
                <?php } ?>
              </div>
              <h3 class="name_client"><?php if (isset($_SESSION['name'])&&!empty($_SESSION['name'])) { echo $_SESSION['name']; }?></h3>
            </div>
            <div class="listing_options">
              <ul>
                <li><a href="<?php echo base_url(); ?>customer/orders">My Orders</a></li>
                <li><a href="<?php echo base_url(); ?>customer">profile</a></li>
                <li><a href="#">payment</a></li>
                <li><a href="#">Free</a></li>
                <li><a href="#">Drive</a></li>
                <li><a href="<?php echo base_url(); ?>user/logout">Log Out</a></li>
              </ul>
              <div class="search_icon">
                <i class="fa fa-search" aria-hidden="true"></i>
              </div>
              <div class="lost_something">
                <a href="" class="lost_lnk">Lost Something?</a>
                <span>Check Out lockmaster.com/lost</span>
              </div>
            </div>
          </div>
        </div>
   

