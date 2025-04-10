<?php
require_once('../config.php');
require_once('session.php');
if(isset($_REQUEST['delete'])){
  $browsers_languages->delete($_REQUEST['delete']);
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Languages</title>
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
      <h1>Languages</h1>
      <ol class="breadcrumb">
        <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Languages</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
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
            <div class="col-md-2"><a href="new-language.php" class="btn btn-default pull-right">Add New</a></div>
          </div>
        </div>
        <div class="box-body">
          <div class="col-md-12">
            <?php echo flashNotification() ?>
          </div>
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th style="width: 10px">ID</th>
                <th>Languages</th>
                <th>Browsers</th>
                <th style="width: 80px">Status</th>
                <th style="width: 90px;text-align: center;">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $alllanguages=$browsers_languages->getLanguages();
              $id=1;
              if(!empty($alllanguages['data'])){
                foreach ($alllanguages['data'] as $key => $language) {
              ?>
                  <tr>
                    <td><?php echo $id; ?></td>
                    <td style="vertical-align: middle;"><?php echo $language['name'] ?></td>
                    <td style="vertical-align: middle;">
                      <?php 
                      $browsersset=explode(",",$language['browsersid']);
                      $browserscount=count($browsersset);                              
                      $allbrowsers=$browsers->getAllBrowsers();
                        if(!empty($allbrowsers)){
                          $chck = 1;
                          foreach ($allbrowsers as $key => $browser) {
                            if(in_array($browser['id'], $browsersset)) {
                              echo $browsersname =  $browser['name'];
                              if($browserscount!=$chck){
                                echo ',';
                              }
                              $chck++;
                            }
                          }                               
                        }
                        ?>
                    </td>
                    <td style="vertical-align: middle;">
                      <?php if($language['status']==1){ ?>
                        <span class="badge bg-green">Active</span>
                      <?php } else { ?>
                        <span class="badge bg-red">Inactive</span>
                      <?php } ?>
                    </td>
                    <td style="vertical-align: middle;">
                      <a href="edit-language.php?id=<?php echo md5($language['id']) ?>" class="btn btn-sm btn-default">
                        <i class="fa fa-pencil"></i>
                      </a>
                      <a onclick="return confirm('Are you sure?')" href="?delete=<?php echo md5($language['id']) ?>" class="btn btn-sm btn-default">
                        <i class="fa fa-trash"></i>
                      </a>
                    </td>
                  </tr>    
              <?php
              $id++;
                }
              }else{
                echo '<tr><td colspan="4">Data not found</td></tr>';
              }
              ?>
            </tbody>
          </table>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          <?php echo $alllanguages['pagination'] ?>
        </div>
        <!-- /.box-footer-->
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
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