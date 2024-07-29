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

    <section class="login-form">
      <div class="wrap_form">
        <h2 class="text-center logo">
          LOCK <span class="color-blue">MASTER</span>
        </h2>

        <p class="bar_design"><span>Forgot Password</span></p>

        <form role="form" action="<?php echo base_url(); ?>user/forgotpassword" method="post">
          <?php
            if ( isset( $success ) && !empty( $success ) ) {
              echo "<div class='alert alert-success' style='overflow:hidden;'>".$success."</div>";
            }
          ?>
          <div class="form-group">
            <input type="email" name="email" placeholder="Email Address" autofocus value="<?php if(isset($_POST['email'])&&!empty($_POST['email'])){echo $_POST['email'];}?>">
            <?php if ( form_error('email') ) : ?>
              <div class="alert alert-danger">
                <?php echo form_error('email'); ?>
              </div>
            <?php endif; ?>
            <?php
              if ( isset( $error ) && !empty( $error ) ) {
                echo "<div class='alert alert-danger'>".$error."</div>";
              }
            ?>
          </div>
          <div class="form-group btn_login">
            <input type="submit" name="" value="SUBMIT">
          </div>
        </form>
        <hr>
      </div>
    </section>

    <script src="//ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/custom.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
  </body>
</html>