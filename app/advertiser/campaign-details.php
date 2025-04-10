<?php
$allos=$this->os->all();
$osversions=$this->os->getAllOSVersions();
$allbrowsers=$this->browsers->getAllBrowsers();
$allblanguage=$this->browsers_languages->getAllLanguages();
$allisp=$this->isp->getAllISP();
if(isset($_REQUEST['token'])){
    $camdata=$this->getCampaignByIdEncript($_REQUEST['token']);
}
?>
<section class="content">
  <div class="white-wapper">
    <div class="white-layer">
      <h4 class="white-layer-title">Campaign Details</h4>
      <div class="stepwizard">
        <div class="stepwizard-row setup-panel">
          <div class="stepwizard-step col-xs-2">
            <a type="button" class="btn btn-default btn-circle active">1</a>
            <p><small>Campaign Details</small></p>
          </div>
          <div class="stepwizard-step col-xs-2">
            <a type="button" class="btn btn-default btn-circle" disabled="disabled">2</a>
            <p><small>Targeting</small></p>
          </div>
          <div class="stepwizard-step col-xs-2">
            <a type="button" class="btn btn-default btn-circle" disabled="disabled">3</a>
            <p><small>Campaign Type</small></p>
          </div>
          <div class="stepwizard-step col-xs-2">
            <a type="button" class="btn btn-default btn-circle" disabled="disabled">4</a>
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
      <form method="post" class="theme-fields-form" id="campaign-details" >
        <div class="row">
            <div class="col-md-6">
              <div class="white-box pl-5 pr-5">
                <h4 class="white-box-sub-titile">Campaign Details:</h4>
                <div class="form-group">
                  <div class="row">
                    <label class="col-sm-4 control-label required-field">Campaign Name: </label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control theme-field" name="name" value="<?php echo htmlspecialchars_decode($camdata['name']); ?>">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <label class="col-sm-4 control-label required-field">Campaign Model Type: </label>
                    <div class="col-sm-8">
                      <select class="form-control theme-field" name="model" <?php if($_REQUEST['token']&&$_REQUEST['edit']){ echo 'disabled style="color:#000;"'; }else{ echo ''; } ?> required>
                        <option value="">Select Model</option>
                        <?php
                        $allmodels=$this->models->allModels();
                        if(!empty($allmodels)){
                          foreach ($allmodels as $key => $model) {
                            echo '<option value="'.$model['id'].'-'.$model['type'].'" '.selectOption($model['id'],$camdata['model']).'>'.$model['name'].'&nbsp;&nbsp;-&nbsp;&nbsp;'.$model['type'].'</option>';
                          }
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <label class="col-sm-4 control-label required-field">Traffic Type : </label>
                    <div class="col-sm-8">
                      <select class="form-control theme-field" name="performodel" <?php if($_REQUEST['token']&&$_REQUEST['edit']){ echo 'disabled style="color:#000;"'; }else{ echo ''; } ?> required>
                        <option value="">Select Model</option>
                        <?php
                        $allperformodels=$this->performancemodel->allPerformanceModels();
                        if(!empty($allperformodels)){
                          foreach ($allperformodels as $key => $performodel) {
                            echo '<option value="'.$performodel['id'].'" '.selectOption($performodel['id'],$camdata['performodel']).'>'.$performodel['name'].'</option>';
                          }
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-sm-4">
                      <label class="control-label required-field">Device Type:</label>
                    </div>
                    <div class="col-sm-8">
                      <div class="row">
                        <?php
                        $alldevices=$this->devices->getAllDevice();
                        $cdevice=json_decode($camdata['device']);
                        if(!empty($alldevices)){
                          foreach ($alldevices as $key => $device) {
                            $checked='';
                            if(!empty($cdevice) && in_array($device['id'],$cdevice)){
                              $checked='checked';
                            }
                        ?>
                            <div class="col-sm-4 device-box">
                              <label>
                                <img src="<?php echo baseurl.'/public/uploads/'.$device['icon'] ?>">
                                <input required type="checkbox" onclick="deviceType()" <?php echo $checked ?> class="devicetype" name="device[]" value="<?php echo $device['id'] ?>">
                              </label>
                            </div>
                        <?php
                          }
                        }
                        ?>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row" id="apostypes">
                    <label class="col-sm-3 control-label">OS Type: </label>
                    <div class="col-sm-9" id="ostypes">
                      <select class="magicsearch form-control select2" id="os" name="ostype[]" multiple="multiple" data-placeholder="Select a Versions">
                        <option value="">Select OS</option>
                        <?php
                        if(!empty($allos)){
                          foreach ($allos as $key => $os) {
                        ?>
                            <option value="<?php echo $os['id'] ?>" <?php echo selectInOption($os['id'],json_decode($camdata['os'])) ?>><?php echo $os['name'] ?></option>
                        <?php
                          }
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row" id="aposversion">
                    <label class="col-sm-3 control-label">OS Versions: </label>
                    <div class="col-sm-9" id="osversion">
                      <select class="magicsearch form-control select2" name="osversions[]" multiple="multiple" data-placeholder="Select a Versions">
                        <option value="">Select OS Version</option>
                        <?php
                        if(!empty($osversions)){
                          foreach ($osversions as $key => $version) {
                        ?>
                            <option value="<?php echo $version['id'] ?>" <?php echo selectInOption($version['id'],json_decode($camdata['versions'])) ?>><?php echo $version['name'] ?></option>
                        <?php
                          }
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="white-box pl-5 pr-5">
                <div class="form-group">
                  <div class="row" id="apbrowsers">
                    <label class="col-sm-4 control-label">Browser: </label>
                    <div class="col-sm-8" id="browsers">
                      <select class="magicsearch form-control select2" name="browser[]" multiple="multiple" data-placeholder="Select a browser">
                        <option value="">Select Browser</option>
                        <?php
                        if(!empty($allbrowsers)){
                          foreach ($allbrowsers as $key => $browser) {
                        ?>
                            <option value="<?php echo $browser['id'] ?>" <?php echo selectInOption($browser['id'],json_decode($camdata['browser'])) ?>><?php echo $browser['name'] ?></option>
                        <?php
                          }
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row" id="apbrowserslang">
                    <label class="col-sm-4 control-label">Browser Language: </label>
                    <div class="col-sm-8" id="browserslang">
                      <select class="magicsearch form-control select2" name="language[]" multiple="multiple" data-placeholder="Select a browser">
                        <option value="">Select Browser Language</option>
                        <?php
                        if(!empty($allblanguage)){
                          foreach ($allblanguage as $key => $language) {
                        ?>
                            <option value="<?php echo $language['id'] ?>" <?php echo selectInOption($language['id'],json_decode($camdata['language'])) ?>><?php echo $language['name'] ?></option>
                        <?php
                          }
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="form-group" id="ips-field" <?php if(!empty($cdevice) && (in_array(2,$cdevice) || in_array(3,$cdevice))){ } else{ ?> style="display: none;" <?php } ?>>
                  <div class="row">
                    <label class="col-sm-4 control-label">ISP: </label>
                    <div class="col-sm-8">
                      <select class="magicsearch form-control select2" name="isp[]" multiple="multiple" data-placeholder="Select a ISP">
                        <option value="">Select ISP</option>
                        <?php
                        if(!empty($allisp)){
                          foreach ($allisp as $key => $isp) {
                        ?>
                            <option value="<?php echo $isp['id'] ?>" <?php echo selectInOption($isp['id'],json_decode($camdata['isp'])) ?>><?php echo $isp['name'] ?></option>
                        <?php
                          }
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <label class="col-sm-4 control-label">Connection Type:</label>
                    <div class="col-sm-8">
                      <select class="form-control" name="connection" required>
                        <option value="cellular" <?php echo selectOption('cellular', $camdata['connection']) ?>>Cellular</option>
                        <option value="wifi"<?php echo selectOption('wifi', $camdata['connection']) ?>>Wifi</option>
                        <option value="Both"<?php echo selectOption('Both', $camdata['connection']) ?>>both</option>
                      </select>
                    </div>
                  </div>
                  
                </div>
              </div>
            </div>
            <div class="col-sm-12">
              <br/>
              <input type="hidden" name="step" value="1">
              <input type="submit" value="Next" name="save" class="btn btn-warning pull-right">
            </div>
        </div>            
      </form>
    </div>
  </div>
</section>
<style type="text/css">
input.devicetype.error + div {
    width: 160px;
}
</style>

