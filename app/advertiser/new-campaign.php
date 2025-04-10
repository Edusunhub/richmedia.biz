<?php
require_once('../config.php');
require_once('session.php');
$allos=$os->all();
$osversions=$os->getAllOSVersions();
$allblanguage=$browsers_languages->getAllLanguages();
$allisp=$isp->getAllISP();
$allmacros=$macros->getAllMacros();
if(isset($_POST['save'])){
  $campaign->save();
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Campaign</title>
  <?php include('../common/head.php') ?>
  <link rel="stylesheet" type="text/css" href="<?php echo baseurl .'/dist/css/jquery.magicsearch.css' ?>">
  <link rel="stylesheet" type="text/css" href="<?php echo baseurl .'/dist/css/token-input.css' ?>">
</head>
<body class="hold-transition skin-blue sidebar-collapse">
<!-- Site wrapper -->
<div class="wrapper">
  <?php
  $title='Create Campaign';
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
  <?php echo flashNotification() ?>
  <?php $step=$_REQUEST['step'] ? $_REQUEST['step'] : 1 ; ?>
  <?php $type=$_REQUEST['type'] ? $_REQUEST['type'] : '' ; ?>
  <?php $id=$_REQUEST['token']; ?>
  <?php $campaign->newCampaignForm($id,$step,$type); ?>
  </div>

  <!-- /.content-wrapper -->
  <?php //include('../common/footer.php') ?>
</div>
<?php include('../common/footer-script.php') ?>
<script type="text/javascript" src="<?php echo baseurl .'/dist/js/jquery.magicsearch.min.js' ?>"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAYw1qIZUqAK4lfkB8dLIOK0XOVU9e66xE&libraries=places"></script>
<script type="text/javascript" src="<?php echo baseurl.'/dist/js/map.js'?>"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="<?php echo baseurl .'/dist/js/jquery.tokeninput.js' ?>"></script>
<script type="text/javascript">
    function yesnoCheck(that) {
        var mycountries = document.querySelector("#countries");
        if (that.value == "WW") {
      //alert("check");ctry_none
            document.getElementById("ww_none").style.display = "none";
            for ( var i = 0; i < mycountries.children.length; i++ ) {
                if(i!=0){
                 mycountries[i].disabled = true;   
                }                    
            }
        } else {
            document.getElementById("ww_none").style.display = "block";
            for ( var i = 0; i < mycountries.children.length; i++ ) {
                mycountries[i].disabled = false;
            }

        }
    }
</script>
<script>
$('form').validate({
    rules: {
        name: {
            required: true
        },
        model: {
            required: true
        },
        daily_amount: {
            lessThanEquals: "#total_budget"
        }
    },
    errorElement : 'div',
    errorPlacement: function(error, element) {
      var placement = $(element).data('error');
      if (placement) {
        $(placement).after(error)
      } else {
        $(element).parent().append(error);
      }
    }
});
$.validator.addMethod('lessThanEquals', 
    function(value, element, param) {
            var i = parseFloat(value);
            var j = $('#total_budget').val();
            if(j >= i){
                return true;
            }else{
                return false;
            }
        }, "The value Daily Amount must be less than Total Campaign Budget"
    );
</script>
<script>
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        var error;
        var img = new Image();
        

        reader.onload = function(e) {
            var img = new Image;
            img.src = reader.result;
            
            img.onload = function() {
                var width=$('#banner_width').val();
                var height=$('#banner_height').val();
                console.log(width.length+'|'+height.length);
                if(width.length > 0 && height.length > 0 && width==this.width && height==this.height){
                    error=false;
                    console.log('ifwidth:'+img.width+' ifheight:'+img.height);
                }else{
                    error=true;
                    alert('The image size is not matching the mentioned dimensions');
                    console.log('width:'+width+' height:'+height);
                    console.log('ifwidth:'+img.width+' ifheight:'+img.height);
                    $('.file-upload-default').val('');
                }
                if(error){
                    $('#blah').attr('src','#');
                }else{
                    $('#blah').attr('src', this.src);
                }
            }
            img.src = img.src;
            
            
        }
    }
    reader.readAsDataURL(input.files[0]);
}

$(".file-upload-default").change(function() {
  readURL(this);
});

$(".pushimage").change(function(){
    var fileinput=$(this);
    var preview=$(this).data('set');
    console.log(preview);
    if (this.files && this.files[0]) {
        var reader = new FileReader();
        var error;
        var img = new Image();        

        reader.onload = function(e) {
            var img = new Image;
            img.src = reader.result;
            
            img.onload = function() {
                if( (192==this.width && 192==this.height) || (320==this.width && 240==this.height) || (720==this.width && 480==this.height)){
                    error=false;
                    console.log('ifwidth:'+img.width+' ifheight:'+img.height);
                }else{
                    error=true;
                    alert('The image size is not matching the mentioned dimensions');
                    fileinput.val('');
                }
                if(error){
                    $('.'+preview).children('img').removeAttr('src');
                }else{
                    $('.'+preview).children('img').attr('src', this.src);
                }
            }
            img.src = img.src;
            
            
        }
    }
    reader.readAsDataURL(this.files[0]);
})

$(".nativeimage").change(function(){
    var fileinput=$(this);
    var preview=$(this).data('set');
    console.log(preview);
    if (this.files && this.files[0]) {
        var reader = new FileReader();
        var error;
        var img = new Image();        

        reader.onload = function(e) {
            var img = new Image;
            img.src = reader.result;
            
            img.onload = function() {
                if( (192==this.width && 192==this.height) || (320==this.width && 240==this.height) || (300==this.width && 220==this.height) || (720==this.width && 480==this.height)){
                    error=false;
                    console.log('ifwidth:'+img.width+' ifheight:'+img.height);
                }else{
                    error=true;
                    alert('The image size is not matching the mentioned dimensions');
                    fileinput.val('');
                }
                if(error){
                    $('.'+preview).children('img').removeAttr('src');
                }else{
                    $('.'+preview).children('img').attr('src', this.src);
                }
            }
            img.src = img.src;
            
            
        }
    }
    reader.readAsDataURL(this.files[0]);
})

var startDate;
var endDate;
$('#reservation').daterangepicker(
    {
        autoUpdateInput: false,
        opens: 'left'
    },
    function(start, end) {
        $('#reservation').val(start.format('DD-MM-YYYY') +' - '+ end.format('DD-MM-YYYY'));
        $('#start-datepicker').val(start.format('DD-MM-YYYY'));
        $('#end-datepicker').val(end.format('DD-MM-YYYY'));
    }
);

$("#start-datepicker").datepicker({
    dateFormat: "dd-M-yy",
    minDate: 0
});
$('#end-datepicker').datepicker({
    dateFormat: "dd-M-yy",
    minDate: 0
});

$('#bannerjsinput').on('change',function(){
  $('.jspreview-cover').html($(this).val());
})
function deviceType() {
    var deviceid = false;
    $.each($(".devicetype:checked"), function(index,item){
        if($(this).val()==2 || $(this).val()==3){
            deviceid=true;
        }
    })
    if(deviceid===true){
        $('#ips-field').show();
        $('#ips-field .select2-container').css('width','100%');
    }else{
        $('#ips-field').hide();
    }
}

function getMapCount(){
    var i=0;
    $('#map-section .col-md-3').each(function(){
        i++;
    });
    return i;
}
function removeMap(ids){
    console.log(ids);
    $('#map-section .col-md-3').each(function(){
        if($.inArray($(this).attr('id'),ids) > -1 ){
        } else {
            $(this).remove();
        }
    });
}
$(document).ready(function(){
    var count=getMapCount();
    count=count+1;
    $('#countries').on('change',function(){
        var a=$('#advance_target').val();
        if(a=='yes'){
            var ids=[];
            $('#countries :selected').each(function(){
                var country_code=$(this).val();
                var idcode=country_code.toLowerCase();
                if($('#map-section').find('#'+idcode).length==0){
                    count++;
                    var id=$(this).data('id');
                    var country=$(this).data('name');
                    mapObject.createMap('map'+count,country,$(this).val(),count,country_code);
                }
                ids.push(idcode);
            });
            removeMap(ids);
        }
    });

    $('#advance_target').on('change',function(){
        $('#map-section').html('');
        $('#map-section').hide();
        var a=$('#advance_target').val();
        if(a=='yes'){
            var i=0;
            var scroll=false;
            $('#countries :selected').each(function(){
                scroll=true;
                $('#map-section').show();
                i++;
                var id=$(this).data('id');
                var country=$(this).data('name');
                var country_code=$(this).val();
                mapObject.createMap('map'+id,country,$(this).val(),i,country_code);
            });
            if(scroll){
                $('html, body').animate({
                    scrollTop: ($('#map-section').offset().top)
                },1500);
            }
        }
    });
    $('.select2').select2();
})
</script>
<?php
$camdata=$campaign->getCampaignByIdEncript($_REQUEST['token']);
$geo_targeting=json_decode($camdata['geo_targeting'],true);
$advanced_targeting=json_decode($camdata['advanced_targeting'],true);
$coordinates=json_decode($camdata['coordinates'],true);
if($advanced_targeting['advance_target']=='yes' && $_REQUEST['step']==2){
    if(!empty($coordinates)){
        $i=0;
?>
<script type="text/javascript">
    <?php
    foreach ($coordinates as $key => $coordinate){
        $country=$common->countriesByCode($key);
        $i++;
    ?>
        mapObject.editMap('map<?php echo $i ?>','<?php echo $country['name'] ?>','<?php echo $key ?>', <?php echo $i ?>,<?php echo $coordinate['lat'] ?>,<?php echo $coordinate['lng'] ?>,<?php echo $coordinate['radius'] ?>,'<?php echo $key ?>');
    <?php
    }
    ?>
</script>
<?php
    }
}
?>
<script type="text/javascript">
  $(document).ready(function(){
    $(document).on('change','.devicetype',function(){

        var deviceid = [];
         var osselectid = [];
        $('.devicetype:checkbox:checked').each(function(i){
          deviceid[i] = $(this).val();          
        });
        $('#ostypes :selected').each(function(i){
          osselectid[i] = $(this).val();          
        }); 
        
        var dlength = deviceid.length;

        if(dlength===0){
            $("#ostypes select").each(function () { //added a each loop here
                $(this).val("").select2();
            });
            $("#osversion select").each(function () { //added a each loop here
                $(this).val("").select2();
            });
            $("#browsers select").each(function () { //added a each loop here
                $(this).val("").select2();
            });
            $("#browserslang select").each(function () { //added a each loop here
                $(this).val("").select2();
            });
        }
        
        $.ajax({
        url:"loadajaxosname.php",
        method:"POST",
        data:{
        deviceid:deviceid,
        osselectid:osselectid,
        },
        beforeSend: function(){
        $("#loader").show();
        },
        success:function(data){
        if(data!='')
        {
        $('#ostypes').remove();
        $('#apostypes').append(data);
        $('.select2').select2()
        }
        },
        complete:function(data){
        $("#loader").hide();
            var osid= [];
            $('#ostypes :selected').each(function(i){
              osid[i] = $(this).val();
            }); //console.log(osid);
            var osversionid= [];
            $('#osversion :selected').each(function(i){
              osversionid[i] = $(this).val();
            });
            var oslength = osid.length;
            if(oslength===0){
                $("#osversion select").each(function () { //added a each loop here
                    $(this).val("").select2();
                });
            }
            $.ajax({
                url:"loadajaxosname.php",
                method:"POST",
                data:{
                    osid:osid,
                    osversionid:osversionid,
                },
                beforeSend: function(){
                    $("#loader").show();
                },
                success:function(data){
                    if(data!='')
                    {
                        $('#osversion').remove();
                        $('#aposversion').append(data);
                        $('.select2').select2()
                    }
                },
                complete:function(data){
                    $("#loader").hide();

                }
            });

            var  osbrowserid= [];
            $('#ostypes :selected').each(function(i){
              osbrowserid[i] = $(this).val();
              //console.log(osbrowserid);
            });
            var  osbrowsersid= [];
            $('#browsers :selected').each(function(i){
              osbrowsersid[i] = $(this).val();
              //console.log(browsersid);
            });

            var osbrowserlength = osbrowserid.length;
            if(osbrowserlength===0){
                $("#browsers select").each(function () { //added a each loop here
                    $(this).val("").select2();
                });
            }

            $.ajax({
                url:"loadajaxosname.php",
                method:"POST",
                data:{
                    osbrowserid:osbrowserid,
                    osbrowsersid:osbrowsersid,
                },
                beforeSend: function(){
                    $("#loader").show();
                },
                success:function(data){
                    if(data!='')
                    {
                        $('#browsers').remove();
                        $('#apbrowsers').append(data);
                        $('.select2').select2()
                        
                    }
                },
                complete:function(data){
                    $("#loader").hide();
                     var  browserid= [];
        $('#browsers :selected').each(function(i){
          browserid[i] = $(this).val();
          //console.log(browserid);
        });
        var  browserlangid= [];
        $('#browserslang :selected').each(function(i){
          browserlangid[i] = $(this).val();
          //console.log(browserlangid);
        });

        var browseridlength = browserid.length;
        if(browseridlength===0){
            $("#browserslang select").each(function () { //added a each loop here
                $(this).val("").select2();
            });
        }
        $.ajax({
            url:"loadajaxosname.php",
            method:"POST",
            data:{
                browserid:browserid,
                browserlangid:browserlangid,
            },
            beforeSend: function(){
                $("#loader").show();
            },
            success:function(data){
                if(data!='')
                {
                    $('#browserslang').remove();
                    $('#apbrowserslang').append(data);
                    $('.select2').select2()
                    
                }
            },
            complete:function(data){
                $("#loader").hide();
            }
        });

                }
            });
        }
        });

               
    });
   });

  $(document).ready(function(){
    $(document).on('change','#ostypes',function(){
         var osid= [];
        $('#ostypes :selected').each(function(i){
          osid[i] = $(this).val();
        }); //console.log(osid);
        var osversionid= [];
        $('#osversion :selected').each(function(i){
          osversionid[i] = $(this).val();
        });


        var oslength = osid.length;
        if(oslength===0){
            $("#osversion select").each(function () { //added a each loop here
                $(this).val("").select2();
            });
        }
        $.ajax({
            url:"loadajaxosname.php",
            method:"POST",
            data:{
                osid:osid,
                osversionid:osversionid,
            },
            beforeSend: function(){
                $("#loader").show();
            },
            success:function(data){
                if(data!='')
                {
                    $('#osversion').remove();
                    $('#aposversion').append(data);
                    $('.select2').select2()
                }
            },
            complete:function(data){
                $("#loader").hide();
            }
        });
    });
   });
  $(document).ready(function(){
    $(document).on('change','#ostypes',function(){
         var  osbrowserid= [];
        $('#ostypes :selected').each(function(i){
          osbrowserid[i] = $(this).val();
          //console.log(osbrowserid);
        });
        var  osbrowsersid= [];
        $('#browsers :selected').each(function(i){
          osbrowsersid[i] = $(this).val();
          //console.log(browsersid);
        });

        var osbrowserlength = osbrowserid.length;
        if(osbrowserlength===0){
            $("#browsers select").each(function () { //added a each loop here
                $(this).val("").select2();
            });
        }

        $.ajax({
            url:"loadajaxosname.php",
            method:"POST",
            data:{
                osbrowserid:osbrowserid,
                osbrowsersid:osbrowsersid,
            },
            beforeSend: function(){
                $("#loader").show();
            },
            success:function(data){
                if(data!='')
                {
                    $('#browsers').remove();
                    $('#apbrowsers').append(data);
                    $('.select2').select2()
                    
                }
            },
            complete:function(data){
                $("#loader").hide();
            }
        });
    });
   });
    $(document).ready(function(){
        $(document).on('change','#browsers',function(){
             var  browserid= [];
            $('#browsers :selected').each(function(i){
              browserid[i] = $(this).val();
              //console.log(browserid);
            });
            var  browserlangid= [];
            $('#browserslang :selected').each(function(i){
              browserlangid[i] = $(this).val();
              //console.log(browserlangid);
            });

            var browseridlength = browserid.length;
            if(browseridlength===0){
                $("#browserslang select").each(function () { //added a each loop here
                    $(this).val("").select2();
                });
            }
            $.ajax({
                url:"loadajaxosname.php",
                method:"POST",
                data:{
                    browserid:browserid,
                    browserlangid:browserlangid,
                },
                beforeSend: function(){
                    $("#loader").show();
                },
                success:function(data){
                    if(data!='')
                    {
                        $('#browserslang').remove();
                        $('#apbrowserslang').append(data);
                        $('.select2').select2()
                        
                    }
                },
                complete:function(data){
                    $("#loader").hide();
                }
            });
        });
    });
</script>
<?php
$advanced_targeting=json_decode($camdata['advanced_targeting'],true);
$publishersdatas=$advanced_targeting['publishers'];
$domains=array();
if(!empty($publishersdatas)){
    foreach ($publishersdatas as $key => $data) {
        $domains[$key]['id']=$data;
        $domain=$publishers->getPublisherByID($data);
        $domains[$key]['name']=$domain['name'];
    }
}
$domains=json_encode($domains);
?>
<script>
$(document).ready(function() {
    $("#domains").tokenInput("loadajaxdomain.php", {
        onResult: function(results){
            return results;
        },
         preventDuplicates: true,
        prePopulate: <?php echo $domains ?>
    });
});
$('#ip_target').keyup(function(){
     var value=$(this).val().replace(/[^0-9.,]*/g, '');
    $(this).val(value)
})
$('#frequency_cap').keyup(function(){
     var value=$(this).val().replace(/[^0-9]*/g, '');
    $(this).val(value)
})
</script>

<?php include('../common/footer.php') ?>
<div class="loader" id='loader'>
        <div class="lds-ring"><div></div><div></div><div></div><div></div></div>
</div>
</body>
</html>
