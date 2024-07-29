<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">Rides</h1>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-12">
      <div class="panel panel-default">
        <div class="panel-heading">
            All Rides <!--<span style="float: right;"><a href="<?php //echo base_url(); ?>admin/addorder">Add New Order</a></span>-->
        </div>
        <div class="panel-body">
          <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="adminorder-dataTables">
            <thead>
              <tr>
                <th>ID</th>
               
                <th>Customer</th>
              
                <th>Price</th>
                <th>Address</th>
                <!--<th>Weekend</th>-->
                <th>Status</th>
                <th>Creation Date</th>
                <th>Actions</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>