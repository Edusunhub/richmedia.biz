<?php
$camp=$this->getCampaignByIdEncript($_REQUEST['id']);
print_r($camp);
?>
<section class="content">
  <div class="white-wapper">
    <div class="white-layer">
      <h4 class="white-layer-title">Campaign Details</h4>
      <form method="post" class="theme-fields-form">
        <div class="row">
            <div class="col-md-6">
              <div class="white-box pl-5 pr-5">
                <h4 class="white-box-sub-titile">Geo:</h4>
                <div class="form-group">
                  <div class="row">
                    <label class="col-sm-4 control-label">Country: </label>
                    <div class="col-sm-8">
                      <?php echo $camp['geo_targeting'] ?>
                      <select class="form-control" disabled style="background: #f6a269">
                        <?php
                        $countries=$this->common->getCountries();
                        if(!empty($countries)){
                          foreach ($countries as $key => $country) {
                        ?>
                            <option value="<?php echo $country['id'] ?>" <?php echo selectOption($country['id'],$camp['country']) ?>><?php echo $country['name'] ?></option>
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
                    <label class="col-sm-4 control-label">State: </label>
                    <div class="col-sm-8">
                      <select class="form-control theme-field" id="state" disabled style="background: #f6a269">
                        <?php
                        $states=$this->common->getAllState($camp['country']);
                        if(!empty($states)){
                          foreach ($states as $key => $state) {
                            echo '<option value="'.$state['id'].'" '.selectOption($state['id'],$camp['state']).'>'.$state['name'].'</option>';
                          }
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <label class="col-sm-4 control-label">City: </label>
                    <div class="col-sm-8">
                      <select class="form-control theme-field" id="city" name="geo[city]">
                        <?php
                        $cities=$this->common->getcity(35);
                        if(!empty($cities)){
                          foreach ($cities as $key => $city) {
                            echo '<option value="'.$city['id'].'" '.selectOption($city['id'],$camp['city']).'>'.$city['name'].'</option>';
                          }
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <label class="col-sm-4 control-label">Zip Code: </label>
                    <div class="col-sm-8">
                      <input class="form-control" name="geo[zipcode]" type="text">
                    </div>
                  </div>
                </div>

              </div>
            </div>
            <div class="col-md-6">
              <div class="white-box pl-5 pr-5">
                <h4 class="white-box-sub-titile">Advanced Targeting:</h4>
                <div class="form-group">
                  <div class="row">
                    <label class="col-sm-4 control-label">SSP: </label>
                    <div class="col-sm-8">
                      <input class="magicsearch form-control" id="ssp" name="targeting[ssp]">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <label class="col-sm-4 control-label">Publishers: </label>
                    <div class="col-sm-8">
                      <input class="magicsearch form-control" id="publishers" name="targeting[publishers]">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <label class="col-sm-4 control-label">IP Targeting: </label>
                    <div class="col-sm-8">
                      <input class="magicsearch form-control" name="targeting[ip_target]">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <label class="col-sm-4 control-label">Language: </label>
                    <div class="col-sm-8">
                      <input class="magicsearch form-control" id="language" name="targeting[language]">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <label class="col-sm-4 control-label">Position: </label>
                    <div class="col-sm-8">
                      <select class="form-control" name="targeting[position]">
                        <option value="atf">ATF</option>
                        <option value="btf">BTF</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-12">
              <br/>
              <input type="hidden" name="step" value="2">
              <input type="submit" value="Next" name="save" class="btn btn-warning pull-right">
            </div>
        </div>            
      </form>
    </div>
  </div>
</section>