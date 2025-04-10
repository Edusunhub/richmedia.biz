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
          <?php if(empty($_REQUEST['edit'])){ ?>
            <div class="stepwizard-step col-xs-2">
              <a type="button" class="active btn btn-default btn-circle">5</a>
              <p><small>Pricing</small></p>
            </div>
            <div class="stepwizard-step col-xs-2">
              <a type="button" class="btn btn-default btn-circle" disabled="disabled">6</a>
              <p><small>Scheduling</small></p>
            </div>
          <?php } else { ?>
            <div class="stepwizard-step col-xs-2">
              <a type="button" class="btn btn-disabled btn-circle">5</a>
              <p><small>Pricing</small></p>
            </div>
            <div class="stepwizard-step col-xs-2">
              <a type="button" class="btn btn-disabled btn-circle">6</a>
              <p><small>Scheduling</small></p>
            </div>
          <?php } ?>
        </div>
      </div>
      <section class="content">
        <div class="white-layer">
          <h4 class="white-layer-title"></h4>
          <div class="row">
            <div class="col-md-6 col-md-offset-3">
              <div class="white-box">
                <div class="col-md-12">
                  <?php echo flashNotification() ?>
                </div>

                <div class="row">
                  <div class="col-sm-12 text-center">
                    <h2 class="mt-5 mb-5 text-green">Your Camapign saved..!</h2>
                  </div>
                </div>


              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
</section>