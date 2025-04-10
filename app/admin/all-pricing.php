<?php
require_once('../config.php');
require_once('session.php');
if(isset($_REQUEST['delete'])){
  $pricing->delete($_REQUEST['delete']);
}
?>
<?php $campains=$campaign->allCampaignTypes(); ?>
<?php $allmodels=$models->allModels(); ?>
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
        <li class="active">Pricing</li>
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
                  <select name="model" class="form-control">
                    <option value="">Model</option>
                    <?php
                    $allmodel=array();
                    if(!empty($allmodels)){
                      foreach ($allmodels as $key => $model) {
                        $allmodel[$model['id']]=$model['name'].'&nbsp;&nbsp;-&nbsp;&nbsp;'.$model['type']; 
                    ?>
                        <option <?php echo filterSelect($_REQUEST['model'],$model['id']) ?> value="<?php echo $model['id'] ?>"><?php echo $model['name']."&nbsp;&nbsp;-&nbsp;&nbsp;".$model['type'];  ?></option>
                    <?php
                      }

                    }
                    ?>
                  </select>
                </div>
                <!--<div class="col-md-2">
                  <select name="type" class="form-control">
                    <option value="">Type</option>
                    <?php
                    $allcampains=array();
                    if(!empty($campains)){
                      foreach ($campains as $key => $camp) {
                        $allcampains[$camp['id']]=$camp['name'];
                    ?>
                        <option <?php echo filterSelect($_REQUEST['type'],$camp['id']) ?> value="<?php echo $camp['id'] ?>"><?php echo $camp['name'] ?></option>
                    <?php
                      }

                    }
                    ?>
                  </select>
                </div>-->
                <div class="col-md-2">
                  <select name="status" class="form-control">
                    <option value="">Status</option>
                    <option <?php echo filterSelect($_REQUEST['status'],'1') ?> value="1">Active</option>
                    <option <?php echo filterSelect($_REQUEST['status'],'0') ?> value="0">Inactive</option>
                  </select>
                  <input type="hidden" name="limit" value="<?php echo $_REQUEST['limit'] ?>" class="btn btn-warning">
                </div>
                <div class="col-md-2">
                  <input type="submit" name="filter" value="filter" class="btn btn-warning">
                </div>
              </form>
            </div>
            <div class="col-md-2"><a href="new-price.php" class="btn btn-default pull-right">Add New</a></div>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th style="width: 15px;">S.No</th>
                <th style="width: 15px;">ID</th>
                <th>Country</th>
                <th>Model</th>
                <!--<th>Type</th>-->
                <th>Min.Bid</th>
                <th>Max.Bid</th>
                <th style="width: 70px;">Status</th>
                <th style="width: 100px;">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $allprices=$pricing->getAllPrices();
              if(!empty($allprices['data'])){
                $i=(!empty($_GET['page']) && $_GET['page'] > 1 ) ? ($_GET['page']-1)*15+1 : 1;
                foreach ($allprices['data'] as $key => $price) {
              ?>
              <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $price['id']; ?></td>
                <td style="text-align: left;"><?php echo $price['name']; ?></td>
                <td><?php echo $allmodel[$price['model']] ?></td>
                <!--<td><?php echo $allcampains[$price['type']]; ?></td>-->
                <td><?php echo $price['min_bid']; ?></td>
                <td><?php echo $price['max_bid']; ?></td>
                <td class="text-center">
                  <?php
                  $status=array(1=>array('label'=>'Active','class'=>'bg-green'),0=>array('label'=>'Inactive','class'=>'bg-red'));
                  echo '<small class="label '.$status[$price['status']]['class'].'">';
                  echo $status[$price['status']]['label'];
                  echo '</small>';
                  ?>                    
                </td>
                <td class="text-center">
                  <a href="edit-pricing.php?id=<?php echo $price['id'] ?>" class="btn btn-sm btn-default">
                    <i class="fa fa-pencil"></i>
                    <a onclick="return confirm('Are you sure?')" href="all-pricing.php?delete=<?php echo md5($price['id']); ?>" class="btn btn-sm btn-default">
                    <i class="fa fa-trash"></i>
                  </a>
                  </a>
                </td>
              </tr>
              <?php
              $i++;
                }
              }else{
              ?>
                <tr>
                  <td colspan="9">No data found</td>
                </tr>
              <?php
              }
              ?>
            </tbody>
          </table>
          <div class="row" style="margin: 2px 0 !important;">
              <div class="col-md-2" style="padding-left: 0 !important;">
                <form id="limit">
                  <select name="limit" class="form-control" onchange="this.form.submit();">
                    <option value="">no of record</option>
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="30">30</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                  </select>
                </form>
            </div>
            <?php echo $allprices['pagination'] ?>
          </div>
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
