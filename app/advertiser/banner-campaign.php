<?php
if(isset($_REQUEST['token'])){
  $camdata=$this->getCampaignByIdEncript($_REQUEST['token']);
  $image=json_decode($camdata['banner_size'],true);
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
      		<div class="col-xs-12 text-center">
      			<input type="radio" name="banner_type" value="url" class="banner_type_input" id="banner_type_url" checked>
      			<label class="banner_type" for="banner_type_url">URL</label>
      			<input type="radio" name="banner_type" value="js" class="banner_type_input" id="banner_type_js">
      			<label class="banner_type" for="banner_type_js">js</label>
      		</div>
      	</div>
      	<br/>
        <div class="row">
            <div class="col-md-6 col-md-offset-3 banner_type_url_form">
              <div class="white-box pl-5 pr-5">
                <h4 class="white-box-sub-titile">URL:</h4>
                <div class="form-group">
                  <div class="row">
                    <label class="col-sm-4 control-label required-field">Creative Name: </label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control theme-field" name="creative_name" value="<?php echo htmlspecialchars_decode($camdata['creative_name']); ?>" required>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <label class="col-sm-4 control-label required-field">Size: </label>
                    <div class="col-sm-2">
                    	<input type="number" name="banner[width]" id="banner_width" min="0" class="magicsearch form-control theme-field" value="<?php echo $image['width'] ?>" required>
                    </div>
                    <div class="col-sm-1 pt-1 text-center">x</div>
                    <div class="col-sm-2">
                    	<input type="number" name="banner[height]" id="banner_height" min="0" class="magicsearch form-control theme-field" value="<?php echo $image['height'] ?>" required>
                    </div>
                    <div class="col-sm-2 pt-1">Pixels</div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <label class="col-sm-4 control-label required-field">Image: </label>
                    <div class="col-sm-8">
	                    <input type="file" name="banner" class="file-upload-default" accept="image/png, image/jpeg" value="" <?php echo $camdata['image'] ? '' : 'required' ?> >
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
                      <!--<img <?php echo $camdata['image'] ? 'src="'.baseurl.'/public/uploads/'.$camdata['image'].'"' : '' ?> / style="max-width:100%;">-->
                      <input type="hidden" name="oldimage" value="<?php echo $camdata['image'];?>">
                      </div>
                      <div class="imagepreview-cover">
                        <img id="blah" <?php echo $camdata['image'] ? 'src="'.baseurl.'/public/uploads/'.$camdata['image'].'"' : '' ?> / style="max-width:100%;">
                        <!--<img  src="#" alt="" border="none" width="150" />-->
                      </div>
                    </div>
                  </div>
			          </div>

                <div class="form-group">
                  <div class="row">
                    <label class="col-sm-4 control-label required-field">URL: </label>
                    <div class="col-sm-8">
                      <input class="magicsearch form-control" value="<?php echo htmlspecialchars_decode($camdata['url']); ?>" name="url" required>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <label class="col-sm-4 control-label">Macros: </label>
                    <div class="col-sm-8">
                      <input type="hidden" class="magicsearch form-control" name="macros[]" value="<?php echo $macrodb?>" data-placeholder="Select a Macros">
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
            <div class="col-md-12 banner_type_js_form" style="display: none;">
              <div class="white-box pl-5 pr-5">
                <h4 class="white-box-sub-titile">JS:</h4>
                <div class="form-group">
                  <div class="row">
                    <label class="col-sm-4 control-label required-field">Creative Name: </label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control theme-field" name="creative_name" value="<?php echo htmlspecialchars_decode($camdata['creative_name']) ?>" required>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <label class="col-sm-4 control-label required-field">Size: </label>
                    <div class="col-sm-2">
                      <input type="number" name="banner[width]" min="0" value="<?php echo $image['width'] ?>" class="magicsearch form-control theme-field" required>
                    </div>
                    <div class="col-sm-1 pt-1 text-center">x</div>
                    <div class="col-sm-2">
                      <input type="number" name="banner[height]" min="0" value="<?php echo $image['height'] ?>" class="magicsearch form-control theme-field" required>
                    </div>
                    <div class="col-sm-2 pt-1">Pixels</div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <label class="col-sm-4 control-label required-field">JS: </label>
                    <div class="col-sm-8">
                      <textarea class="form-control theme-field" name="js" rows="3" id="bannerjsinput" required><?php echo htmlspecialchars_decode($camdata['js_tag']) ?></textarea>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                    <div class="row">
                      <label class="col-sm-4 control-label"></label>
                      <div class="col-sm-8">
                        <div class="jspreview-cover">
                          
                        </div>
                      </div>
                    </div>
				        </div>
                <div class="form-group">
                  <div class="row">
                    <label class="col-sm-4 control-label required-field">URL: </label>
                    <div class="col-sm-8">
                      <input class="magicsearch form-control" value="<?php echo htmlspecialchars_decode($camdata['url']) ?>" name="url" required>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <label class="col-sm-4 control-label">Macros: </label>
                    <div class="col-sm-8">
                      <input type="hidden" class="magicsearch form-control" name="macros[]" value="<?php echo $macrodb?>" data-placeholder="Select a Macros">
                      <!--<select class="magicsearch form-control select2" name="macros[]" multiple="multiple" data-placeholder="Select a Macros">
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
              <input type="hidden" name="type" value="Banner">
              <input type="hidden" name="typeid" value="1">
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