<?php
require_once('../config.php');
require_once('session.php');
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Profile</title>
  <?php include('../common/head.php') ?>
</head>
<body class="hold-transition skin-blue sidebar-collapse">
<!-- Site wrapper -->
<div class="wrapper">
  <?php
  $title='Profile';
  $breadcrumbdata=array(
    0=>array(
      'link'=>'dashboard.php',
      'name'=>'Home'
    ),
    1=>array(
      'link'=>'',
      'name'=>'Profile'
    )
  )
  ?>
  <div class="content-wrapper bg-image">
  <?php include('../common/admin-header.php') ?>
  <?php include('../common/sidebar.php') ?>
    <!-- Main content -->
    <section class="content">
      <div class="white-wapper">
        <div class="white-layer-none">
          <div class="row">
            <div class="col-md-12">
              <div class="tab-box">
                <div class="tab">
                  <a href="profile.php" class="active">Profile Details</a>
                </div>
<!--                 <div class="tab">
                  <a href="#">Billing Details</a>
                </div> -->
                <div class="tab">
                  <a href="change-password.php">Change Password</a>
                </div>
              </div>              
            </div>
          </div>
          <div class="gray-box">
            <?php
            $current_user=$users->get_current_user();
            ?>
            <div class="row">
              <div class="col-md-6">
                <table id="profile-table" class="table table-bordered table-striped">
                  <tr>
                    <td>Name:</td>
                    <td><?php echo $current_user['name'] ?></td>
                  </tr>
                  <tr>
                      <td>Company Name:</td>
                      <td><?php echo $current_user['company_name'] ?></td>
                </tr>
                <tr>
                  <td>Email:</td>
                  <td><?php echo $current_user['email'] ?></td>
                </tr>
                <tr>
                  <td>Phone No:</td>
                  <td><?php echo $current_user['phone'] ?></td>
                </tr>
                <tr>
                  <td>Company Name:</td>
                  <td><?php echo $current_user['company_name'] ?></td>
                </tr>
                <tr>
                  <td>Skype:</td>
                  <td><?php echo $current_user['skype'] ?></td>
                </tr>
                <tr>
                  <td>Address:</td>
                  <td><?php echo $current_user['address'] ?></td>
                </tr>
                </table>
              </div>
              <div class="col-md-6 vertical-border">
                <div class="row">
                  <div class="control-label col-md-4">Profile Picture:</div>
                </div>
                <div class="row mt-5">
                  <div class="control-label col-md-3"></div>
                  <div class="col-md-6 profile-photo-cover">
                    <?php if(!empty($current_user['photo'])){ ?>
                      <img src="<?php echo baseurl.'/images/profile/'.$current_user['photo'] ?>">
                    <?php } ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="row mt-5">
              <div class="col-md-12 text-right">
                <a href="profile-edit.php" class="btn btn-warning">Edit</a>
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
<?php include('../common/footer.php') ?>
<?php include('../common/footer-script.php') ?>
<script>
  $(document).ready(function () {
    $('.sidebar-menu').tree()
  })
</script>
</body>
</html>
