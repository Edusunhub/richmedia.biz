<?php
require_once('../config.php');
require_once('session.php');
if($_REQUEST['id']){
  $type=$campaign->getTypeByID($_REQUEST['id']);
}
if(isset($_POST['save'])){
  $campaign->saveType();
}
if(isset($_POST['update'])){
  $campaign->updateType($_REQUEST['id']);
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo empty($type) ? 'Add New' : 'Edit' ?> Campaign Type</title>
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
      <h1>
        Campaign Types
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="campaign-types.php"><i class="fa fa-dashboard"></i> Campaign Types</a></li>
        <li class="active"><?php echo empty($type) ? 'Add New' : 'Edit' ?> Type</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="col-md-3"></div>
      <div class="col-md-6">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title"><?php echo empty($type) ? 'Add New' : 'Edit' ?> Type</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <div class="col-sm-12">
              <?php echo flashNotification() ?>
            </div>
            <form method="post" class="form-horizontal" enctype="multipart/form-data">
              <div class="box-body">
                <div class="form-group">
                  <label class="col-sm-2 control-label">Name</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" required id="osname" name="name" placeholder="Name" value="<?php echo $type['name'] ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label">Type</label>
                  <div class="col-sm-10">
                    <select name="type" class="form-control">
                      <option value="banner" <?php echo selectOption('banner',$type['type']) ?>>Banner</option>
                      <option value="push" <?php echo selectOption('push',$type['type']) ?>>Push</option>
                      <option value="pop" <?php echo selectOption('pop',$type['type']) ?>>POP</option>
                      <option value="video" <?php echo selectOption('video',$type['type']) ?>>Video</option>
                      <option value="native" <?php echo selectOption('native',$type['type']) ?>>Native</option>
                    </select>
                  </div>
                </div>
                <!-- <div class="form-group">
                  <label class="col-md-2 control-label">Icon</label>
                  <div class="col-md-10">
                    <input type="file" name="icon" class="file-upload-default" accept="image/png, image/jpeg" required>
                    <div class="input-group col-xs-12">
                      <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image">
                      <span class="input-group-addon cursor file-upload-browse">Upload</span>
                    </div>
                    <div class="imagepreview-cover col-xs-12">
                    </div>
                  </div>
                </div> -->
                <div class="form-group">
                  <label class="col-sm-2 control-label">Status</label>
                  <div class="col-sm-10">
                    <select name="status" class="form-control">
                      <option value="1" <?php echo selectOption(1,$type['status']) ?>>Active</option>
                      <option value="2" <?php echo selectOption(2,$type['status']) ?>>Inactive</option>
                    </select>
                  </div>
                </div>
                <div class="form-group text-center">
                  <?php if(!empty($type)){ ?>
                    <button type="submit" name="update" class="btn btn-info">Save</button>
                  <?php } else { ?>
                  <button type="submit" name="save" class="btn btn-info">Save</button>
                  <?php } ?>
                </div>
              </div>
              <!-- /.box-footer -->
            </form>
          </div>
          <!-- /.box -->
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php include('../common/footer.php') ?>  
</div>
<?php include('../common/footer-script.php') ?>
<script>
function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    var error;
    reader.onload = function(e) {
      var img = new Image;
      img.src = reader.result;
      var imageelement='<img class="mt-1" src="'+img.src+'">';
      $('.imagepreview-cover').html(imageelement);
    }
  }
  reader.readAsDataURL(input.files[0]);
}


$(".file-upload-default").change(function() {
  readURL(this);
});
</script>
</body>
</html>
