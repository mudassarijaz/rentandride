<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="page-wrapper">
  <div class="row">
    <?php if (isset($error)) : ?>
      <div class="col-md-8 col-md-offset-3">
        <div class="alert alert-danger" role="alert">
          <?php echo $error; ?>
        </div>
      </div>
    <?php endif; ?>
    <?php if (isset($success)) : ?>
      <div class="col-md-8 col-md-offset-3">
        <div class="alert alert-success" role="alert">
          <?php echo $success; ?>
        </div>
      </div>
    <?php endif; ?>
    <div class="col-md-8 col-md-offset-3">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">Edit</h3>
        </div>
        <div class="panel-body">
          <form role="form" action="<?php echo base_url(); ?>admin/editcustomer/<?php echo $id; ?>" method="post">
            <fieldset>
              <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Your Name" value="<?php if(isset($name)&&!empty($name)){echo $name;}elseif(isset($_POST['name'])&&!empty($_POST['name'])){echo $_POST['name'];} ?>" autofocus>
              </div>
              <div class="form-group">
                <label for="email">E-mail</label>
                <input class="form-control" placeholder="E-mail" name="email" type="email" value="<?php if(isset($email)&&!empty($email)){echo $email;}elseif(isset($_POST['email'])&&!empty($_POST['email'])){echo $_POST['email'];} ?>" >
                <?php if ( form_error('email') ) : ?>
                  <div class="help-block with-errors"><?php echo form_error('email'); ?></div>
                <?php endif; ?>
              </div>
              <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" value="<?php if(isset($_POST['password'])&&!empty($_POST['password'])){echo $_POST['password'];} ?>">
                <p class="help-block">At least 6 characters</p>
                <?php if ( form_error('password') ) : ?>
                  <div class="help-block with-errors"><?php echo form_error('password'); ?></div>
                <?php endif; ?>
              </div>
              <div class="form-group">
                <label for="contact_no">Contact Number</label>
                <input type="text" class="form-control" id="contact_no" name="contact_no" placeholder="Contact Number" value="<?php if(isset($contact_no)&&!empty($contact_no)){echo $contact_no;}elseif(isset($_POST['contact_no'])&&!empty($_POST['contact_no'])){echo $_POST['contact_no'];} ?>">
              </div>
              <div class="form-group">
                <label for="address">Address</label>
                <textarea class="form-control" id="address" name="address" placeholder="Enter Address"><?php if(isset($address)&&!empty($address)){echo $address;}elseif(isset($_POST['address'])&&!empty($_POST['address'])){echo $_POST['address'];} ?></textarea>
              </div>
              <!-- Change this to a button or input when using this as a form -->
              <input type="submit" class="btn btn-success" value="Submit">
              <a href="/admin/customer" id="cancel" name="cancel" class="btn btn-default">Cancel</a>
            </fieldset>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>