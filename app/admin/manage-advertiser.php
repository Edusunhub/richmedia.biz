<?php
require_once('../config.php');
require_once('session.php');
if(isset($_POST['changemaanaager'])){
  $users->changeManager();
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Switching Advertiser</title>
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
      <h1>Switching Advertiser</h1>
      <ol class="breadcrumb">
        <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Switching Advertiser</li>
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
          <form name="bulk_action_form" action="" method="post" onsubmit="return changeManagerConfirm()">
            <div class="row">
              <div class="col-md-2">
                <select class="form-control" name="manager" required>
                  <option value="">Select Manager</option>
                  <?php
                  $managers=$users->getAllManagers();
                  if(!empty($managers)){
                    foreach ($managers as $key => $manager) {
                  ?>
                    <option value="<?php echo $manager['id'] ?>"><?php echo $manager['name'] ?></option>
                  <?php
                    }
                  }
                  ?>
                </select>
              </div>
              <div class="col-md-2">
                <input type="submit" name="changemaanaager" value="Change" class="btn btn-warning">
              </div>
            </div>
            <br/>
            <table  class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th style="width: 10px"><input type="checkbox" id="select_all" value=""/></th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $allusers=$users->getAdvertisersByManager($_REQUEST['manager']);
                if(!empty($allusers['data'])){
                  foreach ($allusers['data'] as $key => $user) {
                ?>
                <tr>
                  <td>
                    <input type="checkbox" name="users[]" class="checkbox" value="<?php echo $user['id']; ?>">
                  </td>
                  <td><?php echo $user['name'] ?></td>
                  <td><?php echo $user['email'] ?></td>
                  <td>
                    <?php
                    if($user['deleted_at']==NULL){
                      if($user['status']==1){
                        echo '<small class="label bg-green">Active</small>';
                      }else{
                        echo '<small class="label bg-yellow">Inactive</small>';
                      }
                    }else{
                      echo '<small class="label bg-red">Deleted</small>';
                    }
                    ?>
                  </td>
                </tr>
                <?php
                  }
                }else{
                  echo '<tr><td colspan="8">No data found</td></tr>';
                }
                ?>
              </tbody>
            </table>
          </form>
          <?php echo $allusers['pagination'] ?>
        </div>
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
function changeManagerConfirm(){
  if($('.checkbox:checked').length > 0){
      var result = confirm("Are you sure?");
      if(result){
          return true;
      }else{
          return false;
      }
  }else{
      return false;
  }
}
</script>
</body>
</html>