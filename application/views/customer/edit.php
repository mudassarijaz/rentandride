<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="col-md-9 right_content">
  <div class="title_main">
    <h2>Profile</h2>
  </div>
  <div class="tag_line">
    <h4>Edit</h4>
  </div>
  <div class="main_form">
    <?php if ( isset($success) && !empty($success) ) { ?>
      <div class='alert alert-success' style='overflow:hidden;'><?php echo $success; ?></div>
    <?php } ?>
    <form action="<?php echo base_url(); ?>customer/edit" method="post" enctype="multipart/form-data">
      <div class="col-md-12 no-padding border_bottom">
        <div class="col-md-2 no-padding">
          <label class="control-label">First Name</label>    
        </div>
        <div class="col-md-4">
          <?php $name = explode(' ', $user->name); ?>
          <input type="text" name="name[]" value="<?php echo $name[0]; ?>" />
        </div>
        <div class="col-md-2 no-padding">
          <label class="control-label">Last Name</label>    
        </div>
        <div class="col-md-4">
          <input type="text" name="name[]" value="<?php echo $name[1]; ?>" />
        </div>
      </div>
      <div class="col-md-12 no-padding border_bottom">
        <div class="col-md-2 no-padding">
          <label class="control-label">Email</label>    
        </div>
        <div class="col-md-4">
          <input type="email" name="email" value="<?php echo $user->email; ?>" />
        </div>
        <div class="col-md-2 no-padding">
          <label class="control-label">Phone</label>    
        </div>
        <div class="col-md-4">
          <input type="text" name="contact_no" value="<?php echo $user->contact_no; ?>" />
        </div>
      </div>
      <div class="col-md-12 no-padding border_bottom">
        <div class="col-md-2 no-padding">
          <label class="control-label">City</label>    
        </div>
        <div class="col-md-4">
          <input type="text" name="city" value="<?php echo $user->city; ?>" />
        </div>
        <div class="col-md-2 no-padding">
          <label class="control-label">Address</label>    
        </div>
        <div class="col-md-4">
          <textarea name="address"><?php echo $user->address; ?></textarea>
        </div>
      </div>

      <div class="col-md-12 no-padding border_bottom">
        <div class="col-md-2 no-padding photo_text">
          <label class="control-label">Photo</label>    
        </div>
        <div class="col-md-4">
          <input type="file" name="image" />
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