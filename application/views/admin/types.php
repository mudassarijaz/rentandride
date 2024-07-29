<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">Services</h1>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-12">
      <div class="panel panel-default">
        <div class="panel-heading">
            All Services <span style="float: right;"><a href="<?php echo base_url(); ?>admin/addtype">Add New Service</a></span>
        </div>
        <div class="panel-body">
          <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="admintype-dataTables">
            <thead>
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Customer Price</th>
                <th>Locksmith Price</th>
                <th>Actions</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>