<?php
$camp=$this->getCampaignByIdEncript($_REQUEST['id']);
?>
<section class="content">
  <div class="white-wapper">
    <div class="white-layer">
      <h4 class="white-layer-title">Campaign Details</h4>
      <form method="post" class="theme-fields-form">
        <div class="row">
            <div class="col-md-6">
              <div class="white-box pl-5 pr-5">
                <h4 class="white-box-sub-titile">Targeting:</h4>
                <div class="form-group">
                  <div class="row">
                    <label class="col-sm-4 control-label">Campaign Name: </label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control theme-field" name="name" value="<?php echo $camp['name'] ?>"  readonly >
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <label class="col-sm-4 control-label">Campaign Model Type: </label>
                    <div class="col-sm-8">
                      <select class="form-control theme-field" name="model" disabled style="background: #f6a269">
                        <?php
                        $allmodels=$this->models->allModels();
                        if(!empty($allmodels)){
                          foreach ($allmodels as $key => $model) {
                            echo '<option value="'.$model['id'].'" '.filterSelect($model['id'],$camp['model']).'>'.$model['name'].'</option>';
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
                      <label class="control-label">Device Type:</label>
                    </div>
                    <div class="col-sm-8">
                      <div class="row">
                        <?php
                        $alldevices=$this->devices->getAllDevice();
                        if(!empty($alldevices)){
                          foreach ($alldevices as $key => $device) {
                        ?>
                            <div class="col-sm-4 device-box">
                              <label>
                                <img src="<?php echo baseurl.'/public/uploads/'.$device['icon'] ?>">
                                <input type="checkbox" name="device[]" value="<?php echo $device['id'] ?>" <?php echo in_array($device['id'], json_decode($camp['device'])) ? 'checked' : '' ;?>>
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
                  <div class="row">
                    <label class="col-sm-3 control-label">OS Type: </label>
                    <div class="col-sm-9">
                      <?php
                      $oss=$this->os->getAllOSTypesByIds(json_decode($camp['os']));
                      if(!empty($oss)){
                        foreach ($oss as $key => $ost) {
                          echo '<span class="label bg-gray">'.$ost['name'].'</span>';
                        }
                      }
                      ?>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <label class="col-sm-3 control-label">OS Versions: </label>
                    <div class="col-sm-9">
                      <?php
                      $oss=$this->os->getAllOSTypesByIds(json_decode($camp['versions']));
                      if(!empty($oss)){
                        foreach ($oss as $key => $ost) {
                          echo '<span class="label bg-gray">'.$ost['name'].'</span>';
                        }
                      }
                      ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="white-box pl-5 pr-5">
                <div class="form-group">
                  <div class="row">
                    <label class="col-sm-4 control-label">Browser: </label>
                    <div class="col-sm-8">
                      <?php
                      $oss=$this->browsers->getAllBrowsersByIds(json_decode($camp['browser']));
                      if(!empty($oss)){
                        foreach ($oss as $key => $ost) {
                          echo '<span class="label bg-gray">'.$ost['name'].'</span>';
                        }
                      }
                      ?>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <label class="col-sm-4 control-label">Browser Language: </label>
                    <div class="col-sm-8">
                      <?php
                      $oss=$this->browsers_languages->getAllLanguagesByIds(json_decode($camp['language']));
                      if(!empty($oss)){
                        foreach ($oss as $key => $ost) {
                          echo '<span class="label bg-gray">'.$ost['name'].'</span>';
                        }
                      }
                      ?>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <label class="col-sm-4 control-label">ISP: </label>
                    <div class="col-sm-8">
                      <?php
                      $oss=$this->isp->getAllISPByIds(json_decode($camp['isp']));
                      if(!empty($oss)){
                        foreach ($oss as $key => $ost) {
                          echo '<span class="label bg-gray">'.$ost['name'].'</span>';
                        }
                      }
                      ?>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <label class="col-sm-4 control-label">Connection Type:</label>
                    <div class="col-sm-8">
                      <select class="form-control" name="connection" disabled style="background: #f6a269">
                        <option value="cellular">Cellular</option>
                        <option value="wifi">Wifi</option>
                        <option value="Both">both</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-12">
              <br/>
              <input type="hidden" name="step" value="1">
              <a href="?id=<?php echo $_REQUEST['id'] ?>&step=2" class="btn btn-warning pull-right">Next</a>
            </div>
        </div>            
      </form>
    </div>
  </div>
</section>