<?php
require_once('../config.php');
require_once('session.php');
if(isset($_POST['export'])){
	$reports=$reportModule->export();
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Report</title>
  <?php include('../common/head.php') ?>
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo baseurl ?>/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
</head>
<body class="hold-transition skin-blue sidebar-collapse">
<!-- Site wrapper -->
<div class="wrapper">
  <?php
  $title='Report';
  $breadcrumbdata=array(
    0=>array(
      'link'=>'dashboard.php',
      'name'=>'Home'
    ),
    1=>array(
      'link'=>'',
      'name'=>'Report'
    )
  )
  ?>
  <div class="content-wrapper bg-image">
  <?php include('../common/advertiser-header.php') ?>
  <?php include('../common/sidebar.php') ?>

  <!-- Content Wrapper. Contains page content -->
    <section class="content">
      <div class="white-wapper">
        <div class="white-layer-none">
          <div class="gray-box">
            <h4 class="gray-box-title">Report List</h4>
            <?php echo flashNotification() ?>
            <div class="row">
              <div class="col-md-6 col-md-offset-3 filter-form">
                <form method="post" class="form-horizontal export-form" enctype="multipart/form-data">
                  <div class="form-group">
                    <div class="col-sm-12">
                      <div class="input-group">
                        <input type="text" class="form-control pull-left datepicker" name="from" value="<?php echo $_REQUEST['from'] ?>" autocomplete="off" placeholder="From Date">
                        <div class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-12 mt-1">
                      <div class="input-group">
                        <input type="text" class="form-control pull-left datepicker" name="to" value="<?php echo $_REQUEST['to'] ?>" autocomplete="off" placeholder="To Date">
                        <div class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-12 mt-1">
                      <select class="form-control" name="country">
                        <option value="">Select Country</option>
                        <?php
                        $countries=$common->getCountries();
                        if(!empty($countries)){
                          foreach ($countries as $key => $country) {
                            echo '<option '.filterSelect($_REQUEST['country'],$country['sortname']).' value="'.$country['sortname'].'">'.$country['name'].'</option>';
                          }
                        }
                        ?>
                      </select>
                    </div>
                    <div class="col-sm-12 mt-1">
                      <select class="form-control" name="type">
                        <option value="">Select Type</option>
                        <?php
                        $types=$campaign->allCampaignTypes();
                        if(!empty($types)){
                          foreach ($types as $key => $type) {
                            echo '<option '.filterSelect($_REQUEST['type'],$type['name']).' value="'.$type['name'].'">'.$type['name'].'</option>';
                          }
                        }
                        ?>
                      </select>
                    </div>
                    <div class="col-sm-12 mt-1">
                      <select class="form-control" name="model">
                        <option value="">Select Model</option>
                        <?php
                        $allmodels=$models->allModels();
                        if(!empty($allmodels)){
                          foreach ($allmodels as $key => $model) {
                            echo '<option '.filterSelect($_REQUEST['model'],$model['name']).' value="'.$model['name'].'">'.$model['name'].'</option>';
                          }
                        }
                        ?>
                      </select>
                    </div>
                    <div class="col-sm-12 mt-1">
                      <label class="form-label">Select Additional Column</label>
                      <select class="form-control select2" name="grouping[]" multiple="">
                        <option value="operating_system">Operating System</option>
                        <option value="ssp">SSP</option>
                        <option value="city">City</option>
                        <option value="domain">Domain</option>
                        <option value="landing_domain">Landing Domain</option>
                        <option value="browser">Browser</option>
                        <option value="site">Site</option>
                        <option value="video">Video</option>
                        <option value="zip_code">Zipcode</option>
                        <option value="server">Server</option>
                        <option value="campaign">Campaign</option>
                        <option value="device_type">Device Type</option>
                        <option value="creative_Type">Creative Type</option>
                        <option value="carrier">Carrier</option>
                        <option value="keywords">Keywords</option>
                        <option value="region">Region</option>
                        <option value="closed">Closed</option>
                        <option value="skipped">Skipped</option>
                        <option value="watched">Watched</option>
                        <option value="view_rate">View Rate</option>
                        <option value="PCC">PCC</option>
                        <option value="PVC">PVC</option>
                        <option value="opportunities">Opportunities</option>
                      </select>
                    </div>
                    <div class="col-sm-12 mt-1 text-center">
                      <input type="submit" class="btn btn-warning" name="export" value="Export">
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php //include('../common/footer.php') ?>  
</div>
<?php include('../common/footer-script.php') ?>
<!-- DataTables -->
<script src="<?php echo baseurl ?>/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo baseurl ?>/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script>
$('.select2').select2();
$('.datepicker').datepicker({
  autoclose: true,
  format:'d-m-yyyy'
})
</script>
<style type="text/css">
.export-form .form-control{
	border: 1px solid #F6A269;
	background: #fff;
}
.export-form .input-group .input-group-addon{
	border-color:#F6A269;
}
.export-form .select2-container--default .select2-selection--multiple{
	background: #fff !important;
	border: 1px solid #F6A269 !important;
}
</style>
</body>
</html>