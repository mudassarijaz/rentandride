<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="col-md-9 right_content">
  <div class="title_main">
    <h2>Profile</h2>
  </div>
  <div class="tag_line">
    <h4>General Information</h4>
  </div>
  <?php if($verified == 0){ ?>
    <div class='alert alert-danger' style='margin:10px 0;overflow:hidden;'>Your email is not verified. Please verify it by clicking the link in the email we have sent you.</div>
  <?php } ?>
  <div class="main_form">
    <form>
      <div class="col-md-12 no-padding border_bottom">
        <div class="col-md-2 no-padding">
          <label class="control-label">Name</label>    
        </div>
        <div class="col-md-4">
          <p><?php echo $name; ?></p>
        </div>
        <div class="col-md-2 no-padding">
          <label class="control-label">Address</label>    
        </div>
        <div class="col-md-4">
            <p><?php echo $address; ?></p>
        </div>
      </div>
      <div class="col-md-12 no-padding border_bottom">
        <div class="col-md-2 no-padding photo_text">
          <label class="control-label">Photo</label>    
        </div>
        <div class="col-md-4">
          <div class="img_form">
            <?php if( !empty($image) ) { ?>
              <img src="<?php echo base_url(); ?>uploads/user/<?php echo $id . '/' . $image; ?>">
            <?php } else { ?>
              <img src="<?php echo base_url(); ?>assets/img/person.jpg">
            <?php } ?>
          </div>
        </div>
        <div class="col-md-2 no-padding">
          <label class="control-label">Mobile</label>    
        </div>
        <div class="col-md-4 num_field">
          <!--<p>Pakistan +92</p>-->
          <p><?php echo $contact_no; ?></p>
        </div>
      </div>
      <div class="col-md-12 no-padding border_bottom">
<!--
        <div class="col-md-2 no-padding">
          <label class="control-label">Language</label>    
        </div>
        <div class="col-md-4">
          <select class="form-control">
            <option>English</option>
            <option>Pakistan</option>
            <option>Pakistan</option>
            <option>Pakistan</option>
          </select>
        </div>
-->
        <div class="col-md-2 no-padding">
          <label class="control-label">Invite Code</label>    
        </div>
        <div class="col-md-4">
          <p> Mudassir99ue <span class="pull-right"><a href="#">Customize</a></span></p>
        </div>
      </div>
      <div class="col-md-12 no-padding border_bottom">
        <div class="col-md-2 no-padding">
          <label class="control-label">Email Address</label>    
        </div>
        <div class="col-md-4">
          <p><?php echo $email; ?></p>
        </div>
      </div>
        <!--
      <div class="col-md-12 no-padding border_bottom">
        <div class="btn-submit text-center">
          <button class="btn-submit">Submit</button>
        </div>
      </div>
        -->
    </form>
  </div>
</div>