<?php
require_once('../config.php');
require_once('session.php');
if(isset($_REQUEST['delete'])){
  $campaign->typeDelete($_REQUEST['delete']);
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Campaign Types</title>
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

    <!-- Content Wrapper. Contains page content -->
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Campaign Types
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Campaign Types</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="box">
        <div class="col-md-12">
          <?php echo flashNotification() ?>
        </div>
        <div class="box-header">
          <h3 class="box-title">All Types of Campaigns</h3>
          <!-- <a href="new-campaign-type.php" class="pull-right btn btn-info">Add New Type</a> -->
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table id="campaigntype-table" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Type</th>
                <th style="width: 70px;">Status</th>
                <th style="width: 70px;">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $campains=$campaign->allCampaignTypes();
              if(!empty($campains)){
                foreach ($campains as $key => $type) {
              ?>
              <tr>
                <td><?php echo $type['id']; ?></td>
                <td><?php echo $type['name']; ?></td>
                <td><?php echo $type['type']; ?></td>
                <td class="text-center">
                  <?php
                  $status=array(1=>array('label'=>'Active','class'=>'bg-green'),2=>array('label'=>'Inactive','class'=>'bg-red'));
                  echo '<small class="label '.$status[$type['status']]['class'].'">';
                  echo $status[$type['status']]['label'];
                  echo '</small>';
                  ?>                    
                </td>
                <td>
                  <a href="new-campaign-type.php?id=<?php echo $type['id'] ?>" class="btn btn-sm btn-default">
                    <i class="fa fa-pencil"></i>
                  </a>
                  <?php
                  /*
                  <a onclick="return confirm('Are you sure?')" href="campaign-types.php?delete=<?php echo $type['id'] ?>" class="btn btn-sm btn-default">
                    <i class="fa fa-trash"></i>
                  </a>
                  */
                  ?>
                </td>
              </tr>
              <?php
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
<!-- DataTables -->
<script src="<?php echo baseurl ?>/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo baseurl ?>/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script>
  $(function () {
    $('#campaigntype-table').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : false,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>
</body>
</html>
