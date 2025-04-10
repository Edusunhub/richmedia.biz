<?php
require_once('../config.php');
require_once('session.php');
if(isset($_REQUEST['delete'])){
  $os->deleteOSVersion($_REQUEST['delete']);
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>OS Versions</title>
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
      <h1>OS Versions</h1>
      <ol class="breadcrumb">
        <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">OS Versions</li>
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
                    <option <?php echo filterSelect($_REQUEST['status'],'1') ?> value="1">Active</option>
                    <option <?php echo filterSelect($_REQUEST['status'],'0') ?> value="0">Inactive</option>
                  </select>
                </div>
                <div class="col-md-2">
                  <input type="submit" name="filter" value="filter" class="btn btn-warning">
                </div>
              </form>              
            </div>
            <div class="col-md-2"><a href="new-os-version.php" class="btn btn-default pull-right">Add New</a></div>
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
                <th>OS Name</th>
                <th>Version</th>
                <th style="width: 70px;">Status</th>
                <th style="width: 100px;">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $versions=$os->getOSVersions();
              if(!empty($versions['data'])){
                $id=1;
                foreach ($versions['data'] as $key => $version) {
              ?>
              <tr>
                <td><?php echo $id; //$version['id'] ?></td>
                <td style="text-align: middle;">
                  <?php 
                        $osset=explode(",",$version['os_id']);
                        $oscount=count($osset);                              
                        $alloss=$os->all();
                        if(!empty($alloss)){
                          $chck = 1;
                          foreach ($alloss as $key => $ossvalue) {
                           if(in_array($ossvalue['id'], $osset)) {
                             echo $osname =  $ossvalue['name'];
                             if($oscount!=$chck){
                              echo ',';
                             }
                             $chck++;
                           }
                          }                               
                        }
                  ?>
                </td>
                <td class="text-center"><?php echo $version['name'] ?></td>
                <td style="vertical-align: middle;">
                  <?php if($version['status']==1){ ?>
                    <span class="badge bg-green">Active</span>
                  <?php } else { ?>
                    <span class="badge bg-red">Inactive</span>
                  <?php } ?>
                </td>
                <td>
                  <a href="edit-os-version.php?id=<?php echo md5($version['id']) ?>" class="btn btn-sm btn-default">
                    <i class="fa fa-pencil"></i>
                  </a>
                  <a onclick="return confirm('Are you sure?')" href="?delete=<?php echo md5($version['id']) ?>" class="btn btn-sm btn-default">
                    <i class="fa fa-trash"></i>
                  </a>
                </td>
              </tr>
              <?php
              $id++;
                }
              }else{
                echo '<tr><td colspan="5">Data not found</td></tr>';
              }
              ?>
            </tbody>
          </table>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          <?php echo $versions['pagination'] ?>
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
