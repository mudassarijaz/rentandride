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
          <h3 class="panel-title">Add New Service</h3>
        </div>
        <div class="panel-body">
          <form role="form" action="<?php echo base_url(); ?>admin/addtype" method="post">
            <fieldset>
              <div class="form-group">
                <label for="name">Service</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Service" value="<?php if(isset($_POST['name'])&&!empty($_POST['name'])){echo $_POST['name'];} ?>" autofocus>
              </div>
              <div class="form-group">
                <label for="price">Customer Price</label>
                <input type="text" class="form-control" id="price" name="price" placeholder="Enter Customer Price" value="<?php if(isset($_POST['price'])&&!empty($_POST['price'])){echo $_POST['price'];} ?>" >
              </div>
              <div class="form-group">
                <label for="locksmithprice">Locksmith Price</label>
                <input type="text" class="form-control" id="locksmithprice" name="locksmithprice" placeholder="Enter Locksmith Price" value="<?php if(isset($_POST['locksmithprice'])&&!empty($_POST['locksmithprice'])){echo $_POST['locksmithprice'];} ?>" >
              </div>
              <!-- Change this to a button or input when using this as a form -->
              <input type="submit" class="btn btn-success " value="Submit">
              <a href="/admin/types" id="cancel" name="cancel" class="btn btn-default">Cancel</a>
            </fieldset>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>