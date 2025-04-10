<form method="post" class="form-horizontal">
  <div class="box-body">
    <h4>General Information</h4>
    <div class="col-sm-12">
      <div class="form-group">
        <label class="control-label mb-1">Admin Email</label>
        <input name="setting[admin_email]" type="text" class="form-control" value="<?php echo $common->getOption('admin_email') ?>">
      </div>
    </div>
    <hr/>
    <h4>Paypal Information</h4>
    <hr/>
    <div class="col-sm-12">
      <div class="form-group">
        <label class="control-label mb-1">Key</label>
        <input name="setting[accname]" type="text" class="form-control" value="<?php echo $common->getOption('accname') ?>">
      </div>
    </div>
    <div class="col-sm-12">
      <div class="form-group">
        <label class="control-label mb-1">Key</label>
        <input name="setting[accnumber]" type="text" class="form-control" value="<?php echo $common->getOption('accnumber') ?>">
      </div>
    </div>
    <div class="col-sm-12">
      <div class="text-center">
        <button type="submit" name="submit" class="btn btn-info">Save</button>
      </div>
    </div>
  </div>
</form>