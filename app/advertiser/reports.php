<?php
require_once('../config.php');
require_once('session.php');
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
              <div class="col-md-12 filter-form">
                <form method="get" class="form-horizontal" enctype="multipart/form-data">
                  <div class="form-group">
                    <div class="col-sm-2">
                      <div class="input-group">
                        <input type="text" class="form-control pull-left datepicker" name="from" value="<?php echo $_REQUEST['from'] ?>" autocomplete="off" placeholder="From Date">
                        <div class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-2">
                      <div class="input-group">
                        <input type="text" class="form-control pull-left datepicker" name="to" value="<?php echo $_REQUEST['to'] ?>" autocomplete="off" placeholder="To Date">
                        <div class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-2">
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
                    <div class="col-sm-2">
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
                    <div class="col-sm-2">
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
                    <div class="col-sm-1">
                      <input type="submit" class="btn btn-warning" name="search" value="Search">
                    </div>
                    <div class="col-sm-1">
                      <a href="report-export.php" class="btn btn-info">Export</a>
                    </div>
                  </div>
                </form>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <table id="reports-table" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>Campaign ID</th>
                      <th>IO</th>
                      <th>Created on</th>
                      <th>Name</th>
                      <th>Type</th>
                      <th>Model</th>
                      <th>Impressions</th>
                      <th>Clicks</th>
                      <th>Conversions</th>
                      <th>CTR</th>
                      <th>Unit Price($)</th>
                      <th>Spent($)</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $reports=$reportModule->reportsByUser();
                    if(!empty($reports['datas'])){
                      foreach ($reports['datas'] as $key => $report) {
                    ?>
                    <tr>
                      <td><?php echo $report['campaign_id']; ?></td>
                      <td><?php echo $report['io']; ?></td>
                      <td><?php echo date('jS m, Y',strtotime($report['campaign_date'])); ?></td>
                      <td><?php echo $report['campaign_name']; ?></td>
                      <td class="text-capitalize"><?php echo $report['type']; ?></td>
                      <td><?php echo $report['model']; ?></td>
                      <td><?php echo $report['impression']; ?></td>
                      <td><?php echo $report['clicks']; ?></td>
                      <td><?php echo $report['conversions']; ?></td>
                      <td><?php echo $report['ctr']; ?></td>
                      <td class="text-right"><?php echo $report['unit_price']; ?></td>
                      <td class="text-right"><?php echo number_format((float)$report['spent'], 2, '.', ''); ?></td>
                      <td>
                        <a href="report-history.php?id=<?php echo md5($report['campaign_id']); ?>&<?php echo $_SERVER['QUERY_STRING'] ?>">
                          <i class="fa fa-eye"></i>
                        </a>
                      </td>
                    </tr>
                    <?php
                      }
                    }else{
                    ?>
                      <tr>
                        <td colspan="13">No record found</td>
                      </tr>
                    <?php
                    }
                    ?>
                  </tbody>
                </table>
                <div>
                  <?php echo $reports['pagination']; ?>
                  <a href="<?php echo baseurl ?>" class="btn btn-warning pull-right">Back</a>
                </div>
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
  // $(function () {
  //   $('#reports-table').DataTable({
  //     'paging'      : true,
  //     'lengthChange': false,
  //     'searching'   : false,
  //     'ordering'    : false,
  //     'info'        : true,
  //     'autoWidth'   : false
  //   })
  // })
$('.datepicker').datepicker({
  autoclose: true,
  format:'d-m-yyyy'
})
</script>
</body>
</html>
