<?php
require_once('../config.php');
require_once('session.php');
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Prices</title>
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
        <!-- /.box-header -->
        <div class="box-body">
          <table  class="table table-bordered table-striped">
            <thead>
              <tr>
                <th style="width: 100px">User ID</th>
                <th>Email</th>
                <th>Amount</th>
                <th style="width: 50px;">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $userswallet=$users->getUsersWallet();
              if(!empty($userswallet['data'])){
                foreach ($userswallet['data'] as $key => $wallet) {
              ?>
              <tr>
                <td><?php echo $wallet['id']; ?></td>
                <td><?php echo $wallet['email']; ?></td>
                <td><?php //echo $user['email']; ?></td>
                <td>
                  <a href="add-money.php?id=<?php echo md5($wallet['id']) ?>" class="btn btn-sm btn-default">
                    <i class="fa fa-plus-square"></i>
                  </a>
                </td>
              </tr>
              <?php
                }
              }
              ?>
            </tbody>
          </table>
          <?php echo $userswallet['pagination'] ?>
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