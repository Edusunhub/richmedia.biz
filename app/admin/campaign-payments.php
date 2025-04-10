<?php
require_once('../config.php');
require_once('session.php');
?>
<?php $campains=$campaign->allCampaignTypes(); ?>
<?php $allmodels=$models->allModels(); ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Payments</title>
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

    <section class="content-header">
      <h1>Payments</h1>
      <ol class="breadcrumb">
        <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Payments</li>
      </ol>
    </section>

    <section class="content">
      <div class="box">
        <div class="box-header with-border">
          <div class="col-md-12">
            <?php echo flashNotification() ?>
          </div>
          <div class="row">
            <div class="col-md-10">
              <form class="row">
                <?php
                    $allmodel=array();
                    if(!empty($allmodels)){
                      foreach ($allmodels as $key => $model) {
                        $allmodel[$model['id']]=$model['name'];
                        /*
                    ?>
                        <option <?php echo filterSelect($_REQUEST['model'],$model['id']) ?> value="<?php echo $model['id'] ?>"><?php echo $model['name'] ?></option>
                    <?php
                        */
                      }

                    }
                    ?>
                <!-- <div class="col-md-2">
                  <select name="model" class="form-control">
                    <option value="">Users</option>
                    
                  </select>
                </div> -->
                <?php
                    $allcampains=array();
                    if(!empty($campains)){
                      foreach ($campains as $key => $camp) {
                        $allcampains[$camp['id']]=$camp['name'];
                        /*
                    ?>
                        <option <?php echo filterSelect($_REQUEST['type'],$camp['id']) ?> value="<?php echo $camp['id'] ?>"><?php echo $camp['name'] ?></option>
                    <?php
                        */
                      }

                    }
                    ?>
                <!-- <div class="col-md-2">
                  <select name="type" class="form-control">
                    <option value="">Type</option>
                  </select>
                </div> -->
                <div class="col-md-3">
                  <input type="text" name="campaign" class="form-control" placeholder="Campaign ID / Name" value="<?php echo $_REQUEST['campaign'] ?>">
                </div>
                <div class="col-md-3">
                  <input type="text" name="advertiser" class="form-control" placeholder="Advertiser ID / Name" value="<?php echo $_REQUEST['advertiser'] ?>">
                </div>
                <div class="col-md-2">
                  <select name="status" class="form-control">
                    <option value="">Status</option>
                    <option <?php echo filterSelect($_REQUEST['status'],'0') ?> value="0">Pending</option>
                    <option <?php echo filterSelect($_REQUEST['status'],'2') ?> value="2">Approved</option>
                    <option <?php echo filterSelect($_REQUEST['status'],'3') ?> value="3">Decline</option>
                  </select>
                  <input type="hidden" name="limit" value="<?php echo $_REQUEST['limit'] ?>" class="btn btn-warning">
                </div>
                <div class="col-md-2">
                  <input type="submit" name="filter" value="filter" class="btn btn-warning">
                </div>
              </form>
            </div>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>User Name</th>
                <th>Campaign ID</th>
                <th>Campaign Name</th>
                <th>Model</th>
                <th>Budget</th>
                <th>Payment Type</th>
                <th>TX.ID</th>
                <th>Date</th>
                <th style="width: 70px;">Status</th>
                <th style="width: 90px;">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $allpayments=$payments->getCampaignPayments();
              if(!empty($allpayments['data'])){
                foreach ($allpayments['data'] as $key => $price) {
              ?>
              <tr>
                <td>
                  <?php echo $price['uname'] ?  $price['uname'].'<br/>' :''; ?>
                  <?php echo $price['email'] ?  '<small>('.$price['email'].')</small>' :''; ?>                  
                </td>
                <td><?php echo $price['campaign_id']; ?></td>
                <td style="word-break: break-all;"><?php echo htmlspecialchars_decode($price['name']); ?></td>
                <td><?php echo $allmodel[$price['cmodel']].'&nbsp;&nbsp;-&nbsp;&nbsp;'.$price['ctype']; ?></td>
                <td>$<?php echo number_format($price['total_budget'],2); ?></td>
                <td><?php echo $price['type']; ?></td>
                <td style="word-break: break-all;"><?php echo $price['transactionid']; ?></td>
                <td><?php echo date('jS M, Y - h:m:s A',strtotime($price['created_at'])) ?></td>
                <td class="text-center">
                  <?php
                  $status=array(
                    0=>array('label'=>'Pending','class'=>'bg-orange'),
                    1=>array('label'=>'Verified','class'=>'bg-blue'),
                    2=>array('label'=>'Approved','class'=>'bg-green'),
                    3=>array('label'=>'Decline','class'=>'bg-red')
                  );
                  echo '<small class="label '.$status[$price['status']]['class'].'">';
                  echo $status[$price['status']]['label'];
                  echo '</small>';
                  ?>                    
                </td>
                <td class="text-center">
                  <a href="check-payment.php?id=<?php echo md5($price['id']) ?>" class="btn btn-sm btn-default" title="View">
                    <i class="fa fa-eye"></i>
                  </a>                  
                </td>
              </tr>
              <?php
                }
              }else{
                echo "<tr><td algin='center' colspan='11'>No data found</tr>";
              }
              ?>
            </tbody>
          </table>
          <div class="row" style="margin: 2px 0 !important;">
              <div class="col-md-2" style="padding-left: 0 !important;">
                <form id="limit">
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
            <?php echo $allpayments['pagination'] ?>
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
</body>
</html>