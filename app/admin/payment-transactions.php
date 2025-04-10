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
<body class="hold-transition skin-blue">
<!-- Site wrapper -->
<div class="wrapper">
  <div class="content-wrapper">
    <?php include('../common/admin-header.php') ?>
    <?php include('../common/sidebar.php') ?>

    <section class="content-header">
      <h1>Payments</h1>
      <ol class="breadcrumb">
        <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Payments</li>
      </ol>
    </section>

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
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>User ID</th>
                <th>User Name</th>
                <th>Date</th>
                <th>Payment ID</th>
                <th>Payment Method</th>
                <th>Transaction ID</th>
                <th>Payment Amount</th>
                <th>Net Amount</th>
                <th>Status</th>
                <td>Action</td>
              </tr>
            </thead>
            <tbody>
              <?php
              $allpayments=$payments->getAllPaymentTransactions('',15,true,'payment-transactions.php');
              if(!empty($allpayments['data'])){
                foreach ($allpayments['data'] as $key => $price) {
              ?>
              <tr>
                <td><?php echo $price['uid']; ?></td>
                <td>
                  <?php echo $price['uname'] ?  $price['uname'].'<br/>' :''; ?>
                  <?php echo $price['email'] ?  '<small>('.$price['email'].')</small>' :''; ?>                  
                </td>
                <td><?php echo date('jS M, Y - h:m:s A',strtotime($price['created_at'])) ?></td>
                <td><?php echo $price['id']; ?></td>
                <td><?php echo $price['type']; ?></td>
                <td><?php echo $price['transactionid']; ?></td>
                <td><?php echo $price['amount'] ? '$'.number_format($price['amount'],2) : '$0' ; ?></td>
                <td><?php echo $price['net_amount'] ? '$'.number_format($price['net_amount'],2) : '$0' ; ?></td>
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
                <td>
                  <a href="edit-check-payment.php?id=<?php echo md5($price['id']); ?>" class="btn btn-sm btn-default"><i class="fa fa-pencil"></i></a>
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