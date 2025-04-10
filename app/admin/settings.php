<?php
require_once('../config.php');
require_once('session.php');
if(isset($_POST['bankdata'])){
  $common->saveSettings();
}
if(isset($_POST['login-assistant-password'])){
  $common->loginAssistantPassword();
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Profile</title>
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
      <h1>Settings</h1>
      <ol class="breadcrumb">
        <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Settings</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-md-12">
          <?php echo flashNotification() ?>
        </div>
        <div class="col-md-12">
          <!-- Custom Tabs -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active">
                <a href="#bank-details" data-toggle="tab" aria-expanded="false">Bank Details</a>
              </li>
              <li>
                <a href="#login-assistant" data-toggle="tab">Login Assistant</a>
              </li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="bank-details">
                <form class="forms-sample" method="post" enctype="multipart/form-data">
                  <div class="form-group">
                    <label for="exampleInputName1">Account Name</label>
                    <input type="text" name="setting[account_name]" class="form-control" value="<?php echo $common->getSetting('account_name') ?>">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputName1">Account Number</label>
                    <input type="text" name="setting[account_number]" class="form-control" value="<?php echo $common->getSetting('account_number') ?>">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputName1">Branch Name</label>
                    <input type="text" name="setting[branch_name]" class="form-control" value="<?php echo $common->getSetting('branch_name') ?>">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputName1">IFSC Code</label>
                    <input type="text" name="setting[ifsc_code]" class="form-control" value="<?php echo $common->getSetting('ifsc_code') ?>">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputName1">MICR Code</label>
                    <input type="text" name="setting[micr_code]" class="form-control" value="<?php echo $common->getSetting('micr_code') ?>">
                  </div>
                  <button type="submit" name="bankdata" class="btn btn-primary mr-2">Save</button>
                </form>
              </div>
              <div class="tab-pane" id="login-assistant">
                <form class="forms-sample" method="post" enctype="multipart/form-data">
                  <div class="form-group">
                    <label for="exampleInputName1">Current Password</label>
                    <input type="password" name="cpassword" class="form-control">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputName1">New Password</label>
                    <input type="password" name="newpassword" class="form-control">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputName1">Re-Type Password</label>
                    <input type="password" name="repassword" class="form-control">
                  </div>
                  <button type="submit" name="login-assistant-password" class="btn btn-primary mr-2">Set Password</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
</div>
<?php include('../common/footer-script.php') ?>
<script>
  $(document).ready(function () {
    $('.sidebar-menu').tree()
  })
</script>
</body>
</html>
