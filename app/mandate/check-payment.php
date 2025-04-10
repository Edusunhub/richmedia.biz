<?php
require_once('../config.php');
require_once('session.php');
$payment=$payments->getPaymentByIdEncript($_REQUEST['id']);
$camp=$campaign->getCampaignByIdEncript(md5($payment['campaign_id']));
$userdata=$users->getUser($payment['user_id']);
if(isset($_POST['checkpaymentstatus'])){
    echo $payments->checkPayment();
}
if(empty($payment)){
  include('404.php');
  die();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Payment</title>
    <?php include('../common/head.php') ?>
    <link rel="stylesheet" type="text/css" href="<?php echo baseurl .'/dist/css/jquery.magicsearch.css' ?>">
</head>
<body class="hold-transition skin-blue">
<!-- Site wrapper -->
<div class="wrapper">
    <?php
    $title='Payment';
    $breadcrumbdata=array(
        0=>array(
          'link'=>'dashboard.php',
          'name'=>'Home'
        ),
        1=>array(
          'link'=>'campaign-payments.php',
          'name'=>'Campaign Payments'
        ),
        2=>array(
          'link'=>'',
          'name'=>'Check Payment'
        )
    )
    ?>
    <div class="content-wrapper bg-image">
        <?php include('../common/admin-header.php') ?>
        <?php include('../common/sidebar.php') ?>
        <!-- Main content -->
        <section class="invoice">
            <!-- title row -->
            <div class="row">
                <div class="col-xs-12">
                    <h2 class="page-header"><i class="fa fa-money"></i> Payment <strong class="pull-right"><small>Wallet : </small>$<?php echo $userdata['wallet'] ? number_format($userdata['wallet'],2) : '0' ?></strong></h2>
                </div>
            <!-- /.col -->
            </div>
            <?php echo flashNotification() ?>
          <!-- info row -->
            <div class="row invoice-info">
                <!-- User Deatails -->
                <div class="col-sm-4 invoice-col">
                    <span class="text-underline">User Details</span>
                    <address>
                        <small>Name : </small><strong><?php echo $userdata['name'] ?></strong>
                        <br>
                        <small>Email : </small><strong><?php echo $userdata['email'] ?></strong>
                        <br>
                        <small>Phone : </small><strong><?php echo $userdata['phone'] ?></strong>
                    </address>
                </div>
                <div class="col-sm-4 invoice-col">
                    <span class="text-underline">Campaign Details</span>
                    <address>
                        <small>Name : </small> <strong><?php echo $camp['name'] ?></strong>
                        <br>
                        <small>Model : </small> <strong>
                        <?php
                        $model=$models->getModelByID($camp['model']);
                        echo $model['name'];
                        ?>
                        </strong><br>
                        <small>Type : </small>
                        <strong><?php echo $camp['type']; ?></strong>
                    </address>
                    <span class="text-underline">Budget</span>
                    <address>
                        <small>Total Budget : </small>
                        <strong class="text-capitalize">$<?php echo number_format($camp['total_budget'],2); ?></strong><br>
                   </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                    <span class="text-underline">Payment Details</span>
                    <address>
                        <small>Date: </small>
                        <small class="text-capitalize"><strong><?php echo date('jS M, Y',strtotime($payment['created_at'])) ?></strong></small><br/>
                        <small>Transaction id: </small>
                        <strong class="text-capitalize"><?php echo $payment['transactionid'] ?></strong><br>
                        <small>Payment Type: </small>
                        <strong class="text-capitalize"><?php echo $payment['type'] ?></strong><br>
                        <small>Status: </small>
                        <?php
                        $payment['status'];
                        $status=array(
                            0=>array('label'=>'Pending','class'=>'bg-orange'),
                            1=>array('label'=>'Verified','class'=>'bg-blue'),
                            2=>array('label'=>'Approved','class'=>'bg-green'),
                            3=>array('label'=>'Decline','class'=>'bg-red')
                        );
                        echo '<small class="label '.$status[$payment['status']]['class'].'">';
                        echo $status[$payment['status']]['label'];
                        echo '</small>';
                        ?>
                   </address>
                </div>
            </div>
            <hr/>
        <!-- /.row -->
            <div class="row">
                <div class="col-xs-12">
                    <small class="text-underline">Remarks : </small>
                    <p><?php echo $payment['remarks'] ?></p><br>
                </div>
            </div>
            <hr/>
            <div class="row">
                <form method="post">
                    <div class="row">
                        <?php
                        /*
                        <div class="col-md-4">
                            <label class="control-label">Status</label>
                            <select name="status" class="form-control">
                                <option <?php echo filterSelect($payment['status'],'0') ?> value="0">Pending</option>
                                <!-- <option <?php echo filterSelect($payment['status'],'1') ?> value="1">Verified</option> -->
                                <option <?php echo filterSelect($payment['status'],'2') ?> value="2">Approved</option>
                                <option <?php echo filterSelect($payment['status'],'3') ?> value="3">Decline</option>
                            </select>
                        </div>
                        */
                        ?>
                        <div class="col-md-3 col-md-offset-3">
                            <label class="control-label">Net Amount</label>
                            <input type="tex" name="amount" class="form-control" required value="0">
                        </div>
                        <div class="col-md-3">
                            <label class="control-label">IO Number</label>
                            <input type="tex" class="form-control" value="<?php echo 'RMAIO'.$payment['id'] ?>" disabled>
                        </div>
                        <div class="col-md-12 text-center mt-1">
                            <button type="button" onclick="confirmPayment(2)" name="approved" class="btn btn-success">Approve Payment</button>
                            <button type="button" onclick="confirmPayment(3)" name="decline" class="btn btn-danger">Decline</button>
                            <a href="<?php echo baseurl.'/admin/campaign-payments.php' ?>" class="btn btn-default">Back</a>
                            <input type="hidden" name="checkpaymentstatus" id="status" class="hidden">
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
    <!-- /.content-wrapper -->
    <?php //include('../common/footer.php') ?>
</div>
<?php include('../common/footer-script.php') ?>
<script type="text/javascript">
function confirmPayment(arg){
    var com,approve,decline;
    if(arg==2){
        approve=confirm('Are you sure to approve this payment for this campaign ?');
    }
    if(approve==true){
        $('#status').val(2)
        $('form').trigger('submit');
    }
    if(arg==3){
        decline=confirm('Are you sure to decline this payment for this campaign ?');
    }
    if(decline==true){
        $('#status').val(3)
        $('form').trigger('submit');
    }
}
</script>
</body>
</html>
