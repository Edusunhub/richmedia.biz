<?php
require_once('../config.php');
require_once('session.php');
$camp=$campaign->getCampaignByIdEncript($_REQUEST['id']);  //echo '<pre>'; print_r($camp); 
if(empty($camp)){
  include('404.php');
  die();
}

if(isset($_REQUEST['noteid'])){
    $common->readNote($_REQUEST['noteid']);
}

if(isset($_POST['save'])){
    $campaign->campaignActive();
}
if(isset($_POST['Pause'])){
    $campaign->campaignPause();
}
if(isset($_REQUEST['renew'])&&isset($_REQUEST['id'])){
  $campaign->renewCamp($_REQUEST['id']);
}
if(isset($_REQUEST['cancelrenew'])&&isset($_REQUEST['id'])){
  $campaign->cancelRenewCamp($_REQUEST['id']);
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Campaign</title>
    <?php include('../common/head.php') ?>
    <link rel="stylesheet" type="text/css" href="<?php echo baseurl .'/dist/css/jquery.magicsearch.css' ?>">
</head>
<body class="hold-transition skin-blue">
<!-- Site wrapper -->
<div class="wrapper">
    <?php
    $title='Create Campaign';
    $breadcrumbdata=array(
        0=>array(
          'link'=>'dashboard.php',
          'name'=>'Home'
        ),
        1=>array(
          'link'=>'',
          'name'=>'Campaign'
        )
    )
    ?>
    <div class="content-wrapper bg-image">
        <?php include('../common/admin-header.php') ?>
        <?php include('../common/sidebar.php') ?>
        <!-- Main content -->

        
        <section class="invoice">
          <!-- title row -->
            <?php echo flashNotification() ?>
          <div class="row">
            <div class="col-xs-12">
              <h2 class="page-header">
                <i class="fa fa-files-o"></i> <?php echo htmlspecialchars_decode($camp['name']) ?>
                <small class="pull-right">Date: <?php echo date('jS M, Y',strtotime($camp['created_at'])) ?></small>
              </h2>
            </div>
            <!-- /.col -->
          </div>
          <!-- info row -->
          <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">
              <span class="text-underline">Campaign Details</span>
              <address>
                <strong><?php echo htmlspecialchars_decode($camp['name']) ?></strong><br>
                <small>Model : </small>
                <?php
                if(!empty($camp['model'])){
                    $model=$models->getModelByID($camp['model']);
                    echo $model['name'].'&nbsp;&nbsp;-&nbsp;&nbsp;'.$camp['type'];   
                }                
                ?><br>
                <small>Traffic Type : </small>
                <?php
                if(!empty($camp['performodel'])){
                  $permodel=$performancemodel->getPerformanceModelByID($camp['performodel']);
                    echo $permodel['name'];  
                }                
                ?><br>
                <?php
                if(!empty($camp['device'])){
                    echo '<small>Devices : </small>';
                    $device=json_decode($camp['device']);
                    $no=count($device);                 
                    $chk=1;
                    foreach ($device as $key => $devicesvalue) {
                        $devicename=$devices->getDeviceByID($devicesvalue);                     
                        echo $devicename['name'];
                        if($no!=$chk){
                            echo ',';
                        }
                        $chk++;
                    }  
                }               
                ?>
                <br>
                <?php
                $ostype=json_decode($camp['os']);
                if($ostype[0]!=''){
                    echo'<small>OS Types : </small>';
                    foreach ($ostype as $key => $osvalue) {
                        $oss=$os->getAllOSTypesByIds($osvalue);
                        if(!empty($oss)){
                            foreach ($oss as $key => $ost) {
                                echo '<span class="label bg-gray mr-1">'.$ost['name'].'</span><br>';
                            }
                        }
                    }                       
                }                
                ?>
                <?php
                $versions=json_decode($camp['versions']);
                if($versions[0]!=''){
                    echo'<small>OS Versions : </small>';
                    foreach ($versions as $key => $vervalue) {
                      $osversions=$os->getAllOSVersionsByIds($vervalue);
                        if(!empty($osversions)){
                            foreach ($osversions as $key => $osversion) {
                                echo '<span class="label bg-gray mr-1">'.$osversion['name'].'</span><br>';
                            }
                        }
                    }                    
                }                
                ?>
                <?php
                $browser=json_decode($camp['browser']);
                if($browser[0]!=''){
                    echo'<small>Browsers : </small>';
                    foreach ($browser as $key => $brovalue) {
                        $allbrowsers=$browsers->getAllBrowsersByIds($brovalue);
                        if(!empty($allbrowsers)){
                            foreach ($allbrowsers as $key => $browser) {
                                echo '<span class="label bg-gray mr-1">'.$browser['name'].'</span><br>';
                            }
                        }
                    }                    
                }               
                ?>                
                <?php
                $lang=json_decode($camp['language']);
                if($lang[0]!=''){
                    echo'<small>Languages : </small>';
                    foreach ($lang as $key => $langvalue) {
                        $langs=$browsers_languages->getAllLanguagesByIds($langvalue);
                        if(!empty($langs)){
                            foreach ($langs as $key => $lang) {
                                echo '<span class="label bg-gray mr-1">'.$lang['name'].'</span><br>';
                            }
                        }
                    }                    
                }                
                ?>                
                <?php
                $ispid=json_decode($camp['isp']);
                if($ispid[0]!='') {
                    echo'<small>ISP : </small>';
                    foreach ($ispid as $key => $ispvalue) {
                        $allisps=$isp->getAllISPByIds($ispvalue);
                    }
                    if(!empty($allisps)){
                        foreach ($allisps as $key => $ispval) {
                            echo '<span class="label bg-gray mr-1">'.$ispval['name'].'</span><br>';
                        }
                    }
                    
                }                
                ?>                
                <?php if(!empty($camp['connection'])) { echo'<small>Connection Type : </small>'; echo '<span class="label bg-gray mr-1">'.$camp['connection'].'</span>'; } ?>
              </address>
            </div>
            <!-- /.col -->
            <div class="col-sm-4 invoice-col">
                <span class="text-underline">Campaign Target</span>
                <?php $geo=json_decode($camp['geo_targeting']); ?> 
                <?php $advanced=json_decode($camp['advanced_targeting']); ?>
                <?php $coordinates=json_decode($camp['coordinates']); ?>
                <?php $schedule_time=json_decode($camp['schedule_time']);?>
                <address>                    
                    <?php
                    if(!empty($geo)){
                        echo'<small>Country : </small>';
                        $no=count($geo);
                        $chk=1;
                        foreach ($geo as $key => $shortcode) {
                            $country=$common->countriesByCode($shortcode);
                            echo $country['name'];
                            if($no!=$chk){
                                echo ',';
                            }
                            $chk++;
                        }                        
                    }//$country=$common->countriesByCode($geo->country);                    
                    ?><br>                 
                    <?php
                    if($advanced->ssp[0]!='') {
                        echo'<small>SSP : </small>';
                        foreach ($advanced->ssp as $key => $value) {
                            $allssps=$ssp->getAllSSPByIds($value);
                            if(!empty($allssps)){
                                foreach ($allssps as $key => $sspval) {
                                echo '<span class="label bg-gray mr-1">'.$sspval['name'].'</span><br>';
                                }
                            }
                        }
                        
                    }                    
                    ?>
                    
                    <?php
                    if($advanced->publishers[0]!='') {
                        echo'<small>Domains : </small>';
                        foreach ($advanced->publishers as $key => $value) {
                        $allpublishers=$publishers->getPublisherByIds($value);
                            if(!empty($allpublishers)){
                                foreach ($allpublishers as $key => $publisher) {
                                    echo '<span class="label bg-gray mr-1">'.$publisher['name'].'</span><br>';
                                }
                            }
                        }
                    }                    
                    ?>

                    <?php
                    echo'<small>Domain Optiomination : </small>';
                    echo '<span class="label bg-gray mr-1">'.$advanced->domain_optiomination=='yes' ? 'White' : 'Black'.'</span><br>';
                    ?>
                    <?php
                    echo '<span>'.$advanced->domain_data.'</span><br>';
                    ?>

                    <?php
                    $ips=explode(',', $advanced->ip_target);
                    if($ips!=''){
                        echo'<small>IP Targeting : </small>';
                        foreach ($ips as $key => $ip) {
                            echo '<span class="label bg-gray mr-1">'.$ip.'</span><br>';
                        }
                    }
                    ?>

                    <?php
                    echo'<small>IP Optiomination : </small>';
                    echo '<span class="label bg-gray mr-1">'.$advanced->ip_optiomination=='yes' ? 'White' : 'Black'.'</span><br>';
                    ?>
                    <?php
                    echo '<span>'.$advanced->ip_data.'</span><br>';
                    ?>

                    <?php
                    if($advanced->language[0]!='') {
                        echo'<small>Language : </small>';
                        foreach ($advanced->language as $key => $value) {
                        $alllanguages=$campaign_languages->getAllLanguagesByIds($value);
                            if(!empty($alllanguages)){
                                foreach ($alllanguages as $key => $alllang) {
                                    echo '<span class="label bg-gray mr-1">'.$alllang['name'].'</span><br>';
                                }
                            }
                        }
                    }
                    
                    ?>
                    <?php 
                    if($advanced->position[0]!=''){ ?>
                    <small>Position : </small>
                    <?php echo '<span class="label bg-gray mr-1 text-uppercase">'.$advanced->position.'</span>'; ?>
                    <?php } ?>
                    <br>
                    <?php 
                    if($coordinates!=''){
                        foreach ($coordinates as $key => $value) {
                            $country=$common->countriesByCode($key);
                            echo'<small>Country : </small>
                            <span class="label bg-gray mr-1 text-uppercase">'.$country['name'].'</span>
                            <br><small>Latitude : </small>
                            <span class="label bg-gray mr-1 text-uppercase">'.$coordinates->$key->lat.'</span>
                            <br><small>Longitude : </small>
                            <span class="label bg-gray mr-1 text-uppercase">'.$coordinates->$key->lng.'</span>
                            <br><small>Radius : </small>
                            <span class="label bg-gray mr-1 text-uppercase">'.$coordinates->$key->radius.'</span><br>';

                        }  
                    }
                    ?>
                </address>
            </div>
            <!-- /.col -->
            <div class="col-sm-4 invoice-col">
              <b>IO No. #<?php echo $camp['io'] ? $camp['io'] : ' ' ?></b><br>
              <br>
              <?php /* (<?php echo $camp['image'] ? 'URL' : 'JS' ?>) */ ?>
              <small>Campaign Type : </small><strong class="text-capitalize"><?php echo $camp['type'] ?> </strong><br>
              <small>Start Date : </small><strong class="text-capitalize"><?php echo $camp['startdate'] ?></strong><br>
              <small>End Date : </small><strong class="text-capitalize"><?php echo $camp['enddate'] ?></strong><br>
              <?php 
                if($schedule_time!=''){ 
                    echo'<table><tr><th>DAY-</th><th>-START TIME-</th><th>-END TIME</th></tr>';
                    foreach ($schedule_time as $key => $value) {
                        echo '<tr><td>'.$key.'</td><td>
                        <span class="label bg-gray mr-1 text-uppercase">'.$schedule_time->$key->start->hour.'</span>
                        <span class="label bg-gray mr-1 text-uppercase">'.$schedule_time->$key->start->minute.'</span></td><td>
                        <span class="label bg-gray mr-1 text-uppercase">'.$schedule_time->$key->end->hour.'</span>
                        <span class="label bg-gray mr-1 text-uppercase">'.$schedule_time->$key->end->minute.'</span></td></tr>';

                    } echo'</table>';
                } 

            ?>
              <small>Budget : </small><strong class="text-capitalize">$<?php echo number_format($camp['total_budget'],2) ?></strong><br>
              <small>Daily Amount : </small><strong class="text-capitalize">$<?php echo $camp['daily_amount'] ?></strong><br>
              <small> Frequency cap 24 hours: </small><strong class="text-capitalize"><?php echo $camp['cap'] ?></strong><br>
            </div>
            <!-- /.col -->
          </div>
          <hr/>
          <!-- /.row -->
          <?php if($camp['type']=='Banner'){ ?>
            <?php if($camp['banner_type']=='url'){ ?>
            <div class="row">
                <?php if($camp['creative_name']!='') { ?>
                <div class="col-xs-4">
                    <small>Creative Name</small><br/>
                    <strong><?php echo htmlspecialchars_decode($camp['creative_name']) ?></strong>
                </div>
                <?php } ?>                
                <div class="col-xs-4">
                    <small>Size</small><br/>
                    <?php $banner_size=json_decode($camp['banner_size']) ?>
                    <strong><?php echo $banner_size->width ?><small>px</small></strong>
                    <small> x </small>
                    <strong><?php echo $banner_size->height ?><small>px</small></strong>
                </div>
                <div class="col-xs-4">
                    <!--<small>Macros</small><br/>-->
                    <?php
                    $allmacros=json_decode($camp['macros'],true);
                    $macrodb=implode(" ",$allmacros);
                    echo '<span class="label bg-gray mr-1 text-uppercase">'.$macrodb.'</span>';
                    //$allmacros=$macros->getMacroByIds($allmacros[0]);
                    /*if(!empty($allmacros)){
                        foreach ($allmacros as $key => $macro) {
                            echo '<span class="label bg-gray mr-1 text-uppercase">'.$macro['name'].'</span>';
                        }
                    }*/
                    ?>
                </div>
                <div class="col-xs-12 mt-1">
                    <small><?php echo $camp['image'] ? 'Banner Image' : 'JS' ?></small><br/><br/>
                    <?php echo $camp['image'] ? '<img src="'.baseurl.'/public/uploads/'.$camp['image'].'" ><br><a href="'.baseurl.'/public/uploads/'.$camp['image'].'" download class="btn btn-theme">Download</a>' : '' ?>
                    <?php echo $camp['image'] ? '<br/><br/><small>URL</small><br/><a href="'.htmlspecialchars_decode($camp['url']).'" target="_blank">'.htmlspecialchars_decode($camp['url']).'</a>' : '' ?>
                </div>
            </div>
        <?php }else{ ?>
            <div class="row">
                <div class="col-xs-4">
                    <small>Creative Name</small><br/>
                    <strong><?php echo htmlspecialchars_decode($camp['creative_name']) ?></strong>
                </div>
                <div class="col-xs-4">
                    <small>Size</small><br/>
                    <?php $banner_size=json_decode($camp['banner_size']) ?>
                    <strong><?php echo $banner_size->width ?><small>px</small></strong>
                    <small> x </small>
                    <strong><?php echo $banner_size->height ?><small>px</small></strong>
                </div>
                <div class="col-xs-4">
                    <!--<small>Macros</small><br/>-->
                    <?php
                    $allmacros=json_decode($camp['macros'],true);
                    $macrodb=implode(" ",$allmacros);
                    echo '<span class="label bg-gray mr-1 text-uppercase">'.$macrodb.'</span>';
                    /*if(!empty($allmacros)){
                        foreach ($allmacros as $key => $macro) {
                            $macroname=$macros->getMacroById($macro);
                            if(!empty($macroname)){
                                echo '<span class="label bg-gray mr-1 text-uppercase">'.$macroname['name'].'</span>';
                            }
                        }
                    }*/
                    ?>
                </div>
                <div class="col-xs-12 mt-1">
                    <small><?php echo $camp['banner_type'] ?></small><br/><br/>
                    <pre><?php echo htmlentities($camp['js_tag']) ?></pre>
                    <?php echo $camp['js_tag'] ? '<br/><br/><small>URL</small><br/><a href="'.htmlspecialchars_decode($camp['url']).'" target="_blank">'.htmlspecialchars_decode($camp['url']).'</a>' : '' ?>
                </div>
            </div>
            <?php } ?>
        <?php }elseif ($camp['type']=='Pop') { ?>
            <div class="row">
                <div class="col-xs-4">
                    <small>Creative Name</small><br/>
                    <strong><?php echo htmlspecialchars_decode($camp['creative_name']) ?></strong>
                </div>
                <div class="col-xs-4">
                    <!--<small>Macros</small><br/>-->
                    <?php
                    $allmacros=json_decode($camp['macros'],true);
                    $macrodb=implode(" ",$allmacros);
                    echo '<span class="label bg-gray mr-1 text-uppercase">'.$macrodb.'</span>';
                    /*$allmacros=json_decode($camp['macros']);
                    if(!empty($allmacros)){
                        foreach ($allmacros as $key => $macro) {
                            $macroname=$macros->getMacroById($macro);
                            if(!empty($macroname)){
                                echo '<span class="label bg-gray mr-1 text-uppercase">'.$macroname['name'].'</span>';
                            }
                        }
                    }*/
                    ?>
                </div>
                <div class="col-xs-12 mt-1">
                    <pre><?php echo htmlspecialchars_decode($camp['url']) ?></pre>
                </div>
            </div>
        <?php }elseif ($camp['type']=='Video') { ?>
            <?php $video=json_decode($camp['video'],true) ?>
            <div class="row">
                <div class="col-xs-4">
                    <small>Creative Name</small><br/>
                    <strong><?php echo htmlspecialchars_decode($camp['creative_name']) ?></strong>
                </div>
                <div class="col-xs-4">
                    <!--<small>Macros</small><br/>-->
                    <?php
                    $allmacros=json_decode($camp['macros'],true);
                    $macrodb=implode(" ",$allmacros);
                    echo '<span class="label bg-gray mr-1 text-uppercase">'.$macrodb.'</span>';
                    /*$allmacros=json_decode($camp['macros']);
                    if(!empty($allmacros)){
                        foreach ($allmacros as $key => $macro) {
                            $macroname=$macros->getMacroById($macro);
                            if(!empty($macroname)){
                                echo '<span class="label bg-gray mr-1 text-uppercase">'.$macroname['name'].'</span>';
                            }
                        }
                    }*/
                    ?>
                </div>
                <div class="col-xs-12 mt-1">
                    <small>URL Vast</small><br/>
                    <pre><?php echo htmlspecialchars_decode($video['url']) ?></pre>
                </div>
                <div class="col-xs-4">
                    <small>Video Length(secs)</small><br/>
                    <span class="label bg-gray mr-1 text-uppercase"><?php echo htmlspecialchars_decode($video['length']) ?></span>
                </div>
                <div class="col-xs-4">
                    <small>Mime Type</small><br/>
                    <?php
                    $allmime=$video['mime'];
                    if(!empty($allmime)){
                        foreach ($allmime as $key => $mimeval) {
                            $mimename=$mimeModule->getMimeByID($mimeval);
                            if(!empty($mimename)){
                                echo '<span class="label bg-gray mr-1 text-uppercase">'.$mimename['name'].'</span>';
                            }
                        }
                    }
                    ?>
                </div>
                <div class="col-xs-4">
                    <?php
                    $alldimension=$video['dimensions'];
                    if(!empty($alldimension)){ ?>
                    <small>Video Dimension/Size:</small><br/>
                    <?php   foreach ($alldimension as $key => $dimval) {
                            $videosize=$videosobj->getVideoByID($dimval);
                            if(!empty($videosize)){
                                echo '<span class="label bg-gray mr-1 text-uppercase">'.$videosize['videosize'].'</span>';
                            }
                        }
                    }
                    ?>
                </div>
                <div class="col-xs-4">
                    <small>Landing Domain</small><br/>
                    <?php echo '<span class="label bg-gray mr-1 text-uppercase">'.htmlspecialchars_decode($video['domain']).'</span>';  ?>
                </div>
                <!--<div class="col-xs-12">
                    <small>Landing Page</small><br/>
                    <pre><?php echo $video['page'] ?></pre>
                </div>-->
            </div>
        <?php }elseif ($camp['type']=='Push') { ?>
            <?php $video=json_decode($camp['push'],true) ?>
            <div class="row">
                <?php if($video['title']!='') { ?>
                <div class="col-xs-4">
                    <small>Title</small><br/>
                    <strong><?php echo htmlspecialchars_decode($video['title']) ?></strong>
                </div>
                <?php } ?>
                <div class="col-xs-4">
                    <small>Size</small><br/>
                    <strong><?php echo $video['width'] ?><small>px</small></strong>
                    <small> x </small>
                    <strong><?php echo $video['height'] ?><small>px</small></strong>
                </div>
                <?php if($video['page']!='') { ?>                
                <div class="col-xs-12">
                    <small>Landing Page:</small><br/>
                    <strong><?php echo htmlspecialchars_decode($video['page']) ?></strong>
                </div>
                <?php } ?>
                <?php if($camp['url']!='') { ?>
                <div class="col-xs-12">
                    <small>Destination Url:</small><br/>
                    <strong><?php echo '<a href="'.htmlspecialchars_decode($camp['url']).'" target="_blank">'.htmlspecialchars_decode($camp['url']).'</a>'?></strong>
                </div>
                <?php } ?>
                <?php if($video['description']!='') { ?>
                <div class="col-xs-12">
                    <small>Description</small><br/>
                    <strong><?php echo htmlspecialchars_decode($video['description']) ?></strong>
                </div>
                <?php } ?>
                <div class="col-xs-12">
                    <br/><br/><small>Image</small><br/><br/>
                </div>
                <?php if(!empty($video['image'][0])){ ?>
                <div class="col-xs-6">
                    <a href="<?php echo $video['image'][0] ?>" target="_blank"><img src="<?php echo baseurl.'/public/uploads/'.$video['image'][0] ?>"></a>
                    <?php echo'<a href="'.baseurl.'/public/uploads/'.$video['image'][0].'" download class="btn btn-theme">Download</a>'; ?>
                </div>
                <?php } ?>
                <?php if(!empty($video['image'][1])){ ?>
                <div class="col-xs-6">
                    <a href="<?php echo $video['image'][1] ?>" target="_blank"><img src="<?php echo baseurl.'/public/uploads/'.$video['image'][1] ?>"></a>
                    <?php echo'<a href="'.baseurl.'/public/uploads/'.$video['image'][1].'" download class="btn btn-theme">Download</a>'; ?>
                </div>
                <?php } ?>
            </div>
        <?php }elseif ($camp['type']=='Native') { ?>
            <?php $video=json_decode($camp['native'],true); ?>
            <div class="row">
                <?php if($camp['creative_name']!='') { ?>
                <div class="col-xs-4">
                    <small>Creative Name</small><br/>
                    <strong><?php echo htmlspecialchars_decode($camp['creative_name']) ?></strong>
                </div>
                <div class="col-xs-4">
                    <small>Size</small><br/>
                    <strong><?php echo $video['width'] ?><small>px</small></strong>
                    <small> x </small>
                    <strong><?php echo $video['height'] ?><small>px</small></strong>
                </div>
                <?php } ?>
                <?php if($video['page']!='') { ?>
                <div class="col-xs-4">
                    <small>Landing Page</small><br/>
                    <strong><?php echo htmlspecialchars_decode($video['page']) ?></strong>
                </div>
                <?php } ?>
                <?php if($camp['url']!='') { ?>
                <div class="col-xs-12">
                    <small>Destination Url:</small><br/>
                    <strong><?php echo '<a href="'.htmlspecialchars_decode($camp['url']).'" target="_blank">'.htmlspecialchars_decode($camp['url']).'</a>'?></strong>
                </div>
                <?php } ?>
                <?php if($video['title']!='') { ?>
                <div class="col-xs-4">
                    <small>Title</small><br/>
                    <strong><?php echo htmlspecialchars_decode($video['title']) ?></strong>
                </div>
                <?php } ?>
                <?php if($video['sponsored']!='') { ?>
                <div class="col-xs-4">
                    <small>Sponsored Text</small><br/>
                    <strong><?php echo htmlspecialchars_decode($video['sponsored']) ?></strong>
                </div>
                <?php } ?>
                
                <?php if($video['phone']!='') { ?>
                <div class="col-xs-4">
                    <small>Phone</small><br/>
                    <strong><?php echo htmlspecialchars_decode($video['phone']) ?></strong>
                </div>
                <?php } ?>
                <?php if($video['address']!='') { ?>
                <div class="col-xs-4">
                    <small>Address</small><br/>
                    <strong><?php echo htmlspecialchars_decode($video['address']) ?></strong>
                </div>
                <?php } ?>
                <?php if($camp['macros']!='') { ?>
                <div class="col-xs-4">
                    <small>Macros</small><br/>
                    <?php
                    $allmacros=json_decode($camp['macros'],true);
                    $macrodb=implode(" ",$allmacros);
                    echo '<span class="label bg-gray mr-1 text-uppercase">'.$macrodb.'</span>';
                    /*$allmacros=json_decode($camp['macros']);
                    if(!empty($allmacros)){
                        foreach ($allmacros as $key => $macro) {
                            $macroname=$macros->getMacroById($macro);
                            if(!empty($macroname)){
                                echo '<span class="label bg-gray mr-1 text-uppercase">'.$macroname['name'].'</span>';
                            }
                        }
                    }*/
                    ?>
                </div>
                <?php } ?>
                <div class="col-xs-12">
                    <small>Images</small><br/><br/>
                </div>
                <?php if(!empty($video['image'][0][0])){ ?>

                <div class="col-xs-4">
                    <a href="<?php echo $video['image'][0][0] ?>" target="_blank"><img src="<?php echo baseurl.'/public/uploads/'.$video['image'][0][0] ?>"></a>
                    <?php echo'<a href="'.baseurl.'/public/uploads/'.$video['image'][0][0].'" download class="btn btn-theme">Download</a>'; ?>
                </div>
                <?php } ?>
            </div>
        <?php } ?>
          <!-- Table row -->
          <hr/>
          <div class="row">
            <div class="col-xs-12 table-responsive">
              <table class="table table-striped">
                <thead>
                <tr>
                  <th>Sr.No</th>
                  <th>Country</th>
                  <th>Min.Bid</th>
                  <th>Max.Bid</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $bidcampaigns=$campaign->getAllCampaignsByGroupId($camp['id']);
                if(!empty($bidcampaigns)){
                    $i=0;
                    foreach ($bidcampaigns as $key => $bidcampaign) {
                        $i++;
                ?>
                        <tr>
                            <td><?php echo $i ?></td>
                            <td>
                            <?php
                            $country=$common->countriesByID($bidcampaign['country']);
                            echo $country['name'];
                            ?>
                            </td>
                            <td><?php echo $bidcampaign['min_bid'] ?></td>
                            <td><?php echo $bidcampaign['max_bid'] ?></td>
                        </tr>
                <?php
                    }
                }
                ?>
                </tbody>
              </table>
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
          <!-- /.row -->
        
        <form method="post">
            <div class="row">
                <div class="col-md-12">
                    <?php if($camp['mandate_camp_status']==1){ ?>
                        <h4 class="text-center">Mandate Report</h4>
                        <P><?php echo $camp['mandate_comment'] ?></p>
                    <?php } ?>
                </div>
                <div class="col-md-12 text-center">
                    <?php if($camp['status']==3 && $camp['renewstatus']!=1) { ?>
                  <a onclick="return confirm('Are you sure renew?')" href="?renew=1&id=<?php echo md5($camp['id']); ?>" class="btn btn-sm btn-default" title="Renewable Camp">
                    <i class="fa fa-refresh"></i> Renew
                  </a>
                <?php } elseif($camp['renewstatus']==1) { ?>
                  <p  class="btn btn-info disabled">Renew Request sent</p>
                  <a onclick="return confirm('Hey, Are you sure you?')" href="?cancelrenew=1&id=<?php echo md5($camp['id']); ?>" class="btn btn-warning" title="Cancel Renew Request"><i class="fa fa-times-circle"></i> Cancel</a>
                <?php } ?>
                    <?php if(!empty($camp['io'])){ 
                                if(!empty($camp['status'])){
                                    if ($camp['status']==2) { 
                    ?>                  <input type="hidden" name="type" value="<?php echo $_SESSION['type']; ?>">
                                        <button type="submit" name="Pause" onclick="return confirm('Are you sure want to proceed to Pause Campaign')" class="btn btn-success">Pause Campaign</button>
                            <?php   }elseif(($camp['status']==1)||($camp['status']==3) && $camp['renewstatus']!=1){ 
                            ?>          <input type="hidden" name="type" value="<?php echo $_SESSION['type']; ?>">
                                        <button type="submit" name="save" onclick="return confirm('Are you sure want to proceed to Activate Campaign')" class="btn btn-success">Activate Campaign</button>
                            <?php   }
                                } 
                            } 
                            ?>
                    <?php
                    $camph=$campaign->reversionCampaign($_REQUEST['id']);
                    if(!empty($camph)){
                    ?>
                    <a href="<?php echo baseurl.'/admin/campaign-history.php?token='.md5($camp['id']) ?>" class="btn btn-default">Campaign History</a>
                <?php } ?>
                    <a href="<?php echo baseurl.'/admin/all-campaigns.php' ?>" class="btn btn-default">Back</a>
                </div>
            </div>
        </form>
        
          <!-- this row will not appear when printing -->
        </section>
    </div>
    <!-- /.content-wrapper -->
    <?php //include('../common/footer.php') ?>
</div>
<?php include('../common/footer-script.php') ?>
</body>
</html>
