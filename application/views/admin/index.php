<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">Dashboard</h1>
    </div>
    <!-- /.col-lg-12 -->
  </div>
  <!-- /.row -->
  <div class="row dasboardstyles">
   
    <div class="col-lg-4 col-md-6">
      <div class="panel panel-primary">
        <div class="panel-heading">
          <div class="row">
            <div class="col-xs-3">
              <i class="fa fa-tasks fa-5x"></i>
            </div>
            <div class="col-xs-9 text-right">
              <div class="huge"><?php echo $customer; ?></div>
              <div>New Customers!</div>
            </div>
          </div>
        </div>
        <a href="admin/customer">
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
              <div>New Rides!</div>
            </div>
          </div>
        </div>
        <a href="admin/orders">
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
              <i class="fa fa-support fa-5x"></i>
            </div>
            <div class="col-xs-9 text-right">
              <div class="huge"><?php echo $review; ?></div>
              <div>Reviews!</div>
            </div>
          </div>
        </div>
        <a href="admin/reviews">
          <div class="panel-footer">
            <span class="pull-left">View Details</span>
            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
            <div class="clearfix"></div>
          </div>
        </a>
      </div>
    </div>
  </div>
  <!-- /.row -->
  <div class="row">
    <div class="col-lg-8">
      <div class="panel panel-default">
        <div class="panel-heading">
          <i class="fa fa-bar-chart-o fa-fw"></i> Rides Chart
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
                Recent Rides
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
                     <!--    <tbody>
                          <?php $i = 0; foreach($lastorders as $order){ ?>
                            <tr class="<?php if($i==0): ?>success<?php elseif($i==1): ?>info<?php elseif($i==2): ?>warning<?php elseif($i==3): ?>danger<?php endif; ?>">
                                <td><?php echo $order['id']; ?></td>
                                <td><?php echo $order['customer_name']; ?></td>
                                <td><?php echo $order['type_name']; ?></td>
                                <td><?php echo $order['price']; ?></td>
                            </tr>
                          <?php $i++; } ?>
                        </tbody> -->
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
        <!--   <ul class="list-group">
            <?php if ( count( $newreviews ) > 0 ) { ?>
              <?php foreach ( $newreviews as $view ) { ?>
                <li class="list-group-item"><?php echo $view['rating']; ?> star rating given to 
                  <?php if ( $view['customer_id'] == $view['posted_by'] ) { ?>
                    <?php echo $view['locksmith_name']; ?> by <?php echo $view['customer_name']; ?>.
                  <?php } elseif ( $view['locksmith_id'] == $view['posted_by'] ) { ?>
                    <?php echo $view['customer_name']; ?> by <?php echo $view['locksmith_name']; ?>.
                  <?php } ?>
                </li>
              <?php } ?>
            <?php } ?>
          </ul> -->
          <a href="admin/reviews" class="btn btn-default btn-block">View All Reviews</a>
        </div>
        <!-- /.panel-body -->
      </div>
      <!-- /.panel -->
      <div class="panel panel-default">
        <div class="panel-heading">
          <i class="fa fa-bar-chart-o fa-fw"></i> Payments Chart
        </div>
        <div class="panel-body">
          <div id="morris-donut-chart"></div>
          <a href="#" class="btn btn-default btn-block">View Details</a>
        </div>
        <!-- /.panel-body -->
      </div>
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
        if ( !data[i]['pending'] ) {
          data[i]['pending'] = null;
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
        label: "Locksmith Payments",
        value: <?php echo $payments['lock']; ?>
      }],
      resize: true
    });

    Morris.Area({
      element: 'morris-area-chart',
      data: data,//[
//      {
//        period: '2010 Q1',
//        completed: 2666,
//        pending: null,
//        rejected: 2647
//      }, {
//        period: '2010 Q2',
//        completed: 2778,
//        pending: 2294,
//        rejected: 2441
//      }, {
//        period: '2010 Q3',
//        completed: 4912,
//        pending: 1969,
//        rejected: 2501
//      }, {
//        period: '2010 Q4',
//        completed: 3767,
//        ipad: 3597,
//        rejected: 5689
//      }, {
//        period: '2011 Q1',
//        completed: 6810,
//        pending: 1914,
//        rejected: 2293
//      }, {
//        period: '2011 Q2',
//        completed: 5670,
//        pending: 4293,
//        rejected: 1881
//      }, {
//        period: '2011 Q3',
//        completed: 4820,
//        pending: 3795,
//        rejected: 1588
//      }, {
//        period: '2011 Q4',
//        completed: 15073,
//        pending: 5967,
//        rejected: 5175
//      }, {
//        period: '2012 Q1',
//        completed: 10687,
//        pending: 4460,
//        rejected: 2028
//      }, {
//        period: '2012 Q2',
//        completed: 8432,
//        pending: 5713,
//        rejected: 1791
//      }
//      ],
      xkey: 'period',
      ykeys: ['accepted', 'pending', 'completed'],
      labels: ['Accepted', 'Pending', 'Completed'],
      pointSize: 2,
      hideHover: 'auto',
      resize: true
    });
  });
</script>