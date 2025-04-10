<?php
require_once('../config.php');
require_once('session.php');
if(isset($_POST['save'])){
  $payments->save();
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Campaign Model Types</title>
  <?php include('../common/head.php') ?>
</head>
<body class="hold-transition skin-blue">
<!-- Site wrapper -->
<div class="wrapper">
  <div class="content-wrapper">
  <?php include('../common/admin-header.php') ?>
  <?php include('../common/sidebar.php') ?>

  <!-- Content Wrapper. Contains page content -->
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Payments</h1>
      <ol class="breadcrumb">
        <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="payments.php">Payments</a></li>
        <li class="active">New Payment</li>
      </ol>
    </section>
    <?php echo flashNotification() ?>
    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <div class="row">
        <div class="col-md-offset-3 col-md-6">
          <div class="box">
            <div class="box-header text-center">
              <h4>Add New Payments</h4>
              <hr/>
            </div>
            <div class="box-body">
              <form role="form" method="post">
                <div class="form-group">
                  <label>Payment Method</label>
                  <select name="method" class="form-control" required>
                    <option value="Wire Transfer">Wire Transfer</option>
                    <option value="Paypal">Paypal</option>
                  </select>
                </div>
                <div class="form-group">
                  <label>Amount</label>
                  <input type="number" name="amount" class="form-control" min="0" required>
                </div>
                <div class="form-group">
                  <label>Transaction ID</label>
                  <input type="text" name="transaction_id" class="form-control" required>
                </div>
                <div class="form-group">
                  <label>Date</label>
                  <input type="text" name="date" class="datepicker form-control" required>
                </div>
                <button type="submit" name="save" class="btn btn-warning pull-right">Save</button>
                <button type="reset" class="btn btn-default">Cancel</button>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php include('../common/footer.php') ?>  
</div>
<?php include('../common/footer-script.php') ?>
<script>
  $(document).ready(function () {
    $('.sidebar-menu').tree()
  })
  $('.datepicker').datepicker({
    autoclose: true
  })
</script>
</body>
</html>
