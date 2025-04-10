<?php
require_once('../config.php');
require_once('session.php');
$allvideo=$videosobj->allVideo();
if(isset($_REQUEST['delete'])){
  $videosobj->delete($_REQUEST['delete']);
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Video Dimensions</title>
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
      <h1>Video Dimensions</h1>
      <ol class="breadcrumb">
        <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Video Dimensions</li>
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
                  <select name="video" class="form-control">
                    <option value="">Video Dimensions</option>
                    <?php
                    $allvideos=array();
                    if(!empty($allvideo)){
                      foreach ($allvideo as $key => $video) {
                        $allvideos[$video['id']]=$video['videosize'];
                    ?>
                        <option <?php echo filterSelect($_REQUEST['video'],$video['id']) ?> value="<?php echo $video['id'] ?>"><?php echo $video['videosize'] ?></option>
                    <?php
                      }

                    }
                    ?>
                  </select>
                </div>
                <div class="col-md-2">
                  <select name="status" class="form-control">
                    <option value="">Status</option>
                    <option <?php echo filterSelect($_REQUEST['status'],'1') ?> value="1">Active</option>
                    <option <?php echo filterSelect($_REQUEST['status'],'0') ?> value="0">Inactive</option>
                  </select>
                </div>
                <div class="col-md-2">
                  <input type="submit" name="filter" value="filter" class="btn btn-warning">
                </div>
              </form>
            </div>
            <div class="col-md-2"><a href="add-video-size.php" class="btn btn-default pull-right">Add New</a></div>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th style="width: 80px;">ID</th>
                <th>Video Dimensions</th>
                <th style="width: 70px;">Status</th>
                <th style="width: 90px;text-align: center;">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $allvideosize=$videosobj->getAllVideosSize();
              $id=1;
              if(!empty($allvideosize['data'])){
                foreach ($allvideosize['data'] as $key => $videos) {
              ?>
              <tr>
                <td><?php echo $id; //$videos['id']; ?></td>
                <td style="text-align: left;"><?php echo $videos['videosize']; ?></td>
                <td class="text-center">
                  <?php
                  $status=array(1=>array('label'=>'Active','class'=>'bg-green'),0=>array('label'=>'Inactive','class'=>'bg-red'));
                  echo '<small class="label '.$status[$videos['status']]['class'].'">';
                  echo $status[$videos['status']]['label'];
                  echo '</small>';
                  ?>                    
                </td>
                <td class="text-center">
                  <a href="edit-video-size.php?id=<?php echo md5($videos['id']) ?>" class="btn btn-sm btn-default">
                    <i class="fa fa-pencil"></i>
                  </a>
                  <a onclick="return confirm('Are you sure?')" href="?delete=<?php echo md5($videos['id']) ?>" class="btn btn-sm btn-default">
                    <i class="fa fa-trash"></i>
                  </a>
                </td>
              </tr>
              <?php
              $id++;
                }
              }
              ?>
            </tbody>
          </table>
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
