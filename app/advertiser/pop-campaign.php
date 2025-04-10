<?php
$creative_name=$url='';
$macroarray=array();
if(isset($_REQUEST['token'])){
  $camdata=$this->getCampaignByIdEncript($_REQUEST['token']);
  $creative_name=$camdata['creative_name'];
  $url=$camdata['url'];
  $macroarray=json_decode($camdata['macros'],true);
}
?>
<section class="content">
  <div class="white-wapper">
    <div class="white-layer">
      <h4 class="white-layer-title"><?php echo $_REQUEST['type'] ?> Up- Campaign Details</h4>
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
          <div class="col-md-offset-3 col-md-6">
            <div class="white-box pl-5 pr-5">
              <h4 class="white-box-sub-titile">Pop up Details:</h4>
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
                  <label class="col-sm-4 control-label required-field">Destination URL: </label>
                  <div class="col-sm-8">
                    <input class="magicsearch form-control" name="destination" value="<?php echo htmlspecialchars_decode($url); ?>" required>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <label class="col-sm-4 control-label">Macros: </label>
                  <div class="col-sm-8">
                    <input type="hidden" class="magicsearch form-control" name="macros[]" value="<?php echo $macrodb ?>" data-placeholder="Select a Macros">
                    <!--<select class="magicsearch form-control select2" name="macros[]" multiple="multiple" data-placeholder="Select a macros">
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
            <input type="hidden" name="type" value="Pop">
            <input type="hidden" name="typeid" value="2">
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