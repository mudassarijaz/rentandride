<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">Dashboard</h1>
    </div>
    <!-- /.col-lg-12 -->
  </div>
  <!-- /.row -->
  <div class="row">
    <div class="col-lg-4 col-md-6">
      <div class="panel panel-primary">
        <div class="panel-heading">
          <div class="row">
            <div class="col-xs-3">
              <i class="fa fa-comments fa-5x"></i>
            </div>
            <div class="col-xs-9 text-right">
              <div class="huge"><?php echo $customer; ?></div>
              <div>New Customers!</div>
            </div>
          </div>
        </div>
        <a href="locksmith/customer">
          <div class="panel-footer">
            <span class="pull-left">View Details</span>
            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
            <div class="clearfix"></div>
          </div>
        </a>
      </div>
    </div>
    <div class="col-lg-4 col-md-6">
      <div class="panel panel-primary">
        <div class="panel-heading">
          <div class="row">
            <div class="col-xs-3">
              <i class="fa fa-shopping-cart fa-5x"></i>
            </div>
            <div class="col-xs-9 text-right">
              <div class="huge"><?php echo $order; ?></div>
              <div>New Orders!</div>
            </div>
          </div>
        </div>
        <a href="locksmith/orders">
          <div class="panel-footer">
            <span class="pull-left">View Details</span>
            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
            <div class="clearfix"></div>
          </div>
        </a>
      </div>
    </div>
    <div class="col-lg-4 col-md-6">
      <div class="panel panel-primary">
        <div class="panel-heading">
          <div class="row">
            <div class="col-xs-3">
              <i class="fa fa-tasks fa-5x"></i>
            </div>
            <div class="col-xs-9 text-right">
              <div class="huge"><?php echo $review; ?></div>
              <div>New Reviews!</div>
            </div>
          </div>
        </div>
        <a href="locksmith/reviews">
          <div class="panel-footer">
            <span class="pull-left">View Details</span>
            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
            <div class="clearfix"></div>
          </div>
        </a>
      </div>
    </div>
      <!--
    <div class="col-lg-3 col-md-6">
      <div class="panel panel-primary">
        <div class="panel-heading">
          <div class="row">
            <div class="col-xs-3">
              <i class="fa fa-support fa-5x"></i>
            </div>
            <div class="col-xs-9 text-right">
              <div class="huge">13</div>
              <div>Support Tickets!</div>
            </div>
          </div>
        </div>
        <a href="#">
          <div class="panel-footer">
            <span class="pull-left">View Details</span>
            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
            <div class="clearfix"></div>
          </div>
        </a>
      </div>
    </div>
      -->
  </div>
  <!-- /.row -->
  <div class="row">
    <div class="col-lg-8">
      <div class="panel panel-default">
        <div class="panel-heading">
          <i class="fa fa-bar-chart-o fa-fw"></i> Order Chart
          <div class="pull-right">
            <div class="btn-group">
              <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                Actions
                <span class="caret"></span>
              </button>
              <ul class="dropdown-menu pull-right" role="menu">
                <li><a href="#">Action</a>
                </li>
                <li><a href="#">Another action</a>
                </li>
                <li><a href="#">Something else here</a>
                </li>
                <li class="divider"></li>
                <li><a href="#">Separated link</a>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <!-- /.panel-heading -->
        <div class="panel-body">
          <div id="morris-area-chart"></div>
        </div>
        <!-- /.panel-body -->
      </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                Recent Orders
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Customer</th>
                                <th>Type</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                          <?php $i = 0; foreach($lastorders as $order){ ?>
                            <tr class="<?php if($i==0): ?>success<?php elseif($i==1): ?>info<?php elseif($i==2): ?>warning<?php elseif($i==3): ?>danger<?php endif; ?>">
                                <td><?php echo $order['id']; ?></td>
                                <td><?php echo $order['customer_name']; ?></td>
                                <td><?php echo $order['type_name']; ?></td>
                                <td><?php echo $order['price']; ?></td>
                            </tr>
                          <?php $i++; } ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-8 -->
    <div class="col-lg-4">
      <div class="panel panel-default">
        <div class="panel-heading">
          <i class="fa fa-bell fa-fw"></i> Latest Reviews
        </div>
        <!-- /.panel-heading -->
        <div class="panel-body">
          <ul class="list-group">
            <?php if ( count( $newreviews ) > 0 ) { ?>
              <?php foreach ( $newreviews as $view ) { ?>
                <li class="list-group-item">
                  <?php echo $view['rating']; ?> star rating given by <?php echo $view['customer_name']; ?>.
                </li>
              <?php } ?>
            <?php } ?>
          </ul>
          <a href="locksmith/reviews" class="btn btn-default btn-block">View All Reviews</a>
        </div>
        <!-- /.panel-body -->
      </div>
      <!-- /.panel -->
      <div class="panel panel-default">
        <div class="panel-heading">
          <i class="fa fa-bar-chart-o fa-fw"></i> Order Chart
        </div>
        <div class="panel-body">
          <div id="morris-donut-chart"></div>
          <a href="#" class="btn btn-default btn-block">View Details</a>
        </div>
        <!-- /.panel-body -->
      </div>
      <!-- /.panel -->
    </div>
    <!-- /.col-lg-4 -->
  </div>
  <!-- /.row -->
</div>

<script src="http://locksmith.nexvistech.com/assets/js/jquery.min.js"></script>
<script src="http://locksmith.nexvistech.com/assets/js/raphael.min.js"></script>
<script src="http://locksmith.nexvistech.com/assets/js/morris.min.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
    var data = <?php echo json_encode($monthorders); ?>;
    for ( var i = 0; i <= data.length; i++ ) {
      if ( data[i] ) {
        if ( !data[i]['period'] ) {
          data[i]['period'] = null;
        }
        if ( !data[i]['accepted'] ) {
          data[i]['accepted'] = null;
        }
        if ( !data[i]['rejected'] ) {
          data[i]['rejected'] = null;
        }
        if ( !data[i]['completed'] ) {
          data[i]['completed'] = null;
        }
      }
    }
console.log(data);
    Morris.Donut({
      element: 'morris-donut-chart',
      data: [{
        label: "Total Payments",
        value: <?php echo $payments['total']; ?>
      }, {
        label: "Customer Payments",
        value: <?php echo $payments['cust']; ?>
      }, {
        label: "You Paid",
        value: <?php echo $payments['lock']; ?>
      }],
      resize: true
    });

    Morris.Area({
      element: 'morris-area-chart',
      data: data,
      xkey: 'period',
      ykeys: ['accepted', 'completed', 'rejected'],
      labels: ['Accepted', 'Completed', 'Rejected'],
      pointSize: 2,
      hideHover: 'auto',
      resize: true
    });
  });
</script>