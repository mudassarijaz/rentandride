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
          <form action="<?php echo base_url(); ?>admin/password" method="post" enctype="multipart/form-data">
            <fieldset>
              <div class="form-group">
                <label>Current Password</label>
                <input type="password" class="form-control" name="old_pass" autofocus />
              </div>
              <div class="form-group">
                <label>New Password</label>
                <input type="password" class="form-control" name="new_pass" />
              </div>
              <div class="form-group">
                <label>Confirm New Password</label>
                <input type="password" class="form-control" name="con_new_pass" />
              </div>
              <!-- Change this to a button or input when using this as a form -->
              <input type="submit" class="btn btn-success" value="Submit">
              <a href="/admin" id="cancel" name="cancel" class="btn btn-default">Cancel</a>
            </fieldset>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>