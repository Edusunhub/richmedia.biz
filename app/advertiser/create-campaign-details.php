<?php
require_once('../config.php');
require_once('session.php');
$allos=$os->all();
if(isset($_POST['campaignsetp1'])){
  $campaign->saveSetp1();
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Create Campaign</title>
  <?php include('../common/head.php') ?>
  <link rel="stylesheet" type="text/css" href="<?php echo baseurl .'/dist/css/jquery.magicsearch.css' ?>">
</head>
<body class="hold-transition skin-blue sidebar-collapse">
<!-- Site wrapper -->
<div class="wrapper">
  <?php
  $title='Campaign';
  $breadcrumbdata=array(
    0=>array(
      'link'=>'dashboard.php',
      'name'=>'Home'
    ),
    1=>array(
      'link'=>'',
      'name'=>'Create Campaign'
    )
  )
  ?>
  <div class="content-wrapper bg-image">
  <?php include('../common/advertiser-header.php') ?>
  <?php include('../common/sidebar.php') ?>
    <!-- Main content -->
    <section class="content">
      <div class="white-wapper">
        <div class="white-layer">
          <h4 class="white-layer-title"><?php echo $_REQUEST['type'] ?> - Campaign Details</h4>
          <?php echo flashNotification() ?>
          <form method="post" class="theme-fields-form">
            <div class="row">
                <div class="col-md-6">
                  <div class="white-box pl-5 pr-5">
                    <h4 class="white-box-sub-titile">Targeting:</h4>
                    <div class="form-group">
                      <div class="row">
                        <label class="col-sm-4 control-label">Campaign Name: </label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control theme-field" name="name">
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <label class="col-sm-4 control-label">Campaign Model Type: </label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control theme-field" name="type" value="<?php echo $_REQUEST['type'] ?>" readonly>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <label class="col-sm-4 control-label">Device Type:</label>
                      </div>
                      <div class="row">
                        <div class="col-sm-1"></div>
                        <div class="col-sm-11">
                          <div class="row">
                            <div class="col-sm-4 device-box">
                              <label>
                                <img src="<?php echo baseurl.'/images/pc-device.png' ?>">
                                <input type="checkbox" name="device[]" value="computer">
                              </label>
                            </div>
                            <div class="col-sm-4 device-box">
                              <label>
                                <img src="<?php echo baseurl.'/images/mobile-device.png' ?>">
                                <input type="checkbox" name="device[]" value="tab">
                            </label>
                            </div>
                            <div class="col-sm-4 device-box">
                              <label>
                                <img src="<?php echo baseurl.'/images/tab-device.png' ?>">
                                <input type="checkbox" name="device[]" value="mobile">
                              </label>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <label class="col-sm-3 control-label">OS Type: </label>
                        <div class="col-sm-9">
                          <input class="magicsearch form-control" id="basic" name="ostype">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="white-box pl-5 pr-5">
                    <div class="form-group">
                      <div class="row">
                        <label class="col-sm-4 control-label">Browser: </label>
                        <div class="col-sm-8">
                          <textarea class="form-control" rows="6" name="browser"></textarea>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <label class="col-sm-4 control-label">Browser Language: </label>
                        <div class="col-sm-8">
                          <textarea class="form-control" rows="5" name="language"></textarea>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <label class="col-sm-4 control-label">ISP: </label>
                        <div class="col-sm-8">
                          <textarea class="form-control" rows="5" name="isp"></textarea>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <label class="col-sm-4 control-label">Connection Type:</label>
                        <div class="col-sm-8">
                          <select class="form-control" name="connection">
                            <option value="cellular">Cellular</option>
                            <option value="wifi">Wifi</option>
                            <option value="Both">both</option>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-sm-12">
                  <br/>
                  <a href="create-campaign.php?type=<?php echo $_REQUEST['type'] ?>" class="btn btn-warning pull-left">Previous</a>
                  <input type="submit" value="Next" name="campaignsetp1" class="btn btn-warning pull-right">
                </div>
            </div>            
          </form>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>

  <!-- /.content-wrapper -->
  <?php //include('../common/footer.php') ?>
</div>
<?php include('../common/footer-script.php') ?>
<script type="text/javascript" src="<?php echo baseurl .'/dist/js/jquery.magicsearch.min.js' ?>"></script>
<script>
$(function() {
    var dataSource = <?php echo json_encode($allos); ?>;
    $('#basic').magicsearch({
        dataSource: dataSource,
        fields: ['name'],
        id: 'id',
        format: '%name%',
        multiple: true,
        focusShow: true,
        multiField: 'name',
        hidden: true,
        multiStyle: {
            space: 4,
            width: 80
        }
    });
});
</script>
</body>
</html>
