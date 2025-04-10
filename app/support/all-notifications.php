<?php
require_once('../config.php');
require_once('session.php');
if(isset($_REQUEST['read'])){
  $common->readNote($_REQUEST['read']);
  redirect('all-notifications.php');
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Notification</title>
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
      <h1>Notifications</h1>
      <ol class="breadcrumb">
        <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Notifications</li>
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
                  <select name="status" class="form-control">
                    <option value="">Status</option>
                    <option <?php echo filterSelect($_REQUEST['status'],'0') ?> value="0">Read</option>
                    <option <?php echo filterSelect($_REQUEST['status'],'1') ?> value="1">Unread</option>
                  </select>
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
                <th>Notification</th>
                <th>Date</th>
                <th style="width: 70px;">Status</th>
                <th style="width: 140px;">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $notifications=$common->getNotifications(30,NULL);
              if(!empty($notifications['data'])){
                //$id=1;
                foreach ($notifications['data'] as $key => $notification) {
              ?>
              <tr>
                <td><?php echo $notification['note']; ?></td>
                <td><?php echo $notification['created_at']; ?></td>
                <td class="text-center">
                  <?php
                  $status=array(
                    0=>array('label'=>'Read','class'=>'bg-green'),
                    1=>array('label'=>'Unread','class'=>'bg-yellow'),
                  );
                  echo '<small class="label '.$status[$notification['status']]['class'].'">';
                  echo $status[$notification['status']]['label'];
                  echo '</small>';
                  ?>                    
                </td>
                <td>
                  <a href="<?php echo 'view-campaign.php?id='.md5($notification['campaign_id']).'&from=notification&noteid='.md5($notification['id']) ?>" class="btn btn-sm btn-default" title="View" data-toggle="tooltip">
                    <i class="fa fa-eye"></i>
                  </a>
                  <?php if($notification['status']==1){ ?>
                  <a onclick="return confirm('Are you sure?')" href="?read=<?php echo md5($notification['id']); ?>" class="btn btn-sm btn-default" data-toggle="tooltip" title="Mark as read">
                    <i class="fa fa-check"></i>
                  </a>
                <?php } ?>
                </td>
              </tr>
              <?php
                //$id++;
                }
              }else{
                echo '<tr><td colspan="11">Data not found</td></tr>';
              }
              ?>
            </tbody>
          </table>
          <div class="row" style="margin: 2px 0 !important;">
            <?php echo $campaigns['pagination'] ?>
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
