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
          <h3 class="panel-title">Add New Price</h3>
        </div>
        <div class="panel-body">
          <form role="form" action="<?php echo base_url(); ?>locksmith/addprice" method="post">
            <fieldset>
              <div class="form-group">
                <label>Price</label>
                <input type="text" class="form-control" id="price" name="price" placeholder="Enter Your Price" value="<?php if(isset($_POST['price'])&&!empty($_POST['price'])){echo $_POST['price'];} ?>" autofocus>
                <?php if ( form_error('price') ) : ?>
                  <div class="help-block with-errors"><?php echo form_error('price'); ?></div>
                <?php endif; ?>
              </div>
              <div class="form-group">
                <label>Type</label>
                <select class="form-control" name="type_id" id="type_id">
                  <?php if ( count( $types ) > 0 ) { ?>
                    <?php foreach ( $types as $type ) { ?>
                      <option value="<?php echo $type['id']; ?>"><?php echo $type['name']; ?></option>
                    <?php } ?>
                  <?php } ?>
                </select>
              </div>
              <div class="form-group">
                <label>Evening Price Method</label>
                <select class="form-control" name="eve_method" id="eve_method">
                  <option value="plus">Plus</option>
                  <option value="percent">Percentage</option>
                </select>
              </div>
              <div class="form-group">
                <label>Evening Price</label>
                <input type="text" class="form-control" id="eve_price" name="eve_price" placeholder="Enter Your Evening Price" value="<?php if(isset($_POST['eve_price'])&&!empty($_POST['eve_price'])){echo $_POST['eve_price'];} ?>">
              </div>
              <div class="form-group">
                <label>Weekend Price Method</label>
                <select class="form-control" name="week_method" id="week_method">
                  <option value="plus">Plus</option>
                  <option value="percent">Percentage</option>
                </select>
              </div>
              <div class="form-group">
                <label>Weekend Price</label>
                <input type="text" class="form-control" id="week_price" name="week_price" placeholder="Enter Your Weekend Price" value="<?php if(isset($_POST['week_price'])&&!empty($_POST['week_price'])){echo $_POST['week_price'];} ?>">
              </div>
              <!-- Change this to a button or input when using this as a form -->
              <input type="submit" class="btn btn-success" value="Submit">
              <a href="/locksmith/price" id="cancel" name="cancel" class="btn btn-default">Cancel</a>
            </fieldset>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>