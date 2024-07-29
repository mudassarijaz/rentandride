<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12" style="margin-top: 10px;">
      <div class="panel panel-default">
        <div class="panel-heading">
            Profile <span style="float: right;"><a href="<?php echo base_url(); ?>admin/edit">Edit Profile</a></span>
        </div>
        <div class="panel-body">
          <div class="row">
            <div class="col-md-3 col-lg-3 " align="center">
              <?php if (isset($image)&&!empty($image)) { ?>
                <img alt="User Pic" src="<?php echo base_url(); ?>uploads/user/<?php echo $id . '/' . $image; ?>" class="img-circle img-responsive" />
              <?php } else { ?>
                <img alt="User Pic" src="<?php echo base_url(); ?>assets/img/person.jpg" class="img-circle img-responsive" />
              <?php } ?>
            </div>
            <div class=" col-md-9 col-lg-9 "> 
              <table class="table table-user-information">
                <tbody>
                  <tr>
                    <td>Name:</td>
                    <td><?php echo $name; ?></td>
                  </tr>
                  <tr>
                    <td>Email:</td>
                    <td><?php echo $email; ?></td>
                  </tr>
                  <tr>
                    <td>Phone</td>
                    <td><?php echo $contact_no; ?></td>
                  </tr>
                  <tr>
                    <td>City</td>
                    <td><?php echo $city; ?></td>
                  </tr>
                    <tr>
                    <td>Address</td>
                    <td><?php echo $address; ?></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>