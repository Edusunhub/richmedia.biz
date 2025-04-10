<?php
require_once('../config.php');
require_once('session.php');
if(isset($_POST['update'])){
  $users->profileUpdate();
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
      'link'=>'profile.php',
      'name'=>'Profile'
    ),
    2=>array(
      'link'=>'',
      'name'=>'Profile Edit'
    )
  )
  ?>
  <div class="content-wrapper bg-image">
  <?php include('../common/advertiser-header.php') ?>
  <?php include('../common/sidebar.php') ?>
    <!-- Main content -->
    <section class="content">
      <div class="white-wapper">
        <div class="white-layer-none">
          <div class="gray-box">
            <h4 class="gray-box-title">Update Profile Details</h4>
            <?php
            $current_user=$users->get_current_user();
            ?>
            <?php echo flashNotification() ?>
            <form method="post" class="theme-fields-form" enctype="multipart/form-data">
              <br/>
              <div class="row">
                <div class="col-md-6 vertical-border-right">
                  <div class="form-group">
                    <div class="row">
                      <label class="col-sm-5 control-label">Name:</label>
                      <div class="col-sm-7">
                        <input type="text" class="form-control" name="name" value="<?php echo $current_user['name'] ?>">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <label class="col-sm-5 control-label">Company Name:</label>
                      <div class="col-sm-7">
                        <input type="text" class="form-control" name="company_name" value="<?php echo $current_user['company_name'] ?>">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <label class="col-sm-5 control-label">Email:</label>
                      <div class="col-sm-7">
                        <input type="text" class="form-control" readonly value="<?php echo $current_user['email'] ?>">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <label class="col-sm-5 control-label">Phone No:</label>
                      <div class="col-sm-7">
                        <input type="text" class="form-control" name="phone" value="<?php echo $current_user['phone'] ?>">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <label class="col-sm-5 control-label">Skype:</label>
                      <div class="col-sm-7">
                        <input type="text" class="form-control" name="skype" value="<?php echo $current_user['skype'] ?>">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <label class="col-sm-5 control-label">Address:</label>
                      <div class="col-sm-7">
                        <textarea class="form-control" name="address" rows="5" style="resize: none;"><?php echo $current_user['address'] ?></textarea>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <div class="row">
                      <label class="col-sm-5 control-label">Upload Profile Picture:</label>
                      <div class="col-sm-7">
                        <input type="file" style="max-width: 100%" accept="image/*" id="imgInp" class="form-control" name="photo">
                      </div>
                    </div>
                  </div>
                  <div class="row mt-5">
                    <div class="control-label col-md-5"></div>
                    <div class="col-md-6 profile-photo">
                      <?php if(!empty($current_user['photo'])){ ?>
                        <img id="profile-photo" src="<?php echo baseurl.'/images/profile/'.$current_user['photo'] ?>">
                      <?php } else { ?>
                        <img id="profile-photo">
                      <?php } ?>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row mt-5">
                <div class="col-md-12 text-right">
                  <button type="submit" name="update" class="btn btn-theme btn-flat">Ok</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
  </div>
</div>
<?php include('../common/footer.php') ?>
<?php include('../common/footer-script.php') ?>
<script>
function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    
    reader.onload = function(e) {
      $('#profile-photo').attr('src', e.target.result);
    }
    
    reader.readAsDataURL(input.files[0]);
  }
}

$("#imgInp").change(function() {
  readURL(this);
});
</script>
</body>
</html>
