<?php
require_once('../config.php');
require_once('session.php');
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Campaigns</title>
  <?php include('../common/head.php') ?>
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo baseurl ?>/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
</head>
<body class="hold-transition skin-blue sidebar-collapse">
<!-- Site wrapper -->
<div class="wrapper">
  <div class="content-wrapper">
  <?php include('../common/advertiser-header.php') ?>
  <?php include('../common/sidebar.php') ?>

  <!-- Content Wrapper. Contains page content -->
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Campaigns List</h1>
      <ol class="breadcrumb">
        <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Campaigns</li>
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
                <div class="col-md-2">
                  <input type="text" name="key" class="form-control" placeholder="Key Words" value="<?php echo $_REQUEST['key'] ?>">
                </div>
                <div class="col-md-2">
                  <select name="status" class="form-control">
                    <option value="">Status</option>
                    <option <?php echo filterSelect($_REQUEST['status'],'0') ?> value="0">Payment Pending</option>
                    <option <?php echo filterSelect($_REQUEST['status'],'1') ?> value="1">Pending</option>
                    <option <?php echo filterSelect($_REQUEST['status'],'2') ?> value="2">Active</option>
                    <option <?php echo filterSelect($_REQUEST['status'],'3') ?> value="3">Pause</option>
                  </select>
                </div>
                <div class="col-md-2">
                  <input type="submit" name="filter" value="filter" class="btn btn-warning">
                </div>
              </form>
            </div>
            <div class="col-md-2"><a href="new-campaign.php" class="btn btn-default pull-right">Add New</a></div>
          </div>
        </div>

        <!-- /.box-header -->
        <div class="box-body">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th style="width: 70px;">Campaign ID</th>
                <th>IO ID</th>
                <th>Name</th>
                <!--<th>Type</th>-->
                <th>Model</th>
                <th style="width: 70px;">Status</th>
                <th>Created On</th>
                <th>Budget</th>
                <th>Spent Amount</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th style="width: 90px;">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $campaigns=$campaign->getUserCampaigns();
              if(!empty($campaigns['data'])){
                foreach ($campaigns['data'] as $key => $camp) {
              ?>
              <tr>
                <td><?php echo $camp['id']; ?></td>
                <td>#<?php echo $camp['io']; ?></td>
                <td><?php echo htmlspecialchars_decode($camp['name']); ?><?php $permodel=$performancemodel->getPerformanceModelByID($camp['performodel']); if($permodel['name']=='Adult'||$permodel['name']=='adult'){
                        echo '<small class="adult-label">'.$permodel['name'].'</small>';
                      }?></td>
                <!--<td class="text-capitalize"><?php echo $camp['type']; ?></td>-->
                <td><?php echo $camp['modelname'].'&nbsp;&nbsp;-&nbsp;&nbsp;'.$camp['modeltype']; ?></td>
                <td class="text-center">
                  <?php
                  $status=array(
                    0=>array('label'=>'Payment Pending','class'=>'bg-red'),
                    1=>array('label'=>'Pending','class'=>'bg-yellow'),
                    2=>array('label'=>'Active','class'=>'bg-green'),
                    3=>array('label'=>'Pause','class'=>'bg-blue'),
                    5=>array('label'=>'Make Payment','class'=>'bg-maroon')
                  );
                  echo '<small class="label '.$status[$camp['status']]['class'].'">';
                  echo $status[$camp['status']]['label'];
                  echo '</small>';
                  ?>                    
                </td>
                <td><?php echo date('jS M, Y',strtotime($camp['created_at'])); ?></td>
                <td>$<?php echo number_format($camp['total_budget'],2); ?></td>
                <td>$<?php $reports=$reportModule->getSpentAmount($camp['id']); echo $reports['amt'] ?number_format($reports['amt'],2) : '0.00'; ?></td>
                <td><?php echo date('jS M, Y',strtotime($camp['startdate'])); ?></td>
                <td><?php echo date('jS M, Y',strtotime($camp['enddate'])); ?></td>
                <td>
                  <a href="view-campaign.php?id=<?php echo md5($camp['id']) ?>" class="btn btn-sm btn-default">
                    <i class="fa fa-eye"></i>
                  </a>
                  <?php //if($camp['status']!=3){ ?>
                  <a href="edit-campaign.php?token=<?php echo md5($camp['id']) ?>&edit=<?php echo strtotime('now') ?>" <?php if(in_array($camp['status'],array(2))){ ?> onclick="return confirm('Hi, This campaign seems to be live. If you edit the core fields this campaign will sent to pause and will be live after support team review. Are you sure want to proceed ?')" <?php  } ?> class="btn btn-sm btn-default">
                    <i class="fa fa-edit"></i>
                  </a>
                  <?php //} ?>
                  <?php if(in_array($camp['status'],array(5))){ ?>
                  <a href="campaign-payment.php?token=<?php echo md5($camp['id']) ?>" class="btn btn-sm btn-success mt-5" title="Please make a payment">
                    <i class="fa fa-money"></i>
                  </a>
                <?php } ?>
                <?php if($camp['renewstatus']==1){ ?>
                  <a onclick="return confirm('Are you sure renew campaign?')" href="new-campaign.php?step=7&token=<?php echo md5($camp['id']); ?>&model=<?php echo $camp['modelname']; ?>&renew=renewcam" class="btn btn-sm btn-default">
                    <i class="fa fa-refresh"></i>
                  </a>
                <?php } ?>
                </td>
              </tr>
              <?php
                }
              }else{
                echo '<tr><td colspan="11">Data not found</td></tr>';
              }
              ?>
            </tbody>
          </table>
          <br/>
          <?php echo $campaigns['pagination'] ?>
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
<!-- DataTables -->
<script src="<?php echo baseurl ?>/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo baseurl ?>/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script>
  $(function () {
    $('#ostype-table').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : true,
      'ordering'    : false,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>
</body>
</html>
