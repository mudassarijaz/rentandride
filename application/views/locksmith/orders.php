<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">Orders</h1>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-12">
      <div class="panel panel-default">
        <div class="panel-heading">
            All Orders
        </div>
        <div class="panel-body">
          <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="locksmithorder-dataTables">
            <thead>
              <tr>
                <th>ID</th>
                <th>Customer</th>
                <th>Type</th>
                <th>Price</th>
                <th>Evening</th>
                <th>Weekend</th>
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