<?php 
  include('../config.php');

  if(!empty($_GET['q'])) {
    $sql ="SELECT name,id FROM publishers WHERE name like '" . $_GET['q'] . "%' ORDER BY name LIMIT 0,20";
    $count=$common->get_row($sql);
    $skillData=$common->get_results($sql); //print_r($count);
      if($count < 1){
        echo "No Record found.";
      }
      else
      {
            /*$alert='<ul id="list-domain" style="list-style:none;position: absolute;z-index: 1;background: #FFF;left: 0px;top: -24px;line-height: 33px;width: 100%;border: 1px solid;border-top: none; padding-left:5px; max-height:200px; overflow-y:auto;
            overflow-x:hidden; cursor:pointer;" id="list-domains">';
              foreach ($counts as $key => $names) {
                $alert.='<li style="padding-left:5px;" data-id="'.$names['id'].'">'.$names['name'].'</li>';
              }
            $alert.="</ul>";
            echo $alert;*/
            echo json_encode($skillData);
      }
  }
?>