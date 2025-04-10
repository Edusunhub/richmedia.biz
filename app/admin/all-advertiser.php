<?php
require_once('../config.php');
require_once('session.php');
if(isset($_REQUEST['delete'])){
  $users->deleteUser($_REQUEST['delete']);
}
if(isset($_REQUEST['deactivated'])){
  $users->inactive();
}
if(isset($_REQUEST['approve'])){
  $users->approve();
}
if(isset($_REQUEST['activate'])){
  $users->activate();
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Advertisers</title>
  <?php include('../common/head.php') ?>
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo baseurl ?>/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
</head>
<body class="hold-transition skin-blue">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <?php include('../common/admin-header.php') ?>
    <?php include('../common/sidebar.php') ?>

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Advertisers</h1>
      <ol class="breadcrumb">
        <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Advertisers</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="box">
        <div class="col-md-12">
          <?php echo flashNotification() ?>
        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive">
          <div class="row">
            <div class="col-md-10">
              <form class="row">
                <div class="col-md-2">
                  <input type="text" name="key" class="form-control" placeholder="Key Words" value="<?php echo $_REQUEST['key'] ?>">
                </div>
                <div class="col-md-2">
                  <select name="status" class="form-control">
                    <option value="">Status</option>
                    <option <?php echo filterSelect($_REQUEST['status'],'1') ?> value="1">Active</option>
                    <option <?php echo filterSelect($_REQUEST['status'],'0') ?> value="0">Inactive</option>
                  </select>
                </div>
                <div class="col-md-2">
                  <input type="submit" name="filter" value="filter" class="btn btn-warning">
                </div>
              </form>
            </div>
          </div>
          <br/>
          <table  class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th style="width: 50px;">Skype</th>
                <th>Company</th>
                <th>Wallet Balance</th>
                <th>Account Manager</th>
                <th>Date Registered</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $allusers=$users->getAllAdvertisersByAdmin();
              if(!empty($allusers['data'])){
                foreach ($allusers['data'] as $key => $user) {
              ?>
              <tr>
                <td><?php echo $user['name'].'<br>[ '.$user['id'].' ]'; ?></td>
                <td><?php echo $user['email']; ?></td>
                <td><?php echo $user['phone']; ?></td>
                <td style="width: 10px; "><?php echo $user['skype']; ?></td>
                <td style="width: 20px; word-break: break-all;"><?php echo $user['company_name']; ?></td>
                <td>$<?php echo $user['wallet'] ? number_format($user['wallet'],2) : '0'; ?></td>
                <td>
                  <?php
                  $manager=$users->getuser($user['managerid']);
                  echo $manager['name'];
                  ?>
                </td>
                <td><?php echo date('d-m-Y',strtotime($user['created_at'])); ?></td>
                <td class="status-action">
                  <?php if($user['status']==1){ ?>
                    <div class="" ><i class="fa "></i></div>
                    <a href="?deactivated=<?php echo md5($user['id']) ?>" class="text-green btn btn-sm btn-social btn-default" onclick="return confirm('Are you sure you?')" data-toggle="tooltip" title="Block Advertiser">
                      <i class="fa fa-circle"></i> <span class="text-red"><strong>Inactivate</strong></span>
                    </a>
                  <?php }elseif($user['status']==2){ ?>
                    <a class="text-yellow btn btn-sm btn-social btn-default" href="?approve=<?php echo md5($user['id']) ?>" onclick="return confirm('Are you sure you?')" data-toggle="tooltip" title="Approve Advertiser">
                      <i class="fa fa-dot-circle-o"></i> 
                      <span class="text-green"><strong>Approve</strong></span>
                    </a>
                  <?php }else{ ?>
                    <a class="text-red btn btn-sm btn-social btn-default" href="?activate=<?php echo md5($user['id']) ?>" onclick="return confirm('Are you sure you?')" data-toggle="tooltip" title="Activate Advertiser">
                      <i class="fa fa-circle"></i> 
                      <span class="text-green"><strong>Activate</strong></span>
                    </a>
                  <?php } ?>
                </td>
                <td>
                  <a onclick="return confirm('Are you sure?')" href="login-assistant.php?token=<?php echo md5($user['id']); ?>" class="btn btn-sm btn-default" title="Login AS">
                    <i class="fa fa-sign-in"></i>
                  <a onclick="return confirm('Are you sure?')" href="?delete=<?php echo md5($user['id']); ?>" class="btn btn-sm btn-default">
                    <i class="fa fa-trash"></i>
                  </a>
                </td>
              </tr>
              <?php
                }
              }else{
                echo '<tr><td colspan="10">No data found</td></tr>';
              }
              ?>
            </tbody>
          </table>
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
              <?php echo $allusers['pagination'] ?>
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
<!-- DataTables -->
<script src="<?php echo baseurl ?>/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo baseurl ?>/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script>
  $(function () {
    $('#reports-table').DataTable({
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