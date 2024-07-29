<div class="col-md-9 right_content">
  <div class="title_main">
    <h2>Your Order</h2>
    <p class="dt_trip"> <span class="number"><?php echo date("g:i", strtotime($start_date)); ?></span> <?php echo date("A", strtotime($start_date)); ?> on <?php echo date("F", strtotime($start_date)); ?> <span class="number"><?php echo date("d, Y", strtotime($start_date)); ?></span></p>
  </div>
  <div class="col-md-12 no-padding text-center view_btn">
    <div class="buttons_detail">
      <div class="rate_btns">
        <button class="resend_btn"> <span><i class="fa fa-binoculars" aria-hidden="true"></i></span>Find the Lost Item</button>
        <button class="resend_btn"> <span><i class="fa fa-life-ring" aria-hidden="true"></i></span>Get a Free Review</button>
        <button class="resend_btn"> <span><i class="fa fa-share" aria-hidden="true"></i></span>Resend Receipt</button>
        <button class="resend_btn"> <span><i class="fa fa-download" aria-hidden="true"></i></span>Receipt Invoice</button>
      </div>
    </div>
  </div>

  <div class="col-md-6 no-padding">
    <div class="map_loct view">
      <iframe src="https://www.google.com/maps/embed/v1/place?key=AIzaSyDwSaesn9Cp1cT7N0yrYDRYW0qPpFtVOVA&q=<?php echo str_replace(" ", "+", $address); ?>" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
      <div class="hourly_dt">
        <div class="destination">
          <div class="from">
            <p class="dots_green"><i class="fa fa-dot-circle-o" aria-hidden="true"></i></p>
            <p class="area">
              <span class="number"><?php echo date("g:i A", strtotime($start_date)); ?></span>
              <span class="address"><?php echo $address; ?></span>
            </p>
          </div>
          <div class="from">
            <p class="dots_red"><i class="fa fa-dot-circle-o" aria-hidden="true"></i></p>
            <p class="area">
              <span class="number"><?php echo date("g:i A", strtotime($end_date)); ?></span>
              <span class="address"><?php echo $address; ?></span>
            </p>
          </div>
        </div>
      </div>
      <div class="col-md-12 no-padding bottom_desc">
        <div class="col-md-4 no-padding text-center">
          <span>CAR</span>
          <span>GO</span>
        </div>
        <div class="col-md-4 text-center">
          <span>kILOMETERS</span>
          <span class="number">7.71</span>
        </div>
        <div class="col-md-4 text-center">
          <span>TRIP TIME</span>
          <span class="number">00:25:00</span>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="fare_break">
      <h3>Cost Breakdown</h3>
    </div>
    <div class="bill">
      <hr>
      <ul>
        <li>Base Cost</li>
        <li class="number"><?php echo $price; ?>.00</li>
        <li>Evening Cost</li>
        <li class="number"><?php echo $evening; ?>.00</li>
        <li>Weekend Cost</li>
        <li class="number"><?php echo $weekend; ?>.00</li>
        <hr>
        <li class="bold text-left">Subtotal</li>
        <li class="bold number text-right">USD <?php echo $price+$evening+$weekend; ?>.00</li>

        <li class="small text-left">Discount</li>
        <li class="small color-blue number text-right">-0.00</li>

        <hr>
         <li class="small">Rounding Price</li>
        <li class="bold subtotal number">USD <?php echo $price+$evening+$weekend; ?>.00</li>
      </ul>
    </div>
  </div>

  <div class="col-md-12 no-padding men_detail">
    <div class="col-md-3">
      <div class="img_form">
        <img src="<?php echo base_url(); ?>assets/img/person.jpg">
      </div>
    </div>
    <div class="col-md-3">
      <h4 class="rode">Your locksmith was <?php echo $locksmith_name; ?>.</h4>
    </div>
    <div class="col-md-3">
      <h4 class="fade-text">RATE YOUR Locksmith</h4>
    </div>
    <div class="col-md-3">
      <div class="select_stars">
        <i class="fa fa-star-o" aria-hidden="true"></i>
        <i class="fa fa-star-o" aria-hidden="true"></i>
        <i class="fa fa-star-o" aria-hidden="true"></i>
        <i class="fa fa-star-o" aria-hidden="true"></i>
        <i class="fa fa-star-o" aria-hidden="true"></i>
      </div>
    </div>
  </div>
</div>
