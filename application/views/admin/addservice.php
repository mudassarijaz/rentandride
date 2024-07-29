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
          <form role="form" action="<?php echo base_url(); ?>admin/addservice" method="post">
            <fieldset>
              <div class="form-group">
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="<?php if(isset($_POST['name'])&&!empty($_POST['name'])){echo $_POST['name'];} ?>" autofocus />
              </div>
              <div class="form-group">
                <input type="text" class="form-control" id="price" name="price" placeholder="Enter Price" value="<?php if(isset($_POST['price'])&&!empty($_POST['price'])){echo $_POST['price'];} ?>" />
              </div>
              <!-- Change this to a button or input when using this as a form -->
              <input type="submit" class="btn btn-success" value="Submit">
              <a href="/admin/services" id="cancel" name="cancel" class="btn btn-default">Cancel</a>
            </fieldset>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>