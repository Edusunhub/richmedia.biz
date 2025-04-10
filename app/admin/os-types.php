<?php
require_once('../config.php');
require_once('session.php');
if(isset($_REQUEST['delete'])){
  $os->delete($_REQUEST['delete']);
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>OS Types</title>
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
      <h1>OS Types</h1>
      <ol class="breadcrumb">
        <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Os Types</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="box">
        <div class="box-header with-border">
          <div class="row">
            <div class="col-md-10">
              <form class="row">
                <div class="col-md-2">
                  <input type="text" name="key" class="form-control" placeholder="Key Words" value="<?php echo $_REQUEST['key'] ?>">
                </div>
                <div class="col-md-2">
                  <select name="status" class="form-control">
                    <option value="">Status</option>
                    <option value="1" <?php echo filterSelect($_REQUEST['status'],'1') ?>>Active</option>
                    <option value="0" <?php echo filterSelect($_REQUEST['status'],'0') ?>>Inactive</option>
                  </select>
                </div>
                <div class="col-md-2">
                  <input type="submit" name="filter" value="filter" class="btn btn-warning">
                </div>
              </form>              
            </div>
            <div class="col-md-2"><a href="new-os.php" class="btn btn-default pull-right">Add New</a></div>
          </div>
        </div>
        <div class="box-body">
          <div class="col-md-12">
            <?php echo flashNotification() ?>
          </div>
          <table id="ostype-table" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th style="width: 50px;">ID</th>
                <th >OS Name</th>
                <th >Device Name</th>
                <th style="width: 70px;">Status</th>
                <th style="width: 100px;">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $ostypes=$os->getAllOSType();
              $id=1;             
              if(!empty($ostypes['data'])){
                foreach ($ostypes['data'] as $key => $ostype) {
             ?>
                    <tr>
                      <td><?php echo $id;//echo $ostype['id']; ?></td>
                      <td style="text-align: left;"><?php echo $ostype['name']; ?></td>
                      <td style="text-align: left;">
                        <?php $osdeviceset=explode(",",$ostype['deviceid']);
                              $oscount=count($osdeviceset);                              
                              $alldevices=$devices->getAllDevice();
                              if(!empty($alldevices)){
                                $chck = 1;
                                foreach ($alldevices as $key => $device) {
                                 if(in_array($device['id'], $osdeviceset)) {
                                   echo $devname =  $device['name'];
                                   if($oscount!=$chck){
                                    echo ',';
                                   }
                                   $chck++;
                                 }
                                }                               
                              }
                        ?></td>
                      <td class="text-center">
                        <?php
                        $status=array(1=>array('label'=>'Active','class'=>'bg-green'),0=>array('label'=>'Inactive','class'=>'bg-red'));
                        echo '<small class="label '.$status[$ostype['status']]['class'].'">';
                        echo $status[$ostype['status']]['label'];
                        echo '</small>';
                        ?>                    
                      </td>
                      <td>
                        <a href="edit-os.php?id=<?php echo md5($ostype['id']) ?>" class="btn btn-sm btn-default">
                          <i class="fa fa-pencil"></i>
                        </a>
                        <a onclick="return confirm('Are you sure?')" href="os-types.php?delete=<?php echo md5($ostype['id']) ?>" class="btn btn-sm btn-default">
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
        <div class="box-footer">
          <?php echo $ostypes['pagination'] ?>
        </div>
        <!-- /.box-footer-->
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
</body>
</html>
