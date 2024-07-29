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
          <h3 class="panel-title">Edit Review</h3>
        </div>
        <div class="panel-body">
          <form role="form" action="<?php echo base_url(); ?>admin/editreview/<?php echo $reviews->id; ?>" method="post">
            <fieldset>
            
              <div class="form-group">
                <label>Rating</label>
                <select class="form-control" name="rating" id="rating">
                  <option value="1" <?php if($reviews->rating==1){echo "selected";}?>>1</option>
                  <option value="2" <?php if($reviews->rating==2){echo "selected";}?>>2</option>
                  <option value="3" <?php if($reviews->rating==3){echo "selected";}?>>3</option>
                  <option value="4" <?php if($reviews->rating==4){echo "selected";}?>>4</option>
                  <option value="5" <?php if($reviews->rating==5){echo "selected";}?>>5</option>
                </select>
              </div>

              <div class="form-group">
                <label>Review</label>
                <textarea type="text" class="form-control" id="review" name="review" placeholder="Add Review"><?php if(isset($reviews->review)&&!empty($reviews->review)){echo $reviews->review;}elseif(isset($_POST['review'])&&!empty($_POST['review'])){echo $_POST['review'];} ?></textarea>
                <?php if ( form_error('review') ) : ?>
                  <div class="help-block with-errors"><?php echo form_error('review'); ?></div>
                <?php endif; ?>
              </div>
             
              <!-- Change this to a button or input when using this as a form -->
              <input type="submit" class="btn btn-success" value="Submit">
              <a href="/admin/reviews" id="cancel" name="cancel" class="btn btn-default">Cancel</a>
            </fieldset>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>