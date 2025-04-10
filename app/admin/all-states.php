<?php
require_once('../config.php');
require_once('session.php');
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>State</title>
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
      <h1>State</h1>
      <ol class="breadcrumb">
        <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">State</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <div class="row">
            <div class="col-md-10">
              <form class="row">
                <div class="col-md-2">
                  <input type="text" name="key" class="form-control" placeholder="Key Words" value="<?php echo $_REQUEST['key'] ?>">
                </div>
                <div class="col-md-2">
                  <select name="country" class="form-control">
                    <option value="">Country</option>
                    <?php
                    $allcountries=$common->getCountries();
                    if(!empty($allcountries)){
                      foreach ($allcountries as $key => $country) {
                    ?>
                        <option <?php echo filterSelect($_REQUEST['country'],$country['id']) ?> value="<?php echo $country['id'] ?>"><?php echo $country['name'] ?></option>
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
            <!-- <div class="col-md-2"><a href="new-isp.php" class="btn btn-default pull-right">Add New</a></div> -->
          </div>
        </div>
        <div class="box-body">
          <div class="col-md-12">
            <?php echo flashNotification() ?>
          </div>
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>State Code</th>
                <th>Name</th>
                <th>Country</th>
                <th style="width: 80px">Status</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $allstates=$common->getAllStates();
              if(!empty($allstates['data'])){
                foreach ($allstates['data'] as $key => $state) {
              ?>
                  <tr>
                    <td><?php echo $state['state_code'] ?></td>
                    <td><?php echo $state['name'] ?></td>
                    <td><?php echo $state['cname'] ?></td>
                    <td>
                      <?php
                      $status=array(1=>'<span class="badge bg-green">Active</span>',2=>'<span class="badge bg-green">Inactive</span>');
                      echo $status[$state['status']];
                      ?>
                    </td>
                  </tr>
              <?php
                }
              }else{
                echo '<tr><td colspan="4">Data not found</td></tr>';
              }
              ?>
            </tbody>
          </table>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          <div class="pull-right">
            <?php echo $allstates['pagination'] ?>
          </div>
        </div>
        <!-- /.box-footer-->
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
</script>
</body>
</html>