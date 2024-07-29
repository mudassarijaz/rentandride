<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="col-md-9 right_content">
  <div class="title_main">
    <h2>Profile</h2>
  </div>
  <div class="tag_line">
    <h4>Change Password</h4>
  </div>
  <div class="main_form">
    <?php if ( isset($success) && !empty($success) ) { ?>
      <div class='alert alert-success' style='overflow:hidden;'><?php echo $success; ?></div>
    <?php } ?>
    <form action="<?php echo base_url(); ?>customer/password" method="post">
      <div class="col-md-12 no-padding border_bottom">
        <div class="col-md-2 no-padding">
          <label class="control-label">Current Password</label>    
        </div>
        <div class="col-md-4">
          <input type="password" name="old_pass" />
        </div>
        <div class="col-md-2 no-padding">
          <label class="control-label">New Password</label>    
        </div>
        <div class="col-md-4">
          <input type="password" name="new_pass" />
        </div>
      </div>
      <div class="col-md-12 no-padding border_bottom">
        <div class="col-md-2 no-padding photo_text">
          <label class="control-label">Confirm New Password</label>    
        </div>
        <div class="col-md-4">
          <input type="password" name="con_new_pass" />
        </div>
        
      </div>

      <div class="col-md-12 no-padding border_bottom">
        <div class="btn-submit text-center">
          <button class="btn-submit">Submit</button>
        </div>
      </div>

    </form>
  </div>
</div>