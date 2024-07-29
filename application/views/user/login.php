<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container">
  <div class="row">
    <div class="col-md-4 col-md-offset-4 loginform">
      <div class="logomain">
        <img src="<?php echo base_url(); ?>assets/img/logofinal.png">
      </div>
      <div class="login-panel panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">Please Sign In</h3>
        </div>
        <div class="panel-body">
          <form role="form" action="<?php echo base_url(); ?>user/login" method="post">
            <fieldset>
              <div class="form-group">
                <input class="form-control" placeholder="E-mail" name="email" type="email" autofocus>
                <?php if ( isset( $usererror ) ) : ?>
                  <div class="help-block with-errors"><?php echo $usererror; ?></div>
                <?php endif; ?>
              </div>
              <div class="form-group">
                <input class="form-control" placeholder="Password" name="password" type="password" value="">
                <?php if ( form_error('password') ) : ?>
                  <div class="help-block with-errors"><?php echo form_error('password'); ?></div>
                <?php endif; ?>
              </div>
              <div class="checkbox">
                <label>
                  <input name="remember" type="checkbox" value="Remember Me">Remember Me
                </label>
              </div>
              <!-- Change this to a button or input when using this as a form -->
              <input type="submit" class="btn btn-lg btn-success btn-block" value="Login">
            </fieldset>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>