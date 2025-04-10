<?php 
  sleep(1);
  include('../config.php');
  if(isset($_POST['deviceid']))
  {
  	$deviceid=implode("|",$_POST['deviceid']);
    $osselectid=$_POST['osselectid'];
    /*$sql="SELECT os FROM os_entity WHERE device IN (".$deviceid.") ORDER BY id DESC";
    $data=$common->get_results($sql);
    foreach ($data as $key => $value) {
            $osid[]=$value['os'];
    }*/ 
    //$soidstr=implode(",", $osid);
    if(!empty($deviceid))
    {
        $sql="SELECT * FROM os WHERE deviceid REGEXP '[[:<:]](".$deviceid.")[[:>:]]' AND deleted_at is NULL ORDER BY id DESC";
        $dataname=$common->get_results($sql);
        $html='';
        if(!empty($dataname)){
          foreach ($dataname as $key => $os) {
            if(!empty($osselectid) && in_array($os['id'], $osselectid)){
              $html.='<option selected="selected" value="'.$os['id'].'">'.$os['name'].'</option>';
            }else{
              $html.='<option value="'.$os['id'].'">'.$os['name'].'</option>';
            }
            
          }
        }
        ?>
       <div class="col-sm-9" id="ostypes">
          <select class="magicsearch form-control select2" name="ostype[]" multiple="multiple" data-placeholder="Select a Versions">
              <?php echo $html; ?>    
          </select>
       </div>
    <?php
    }
    else{ ?>
      <div class="col-sm-9" id="ostypes">
          <select class="magicsearch form-control select2" name="ostype[]" multiple="multiple" data-placeholder="Select a Versions">
              <option value="">NO Record Found</option>
              
          </select>
       </div>
   <?php
    }
  }

  if(isset($_POST['osid']))
  {
    $os_id=implode(",",$_POST['osid']);
    $osversionid=$_POST['osversionid']; 
   if(!empty($os_id)) {
      $sql="SELECT * FROM os_versions WHERE os_id IN (".$os_id.") AND deleted_at is NULL ORDER BY id DESC";
      $dataname=$common->get_results($sql);
      $html='';
        if(!empty($dataname)){
          foreach ($dataname as $key => $osversion) {
            if(!empty($osversionid) && in_array($osversion['id'], $osversionid)){
              $html.='<option selected="selected" value="'.$osversion['id'].'">'.$osversion['name'].'</option>';
            }else
            {
              $html.='<option value="'.$osversion['id'].'">'.$osversion['name'].'</option>';
            }
          }
        }
        ?>
       <div class="col-sm-9" id="osversion">
          <select class="magicsearch form-control select2" name="osversions[]" multiple="multiple" data-placeholder="Select a Versions">
              <?php echo $html; ?>    
          </select>
       </div>
    <?php
    }
    else{ ?>
      <div class="col-sm-9" id="osversion">
          <select class="magicsearch form-control select2" name="osversions[]" multiple="multiple" data-placeholder="Select a Versions">
              <option value="">NO Record Found</option>
              
          </select>
       </div>
   <?php
    }

  }

  if(isset($_POST['osbrowserid']))
  {
    $browser_os_id=implode("|",$_POST['osbrowserid']);
    $browsers_id=$_POST['osbrowsersid'];
   if(!empty($browser_os_id)) {
      $sql="SELECT * FROM browsers WHERE osid REGEXP '[[:<:]](".$browser_os_id.")[[:>:]]' AND deleted_at is NULL ORDER BY id DESC";
      $browser=$common->get_results($sql);
      $html='';
        if(!empty($browser)){
          foreach ($browser as $key => $browsers) {
            if(in_array($browsers['id'], $browsers_id)){
              $html.='<option selected="selected" value="'.$browsers['id'].'">'.$browsers['name'].'</option>';
            } else{
              $html.='<option value="'.$browsers['id'].'">'.$browsers['name'].'</option>';
            }
          }
        }
        ?>
       <div class="col-sm-8" id="browsers">
          <select class="magicsearch form-control select2" name="browser[]" multiple="multiple" data-placeholder="Select a browser">
              <?php echo $html; ?>    
          </select>
       </div>
    <?php
    }
    else{ ?>
      <div class="col-sm-8" id="browsers">
          <select class="magicsearch form-control select2" name="browser[]" multiple="multiple" data-placeholder="Select a browser">
              <option value="">NO Record Found</option>              
          </select>
       </div>
   <?php
    }

  }


  if(isset($_POST['browserid']))
  {
    $browserid=implode("|",$_POST['browserid']);
    $browserlangid=$_POST['browserlangid']; 
   if(!empty($browserid)) {
      $sql="SELECT * FROM browser_language WHERE browsersid REGEXP '[[:<:]](".$browserid.")[[:>:]]' AND deleted_at is NULL ORDER BY id DESC";
      $browers_language=$common->get_results($sql);
      $html='';
        if(!empty($browers_language)){
          foreach ($browers_language as $key => $language) {
            if(in_array($language['id'], $browserlangid)) {
             $html.='<option selected="selected" value="'.$language['id'].'">'.$language['name'].'</option>';
            }else {
              $html.='<option value="'.$language['id'].'">'.$language['name'].'</option>';
            }
          }
        }
        ?>
       <div class="col-sm-8" id="browserslang">
          <select class="magicsearch form-control select2" name="language[]" multiple="multiple" data-placeholder="Select a browser">
              <?php echo $html; ?>    
          </select>
       </div>
    <?php
    }
    else{ ?>
      <div class="col-sm-8" id="browserslang">
          <select class="magicsearch form-control select2" name="language[]" multiple="multiple" data-placeholder="Select a browser">
              <option value="">NO Record Found</option>              
          </select>
       </div>
   <?php
    }

  }
?>