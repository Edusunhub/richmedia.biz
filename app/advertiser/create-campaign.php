<?php
require_once('../config.php');
require_once('session.php');
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Create Campaign</title>
  <?php include('../common/head.php') ?>
</head>
<body class="hold-transition skin-blue sidebar-collapse">
<!-- Site wrapper -->
<div class="wrapper">
  <?php
  $title='Campaign';
  $breadcrumbdata=array(
    0=>array(
      'link'=>'dashboard.php',
      'name'=>'Home'
    ),
    1=>array(
      'link'=>'',
      'name'=>'Create Campaign'
    )
  )
  ?>
  <div class="content-wrapper bg-image">
  <?php include('../common/advertiser-header.php') ?>
  <?php include('../common/sidebar.php') ?>

    <section class="content-header">
      <div class="white-wapper">
        <div class="white-layer">
          <h4 class="white-layer-title">Choose Campaign</h4>
          <?php echo flashNotification() ?>
          <form action="create-campaign-details.php">
            <div class="row justify-table">
              <?php
              $campaignIcon=array(
                'banner'=>'Banner.png',
                'pop'=>'Pop.png',
                'video'=>'Video_ads.png',
                'native'=>'Native.png'
              );
              $compaigns=$campaign->allCampaignTypes();
              if(!empty($compaigns)){
                foreach ($compaigns as $key => $type) {
              ?>
              <div class="col-sm-3 column">
                <label>
                  <div class="white-box pl-10 pr-10">
                    <h3 class="box-title"><?php echo $type['type'] ?></h3>
                    <div class="text-center box-image-cover">
                      <img width="150" src="<?php echo baseurl.'/images/'.$campaignIcon[$type['type']] ?>">
                    </div>
                    <div class="text-cover text-center mt-10 mb-10 pl-10 pr-10">
                      <?php echo $type['description'] ?>
                      <div class="campaign-input mt-10 mb-10">
                        <input type="radio" name="type" <?php echo checkedOption($type['type'],$_REQUEST['type']) ?> id="<?php echo $type['type'].'-type' ?>" value="<?php echo $type['type'] ?>">
                      </div>
                    </div>
                  </div>
                </label>
              </div>
              <?php
                }
              }
              ?>
            </div>
            <div class="row">
              <div class="col-sm-12">
                <a href="dashboard.php" class="btn btn-warning pull-left">Previous</a>
                <input type="submit" value="Next" class="btn btn-warning pull-right">
              </div>
            </div>
          </form>
        </div>
      </div>
    </section>
  </div>
  <!-- /.content-wrapper -->
  <?php //include('../common/footer.php') ?>
</div>
<?php include('../common/footer-script.php') ?>
<script>
  $(document).ready(function () {
    $('.sidebar-menu').tree()
  })
</script>
</body>
</html>
