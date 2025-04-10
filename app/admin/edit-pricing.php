<?php
require_once('../config.php');
require_once('session.php');
if($_REQUEST['id']){
  $price=$pricing->getPriceByID($_REQUEST['id']);
}
if(isset($_POST['update'])){
  $pricing->update($_REQUEST['id']);
}
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
<body class="hold-transition skin-blue">
<!-- Site wrapper -->
<div class="wrapper">
  <div class="content-wrapper">
    <?php include('../common/admin-header.php') ?>
    <?php include('../common/sidebar.php') ?>

    <section class="content-header">
      <h1>Pricing</h1>
      <ol class="breadcrumb">
        <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="all-pricing.php">Pricing</a></li>
        <li class="active">Edit Pricing</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <div class="row">
        <div class="col-md-offset-3 col-md-6">
          <div class="box">
            <div class="box-header text-center">
              <h3 class="box-title">Add New Price</h3>
              <hr/>
              <div class="col-sm-12">
                <?php echo flashNotification(); ?>
              </div>
            </div>
            <div class="box-body">
              <form class="forms-sample" method="post" enctype="multipart/form-data">
                <div class="form-group">
                  <label>Country</label>
                  <select name="country" class="form-control" required>
                    <?php
                    $allcountries=$common->getCountries();
                    if(!empty($allcountries)){
                      foreach ($allcountries as $key => $country) {
                    ?>
                        <option value="<?php echo $country['sortname'] ?>" <?php echo selectOption($country['sortname'],$price['country_code']) ?>><?php echo $country['name'] ?></option>
                    <?php
                      }
                    }
                    ?>
                  </select>
                </div>
                <div class="form-group">
                  <label>Type</label>
                  <select name="model" class="form-control" required>
                    <?php
                    $allmodels=$models->allModels();
                    if(!empty($allmodels)){
                      foreach ($allmodels as $key => $model) {
                    ?>
                        <option value="<?php echo $model['id'] ?>" <?php echo selectOption($model['id'],$price['model']) ?>><?php echo $model['name'].'&nbsp;&nbsp;-&nbsp;&nbsp;'.$model['type'] ?></option>
                    <?php
                      }
                    }
                    ?>
                  </select>
                </div>
                <!--<div class="form-group">
                  <label>Type</label>
                  <select name="type" class="form-control" required>
                    <?php
                    $allcompaigns=$pricing->allCampaignTypes();
                    if(!empty($allcompaigns)){
                      foreach ($allcompaigns as $key => $campaign) {
                    ?>
                        <option value="<?php echo $campaign['id'] ?>" <?php echo selectOption($campaign['id'],$price['type']) ?>><?php echo $campaign['name'] ?></option>
                    <?php
                      }
                    }
                    ?>
                  </select>
                </div>-->
                <div class="form-group">
                  <label>Min.Bid</label>
                  <input type="text" name="min_bid" class="form-control" required value="<?php echo $price['min_bid'] ?>">
                </div>
                <div class="form-group">
                  <label>Max.Bid</label>
                  <input type="text" name="max_bid" class="form-control" required value="<?php echo $price['max_bid'] ?>">
                </div>
                <div class="form-group">
                  <label>Status</label>
                  <select name="status" class="form-control">
                    <option value="1" <?php echo selectOption(1,$price['status']) ?>>Active</option>
                    <option value="0" <?php echo selectOption(0,$price['status']) ?>>Inactive</option>
                  </select>
                </div>
                <button type="submit" name="update" class="btn btn-warning pull-right">Save</button>
                <a href="all-pricing.php" class="btn btn-default">Back</a>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- /.box -->
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
      'searching'   : false,
      'ordering'    : false,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>
</body>
</html>