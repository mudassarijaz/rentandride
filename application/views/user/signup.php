<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container">
  <div class="row">
    <div class="col-md-4 col-md-offset-4">
      <div class="login-panel panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">Sign Up</h3>
        </div>
        <div class="panel-body">
          <form role="form" action="<?php echo base_url(); ?>user/signup" method="post">
            <fieldset>
              <div class="form-group">
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Your Name" autofocus>
              </div>
              <div class="form-group">
                <input class="form-control" placeholder="E-mail" name="email" type="email">
                <?php if ( isset( $usererror ) ) : ?>
                  <div class="help-block with-errors"><?php echo $usererror; ?></div>
                <?php endif; ?>
              </div>
              <div class="form-group">
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password">
                <p class="help-block">At least 6 characters</p>
              </div>
              <div class="form-group">
                <input type="password" class="form-control" id="password_confirm" name="password_confirm" placeholder="Confirm your password">
                <p class="help-block">Must match your password</p>
              </div>
              <!-- Change this to a button or input when using this as a form -->
              <input type="submit" class="btn btn-lg btn-success btn-block" value="Submit">
            </fieldset>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>