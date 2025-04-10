<?php
require_once('../config.php');
require_once('session.php');
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Pricing</title>
  <?php include('../common/head.php') ?>
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo baseurl ?>/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
</head>
<body class="hold-transition skin-blue sidebar-collapse">
<!-- Site wrapper -->
<div class="wrapper">
  <?php include('../common/header.php') ?>
  <?php include('../common/sidebar.php') ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <section class="content">
      <div class="box">
        <div class="col-md-12">
          <?php echo flashNotification() ?>
        </div>
        <div class="box-header">
          <h3 class="box-title">Pricing</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table id="ostype-table" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th style="width: 80px;">Sort Name</th>
                <th>Name</th>
                <th>Min. Bid</th>
                <th>Max. Bid</th>
                <th style="width: 70px;">Status</th>
                <th style="width: 30px;">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $countries=$pricing->getPrices();;
              if(!empty($countries)){
                foreach ($countries as $key => $country) {
              ?>
              <tr>
                <td><?php echo $country['sortname']; ?></td>
                <td style="text-align: left;"><?php echo $country['name']; ?></td>
                <td><?php echo $country['min_bid']; ?></td>
                <td><?php echo $country['max_bid']; ?></td>
                <td class="text-center">
                  <?php
                  $status=array(1=>array('label'=>'Active','class'=>'bg-green'),2=>array('label'=>'Inactive','class'=>'bg-red'));
                  echo '<small class="label '.$status[$country['status']]['class'].'">';
                  echo $status[$country['status']]['label'];
                  echo '</small>';
                  ?>                    
                </td>
                <td class="text-center">
                  <a href="edit-pricing.php?id=<?php echo $country['id'] ?>" class="btn btn-sm btn-default">
                    <i class="fa fa-pencil"></i>
                  </a>
                </td>
              </tr>
              <?php
                }
              }
              ?>
            </tbody>
            <tfoot>
              <tr>
                <th>Sort Name</th>
                <th>Name</th>
                <th>Min. Bid</th>
                <th>Max. Bid</th>
                <th>Status</th>
                <th style="width: 70px;">Action</th>
              </tr>
            </tfoot>
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
    $('#ostype-table').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : true,
      'ordering'    : false,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>
</body>
</html>
