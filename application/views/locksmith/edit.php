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
          <h3 class="panel-title">Edit Profile</h3>
        </div>
        <div class="panel-body">
          <form action="<?php echo base_url(); ?>locksmith/edit" method="post" enctype="multipart/form-data">
            <fieldset>
              <div class="form-group">
                <label>First Name</label>
                <?php $name = explode(' ', $user->name); ?>
                <input type="text" class="form-control" name="name[]" value="<?php echo $name[0]; ?>" autofocus />
              </div>
              <div class="form-group">
                <label>Last Name</label>
                <input type="text" class="form-control" name="name[]" value="<?php echo $name[1]; ?>" />
              </div>
              <div class="form-group">
                <label>Email</label>
                <input type="email" class="form-control" name="email" value="<?php echo $user->email; ?>" />
              </div>
              <div class="form-group">
                <label>Phone Number</label>
                <input type="text" class="form-control" name="contact_no" value="<?php echo $user->contact_no; ?>" />
              </div>
              <div class="form-group">
                <label>City</label>
                <input type="text" class="form-control" name="city" value="<?php echo $user->city; ?>" />
              </div>
              <div class="form-group">
                <label>Address</label>
                <textarea class="form-control" name="address"><?php echo $user->address; ?></textarea>
              </div>
              <div class="form-group">
                <label>Photo</label>
                <input type="file" class="form-control" name="image" />
              </div>
              <!-- Change this to a button or input when using this as a form -->
              <input type="submit" class="btn btn-success" value="Submit">
              <a href="/locksmith" id="cancel" name="cancel" class="btn btn-default">Cancel</a>
            </fieldset>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>