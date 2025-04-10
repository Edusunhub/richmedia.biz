<?php
require_once('../config.php');
require_once('session.php');
if(isset($_POST['bulk_delete_submit'])){
  $reportModule->DleteReportHistoryByID();
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
        <li><a href="all-reports.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Reports</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="box">
        <div class="box-header with-border">
          <div class="col-md-12">
            <?php echo flashNotification() ?>
          </div>
          <div class="row">
            <div class="col-md-10">
              <form class="row">
                <input type="hidden" name="id" value="<?php echo $_REQUEST['id'] ?>">
                <input type="hidden" name="token" value="<?php echo $_REQUEST['token'] ?>">
                <div class="col-md-2">
                  Report From:
                  <input type="text" name="from" class="form-control datepicker" placeholder="From Date" value="<?php echo $_REQUEST['from'] ?>" autocomplete="off" >
                </div>
                <div class="col-md-2">
                  To:
                  <input type="text" name="to" class="form-control datepicker" placeholder="To Date" value="<?php echo $_REQUEST['to'] ?>" autocomplete="off">
                </div>
                <input type="hidden" name="limit" value="<?php echo $_REQUEST['limit']; ?>" class="btn btn-warning">
                <div class="col-md-2">
                  <div>&nbsp;</div>
                  <input type="submit" name="filter" value="filter" class="btn btn-warning">
                </div>
              </form>
            </div>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <form name="bulk_action_form" action="" method="post" onSubmit="return delete_confirm();">
          <input type="submit" class="btn btn-danger" style="margin-bottom: 10px;" name="bulk_delete_submit" value="DELETE"/>
          <table id="reports-table" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th><input type="checkbox" id="select_all" value=""/></th>
                <th>Campaign ID</th>
                <th>IO</th>
                <th>User</th>
                <th>Date</th>
                <th>Name</th>
                <!--<th>Model</th>-->
                <th>Type</th>
                <th>Impressions</th>
                <th>Clicks</th>
                <!--<th>Conversions</th>-->
                <th>CTR</th>
                <!--<th>Unit Price</th>-->
                <th>Spent</th>                
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $reports=$reportModule->getReportHistoryByID($_REQUEST['id']);
              if(!empty($reports['datas'])){
                $a=1;
                foreach ($reports['datas'] as $key => $report) {
              ?>
              <tr>
                <td>                  
                    <div class="text-right;">
                      <input type="hidden" name="user_id[]" class="checkbox_user" value="<?php echo $report['user_id']; ?>">
                      <input type="hidden" name="spent[]" class="checkbox_spent" value="<?php echo $report['spent']; ?>">
                      <input type="checkbox" name="checked_id[]" class="checkbox" value="<?php echo $report['id']; ?>">
                    </div>
                </td>               
                <td><?php echo $report['campaign_id']; ?></td>
                <td><?php echo $report['io']; ?></td>
                <td>
                  <?php
                  $user=$users->getUser($report['user_id']);
                  echo $user['name'] ? $user['name'].'<br/>' : '';
                  echo $user['email'];
                  ?>
                </td>
                <td><?php echo date('jS M Y',strtotime($report['created_at'])); ?></td>
                <td><?php echo $report['campaign_name']; ?></td>
                <!--<td>
                  <?php
                  $model=$models->getModelByID($report['model']);
                  echo $model['name'];
                  ?>
                </td>-->
                <td class="text-capitalize"><?php echo $report['type']; ?></td>
                <td><?php echo $report['impression']; ?></td>
                <td><?php echo $report['clicks']; ?></td>
                <!--<td><?php echo $report['conversions']; ?></td>-->
                <td><?php echo $report['ctr']; ?></td>
                <!--<td><?php echo $report['unit_price']; ?></td>-->
                <td><?php echo number_format($report['spent'],2); ?></td>                
                <td>
                  <a href="edit-import-report.php?id=<?php echo md5($report['id']) ?>" class="btn btn-sm btn-default">
                    <i class="fa fa-pencil"></i>
                  </a>
                </td>       
              </tr>
              <?php
                }
              }else{
                echo '<tr><td colspan="12">No data found</td></tr>';
              }
              ?>
            </tbody>
          </table>
          </form>
          <div class="row" style="margin: 2px 0 !important;">
            <div class="col-md-2" style="padding-left: 0 !important;">
              <form id="limit">
                <input type="hidden" name="id" value="<?php echo $_REQUEST['id'] ?>">
                <input type="hidden" name="token" value="<?php echo $_REQUEST['token'] ?>">
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
            <?php echo $reports['pagination'] ?>
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
<script type="text/javascript">
  $(document).ready(function(){
    $('#select_all').on('click',function(){
        if(this.checked){
            $('.checkbox').each(function(){
                this.checked = true;
            });
        }else{
             $('.checkbox').each(function(){
                this.checked = false;
            });
        }
    });
  
    $('.checkbox').on('click',function(){
        if($('.checkbox:checked').length == $('.checkbox').length){
            $('#select_all').prop('checked',true);
        }else{
            $('#select_all').prop('checked',false);
        }
    });
});

  function delete_confirm(){
    if($('.checkbox:checked').length > 0){
        var result = confirm("Are you sure to delete selected users record?");
        if(result){
            return true;
        }else{
            return false;
        }
    }else{
        alert('Select at least 1 record to delete.');
        return false;
    }
}
</script>
<script type="text/javascript">
$('.datepicker').datepicker({
    format: 'yyyy-mm-dd'
});
</script>
</body>
</html>
