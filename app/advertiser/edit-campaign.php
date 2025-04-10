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
  <?php $id=$_REQUEST['token'] ?>
  <?php $campaign->newCampaignForm($id,$step,$type); ?>
  </div>

  <!-- /.content-wrapper -->
  <?php //include('../common/footer.php') ?>
</div>
<?php include('../common/footer-script.php') ?>
<script type="text/javascript" src="<?php echo baseurl .'/dist/js/jquery.magicsearch.min.js' ?>"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script>
$('form').validate({
    rules: {
        name: {
            required: true
        },
        model: {
            required: true
        }
    },
    errorElement : 'div',
    errorPlacement: function(error, element) {
      var placement = $(element).data('error');
      if (placement) {
        $(placement).after(error)
      } else {
        $(element).after(error);
      }
    }
});
</script>
<script>
$(function() {
    var dataSource = <?php echo json_encode($allos); ?>;
    $('#basic').magicsearch({
        dataSource: dataSource,
        fields: ['name'],
        id: 'id',
        format: '%name%',
        multiple: true,
        focusShow: true,
        multiField: 'name',
        hidden: true,
        multiStyle: {
            space: 4,
            width: 80
        }
    });

    var osversions = <?php echo json_encode($osversions); ?>;
    $('#osversions').magicsearch({
        dataSource: osversions,
        fields: ['name'],
        id: 'id',
        format: '%name%',
        multiple: true,
        focusShow: true,
        multiField: 'name',
        hidden: true,
        multiStyle: {
            space: 4,
            width: 80
        }
    });

    var osversions = <?php echo json_encode($allblanguage); ?>;
    $('#language').magicsearch({
        dataSource: osversions,
        fields: ['name'],
        id: 'id',
        format: '%name%',
        multiple: true,
        focusShow: true,
        multiField: 'name',
        hidden: true,
        multiStyle: {
            space: 4,
            width: 80
        }
    });

    var osversions = <?php echo json_encode($allisp); ?>;
    $('#isp').magicsearch({
        dataSource: osversions,
        fields: ['name'],
        id: 'id',
        format: '%name%',
        multiple: true,
        focusShow: true,
        multiField: 'name',
        hidden: true,
        multiStyle: {
            space: 4,
            width: 80
        }
    });

    var osversions = <?php echo json_encode($allisp); ?>;
    $('#ssp').magicsearch({
        dataSource: osversions,
        fields: ['name'],
        id: 'id',
        format: '%name%',
        multiple: true,
        focusShow: true,
        multiField: 'name',
        hidden: true,
        multiStyle: {
            space: 4,
            width: 80
        }
    });

    var osversions = <?php echo json_encode($allisp); ?>;
    $('#publishers').magicsearch({
        dataSource: osversions,
        fields: ['name'],
        id: 'id',
        format: '%name%',
        multiple: true,
        focusShow: true,
        multiField: 'name',
        hidden: true,
        multiStyle: {
            space: 4,
            width: 80
        }
    });

    var osversions = <?php echo json_encode($allmacros); ?>;
    $('#macros').magicsearch({
        dataSource: osversions,
        fields: ['name'],
        id: 'id',
        format: '%name%',
        multiple: true,
        focusShow: true,
        multiField: 'name',
        hidden: true,
        multiStyle: {
            space: 4,
            width: 80
        }
    });

    var jsmacros = <?php echo json_encode($allmacros); ?>;
    $('#jsmacros').magicsearch({
        dataSource: jsmacros,
        fields: ['name'],
        id: 'id',
        format: '%name%',
        multiple: true,
        focusShow: true,
        multiField: 'name',
        hidden: true,
        multiStyle: {
            space: 4,
            width: 100
        }
    });

    // var osversions = <?php echo json_encode($osversions); ?>;
    // $('#language').magicsearch({
    //     dataSource: osversions,
    //     fields: ['name'],
    //     id: 'id',
    //     format: '%name%',
    //     multiple: true,
    //     focusShow: true,
    //     multiField: 'name',
    //     hidden: true,
    //     multiStyle: {
    //         space: 4,
    //         width: 80
    //     }
    // });
});

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
                    alert('The banner image size is not matching the mentioned dimensions');
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

var startDate;
var endDate;
$('#reservation').daterangepicker(
    {
        opens: 'left'
    },
    function(start, end) {
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
    }else{
        $('#ips-field').hide();
    }
}

$(document).ready(function(){
    $('#advance_target').on('change',function(){
        $('#map-section').html('');
        $('#map-section').hide();
        if($('#advance_target').is(':checked')){
            var i=0;
            var scroll=false;
            $('#countries :selected').each(function(){
                scroll=true;
                $('#map-section').show();
                i++;
                var id=$(this).data('id');
                var country=$(this).data('name');
                var country_code=$(this).val();
                mapObject.createMap('map'+id,country,$(this).val(),i);
            });
            if(scroll){
                $('html, body').animate({
                    scrollTop: ($('#map-section').offset().top)
                },1500);
            }
        }
    });
    $('.select2').select2()
})
</script>
</body>
</html>