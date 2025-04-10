<?php
$geo=$camdata=array();
$compaignstype=array(
  'Banner'=>1,
  'Pop'=>2,
  'Video'=>3,
  'Push'=>4,
  'Push'=>4,
  'Native'=>5
);
if(isset($_REQUEST['token'])){
  $camdata=$this->getAllCampaignsByEncriptGroupId($_REQUEST['token']); 
}
$camp=$this->getCampaignByIdEncript($_REQUEST['token']);
$geo=json_decode($camp['geo_targeting']);
$pcambid=array();
if(isset($_REQUEST['token'])){
  $camdata=$this->getAllCampaignsByEncriptGroupId($_REQUEST['token']); 
  if(!empty($camdata)){
    foreach ($camdata as $key => $pcam) {
      $pcambid[$pcam['country']]=array(
        'minbid'=>$pcam['min_bid'],
        'maxbid'=>$pcam['max_bid']
      );
    }
  }
}
?>
<section class="content">
  <div class="white-wapper">
    <div class="white-layer">
      <h4 class="white-layer-title"><?php echo $_REQUEST['type'] ?> - Campaign Details</h4>
      <div class="stepwizard">
        <div class="stepwizard-row setup-panel">
          <div class="stepwizard-step col-xs-2">
            <a type="button" href="?step=1&token=<?php echo $_REQUEST['token'] ?>" class="btn btn-default btn-circle">1</a>
            <p><small>Campaign Details</small></p>
          </div>
          <div class="stepwizard-step col-xs-2">
            <a type="button" href="?step=2&token=<?php echo $_REQUEST['token'] ?>" class="btn btn-default btn-circle">2</a>
            <p><small>Targeting</small></p>
          </div>
          <div class="stepwizard-step col-xs-2">
            <a type="button" href="?step=3&token=<?php echo $_REQUEST['token'] ?>" class="btn btn-default btn-circle">3</a>
            <p><small>Campaign Type</small></p>
          </div>
          <div class="stepwizard-step col-xs-2">
            <a type="button" href="?step=5&type=<?php echo $_REQUEST['type'] ?>&token=<?php echo $_REQUEST['token'] ?>" class="btn btn-default btn-circle">4</a>
            <p><small>Creative Details</small></p>
          </div>
          <div class="stepwizard-step col-xs-2">
            <a type="button" class="active btn btn-default btn-circle">5</a>
            <p><small>Pricing</small></p>
          </div>
          <div class="stepwizard-step col-xs-2">
            <a type="button" class="btn btn-default btn-circle" disabled="disabled">6</a>
            <p><small>Scheduling</small></p>
          </div>
          <div class="stepwizard-step col-xs-2">
            <a type="button" class="btn btn-disabled btn-circle" disabled="disabled">7</a>
            <p><small>Payment</small></p>
          </div>
        </div>
      </div>
      <form method="post" class="theme-fields-form" enctype="multipart/form-data">
      	<div class="row">
          <div class="col-md-12">
            <div class="white-box pt-5 pl-5 pr-5">
              <div class="form-group">
                <div class="row">
                  <div class="col-sm-8">
                    <h4 class="white-box-sub-titile">Pricing:</h4>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-sm-12">
                    <div class="tableFixHead">
                      <table class="table table-bordered table-striped" align="middle">
                        <thead>
                          <tr>
                            <th>Country</th>
                            <th>Model</th>
                            <th>Min. Bid</th>
                            <th>Max. Bid</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $bids=$this->pricing->getCampaignPrices($_REQUEST['model'],$geo);
                          if(!empty($bids)){
                            foreach ($bids as $key => $bid) {
                          ?>
                              <tr>
                                <td>
                                  <input type="hidden" name="country[]" value="<?php echo $bid['countryid'] ?>">
                                  <?php echo $bid['name'] ?>
                                </td>
                                <td>
                                  <?php $model=$this->models->getModelByID($_REQUEST['model']); echo $model['name'] ?>
                                </td>
                                <td class="minbid" style="width: 370px">
                                  <input type="number" class="form-control" name="min_bid[<?php echo $bid['countryid'] ?>]" min="<?php echo $bid['min_bid'] ?>" max="<?php echo $bid['max_bid'] ?>" required value="<?php echo $pcambid[$bid['countryid']]['minbid'] ?>">
                                </td>
                                <td class="maxbid" style="width: 370px">
                                  <input type="number" class="form-control" name="max_bid[<?php echo $bid['countryid'] ?>]" min="<?php echo $bid['min_bid'] ?>" max="<?php echo $bid['max_bid'] ?>" required value="<?php echo $pcambid[$bid['countryid']]['maxbid'] ?>">
                                </td>
                              </tr>
                          <?php
                            }
                          }
                          ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-12">
            <br/>
            <input type="hidden" name="step" value="6">
            <input type="hidden" name="type" value="<?php echo $_REQUEST['type'] ?>">
            <input type="hidden" name="typeid" value="1">
            <input type="submit" value="Next" name="save" class="btn btn-warning pull-right">
            <a class="btn btn-warning pull-left" href="<?php echo baseurl ?>/advertiser/new-campaign.php?step=5&type=<?php echo $_REQUEST['type'] ?>&model=<?php echo $_REQUEST['model'] ?>&token=<?php echo $_REQUEST['token']?><?php echo $_REQUEST['edit'] ? '&edit='.$_REQUEST['edit'] : '' ?>">Back</a>
          </div>
        </div>
      </form>
    </div>
  </div>
</section>