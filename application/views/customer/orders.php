<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="col-md-9 right_content">
  <div class="title_main">
    <h2>My Orders</h2>
  </div>

  <div class="trip_table">
  <table class="table table-hover table-responsive" id="admin_table">
    <thead>
      <tr>
        <th></th>
        <th>Pickup</th>
        <th>Locksmith</th>
        <th>Cost</th>
        <th>Lock Type</th>
        <th>City</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ( $orders as $order ) { ?>
        <tr class="view_profile">
          <td>
            <div class="btn_profile">
              <span class="dark-btn"><i class="fa fa-angle-right" aria-hidden="true"></i></span>
              <span class="red-btn"><i class="fa fa-angle-down" aria-hidden="true"></i></span>
            </div>
          </td>
          <td class="number"><?php echo date("m/d/Y", strtotime($order['start_date'])); ?></td>
          <td><?php echo $order['locksmith_name']; ?></td>
          <td class="number">USD<?php echo $order['price'] + $order['evening'] + $order['weekend']; ?></td>
          <td><?php echo $order['type_name']; ?></td>
          <td><?php echo $order['city']; ?></td>
          <td><i class="fa fa-credit-card" aria-hidden="true"></i> <i class="fa fa-ellipsis-h" aria-hidden="true"></i></td>
        </tr>
      <tr class="admin_profile">
        <td colspan="7 ">
          <div class="info-wrapper view_profile_per">
            <div class="col-md-4  profile_img ">
              <iframe src="https://www.google.com/maps/embed/v1/place?key=AIzaSyDwSaesn9Cp1cT7N0yrYDRYW0qPpFtVOVA&q=<?php echo str_replace(" ", "+", $order['address']); ?>" width="100%" height="250" frameborder="0" style="border:0" allowfullscreen></iframe>
            </div>
            <div class="col-md-4 profile_info">
              <h2 class="price number">USD<?php echo $order['price'] + $order['evening'] + $order['weekend']; ?></h2>
              <span class="crad_info"><i class="fa fa-credit-card" aria-hidden="true"></i> <i class="fa fa-ellipsis-h" aria-hidden="true"></i></span>
              <div class="date_time text-center">
                <p><span><?php echo date("l", strtotime($order['start_date'])); ?></span>, <span><?php echo date("F", strtotime($order['start_date'])); ?></span> <span class="number"><?php echo date("d, Y", strtotime($order['start_date'])); ?> </span><span class="number"> <?php echo date("g:i", strtotime($order['start_date'])); ?> </span> <?php echo date("A", strtotime($order['start_date'])); ?></p>
              </div>
              <div class="destination">
                <div class="from">
                  <p class="dots_green">
                    <i class="fa fa-dot-circle-o" aria-hidden="true"></i> 
                  </p>
                  <p class="area">
                    <span class="number"><?php echo date("g:i A", strtotime($order['start_date'])); ?></span>
                    <span class="address"><?php echo $order['address']; ?></span>
                  </p>
                </div>
                <div class="from">
                  <p class="dots_red">
                    <i class="fa fa-dot-circle-o" aria-hidden="true"></i> 
                  </p>
                  <p class="area">
                    <span class="number"><?php echo date("g:i A", strtotime($order['end_date'])); ?></span>
                    <SPAN class="address"><?php echo $order['address']; ?></SPAN>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="buttons_detail">
                <div class="select_stars">
                  <i class="fa fa-star-o" aria-hidden="true"></i>
                  <i class="fa fa-star-o" aria-hidden="true"></i>
                  <i class="fa fa-star-o" aria-hidden="true"></i>
                  <i class="fa fa-star-o" aria-hidden="true"></i>
                  <i class="fa fa-star-o" aria-hidden="true"></i>
                </div>
                <div class="rate_btns">
                  <button class="resend_btn"> <span><i class="fa fa-file" aria-hidden="true"></i></span> Resend</button>
                  <button class="resend_btn" onclick="window.location.href='<?php echo base_url(); ?>customer/orderdetail/<?php echo $order['id']; ?>'"> <span><i class="fa fa-search" aria-hidden="true"></i></span> View Detail</button>
                </div>
              </div>
            </div>
          </div>
          </div>
        </td>
      </tr>
      <?php } ?>
      </tbody>
    </table>
  </div>
</div>