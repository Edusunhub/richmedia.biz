<?php
require_once('../config.php');
require_once('session.php');
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>User Wallets</title>
  <?php include('../common/head.php') ?>
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo baseurl ?>/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
</head>
<body class="hold-transition skin-blue">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <?php include('../common/admin-header.php') ?>
    <?php include('../common/sidebar.php') ?>

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>User Wallet</h1>
      <ol class="breadcrumb">
        <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">User Wallet</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="box">
        <div class="col-md-12">
          <?php echo flashNotification() ?>
        </div>
        <div class="col-md-12 mt-1 mb-2">
          <form class="row">
            <div class="col-md-3">
              <input type="text" name="key" class="form-control" placeholder="keywords" value="<?php echo $_REQUEST['key'] ?>">
            </div>
            <div class="col-md-3">
              <input type="text" name="advertiser" class="form-control" placeholder="Advertiser ID / Name" value="<?php echo $_REQUEST['advertiser'] ?>">
            </div>
            <div class="col-md-2">
              <select name="method" class="form-control">
                <option value="">Method</option>
                <option <?php echo filterSelect($_REQUEST['method'],'razorpay') ?> value="razorpay">Razorpay</option>
                <option <?php echo filterSelect($_REQUEST['method'],'paypal') ?> value="paypal">paypal</option>
              </select>
            </div>
            <div class="col-md-2">
              <select name="status" class="form-control">
                <option value="">Status</option>
                <option <?php echo filterSelect($_REQUEST['status'],'0') ?> value="0">Pending</option>
                <option <?php echo filterSelect($_REQUEST['status'],'2') ?> value="2">Approved</option>
                <option <?php echo filterSelect($_REQUEST['status'],'3') ?> value="3">Decline</option>
              </select>
              <input type="hidden" name="limit" value="<?php echo $_REQUEST['limit'] ?>" class="btn btn-warning">
            </div>
            <div class="col-md-2">
              <input type="submit" name="filter" value="filter" class="btn btn-warning">
            </div>
          </form>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table  class="table table-bordered table-striped">
            <thead>
              <tr>
                <th style="width: 100px">Payment ID</th>
                <th>User ID</th>
                <th>User Name</th>
                <th>TX.ID</th>
                <th>Date</th>
                <th>Amount</th>
                <th>Approved Amount</th>
                <th>Method</th>
                <th>Status</th>
                <th style="width: 50px;">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $wallets=$payments->getUsersWalletPayment('',15,true);
              if(!empty($wallets['data'])){
                $i=1;
                foreach ($wallets['data'] as $key => $wallet) {
              ?>
              <tr>
                <td><?php echo $wallet['id']; ?></td>
                <td><?php echo $wallet['uid']; ?></td>
                <td>
                  <?php echo $wallet['uname'] ?  $wallet['uname'].'<br/>' :''; ?>
                  <?php echo $wallet['email'] ?  '<small>('.$wallet['email'].')</small>' :''; ?>                  
                </td>
                <td><?php echo $wallet['transactionid']; ?></td>
                <td><?php echo date('jS M, Y - h:m:s A',strtotime($wallet['created_at'])) ?></td>
                <td><?php echo '$'.number_format($wallet['amount'],2); ?></td>
                <td><?php echo '$'.number_format($wallet['net_amount'],2); ?></td>
                <td><?php echo $wallet['method'] ?></td>
                <td class="text-center">
                  <?php
                  $status=array(
                    0=>array('label'=>'Pending','class'=>'bg-orange'),
                    1=>array('label'=>'Verified','class'=>'bg-blue'),
                    2=>array('label'=>'Approved','class'=>'bg-green'),
                    3=>array('label'=>'Decline','class'=>'bg-red')
                  );
                  echo '<small class="label '.$status[$wallet['status']]['class'].'">';
                  echo $status[$wallet['status']]['label'];
                  echo '</small>';
                  ?>                    
                </td>
                <td>
                  <a href="wallet-payment.php?id=<?php echo md5($wallet['id']) ?>" class="btn btn-sm btn-default">
                    <i class="fa fa-pencil"></i>
                  </a>
                </td>
              </tr>
              <?php
              $i++;
                }
              }else{
              ?>
                <tr>
                  <td colspan="8">No data found</td>
                </tr>
              <?php
              }
              ?>
            </tbody>
          </table>
          <?php echo $wallets['pagination'] ?>
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
</body>
</html>
