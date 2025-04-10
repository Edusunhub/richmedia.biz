<?php
$creative_name=$url=$length=$domain=$page='';
$macroarray=$mimearray=array();
if(isset($_REQUEST['token'])){
  $camdata=$this->getCampaignByIdEncript($_REQUEST['token']);
  $video=json_decode($camdata['video'],true);
  $creative_name=$camdata['creative_name'];
  $length=$video['length'];
  $url=$video['url'];
  $mimearray=$video['mime']; 
  $videoarray=$video['dimensions']; 
  $page=$video['page'];
  $domain=$video['domain'];
  $macroarray=json_decode($camdata['macros'],true);
  $macrodb=implode(" ",$macroarray);
}
?>
<section class="content">
  <div class="white-wapper">
    <div class="white-layer">
      <h4 class="white-layer-title"><?php echo $_REQUEST['type'] ?> - Campaign Details</h4>
      <div class="stepwizard">
        <div class="stepwizard-row setup-panel">
          <div class="stepwizard-step col-xs-2">
            <a type="button" href="?step=1&token=<?php echo $_REQUEST['token'] ?><?php echo $_REQUEST['edit'] ? '&edit='.$_REQUEST['edit'] : '' ?>" class="btn btn-default btn-circle">1</a>
            <p><small>Campaign Details</small></p>
          </div>
          <div class="stepwizard-step col-xs-2">
            <a type="button" href="?step=2&token=<?php echo $_REQUEST['token'] ?><?php echo $_REQUEST['edit'] ? '&edit='.$_REQUEST['edit'] : '' ?>" class="btn btn-default btn-circle">2</a>
            <p><small>Targeting</small></p>
          </div>
          <div class="stepwizard-step col-xs-2">
            <a type="button" href="?step=3&token=<?php echo $_REQUEST['token'] ?><?php echo $_REQUEST['edit'] ? '&edit='.$_REQUEST['edit'] : '' ?>" class="btn btn-default btn-circle">3</a>
            <p><small>Campaign Type</small></p>
          </div>
          <div class="stepwizard-step col-xs-2">
            <a type="button" class="active btn btn-default btn-circle">4</a>
            <p><small>Creative Details</small></p>
          </div>
          <?php if(empty($_REQUEST['edit'])){ ?>
            <div class="stepwizard-step col-xs-2">
              <a type="button" class="btn btn-default btn-circle" disabled="disabled">5</a>
              <p><small>Pricing</small></p>
            </div>
            <div class="stepwizard-step col-xs-2">
              <a type="button" class="btn btn-default btn-circle" disabled="disabled">6</a>
              <p><small>Scheduling</small></p>
            </div>
            <div class="stepwizard-step col-xs-2">
              <a type="button" class="btn btn-default btn-circle" disabled="disabled">7</a>
              <p><small>Payment</small></p>
            </div>
          <?php } else { ?>
            <div class="stepwizard-step col-xs-2">
              <a type="button" class="btn btn-default btn-circle" disabled="disabled">5</a>
              <p><small>Pricing</small></p>
            </div>
            <div class="stepwizard-step col-xs-2">
              <a type="button" class="btn btn-default btn-circle" disabled="disabled">6</a>
              <p><small>Scheduling</small></p>
            </div>
            <div class="stepwizard-step col-xs-2">
              <a type="button" class="btn btn-default btn-circle" disabled="disabled">7</a>
              <p><small>Payment</small></p>
            </div>
          <?php } ?>
        </div>
      </div>
      <form method="post" class="theme-fields-form" enctype="multipart/form-data">
        <div class="row">
          <div class="col-md-6">
            <div class="white-box pl-5 pr-5">
              <h4 class="white-box-sub-titile">Video Details:</h4>
              <div class="form-group">
                <div class="row">
                  <label class="col-sm-4 control-label required-field">Creative Name: </label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control theme-field" name="creative_name" value="<?php echo htmlspecialchars_decode($creative_name); ?>" required>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <label class="col-sm-4 control-label required-field">URL VAST: </label>
                  <div class="col-sm-8">
                    <input class="magicsearch form-control" name="video[url]" value="<?php echo htmlspecialchars_decode($url) ?>" required>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="white-box pl-5 pr-5">
              <h4 class="white-box-sub-titile">&nbsp;</h4>
              <div class="form-group">
                <div class="row">
                  <label class="col-sm-4 control-label">Video Length(secs): </label>
                  <div class="col-sm-8">
                    <input type="number" min="0" class="form-control theme-field magicsearch" name="video[length]" value="<?php echo htmlspecialchars_decode($length) ?>">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <label class="col-sm-4 control-label">Mime Type: </label>
                  <div class="col-sm-8">
                    <select class="magicsearch form-control select2" name="video[mime][]" multiple="multiple" data-placeholder="Select a Type">
                      <?php
                      $mimes=$this->mimeModule->getAllMime();
                      if(!empty($mimes)){
                        foreach ($mimes as $key => $mime) {
                      ?>
                          <option value="<?php echo $mime['id'] ?>" <?php echo selectInOption($mime['id'],$mimearray) ?>><?php echo $mime['name'] ?></option>
                      <?php
                        }
                      }
                      ?>
                    </select>
                  </div>
                </div>
              </div><div class="form-group">
                <div class="row">
                  <label class="col-sm-4 control-label">Video Dimension/Size: </label>
                  <div class="col-sm-8">
                    <select class="magicsearch form-control" name="video[dimensions][]" data-placeholder="Select a Type">
                      <option value="">Please Select</option>
                      <?php
                      $videos=$this->videosobj->getAllvideo();
                      if(!empty($videos)){
                        foreach ($videos as $key => $videoval) {
                      ?>
                          <option value="<?php echo $videoval['id'] ?>" <?php echo selectInOption($videoval['id'],$videoarray) ?>><?php echo $videoval['videosize'] ?></option>
                      <?php
                        }
                      }
                      ?>
                    </select>
                  </div>
                </div>
              </div>
              <!--<div class="form-group">
                <div class="row">
                  <label class="col-sm-4 control-label">Landing Page: </label>
                  <div class="col-sm-8">
                    <input class="magicsearch form-control" name="video[page]" value="<?php echo $page ?>">
                  </div>
                </div>
              </div>-->
              <div class="form-group">
                <div class="row">
                  <label class="col-sm-4 control-label required-field">Landing Domain: </label>
                  <div class="col-sm-8">
                    <input class="magicsearch form-control" name="video[domain]" value="<?php echo htmlspecialchars_decode($domain) ?>" required>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <label class="col-sm-4 control-label">Macros: </label>
                  <div class="col-sm-8">
                    <!--<input type="text" class="magicsearch form-control" name="macros[]" value="<?php echo $macrodb ?>" data-placeholder="Select a Macros">-->
                    <!--<select class="magicsearch form-control select2" name="macros[]" multiple="multiple" data-placeholder="Select a Language">
                      <?php
                      $allmacros=$this->macros->getAllMacros();
                      if(!empty($allmacros)){
                        foreach ($allmacros as $key => $macro) {
                      ?>
                          <option value="<?php echo $macro['id'] ?>" <?php echo selectInOption($macro['id'],$macroarray) ?>><?php echo $macro['name'] ?></option>
                      <?php
                        }
                      }
                      ?>
                    </select>-->
                    <?php 
                     if(!empty($allmacros)){
                        foreach ($allmacros as $key => $macro) {
                           echo '<small class="label bg-gray pull-left mt-1 mb-1 ml-1 mr-1">'.$macro['name'].'</small>';
                        }
                      }
                    ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-12">
            <br/>
            <input type="hidden" name="step" value="5">
            <input type="hidden" name="type" value="Video">
            <input type="hidden" name="typeid" value="3">
            <input type="submit" value="Next" name="save" class="btn btn-warning pull-right">
            <a class="btn btn-warning pull-left" href="<?php echo baseurl ?>/advertiser/new-campaign.php?step=3&token=<?php echo $_REQUEST['token'] ?><?php echo $_REQUEST['edit'] ? '&edit='.$_REQUEST['edit'] : '' ?>">Back</a>
          </div>
        </div>            
      </form>
    </div>
  </div>
</section>
<style type="text/css">
.magicsearch-wrapper, .magicsearch-wrapper #jsmacros {
    width: 100% !important;
}
</style>