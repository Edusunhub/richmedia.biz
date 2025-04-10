<?php
require_once('../config.php');
require_once('session.php');
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Campaigns Reports</title>
  <?php include('../common/head.php') ?>
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo baseurl ?>/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
</head>
<body class="hold-transition skin-blue sidebar-collapse">
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
        <li><a href="<?php echo baseurl ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Reports</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="box">
        <div class="col-md-12">
          <?php echo flashNotification() ?>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-sm-12 text-right">
              <a href="reports.php" class="btn btn-default">Back</a>
              <a href="report-export.php" class="btn btn-info">Export</a>
              <br/>
              <br/>
            </div>
          </div>
          <table id="reports-table" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>Campaign ID</th>
                <th>IO</th>
                <th>Reported on</th>
                <th>Name</th>
                <th>Model</th>
                <th>Type</th>
                <th>Impressions</th>
                <th>Clicks</th>
                <th>Conversions</th>
                <th>CTR</th>
                <th>Unit Price</th>
                <th>Spent</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $reports=$reportModule->getReportHistoryByGroupID();
              if(!empty($reports['datas'])){
                foreach ($reports['datas'] as $key => $report) {
              ?>
              <tr>
                <td><?php echo $report['campaign_id']; ?></td>
                <td><?php echo $report['io']; ?></td>
                <td><?php echo date('jS M Y',strtotime($report['created_at'])); ?></td>
                <td><?php echo $report['campaign_name']; ?></td>
                <td><?php echo $report['model']; ?></td>
                <td class="text-capitalize"><?php echo $report['type']; ?></td>
                <td><?php echo $report['impression']; ?></td>
                <td><?php echo $report['clicks']; ?></td>
                <td><?php echo $report['conversions']; ?></td>
                <td><?php echo $report['ctr']; ?></td>
                <td><?php echo $report['unit_price']; ?></td>
                <td><?php echo number_format((float)$report['spent'], 2, '.', ''); ?></td>
              </tr>
              <?php
                }
              }
              ?>
            </tbody>
          </table>
          <br/>
          <?php echo $reports['pagination'] ?>
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
