<?php
$allssp=$this->ssp->getAllSSP();
//$publishers=$this->publishers->getAllPublishers();
$languages=$this->campaign_languages->getAllLanguages();

$ssparray=$publishersarray=$languagearray=array();
$ip_target=$position=$advance_target='';
$advanced_targeting;
if(isset($_REQUEST['token'])){
    $camdata=$this->getCampaignByIdEncript($_REQUEST['token']);
    $advanced_targeting=json_decode($camdata['advanced_targeting'],true);
    if(!empty($advanced_targeting)){
      $ssparray=$advanced_targeting['ssp'];
      $publishersarray=$advanced_targeting['publishers'];
      $ip_target=$advanced_targeting['ip_target'];
      $languagearray=$advanced_targeting['language'];
      $position=$advanced_targeting['position'];
      $advance_target=$advanced_targeting['advance_target'];
    }
    $coordinates=json_decode($camdata['coordinates']);
}
?>
<section class="content">
  <div class="white-wapper">
    <div class="white-layer">
      <h4 class="white-layer-title">Campaign Details</h4>
      <div class="stepwizard">
        <div class="stepwizard-row setup-panel">
          <div class="stepwizard-step col-xs-2">
            <a type="button" href="?step=1&token=<?php echo $_REQUEST['token'] ?><?php echo $_REQUEST['edit'] ? '&edit='.$_REQUEST['edit'] : '' ?>" class="btn btn-default btn-circle">1</a>
            <p><small>Campaign Details</small></p>
          </div>
          <div class="stepwizard-step col-xs-2">
            <a type="button" class="active btn btn-default btn-circle">2</a>
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
      <form method="post" class="theme-fields-form">
        <div class="row">
            <div class="col-md-offset-3 col-md-6">
              <div class="white-box pl-5 pr-5">
                <h4 class="white-box-sub-titile">Targeting:</h4>
                <div class="form-group">
                  <div class="row">
                    <label class="col-sm-4 control-label required-field">Country: </label>
                    <div class="col-sm-8">
                      <select class="form-control" id="countries" name="geo[]" multiple required onchange="yesnoCheck(this);" onload="yesnoCheck(this);">
                        <option value="WW" <?php echo selectInOption('WW',json_decode($camdata['geo_targeting']))?>>World Wide</option>
                        <?php
                        $countries=$this->common->getCountries();
                        if(!empty($countries)){
                          foreach ($countries as $key => $country) {
                            if($country['id']!=247) {
                        ?>
                              <option data-id="<?php echo $country['id'] ?>" <?php echo selectInOption($country['sortname'],json_decode($camdata['geo_targeting'])) ?> <?php echo selectIndisable('WW',json_decode($camdata['geo_targeting'])) ?> data-name="<?php echo $country['name'] ?>" value="<?php echo $country['sortname'] ?>"><?php echo $country['name'] ?></option>
                        <?php
                            }
                          }
                        }
                        ?>
                      </select>
                      <p><small>Press Ctrl And Select Multiple Countries</small></p>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <label class="col-sm-4 control-label">SSP: </label>
                    <div class="col-sm-8">
                      <select class="magicsearch form-control select2" name="targeting[ssp][]" multiple="multiple" data-placeholder="Select a SSP">
                        <?php
                        if(!empty($allssp)){
                          foreach ($allssp as $key => $ssp) {
                        ?>
                            <option value="<?php echo $ssp['id'] ?>" <?php echo selectInOption($ssp['id'],$ssparray) ?>><?php echo $ssp['name'] ?></option>
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
                    <label class="col-sm-4 control-label">Domains: </label>
                    <div class="col-sm-8">
                      <input type="text" autocomplete="off" class="form-control" id="domains" name="targeting[publishers][]" placeholder="Select a Domains" value="45370">
                      <br/>
                        <div style="position: relative;" id="suggesstion-box">            
                        </div>                      
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <label class="col-sm-4 control-label">Domain Optiomination: </label>
                    <div class="col-sm-8 check-switch-cover">
                      <span>White</span>
                      <input type="checkbox" id="domain-opt" class="check-switch" name="targeting[domain_optiomination]" value="yes" <?php echo $advanced_targeting['domain_optiomination']=='yes' ? 'checked' : ''; ?>>
                      <label for="domain-opt"></label>
                      <span>Black</span>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-offset-4 col-sm-8">
                      <textarea class="form-control" name="targeting[domain_data]" placeholder="" rows="3"><?php echo $advanced_targeting['domain_data']; ?></textarea>
                    </div>
                  </div>
                </div>
                
                <div class="form-group">
                  <div class="row">
                    <label class="col-sm-4 control-label">IP Targeting: </label>
                    <div class="col-sm-8">
                      <input class="magicsearch form-control" id="ip_target" name="targeting[ip_target]" value="<?php echo $ip_target ?>" >
                      <p><small>Enter each value by comma (,) separated.</small></p>
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <div class="row">
                    <label class="col-sm-4 control-label">IP Optiomination: </label>
                    <div class="col-sm-8 check-switch-cover">
                      <span>White</span>
                      <input type="checkbox" id="ip-opt" class="check-switch" name="targeting[ip_optiomination]" value="yes" <?php echo $advanced_targeting['ip_optiomination']=='yes' ? 'checked' : ''; ?>>
                      <label for="ip-opt"></label>
                      <span>Black</span>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-offset-4 col-sm-8">
                      <textarea class="form-control" name="targeting[ip_data]" placeholder="" rows="3"><?php echo $advanced_targeting['ip_data']; ?></textarea>
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <div class="row">
                    <label class="col-sm-4 control-label">Language: </label>
                    <div class="col-sm-8">
                      <select class="magicsearch form-control select2" name="targeting[language][]" multiple="multiple" data-placeholder="Select a Language">
                        <?php
                        if(!empty($languages)){
                          foreach ($languages as $key => $language) {
                        ?>
                            <option value="<?php echo $language['id'] ?>" <?php echo selectInOption($language['id'],$languagearray) ?>><?php echo $language['name'] ?></option>
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
                    <label class="col-sm-4 control-label">Position: </label>
                    <div class="col-sm-8">
                      <select class="form-control" name="targeting[position]">
                        <option value="">Select The Option</option>
                        <option value="atf" <?php echo selectOption($position,'atf') ?>>ATF</option>
                        <option value="btf" <?php echo selectOption($position,'btf') ?>>BTF</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row" id='ww_none' <?php echo stylenone('WW',json_decode($camdata['geo_targeting'])) ?>>
                    <label class="col-sm-4 control-label">Advanced Targetting</label>
                    <div class="col-md-8">
                      <select class="form-control" name="targeting[advance_target]" id="advance_target">
                        <option value="">Select The Option</option>
                        <option value="yes" <?php echo selectOption($advance_target,'yes') ?> >Yes</option>
                        <option value="no" <?php echo selectOption($advance_target,'no') ?> >No</option>
                      </select>
                      <p><small>Advanced Precise Targeting helps to target locations of your choice via the map.</small></p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-12 mt-1">
              <div class="row">
                <div class="col-md-12 advance_target_fields"></div>
              </div>
              <div class="row" id="map-section" <?php if($advance_target!='yes'){ ?> style="display: none;" <?php } ?>></div>
            </div>
            <div class="col-sm-12">
              <br/>
              <input type="hidden" name="step" value="2">
              <input type="submit" value="Next" name="save" class="btn btn-warning pull-right">
              <a class="btn btn-warning pull-left" href="<?php echo baseurl ?>/advertiser/new-campaign.php?step=1&token=<?php echo $_REQUEST['token'] ?><?php echo $_REQUEST['edit'] ? '&edit='.$_REQUEST['edit'] : '' ?>">Back</a>
            </div>
        </div>            
      </form>
    </div>
  </div>
</section>
<style type="text/css">
.map-element{
  height: 250px;
  margin: 0 0 15px 0;
}
.map-search-input {
    width: 100%;
    border-radius: 0 !important;
    padding: 5px;
    background: #fff !important;
    border: 1px solid #dcdcdc !important;
    margin: 0 0 0 0;
    color: #000 !important;
}
div#map-section {
    background: #fff;
}
#map-section > div {
    padding-top: 15px;
    padding-bottom: 15px;
}
#map-section .country-name {
    text-align: center;
    margin: 0 0 10px 0;
    font-size: 15px;
}
#map-section input.radius {
    width: 100%;
}
</style>
