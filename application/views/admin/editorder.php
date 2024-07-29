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
          <h3 class="panel-title">Edit Order</h3>
        </div>
        <div class="panel-body">
          <form role="form" action="<?php echo base_url(); ?>admin/editorder/<?php echo $orders->id; ?>" method="post">
            <fieldset>
              <div class="form-group">
                <label>Customer</label>
                <select class="form-control" name="customer" id="customer">
                  <option>Select Customer</option>
                  <?php if ( count( $customers ) > 0 ) { ?>
                    <?php foreach ( $customers as $customer ) { ?>
                      <option value="<?php echo $customer['id']; ?>" <?php if($customer['id']==$orders->customer_id){echo "selected";}?>><?php echo $customer['name']; ?></option>
                    <?php } ?>
                  <?php } ?>
                </select>
              </div>
              <div class="form-group">
                <label>Locksmith</label>
                <select class="form-control" name="locksmith" id="locksmith">
                  <option>Select Locksmith</option>
                  <?php if ( count( $locksmiths ) > 0 ) { ?>
                    <?php foreach ( $locksmiths as $locksmith ) { ?>
                      <option value="<?php echo $locksmith['id']; ?>" <?php if($locksmith['id']==$orders->locksmith_id){echo "selected";}?>><?php echo $locksmith['name']; ?></option>
                    <?php } ?>
                  <?php } ?>
                </select>
              </div>
              <div class="form-group">
                <label>Type</label>
                <select class="form-control" name="type_id" id="type_id">
                  <?php if ( count( $types ) > 0 ) { ?>
                    <?php foreach ( $types as $type ) { ?>
                      <option value="<?php echo $type['id']; ?>" <?php if($type['id']==$orders->type_id){echo "selected";}?>><?php echo $type['name']; ?></option>
                    <?php } ?>
                  <?php } ?>
                </select>
              </div>
              <div class="form-group">
                <label>Address</label>
                <input type="text" class="form-control" id="address" name="address" placeholder="Address" value="<?php if(isset($orders->address)&&!empty($orders->address)){echo $orders->address;}elseif(isset($_POST['address'])&&!empty($_POST['address'])){echo $_POST['address'];} ?>">
                <?php if ( form_error('address') ) : ?>
                  <div class="help-block with-errors"><?php echo form_error('address'); ?></div>
                <?php endif; ?>
              </div>
              <div class="form-group">
                <label>Amount</label>
                <input type="text" class="form-control" id="amount" name="amount" placeholder="Enter Your Price" value="<?php if(isset($orders->amount)&&!empty($orders->amount)){echo $orders->amount;}elseif(isset($_POST['amount'])&&!empty($_POST['amount'])){echo $_POST['amount'];} ?>">
                <?php if ( form_error('amount') ) : ?>
                  <div class="help-block with-errors"><?php echo form_error('amount'); ?></div>
                <?php endif; ?>
              </div>
              <div class="form-group">
                <label>Quantity</label>
                <input type="text" class="form-control" id="amount" name="quantity" placeholder="Quantity" value="<?php if(isset($orders->quantity)&&!empty($orders->quantity)){echo $orders->quantity;}elseif(isset($_POST['quantity'])&&!empty($_POST['quantity'])){echo $_POST['quantity'];} ?>">
                <?php if ( form_error('quantity') ) : ?>
                  <div class="help-block with-errors"><?php echo form_error('quantity'); ?></div>
                <?php endif; ?>
              </div>
              <!-- Change this to a button or input when using this as a form -->
              <input type="submit" class="btn btn-success" value="Submit">
              <a href="/admin/orders" id="cancel" name="cancel" class="btn btn-default">Cancel</a>
            </fieldset>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>