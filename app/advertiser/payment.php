<?php
require_once('../config.php');
require_once('session.php');
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Payments</title>
  <?php include('../common/head.php') ?>
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo baseurl ?>/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
</head>
<body class="hold-transition skin-blue sidebar-collapse">
<!-- Site wrapper -->
<div class="wrapper">
  <?php
  $title='Payment';
  $breadcrumbdata=array(
    0=>array(
      'link'=>'dashboard.php',
      'name'=>'Home'
    ),
    1=>array(
      'link'=>'',
      'name'=>'Payment'
    )
  )
  ?>
  <div class="content-wrapper bg-image">
    <?php include('../common/advertiser-header.php') ?>
    <?php include('../common/sidebar.php') ?>

    <section class="content">
      <div class="box">
        <div class="box-header with-border">
          <div class="col-md-12">
            <?php echo flashNotification() ?>
          </div>
          <div class="row">
            <div class="col-md-10">
              <form class="row">
                <div class="col-md-2">
                  <input type="text" name="from" class="form-control datepicker" placeholder="From Date" value="<?php echo $_REQUEST['from'] ?>" autocomplete="off" >
                </div>
                <div class="col-md-2">
                  <input type="text" name="to" class="form-control datepicker" placeholder="To Date" value="<?php echo $_REQUEST['to'] ?>" autocomplete="off">
                </div>
                <div class="col-md-2">
                  <input type="submit" name="filter" value="filter" class="btn btn-warning">
                </div>
              </form>
            </div>
            <div class="col-md-2"><a href="recharge-wallet.php" class="btn btn-default pull-right">Add Funds</a></div>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>Date</th>
                <th>Payment ID</th>
                <th>Mode of Payment</th>
                <th>Payment Amount</th>
                <th>Net Amount</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $allpayments=$payments->getAllPaymentTransactions($_SESSION['userid']);
              if(!empty($allpayments['data'])){
                foreach ($allpayments['data'] as $key => $price) {
              ?>
              <tr>
                <td><?php echo date('jS M, Y - h:m:s A',strtotime($price['created_at'])) ?></td>
                <td><?php echo $price['id']; ?></td>
                <td><?php echo $price['type']; ?></td>
                <td><?php echo $price['amount'] ? '$'.$price['amount'] : '$0' ; ?></td>
                <td><?php echo $price['net_amount'] ? '$'.$price['net_amount'] : '$0' ; ?></td>
                <td>
                  <?php
                  $status=array(
                    0=>'<small class="label bg-red">Waiting for Approval</small>',
                    1=>'<small class="label bg-yellow">Verified</small>',
                    2=>'<small class="label bg-green">Approved</small>',
                    3=>'<small class="label bg-red">Decline</small>'
                  );
                  echo $status[$price['status']];
                  ?>
                </td>
              </tr>
              <?php
                }
              }else{
                echo "<tr><td algin='center' colspan='10'>No data found</tr>";
              }
              ?>
            </tbody>
          </table>
          <?php echo $allpayments['pagination'] ?>
        </div>
        <!-- /.box-body -->
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php include('../common/footer.php') ?>  
</div>
<?php include('../common/footer-script.php') ?>
<script type="text/javascript">
$('.datepicker').datepicker({
    format: 'yyyy-mm-dd'
});
</script>
</body>
</html>