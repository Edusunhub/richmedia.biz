<?php
require_once('../config.php');
require_once('session.php');
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Dashboard</title>
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
    <?php echo flashNotification() ?>
    <!-- Main content -->
    <section class="content text-center">
      <div class="row">
        <div class="col-sm-12 col-md-12">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Pending Payments</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table class="table no-margin">
                  <thead>
                    <tr>
                      <th>User Name</th>
                      <th>Campaign Name</th>
                      <th>Type</th>
                      <th>Model</th>
                      <th>Budget</th>
                      <th>Payment Type</th>
                      <th>TX.ID</th>
                      <th>Date</th>
                      <th style="width: 70px;">Status</th>
                      <th style="width: 30px;">Action</th>
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
                      <td><?php echo htmlspecialchars_decode($price['name']); ?></td>
                      <td style="text-align: left;"><?php echo $price['ctype']; ?></td>
                      <td><?php echo $allmodel[$price['cmodel']]; ?></td>
                      <td><?php echo '$'.number_format($price['total_budget'],2); ?></td>
                      <td><?php echo $price['type']; ?></td>
                      <td><?php echo $price['transactionid']; ?></td>
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
                      echo "<tr><td algin='center' colspan='10'>No data found</tr>";
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

        <div class="col-sm-12 col-md-4">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Pending Campaigns</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table class="table no-margin">
                  <thead>
                    <tr>
                      <th>User</th>
                      <th>Campaign Name</th>
                      <th>Type</th>
                      <th>Budget</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $pendingcampaigns=$campaign->getAllWaitingCampaigns(15);
                    if(!empty($pendingcampaigns)){
                      foreach ($pendingcampaigns as $key => $camp) {
                    ?>
                        <tr>
                          <td>
                            <?php echo $camp['created_by']; ?>
                          </td>
                          <td><?php echo htmlspecialchars_decode($camp['name']) ?></td>
                          <td><?php echo $camp['type'] ?></td>
                          <td><?php echo '$'.number_format($camp['total_budget'],2); ?></td>
                          <td>
                            <a href="<?php echo baseurl.'/admin/view-campaign.php?id='.md5($camp['id']) ?>"><i class="fa fa-eye"></i></a>
                          </td>
                        </tr>
                    <?php
                      }
                    }else{
                    ?>
                      <tr>
                        <td colspan="5">No data found</td>
                      </tr>
                    <?php
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-12 col-md-4">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Core Edited Campaigns</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table class="table no-margin">
                  <thead>
                    <tr>
                      <th>User</th>
                      <th>Campaign Name</th>
                      <th>Type</th>
                      <th>Budget</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $pendingcampaigns=$campaign->getAllCoreEditCampaigns(15);
                    if(!empty($pendingcampaigns)){
                      foreach ($pendingcampaigns as $key => $camp) {
                    ?>
                        <tr>
                          <td>
                            <?php echo $camp['created_by']; ?>
                          </td>
                          <td><?php echo htmlspecialchars_decode($camp['name']) ?></td>
                          <td><?php echo $camp['type'] ?></td>
                          <td><?php echo '$'.number_format($camp['total_budget'],2); ?></td>
                          <td>
                            <a href="<?php echo baseurl.'/admin/view-campaign.php?id='.md5($camp['id']) ?>"><i class="fa fa-eye"></i></a>
                          </td>
                        </tr>
                    <?php
                      }
                    }else{
                    ?>
                      <tr>
                        <td colspan="5">No data found</td>
                      </tr>
                    <?php
                    }
                    ?>
                  </tbody>
                </table>
              </div>
              <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
            <!-- <div class="box-footer clearfix">
              <a href="javascript:void(0)" class="btn btn-sm btn-info btn-flat pull-left">Place New Order</a>
              <a href="javascript:void(0)" class="btn btn-sm btn-default btn-flat pull-right">View All Orders</a>
            </div> -->
            <!-- /.box-footer -->
          </div>
        </div>
        <div class="col-sm-12 col-md-4">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Minor Edited Campaigns</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table class="table no-margin">
                  <thead>
                    <tr>
                      <th>User</th>
                      <th>Campaign Name</th>
                      <th>Type</th>
                      <th>Budget</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $pendingcampaigns=$campaign->getAllMinorEditCampaigns(15);
                    if(!empty($pendingcampaigns)){
                      foreach ($pendingcampaigns as $key => $camp) {
                    ?>
                        <tr>
                          <td>
                            <?php echo $camp['created_by']; ?>
                          </td>
                          <td><?php echo htmlspecialchars_decode($camp['name']) ?></td>
                          <td><?php echo $camp['type'] ?></td>
                          <td><?php echo '$'.number_format($camp['total_budget'],2); ?></td>
                          <td>
                            <a href="<?php echo baseurl.'/admin/view-campaign.php?id='.md5($camp['id']) ?>"><i class="fa fa-eye"></i></a>
                          </td>
                        </tr>
                    <?php
                      }
                    }else{
                    ?>
                      <tr>
                        <td colspan="5">No data found</td>
                      </tr>
                    <?php
                    }
                    ?>
                  </tbody>
                </table>
              </div>
              <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
            <!-- <div class="box-footer clearfix">
              <a href="javascript:void(0)" class="btn btn-sm btn-info btn-flat pull-left">Place New Order</a>
              <a href="javascript:void(0)" class="btn btn-sm btn-default btn-flat pull-right">View All Orders</a>
            </div> -->
            <!-- /.box-footer -->
          </div>
        </div>
      </div>
    </section>
  </div>
  <!-- /.content-wrapper -->

  <?php include('../common/footer.php') ?>  
</div>
<?php include('../common/footer-script.php') ?>
<script>
  $(document).ready(function () {
    $('.sidebar-menu').tree()
  })
</script>
</body>
</html>
