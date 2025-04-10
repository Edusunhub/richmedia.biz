<section class="content">
  <div class="white-wapper">
    <div class="white-layer">
      <h4 class="white-layer-title"><?php echo $_REQUEST['type'] ?> - Campaign Details</h4>
      <form method="post" enctype="multipart/form-data" class="theme-fields-form">
        <div class="row">
          <div class="col-md-6">
            <div class="white-box pt-5 pl-5 pr-5">
              <h4 class="white-box-sub-titile">Duration000:</h4>
              <div class="form-group">
                <div class="row">
                  <label class="col-sm-4 control-label">Start Date: </label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control datepicker" name="start_date" id="datepicker" required>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <label class="col-sm-4 control-label">End Date: </label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control datepicker" name="end_date" id="datepicker" required>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="white-box pt-5 pl-5 pr-5">
              <h4 class="white-box-sub-titile">Budget:</h4>
              <div class="form-group">
                <div class="row">
                  <label class="col-sm-5 control-label">Total Campaign Budget: <small>(USD)</small></label>
                  <div class="col-sm-7">
                    <input type="number" min="0" class="magicsearch form-control" name="total_budget">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <label class="col-sm-5 control-label">Daily Amount: <small>(USD)</small></label>
                  <div class="col-sm-7">
                    <input type="text" class="form-control" name="daily_amount">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <label class="col-sm-5 control-label">Frequency cap 24 hours:</label>
                  <div class="col-sm-7">
                    <input type="text" class="form-control" name="cap">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <br/>
          <div class="col-sm-12">
            <input type="hidden" name="step" value="7">
            <input type="hidden" name="type" value="banner">
            <input type="hidden" name="typeid" value="1">
            <input type="submit" value="Next" name="save" class="btn btn-warning pull-right">
          </div>
        </div>
      </form>
    </div>
  </div>
</section>