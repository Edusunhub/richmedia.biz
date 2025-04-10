<?php
$allmacros=$this->macros->getAllMacros();
$creative_name=$page=$image1=$image2=$image3=$title=$sponsored=$phone=$address=$url='';
$macroarray=array();
if(isset($_REQUEST['token'])){
  $camdata=$this->getCampaignByIdEncript($_REQUEST['token']);
  $native=json_decode($camdata['native'],true);
  $creative_name=$camdata['creative_name'];
  $page=$native['page'];
  $image1=$native['image'][0][0];
  $image2=$native['image'][1];
  $image3=$native['image'][2];
  $title=$native['title'];
  $sponsored=$native['sponsored'];
  $phone=$native['phone'];
  $address=$native['address'];
  $url=$camdata['url'];
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
              <h4 class="white-box-sub-titile">Native Details:</h4>
              <div class="form-group">
                <div class="row">
                  <label class="col-sm-4 control-label required-field">Creative Name: </label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control theme-field" name="creative_name" value="<?php echo htmlspecialchars_decode($creative_name) ?>" required>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <label class="col-sm-4 control-label required-field">Landing Page: </label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control theme-field" name="native[page]" value="<?php echo htmlspecialchars_decode($page) ?>" required>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <label class="col-sm-4 control-label required-field">Destination URL: </label>
                  <div class="col-sm-8">
                    <input class="magicsearch form-control" name="destination" value="<?php echo htmlspecialchars_decode($url) ?>" required>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <label class="col-sm-4 control-label">Macros: </label>
                  <div class="col-sm-8">
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
              <div class="form-group">
                <div class="row">
                  <label class="col-sm-4 control-label required-field">Size: </label>
                  <div class="col-sm-2">
                    <input type="number" name="native[width]" id="banner_width" min="0" class="magicsearch form-control theme-field" value="<?php echo $native['width'] ?>" required>
                  </div>
                  <div class="col-sm-1 pt-1 text-center">x</div>
                  <div class="col-sm-2">
                    <input type="number" name="native[height]" id="banner_height" min="0" class="magicsearch form-control theme-field" value="<?php echo $native['height'] ?>" required>
                  </div>
                  <div class="col-sm-2 pt-1">Pixels</div>
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <label class="col-sm-4 control-label required-field">Image: </label>
                  <div class="col-sm-8">
                    <input type="file" name="image1" class="file-upload-default" accept="image/png, image/jpeg" value="" <?php echo $image1 ? '' : 'required' ?> >
                    <div class="input-group col-xs-12">
                      <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image">
                      <span class="input-group-addon cursor file-upload-browse">Upload</span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <label class="col-sm-4 control-label"></label>
                  <div class="col-sm-8">
                    <div class="imagepreview-cover pushimage1">
                    <input type="hidden" name="oldimage" value="<?php echo $image1;?>">
                    </div>
                    <div class="imagepreview-cover">
                      <img id="blah" <?php echo $image1 ? 'src="'.baseurl.'/public/uploads/'.$image1.'"' : '' ?> / style="max-width:100%;">
                    </div>
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
                  <label class="col-sm-4 control-label">Title: </label>
                  <div class="col-sm-8">
                    <input type="text" required class="form-control theme-field magicsearch" name="native[title]" value="<?php echo htmlspecialchars_decode($title) ?>">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <label class="col-sm-4 control-label">Sponsored Text: </label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control theme-field magicsearch" name="native[sponsored]" value="<?php echo htmlspecialchars_decode($sponsored) ?>">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <label class="col-sm-4 control-label">Phone (Optional): </label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control theme-field magicsearch" name="native[phone]" value="<?php echo htmlspecialchars_decode($phone) ?>">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <label class="col-sm-4 control-label">Address (Optional): </label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control theme-field magicsearch" name="native[address]" value="<?php echo htmlspecialchars_decode($address) ?>">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <label class="col-sm-4 control-label">Macros: </label>
                  <div class="col-sm-8">
                    <input type="text" class="magicsearch form-control" name="macros[]" value="<?php echo $macrodb ?>" data-placeholder="Select a Macros">
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
            <input type="hidden" name="type" value="Native">
            <input type="hidden" name="typeid" value="5">
            <input type="submit" value="Next" name="save" class="btn btn-warning pull-right">
            <a class="btn btn-warning pull-left" href="<?php echo baseurl ?>/advertiser/new-campaign.php?step=3&token=<?php echo $_REQUEST['token'] ?><?php echo $_REQUEST['edit'] ? '&edit='.$_REQUEST['edit'] : '' ?>">Back</a>
          </div>
        </div>            
      </form>
    </div>
  </div>
</section>
<style type="text/css">
.imagepreview-cover img {
    max-width: 100%;
}
.magicsearch-wrapper, .magicsearch-wrapper #jsmacros {
    width: 100% !important;
}
</style>