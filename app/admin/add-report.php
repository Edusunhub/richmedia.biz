<?php
require_once('../config.php');
require_once('session.php');
//$campaigns=$campaign->getAllCampaignsByEncriptGroupId($_REQUEST['id']);
if(isset($_POST['report'])){
  $reportModule->addReport();
}
if(isset($_REQUEST['id'])){
  $reportcampaign=$campaign->getCampaignByIdEncript($_REQUEST['id']);
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Reports</title>
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
      <h1>Reports</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Reports</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="box">
        <div class="col-md-12">
          <?php echo flashNotification() ?>
        </div>    
        <div class="box-body">
          <form method="post" class="form-horizontal">
            <div class="box-header">
              <h3 class="box-title">Add Report</h3>
            </div>
            <div class="box-body">
              <div class="col-md-offset-3">
                <table class="table">
                  <thead>
                    <tr>
                      <td><small>Campaign Name:</small></td><td><strong><?php echo $reportcampaign['name'] ?></strong></td>
                    </tr>
                    <tr>
                      <td class="text-capitalize"><small>Type:</small></td><td><strong><?php echo $reportcampaign['type'] ?></strong></td>
                    </tr>
                    <tr>
                      <td><small>Model:</small></td><td><strong><?php $model=$models->getModelByID($reportcampaign['model']); echo $model['name'] ?></strong></td>
                    </tr>
                    <tr>
                      <td><small>Daily:</small></td><td><strong><?php echo '$'.$reportcampaign['daily_amount'] ?></strong></td>
                    </tr>
                    <tr>
                      <td><small>Budged:</small></td><td><strong><?php echo '$'.$reportcampaign['total_budget'] ?></strong></td>
                    </tr>
                  </thead>
                </table>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">CPM/CPC</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" onchange="reportCalc('<?php echo $reportcampaign['model'] ?>')" name="rate" id="rate" required >
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">Impression</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" onchange="reportCalc('<?php echo $reportcampaign['model'] ?>')" name="impression" id="impression" required>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">Clicks</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" onchange="reportCalc('<?php echo $reportcampaign['model'] ?>')" name="clicks" id="clicks" required>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">Conversions</label>
                <div class="col-sm-9">
                  <input type="number" min="0" class="form-control" onchange="reportCalc('<?php echo $reportcampaign['model'] ?>')" name="conversions" id="conversions">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">CTR</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" onchange="reportCalc('<?php echo $reportcampaign['model'] ?>')" name="ctr" id="ctr" required>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">Unit Price</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" onchange="reportCalc('<?php echo $reportcampaign['model'] ?>')" name="unit_price" id="unit_price" value="<?php echo $report['unit_price'] ?>">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">Spent</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="spent" id="spent" required>
                </div>
              </div>
              <div class="form-group text-center">
                  <button type="submit" name="report" class="btn btn-info">Save</button>
                  <input type="hidden" class="form-control" name="user_id" value="<?php echo $reportcampaign['created_by'] ?>">
                  <input type="hidden" class="form-control" name="campaign_id" value="<?php echo $reportcampaign['id'] ?>">
                  <input type="hidden" class="form-control" name="campaign_parent_id" value="<?php echo $reportcampaign['campaign_group'] ?>">
                  <input type="hidden" class="form-control" name="type" value="<?php echo $reportcampaign['type'] ?>">
                  <input type="hidden" class="form-control" name="model" value="<?php echo $reportcampaign['model'] ?>">
              </div>
            </div>
            <!-- /.box-footer -->
          </form>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php include('../common/footer.php') ?>  
</div>
<?php include('../common/footer-script.php') ?>
<script type="text/javascript">
function reportCalc(model){
  //CPL= Impression/1000*CPM Rate => Spent
  var rate=impression=click=crt=spent=0;
  if(model==1 || model==2 ){
    console.log(model);
    impression=parseFloat($('#impression').val());
    click=parseFloat($('#clicks').val());
    crt=click/impression;
    rate=parseFloat($('#rate').val());
    spent=(impression/1000)*rate;
    if(isNaN(crt)) {
      crt='';
    }
    if(isNaN(spent)) {
      spent='';
    }
  }
  if(model==3){
    //CPC= Clicks*CPC Rate (0.2) => Spent
    console.log(model);
    rate=parseFloat($('#rate').val());
    impression=parseFloat($('#impression').val());
    click=parseFloat($('#clicks').val());
    crt=click/impression;
    spent=click*rate;
    if(isNaN(crt)) {
      crt='';
    }
    if(isNaN(spent)) {
      spent='';
    }
  }
  if(model==4){
    //CPM= Impression/1000*CPM Rate (2) => Spent
    console.log(model);
    impression=parseFloat($('#impression').val());
    click=parseFloat($('#clicks').val());
    crt=click/impression;
    rate=parseFloat($('#rate').val());
    spent=(impression/1000)*rate;
    if(isNaN(crt)) {
      crt='';
    }
    if(isNaN(spent)) {
      spent='';
    }
  }
  $('#ctr').val(crt);
  $('#spent').val(spent);
}
</script>
</body>
</html>