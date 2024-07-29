<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">Transactions</h1>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-12">
      <div class="panel panel-default">
        <div class="panel-heading">
            My Transactions
        </div>
        <div class="panel-body">
          <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="locksmithmytransaction-dataTables">
            <thead>
              <tr>
                <th>ID</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Transaction Month</th>
                <th>Transaction Date</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-12">
      <div class="panel panel-default">
        <div class="panel-heading">
            Customer's Transactions
        </div>
        <div class="panel-body">
          <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="locksmithcusttransaction-dataTables">
            <thead>
              <tr>
                <th>Order ID</th>
                <th>Customer</th>
                <th>Service</th>
                <th>Price</th>
                <th>Status</th>
                <th>Transaction Date</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>