<?php
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
            <a type="button" href="?step=1&token=<?php echo $_REQUEST['token'] ?><?php echo $_REQUEST['edit'] ? '&edit='.$_REQUEST['edit'] : '' ?>" class="btn btn-default btn-circle">1</a>
            <p><small>Campaign Details</small></p>
          </div>
          <div class="stepwizard-step col-xs-2">
            <a type="button" href="?step=2&token=<?php echo $_REQUEST['token'] ?><?php echo $_REQUEST['edit'] ? '&edit='.$_REQUEST['edit'] : '' ?>" class="btn btn-default btn-circle">2</a>
            <p><small>Targeting</small></p>
          </div>
          <div class="stepwizard-step col-xs-2">
            <a type="button" class="active btn btn-default btn-circle">3</a>
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
      <form method="post">
        <div class="row eq-height">
          <?php
          $campaignIcon=array(
            'Banner'=>'Banner.png',
            'Pop'=>'Pop.png',
            'Video'=>'Video_ads.png',
            'Push'=>'Native.png',
            'Native'=>'Native.png'
          );
          $compaigns=$this->allCampaignTypes();
          if(!empty($compaigns)){
            foreach ($compaigns as $key => $type) {
          ?>
          <label class="column white-box" <?php echo $camdata['type'] ? cursorpointer($type['type'],$camdata['type']) : '' ?>>
              <div class="pl-10 pr-10" <?php echo $camdata['type'] ? cursorpointer($type['type'],$camdata['type']) : '' ?>>
                <h3 class="box-title" <?php echo $camdata['type'] ? cursorpointer($type['type'],$camdata['type']) : '' ?>><?php echo $type['type'] ?></h3>
                <div class="text-center box-image-cover" <?php echo $camdata['type'] ? cursorpointer($type['type'],$camdata['type']) : '' ?>>
                  <img width="150" <?php echo $camdata['type'] ? cursorpointer($type['type'],$camdata['type']) : '' ?> src="<?php echo baseurl.'/images/'.$campaignIcon[$type['type']] ?>">
                </div>
                <div class="text-cover text-center mt-10 mb-20 pl-10 pr-10" <?php echo $camdata['type'] ? cursorpointer($type['type'],$camdata['type']) : '' ?>>
                  <?php echo $type['description'] ?>
                  <div class="campaign-input mt-10 mb-10" <?php echo $camdata['type'] ? cursorpointer($type['type'],$camdata['type']) : '' ?>>
                    <input required type="radio" name="type" <?php echo $camdata['type'] ? checkedOption($type['type'],$camdata['type']) : '' ?> id="<?php echo $type['type'].'-type' ?>" value="<?php echo $type['type'] ?>">
                  </div>
                </div>
              </div>

          </label>
          <?php
            }
          }
          ?>
        </div>
        <div class="row">
          <div class="col-sm-12">
            <input type="submit" value="Next" class="btn btn-warning pull-right" name="save">
            <input type="hidden" name="step" value="4">
            <a class="btn btn-warning pull-left" href="<?php echo baseurl ?>/advertiser/new-campaign.php?step=2&token=<?php echo $_REQUEST['token'] ?><?php echo $_REQUEST['edit'] ? '&edit='.$_REQUEST['edit'] : '' ?>">Back</a>
          </div>
        </div>
      </form>
    </div>
  </div>
</section>
<style type="text/css">
.eq-height {
    display: table;
    border-collapse: separate;
    border-spacing: 20px;
    table-layout: fixed;
    width: 100%;
    position: relative;
}
.eq-height .column {
    display: table-cell;
    float: none;
    vertical-align: top;
    width: calc(100% / 5);
    position: relative;
}
.eq-height .column, .eq-height .column *{
  cursor: pointer;
}
.campaign-input input{
  width: 20px;
  height: 20px;
}
.campaign-input {
    position: absolute;
    bottom: 0;
    width: 100%;
    text-align: center;
    left: 0;
    margin: 10px 0;
}
</style>