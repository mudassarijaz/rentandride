<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Rent & Ride Administration</title>
    <!-- Stylesheets -->
    <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/metisMenu.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/morris.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/sb-admin-2.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/dataTables.bootstrap.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/dataTables.responsive.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet">
    <!--Favicon-->
    <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/img/images/favicon.ico" type="image/x-icon">
    <link rel="icon" href="<?php echo base_url(); ?>assets/img/images/favicon.ico" type="image/x-icon">
    <!-- Responsive -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
  </head>
  <body>
    <div id="wrapper">
      <?php if ( isset( $_SESSION["logged_in"] ) && !empty( $_SESSION["logged_in"] ) ) { ?>
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand topimagelogo">
                <img src="<?php echo base_url(); ?>assets/img/logofinal.png">
            </a>
          </div>
          <!-- /.navbar-header -->

          <ul class="nav navbar-top-links navbar-right">
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-envelope fa-fw"></i> <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-messages">
                    <li>
                        <a href="#">
                            <div>
                                <strong>John Smith</strong>
                                <span class="pull-right text-muted">
                                    <em>Yesterday</em>
                                </span>
                            </div>
                            <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="#">
                            <div>
                                <strong>John Smith</strong>
                                <span class="pull-right text-muted">
                                    <em>Yesterday</em>
                                </span>
                            </div>
                            <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="#">
                            <div>
                                <strong>John Smith</strong>
                                <span class="pull-right text-muted">
                                    <em>Yesterday</em>
                                </span>
                            </div>
                            <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a class="text-center" href="#">
                            <strong>Read All Messages</strong>
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </li>
                </ul>
                <!-- /.dropdown-messages -->
            </li>
            <!-- /.dropdown -->
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-tasks fa-fw"></i> <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-tasks">
                    <li>
                        <a href="#">
                            <div>
                                <p>
                                    <strong>Task 1</strong>
                                    <span class="pull-right text-muted">40% Complete</span>
                                </p>
                                <div class="progress progress-striped active">
                                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                        <span class="sr-only">40% Complete (success)</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="#">
                            <div>
                                <p>
                                    <strong>Task 2</strong>
                                    <span class="pull-right text-muted">20% Complete</span>
                                </p>
                                <div class="progress progress-striped active">
                                    <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%">
                                        <span class="sr-only">20% Complete</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="#">
                            <div>
                                <p>
                                    <strong>Task 3</strong>
                                    <span class="pull-right text-muted">60% Complete</span>
                                </p>
                                <div class="progress progress-striped active">
                                    <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                                        <span class="sr-only">60% Complete (warning)</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="#">
                            <div>
                                <p>
                                    <strong>Task 4</strong>
                                    <span class="pull-right text-muted">80% Complete</span>
                                </p>
                                <div class="progress progress-striped active">
                                    <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                                        <span class="sr-only">80% Complete (danger)</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a class="text-center" href="#">
                            <strong>See All Tasks</strong>
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </li>
                </ul>
                <!-- /.dropdown-tasks -->
            </li>
            <!-- /.dropdown -->
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-bell fa-fw"></i> <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-alerts">
                    <li>
                        <a href="#">
                            <div>
                                <i class="fa fa-comment fa-fw"></i> New Comment
                                <span class="pull-right text-muted small">4 minutes ago</span>
                            </div>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="#">
                            <div>
                                <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                                <span class="pull-right text-muted small">12 minutes ago</span>
                            </div>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="#">
                            <div>
                                <i class="fa fa-envelope fa-fw"></i> Message Sent
                                <span class="pull-right text-muted small">4 minutes ago</span>
                            </div>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="#">
                            <div>
                                <i class="fa fa-tasks fa-fw"></i> New Task
                                <span class="pull-right text-muted small">4 minutes ago</span>
                            </div>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="#">
                            <div>
                                <i class="fa fa-upload fa-fw"></i> Server Rebooted
                                <span class="pull-right text-muted small">4 minutes ago</span>
                            </div>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a class="text-center" href="#">
                            <strong>See All Alerts</strong>
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </li>
                </ul>
                <!-- /.dropdown-alerts -->
            </li>
            <!-- /.dropdown -->
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <?php if ( isset( $_SESSION["level"] ) && $_SESSION["level"] == 1 ) { ?>
                      <li><a href="<?php echo base_url(); ?>admin/edit"><i class="fa fa-user fa-fw"></i> Edit Profile</a></li>
                      <li><a href="<?php echo base_url(); ?>admin/password"><i class="fa fa-gear fa-fw"></i> Change Password</a></li>
                    <?php } else if ( isset( $_SESSION["level"] ) && $_SESSION["level"] == 2 ) { ?>
                      <li><a href="<?php echo base_url(); ?>locksmith/edit"><i class="fa fa-user fa-fw"></i> Edit Profile</a></li>
                      <li><a href="<?php echo base_url(); ?>locksmith/password"><i class="fa fa-gear fa-fw"></i> Change Password</a></li>
                    <?php } ?>
                    <li><a href="<?php echo base_url(); ?>user/logout"><i class="fa fa-sign-out fa-fw"></i> Logout</a></li>
                </ul>
                <!-- /.dropdown-user -->
            </li>
            <!-- /.dropdown -->
          </ul>
          <!-- /.navbar-top-links -->

          <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <!--
                    <li class="sidebar-search">
                        <div class="input-group custom-search-form">
                            <input type="text" class="form-control" placeholder="Search...">
                            <span class="input-group-btn">
                            <button class="btn btn-default" type="button">
                                <i class="fa fa-search"></i>
                            </button>
                        </span>
                        </div>
                    </li>
                    -->
                    <!--
                    <li>
                        <a href="index.html"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Charts<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="flot.html">Flot Charts</a>
                            </li>
                            <li>
                                <a href="morris.html">Morris.js Charts</a>
                            </li>
                        </ul>
                    </li>
                    -->
                    <?php if ( isset( $_SESSION["level"] ) && $_SESSION["level"] == 1 ) { ?>
                      <li>
                        <a href="<?php echo base_url(); ?>admin"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                      </li>
                      <li>
                        <a href="<?php echo base_url(); ?>admin/profile"><i class="fa fa-user-circle fa-fw"></i> My Profile</a>
                      </li>
                     <!--  <li>
                        <a href="<?php echo base_url(); ?>admin/locksmith"><i class="fa fa-table fa-fw"></i> Locksmith</a>
                      </li> -->
                      <li>
                        <a href="<?php echo base_url(); ?>admin/customer"><i class="fa fa-user fa-fw"></i> Customers</a>
                      </li>
                      <li>
                        <a href="<?php echo base_url(); ?>admin/bike"><i class="fa fa-bicycle fa-fw"></i> Bikes</a>
                      </li>
                      <li>
                        <a href="<?php echo base_url(); ?>admin/rides"><i class="fa fa-shopping-cart fa-fw"></i> Rides </a>
                      </li>
                      <li>
                        <a href="<?php echo base_url(); ?>admin/reviews"><i class="fa fa-edit fa-fw"></i> Reviews</a>
                      </li>
                     <!--  <li>
                        <a href="<?php echo base_url(); ?>admin/pages"><i class="fa fa-file-text fa-fw"></i> Pages</a>
                      </li> -->
                   <!--    <li>
                        <a href="<?php echo base_url(); ?>admin/coupons"><i class="fa fa-tags fa-fw"></i> Coupons</a>
                      </li>
                      <li>
                        <a href="<?php echo base_url(); ?>admin/promotions"><i class="fa fa-bullhorn fa-fw"></i> Promotions</a>
                      </li>
                      <li>
                        <a href="<?php echo base_url(); ?>admin/transactions"><i class="fa fa-credit-card fa-fw"></i> Transactions</a>
                      </li> -->
                      <!--
                      <li>
                        <a href="<?php echo base_url(); ?>admin/services"><i class="fa fa-bullhorn fa-fw"></i> Services</a>
                      </li>
                      -->
                    <?php } else if ( isset( $_SESSION["level"] ) && $_SESSION["level"] == 2 ) { ?>
                      <li>
                        <a href="<?php echo base_url(); ?>locksmith"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                      </li>
                      <li>
                        <a href="<?php echo base_url(); ?>locksmith/profile"><i class="fa fa-user fa-fw"></i> My Profile</a>
                      </li>
                      <li>
                        <a href="<?php echo base_url(); ?>locksmith/customer"><i class="fa fa-table fa-fw"></i> Customers</a>
                      </li>
                      <li>
                        <a href="<?php echo base_url(); ?>locksmith/price"><i class="fa fa-edit fa-fw"></i> Prices</a>
                      </li>
                      <li>
                        <a href="<?php echo base_url(); ?>locksmith/orders"><i class="fa fa-shopping-cart fa-fw"></i> Orders</a>
                      </li>
                      <li>
                        <a href="<?php echo base_url(); ?>locksmith/reviews"><i class="fa fa-signal fa-fw"></i> Reviews</a>
                      </li>
                      <li>
                        <a href="<?php echo base_url(); ?>locksmith/transactions"><i class="fa fa-credit-card fa-fw"></i> Transactions</a>
                      </li>
                    <?php } ?>
                    <!--
                    <li>
                        <a href="#"><i class="fa fa-wrench fa-fw"></i> UI Elements<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="panels-wells.html">Panels and Wells</a>
                            </li>
                            <li>
                                <a href="buttons.html">Buttons</a>
                            </li>
                            <li>
                                <a href="notifications.html">Notifications</a>
                            </li>
                            <li>
                                <a href="typography.html">Typography</a>
                            </li>
                            <li>
                                <a href="icons.html"> Icons</a>
                            </li>
                            <li>
                                <a href="grid.html">Grid</a>
                            </li>
                        </ul>
                    </li>
                    -->
                    <!--
                    <li>
                        <a href="#"><i class="fa fa-sitemap fa-fw"></i> Multi-Level Dropdown<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="#">Second Level Item</a>
                            </li>
                            <li>
                                <a href="#">Second Level Item</a>
                            </li>
                            <li>
                                <a href="#">Third Level <span class="fa arrow"></span></a>
                                <ul class="nav nav-third-level">
                                    <li>
                                        <a href="#">Third Level Item</a>
                                    </li>
                                    <li>
                                        <a href="#">Third Level Item</a>
                                    </li>
                                    <li>
                                        <a href="#">Third Level Item</a>
                                    </li>
                                    <li>
                                        <a href="#">Third Level Item</a>
                                    </li>
                                </ul>
                                
                            </li>
                        </ul>
                        
                    </li>
                    -->
                    <!--
                    <li>
                        <a href="#"><i class="fa fa-files-o fa-fw"></i> Sample Pages<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="blank.html">Blank Page</a>
                            </li>
                            <li>
                                <a href="login.html">Login Page</a>
                            </li>
                        </ul>
                    </li>
                    -->
                </ul>
            </div>
          </div>
        </nav>
 <div class="overlayleft"></div>
        <div class="rightbar">
            <p class="closebar">
               <i class="fa fa-times"></i> 
            </p>
           

            <div class="datawarpper">
                <h3>Ride Detail </h3>
                <div class="tabledata">
                <table border="1" width="100%">
                     <tr>
                        <td><b>Data ID</b></td>
                        <td class="dataid"></td>
                    </tr>
                    <tr>
                        <td><b>Customer Name</b></td>
                        <td class="custname"></td>
                    </tr>
                    
                    <tr>
                        <td><b>Status</b></td>
                        <td class="status"></td>
                    </tr>
                     <tr>
                        <td><b>Start Date & Time</b></td>
                        <td class="stdate"></td>
                    </tr>
                      <tr>
                        <td><b>End Date & Time</b></td>
                        <td class="endate"></td>
                    </tr>
                    <tr>
                        <td><b>Start Address</b></td>
                        <td class="staddress"></td>
                    </tr>
                     <tr>
                        <td><b>End Address</b></td>
                        <td class="endaddress"></td>
                    </tr>
                   
                     <tr>
                        <td><b>Ride  Time</b></td>
                        <td class="ridetime"></td>
                    </tr>
                     <tr>
                        <td><b>Distance</b></td>
                        <td class="distance"></td>
                    </tr>
                      <tr>
                        <td><b>Calories</b></td>
                        <td class="calories"></td>
                    </tr>
                      <tr>
                        <td><b>Carbon KG</b></td>
                        <td class="carbon"></td>
                    </tr>
                    <tfoot>
                           <tr>
                        <td><b>Estimated Price</b></td>
                        <td class="price"></td>
                    </tr>

                    </tfoot>

                </table>
            </div>
            </div>
        </div>


      <?php } ?>