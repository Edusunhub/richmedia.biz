<?php
require_once('../config.php');
require_once('session.php');
$allos=$os->all();
if(isset($_POST['campaignsetp3'])){
  $campaign->campaignsetp3();
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Create Campaign</title>
  <?php include('../common/head.php') ?>
  <link rel="stylesheet" href="<?php echo baseurl ?>/plugins/timepicker/bootstrap-timepicker.min.css">
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
    
    <?php echo flashNotification() ?>
    <!-- Main content -->
    <section class="content">
      <div class="white-wapper">
        <div class="white-layer">
          <h4 class="white-layer-title"><?php echo $_REQUEST['type'] ?> - Campaign Details</h4>
          <?php echo flashNotification() ?>

          <form method="post" enctype="multipart/form-data" class="theme-fields-form">
            <div class="row">
              <div class="col-md-6">
                <div class="white-box pt-5 pl-5 pr-5">
                  <h4 class="white-box-sub-titile">Duration:</h4>
                  <div class="form-group">
                    <div class="row">
                      <label class="col-sm-4 control-label">Start Date: </label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control datepicker" name="start_date" id="datepicker">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <label class="col-sm-4 control-label">End Date: </label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control datepicker" name="end_date" id="datepicker">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="white-box pt-5 pl-5 pr-5">
                  <h4 class="white-box-sub-titile">Budget:</h4>
                  <div class="form-group">
                    <div class="row">
                      <label class="col-sm-5 control-label">Total Campaign Budget: <small>(USD)</small></label>
                      <div class="col-sm-7">
                        <input type="text" class="form-control" name="total_budget">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <label class="col-sm-5 control-label">Daily Amount: <small>(USD)</small></label>
                      <div class="col-sm-7">
                        <input type="text" class="form-control" name="daily_amount">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <label class="col-sm-5 control-label">Frequency cap 24 hours:</label>
                      <div class="col-sm-7">
                        <input type="text" class="form-control" name="cap">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <br/>
              <div class="col-sm-12">
                <input type="hidden" name="token" value="<?php echo $_REQUEST['token'] ?>">
                <input type="hidden" name="type" value="<?php echo $_REQUEST['type'] ?>">
                <input type="submit" value="Next" name="campaignsetp3" class="btn btn-warning pull-right">
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
<script src="<?php echo baseurl ?>/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<style type="text/css">
.imagepreview-cover{
  width:100%;
  height:150px;
  background:#b1b1b1;
  text-align: center;
}
#blah{
  max-height: 100%;
  max-width: 100%;
  margin: 0 auto;
}
.tableFixHead          { overflow-y: auto; height: 200px; }
.tableFixHead thead th { position: sticky; top: 0; }

/* Just common table stuff. Really. */
table  { border-collapse: collapse; width: 100%; }
th, td { padding: 8px 16px; }
th     { background:#eee; }
</style>
<script>
function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    
    reader.onload = function(e) {
      $('#blah').attr('src', e.target.result);
    }
    
    reader.readAsDataURL(input.files[0]);
  }
}

$("#imgInp").change(function() {
  readURL(this);
});

function  selectContry(ele) {
  alert(ele.value);
  var min=$(ele).find(':selected').attr('data-minbid');
  var max=$(ele).find(':selected').attr('data-maxbid');
  var minbid='<input type="number" class="form-control" name="min_bid['+ele.value+']" min="'+min+'" max="'+max+'">';
  var maxbid='<input type="number" class="form-control" name="max_bid['+ele.value+']" min="'+min+'" max="'+max+'">';
  $(ele).parents('tr').children('.minbid').html(minbid);
  $(ele).parents('tr').children('.maxbid').html(maxbid);
}

function addNewCountry() {
  var html = '<tr>';
      html += '<td>';
      html += '<select class="form-control" name="country[]" onchange="selectContry(this)">';
      html += '<option value="">Select Country</option>';
      <?php
      $countries_bids=$pricing->getAllPricesCountries();
      if(!empty($countries_bids)){
        foreach ($countries_bids as $key => $bid) {
      ?>
      html += '<option data-minbid="<?php echo $bid['min_bid'] ?>" data-maxbid="<?php echo $bid['max_bid'] ?>" value="<?php echo $bid['country_id'] ?>"><?php echo $bid['name'] ?></option>';
    <?php
      }
    }
    ?>
    html += '</select>';
  html += '</td>';
  html += '<td class="minbid"></td>';
  html += '<td class="maxbid"></td>';
  html += '</tr>';
  $('#countries_table tbody').append(html);
}
$('.datepicker').datepicker({
  autoclose: true
})
</script>
</body>
</html>
