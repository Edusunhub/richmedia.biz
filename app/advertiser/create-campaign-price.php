<?php
require_once('../config.php');
require_once('session.php');
$allos=$os->all();
if(isset($_POST['campaignsetp2'])){
  $campaign->campaignsetp2();
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Create Campaign</title>
  <?php include('../common/head.php') ?>
</head>
<body class="hold-transition skin-blue sidebar-collapse">
<!-- Site wrapper -->
<div class="wrapper">
  <?php
  $title='Campaign';
  $breadcrumbdata=array(
    0=>array(
      'link'=>'dashboard.php',
      'name'=>'Home'
    ),
    1=>array(
      'link'=>'',
      'name'=>'Create Campaign'
    )
  )
  ?>
  <div class="content-wrapper bg-image">
  <?php include('../common/advertiser-header.php') ?>
  <?php include('../common/sidebar.php') ?>
    <!-- Main content -->
    <section class="content">
      <div class="white-wapper">
        <div class="white-layer">
          <h4 class="white-layer-title"><?php echo $_REQUEST['type'] ?> - Campaign Details</h4>
          <?php echo flashNotification() ?>
      
          <form method="post" enctype="multipart/form-data" class="theme-fields-form">
            <div class="row">
              <div class="col-md-6">
                <div class="white-box pt-5 pl-5 pr-5">
                  <h4 class="white-box-sub-titile">Targeting:</h4>
                  <div class="form-group">
                    <div class="row">
                      <label class="col-sm-4 control-label">Uploader Banner: </label>
                      <div class="col-sm-8">
                        <input type="file" accept="image/*" id="imgInp" class="form-control" name="image">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <label class="col-sm-4 control-label">Preview: </label>
                      <div class="col-sm-12">
                        <div class="imagepreview-cover">
                          <img id="blah" src="#" alt="" border="none" />
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <label class="col-sm-4 control-label">URL:</label>
                      <div class="col-sm-8">
                        <input type="text" name="url" class="form-control">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <label class="col-sm-4 control-label">JS Tags:</label>
                      <div class="col-sm-8">
                        <input type="text" name="js_tag" class="form-control">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="white-box pt-5 pl-5 pr-5">
                  <div class="form-group">
                    <div class="row">
                      <div class="col-sm-8">
                        <h4 class="white-box-sub-titile">Pricing:</h4>
                      </div>
                      <div class="col-sm-4">
                      <button type="button" class="btn btn-sm btn-warning pull-right" onclick="addNewCountry()"><i class="fa fa-plus"></i></button>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-sm-12">
                        <div class="tableFixHead">
                          <table id="countries_table">
                            <thead>
                              <tr>
                                <th>Country</th>
                                <th>Min. Bid</th>
                                <th>Max. Bid</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td>
                                  <select class="form-control" name="country[]" onchange="selectContry(this)">
                                    <option value="">Select Country</option>
                                  <?php
                                  $countries_bids=$pricing->getAllPricesCountries();
                                  if(!empty($countries_bids)){
                                    foreach ($countries_bids as $key => $bid) {
                                  ?>
                                    <option data-minbid="<?php echo $bid['min_bid'] ?>" data-maxbid="<?php echo $bid['max_bid'] ?>" value="<?php echo $bid['country_id'] ?>"><?php echo $bid['name'] ?></option>
                                  <?php
                                    }
                                  }
                                  ?>
                                  </select>
                                </td>
                                <td class="minbid"></td>
                                <td class="maxbid">
                                  
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <br/>
              <div class="col-sm-12">
                <input type="hidden" name="token" value="<?php echo $_REQUEST['token'] ?>">
                <input type="hidden" name="type" value="<?php echo $_REQUEST['type'] ?>">
                <a href="create-campaign-details.php?type=<?php echo $_REQUEST['type'] ?>" class="btn btn-warning pull-left">Previous</a>
                <input type="submit" value="Next" name="campaignsetp2" class="btn btn-warning pull-right">
              </div>
            </div>
          </form>

        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>

  <!-- /.content-wrapper -->
  <?php //include('../common/footer.php') ?>
</div>
<?php include('../common/footer-script.php') ?>
<style type="text/css">
.imagepreview-cover{
  width:100%;
  height:150px;
  background:#b1b1b1;
  text-align: center;
}
#blah{
  max-height: 100%;
  max-width: 100%;
  margin: 0 auto;
}
.tableFixHead          { overflow-y: auto; height: 305px; }
.tableFixHead thead th { position: sticky; top: 0; }

/* Just common table stuff. Really. */
table  { border-collapse: collapse; width: 100%; }
th, td { padding: 8px 16px; }
th     { background:#eee; }
</style>
<script>
function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    
    reader.onload = function(e) {
      $('#blah').attr('src', e.target.result);
    }
    
    reader.readAsDataURL(input.files[0]);
  }
}

$("#imgInp").change(function() {
  readURL(this);
});

function  selectContry(ele) {
  var min=$(ele).find(':selected').attr('data-minbid');
  var max=$(ele).find(':selected').attr('data-maxbid');
  var minbid='<input type="number" class="form-control" name="min_bid['+ele.value+']" min="'+min+'" max="'+max+'">';
  var maxbid='<input type="number" class="form-control" name="max_bid['+ele.value+']" min="'+min+'" max="'+max+'"> <button type="button" class="remove-btn float-remove btn btn-sm btn-danger pull-right" onclick="removeCountry(this)"><i class="fa fa-minus"></i></button>';
  $(ele).parents('tr').children('.minbid').html(minbid);
  $(ele).parents('tr').children('.maxbid').html(maxbid);
}

function addNewCountry() {
  var html = '<tr>';
      html += '<td>';
      html += '<select class="form-control" name="country[]" onchange="selectContry(this)">';
      html += '<option value="">Select Country</option>';
      <?php
      $countries_bids=$pricing->getAllPricesCountries();
      if(!empty($countries_bids)){
        foreach ($countries_bids as $key => $bid) {
      ?>
      html += '<option data-minbid="<?php echo $bid['min_bid'] ?>" data-maxbid="<?php echo $bid['max_bid'] ?>" value="<?php echo $bid['country_id'] ?>"><?php echo $bid['name'] ?></option>';
    <?php
      }
    }
    ?>
    html += '</select>';
  html += '</td>';
  html += '<td class="minbid"></td>';
  html += '<td class="maxbid"><button type="button" class="remove-btn btn btn-sm btn-warning pull-right" onclick="removeCountry(this)"><i class="fa fa-minus"></i></button></td>';
  html += '</tr>';
  $('#countries_table tbody').append(html);
}
function removeCountry(ele) {
  $(ele).parents('tr').remove();
}
</script>
</body>
</html>
