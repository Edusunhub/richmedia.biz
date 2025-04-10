<section class="content">
  <div class="white-wapper">
    <div class="white-layer">
      <h4 class="white-layer-title"><?php echo $_REQUEST['type'] ?> - Campaign Details</h4>
      <form method="post" class="theme-fields-form" enctype="multipart/form-data">
      	<div class="row">
          <div class="col-md-12">
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
                              $countries_bids=$this->pricing->getAllPricesCountriesByType($_REQUEST['typeid'],$_REQUEST['model']);
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
          <div class="col-sm-12">
            <br/>
            <input type="hidden" name="step" value="6">
            <input type="hidden" name="type" value="banner">
            <input type="hidden" name="typeid" value="1">
            <input type="submit" value="Next" name="save" class="btn btn-warning pull-right">
          </div>
        </div>
      </form>
    </div>
  </div>
</section>
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
<script type="text/javascript">
  function selectContry(ele) {
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
      $countries_bids=$this->pricing->getAllPricesCountriesByType($_REQUEST['typeid'],$_REQUEST['model']);
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