<?php
require_once('../config.php');
require_once('session.php');
if(isset($_REQUEST['status'])){
  $campaign->changeStatus($_REQUEST['status'],$_REQUEST['token']);
}
if(isset($_REQUEST['delete'])){
  $reportModule->deleteReport($_REQUEST['delete']);
}
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
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-10">
              <form class="row">
                <div class="col-md-3">
                  <input type="text" name="campaign" class="form-control" placeholder="Campaign ID / Name" value="<?php echo $_REQUEST['campaign'] ?>">
                </div>
                <div class="col-md-2">
                  <input type="submit" name="filter" value="filter" class="btn btn-warning">
                </div>
              </form>
            </div>
            <div class="col-md-2 text-right">
              <a href="import-report.php" class="btn btn-default">Import</a>
            </div>
          </div>
          <table id="reports-table" class="table table-bordered table-striped mt-1">
            <thead>
              <tr>
                <th style="width: 60px;">Campaign ID</th>
                <th>IO</th>
                <th>Impressions</th>
                <th>Clicks</th>
                <th style="width: 40px;">Conversions</th>
                <th style="width: 60px;">CTR</th>
                <th>Unit Price</th>
                <th>Spent</th>
                <th style="width: 90px;">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $reports=$reportModule->reports();
              if(!empty($reports['datas'])){
                $i=1;
                foreach ($reports['datas'] as $key => $report) {
              ?>
              <tr>
                <td><?php echo $report['campaign_id']; ?></td>
                <td><?php echo $report['io']; ?></td>
                <td><?php echo $report['impression']; ?></td>
                <td><?php echo $report['clicks']; ?></td>
                <td><?php echo $report['conversions']; ?></td>
                <td><?php echo number_format($report['ctr'],3); ?></td>
                <td><?php echo '$'.number_format($report['unit_price'],2); ?></td>
                <td><?php echo '$'.number_format($report['spent'],2); ?></td>
                <td>                  
                  <a href="report-history.php?id=<?php echo md5($report['campaign_id']) ?>&token=<?php echo md5($report['id']) ?>" class="btn btn-sm btn-default">
                    <i class="fa fa-eye"></i>                    
                  </a>
                  <a onclick="return confirm('Are you sure?')" href="?delete=<?php echo md5($report['campaign_id']); ?>" class="btn btn-sm btn-default">
                    <i class="fa fa-trash"></i>
                  </a>
                </td>
              </tr>
              <?php
                $i++;
                }
              }else{
              ?>
                <tr>
                  <td colspan="8">No data found</td>
                </tr>
              <?php
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
