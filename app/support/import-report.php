<?php
require_once('../config.php');
require_once('session.php');
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>New Report</title>
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
      <ol class="breadcrumb">
        <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Report</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="col-md-3"></div>
      <div class="col-md-6">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Find Campaign</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <div class="col-sm-12 notificatiion-cover">
              <?php echo flashNotification() ?>
            </div>
            <form method="POST" class="form-horizontal" id="import" enctype="multipart/form-data" onsubmit="return importReport(this)">
              <div class="box-body">
                <div class="form-group">
                  <label class="col-sm-4 control-label">Choose CSV File</label>
                  <div class="col-sm-8">
                    <input type="file" name="file" id="file" accept=".csv" class="form-control">
                  </div>
                </div>
                <div class="form-group text-center">
                    <button type="submit" id="submit" name="import" class="btn btn-info">Import</button>
                    <br/>
                    <small><a href="<?php echo baseurl.'/report.csv' ?>">Click here to download Sample CSV File</a></small>
                </div>
              </div>
              <!-- /.box-footer -->
            </form>
          </div>
          <!-- /.box -->
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php include('../common/footer.php') ?>  
<div class="loader" style="display: none;">
  <img src="<?php echo baseurl.'/dist/img/loader.svg' ?>">
</div>
</div>
<?php include('../common/footer-script.php') ?>
<script type="text/javascript">
function importReport(argument) {
  $('.loader').show();
  // Get form
  var form = $('#import')[0];
  // Create an FormData object 
  var data = new FormData(form);
  data.append("action", "import");
  $.ajax({
    data    :   data,
    url     :   '../ajax.php',
    type    :   'post',
    enctype: 'multipart/form-data',
    processData: false,  // Important!
    contentType: false,
    cache: false,
    success :   function(html){
      $('.notificatiion-cover').html(html);
      $('.loader').hide();
    }
  })
  return false;
}
/*$( "#import" ).on( "submit", function( event ) {
  event.preventDefault();
  console.log( $( this ).serialize() );
});*/
</script>
<style type="text/css">
.loader {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100vh;
    background: rgba(0,0,0,0.5);
    text-align: center;
    padding: 50vh 0 0 0;
    z-index: 5;
}
</style>
</body>
</html>