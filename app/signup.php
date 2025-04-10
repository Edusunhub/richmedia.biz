<?php
require_once('config.php');
if(isset($_SESSION['logged'])){
  $type=$_SESSION['type'];
  if($type==1){
    redirect('advertiser/dashboard.php');
  }elseif($type==5){
    redirect('support/dashboard.php');
  }else{
    redirect('admin/dashboard.php');
  }
}

if(isset($_POST['signup'])){
  $users->register();
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Sign Up</title>
  <?php include('common/head.php') ?>
</head>
<body class="hold-transition register-page bg-image">
  <div class="white-wapper">
    <div class="white-layer">
      <?php echo flashNotification() ?>
      <form method="post" id="signup" class="form-horizontal theme-fields-form">
        <div class="row">
          <div class="col-md-4">
            <div class="white-box pb-10">
              <h3 class="box-title text-orange">ADVERTISERS</h3>
              <div class="text-center advertiser-image-cover">
                <img src="<?php echo baseurl.'/images/advertiser.png'; ?>">
              </div>
              <div class="text-cover">
                <ul class="advertiser-keys">
                  <li>Create your Account</li>
                  <li>Setup your Campaign</li>
                  <li>Launch your Campaign</li>
                  <li>Track your Campaign anytime anywhere</li>
                </ul>
                <br/>
                <br/>
                <br/>
                <br/>
                <br/>
                <br/>
                <br/>
              </div>
            </div>
          </div>
          <div class="col-md-8">
            <div class="white-box pb-10">
              <h3 class="box-title">Sign Up</h3>
              <div class="text-center advertiser-image-cover">
                <img src="<?php echo baseurl.'/images/sign-up.png'; ?>">
              </div>
              </br>
              </br>
              </br>
              <div class="row">
                <div class="col-md-offset-1 col-md-9">
                  <div class="form-group" style="display:none;">
                    <label class="col-sm-5 control-label">Select Account Type</label>
                    <div class="col-sm-7">
                      <select class="form-control" name="accounttype" required>
                        <option value="1">Advertisers</option>
                        <option value="2">Publishers</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group" style="display:none;">
                    <label class="col-sm-3 control-label">Currency</label>
                    <div class="col-sm-9">
                      <select class="form-control" name="currency" required>
                        <option value="USD">USD</option>
                        <option value="INR">INR</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-3 control-label">Account Manager</label>
                    <div class="col-sm-9">
                      <?php $managers=$managersobj->allManagers();?>
                      <select class="form-control" name="manager" required>
                        <option value="">Select Manager</option>
                        <?php
                        if(!empty($managers))
                        { 
                          foreach ($managers as $key => $manager) { ?>                        
                            <option value="<?php echo $manager['id']; ?>"><?php echo $manager['name']; ?></option>
                       <?php } 
                       } ?>                    
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-3 control-label">Name</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" name="name" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-3 control-label">Email ID</label>
                    <div class="col-sm-9">
                      <input type="email" class="form-control" name="email" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-3 control-label">Phone No</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" name="phone" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-3 control-label">Company Name</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" name="company_name" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-3 control-label">Skype Name</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" name="skype" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-3 control-label">Password</label>
                    <div class="col-sm-9">
                      <input type="password" class="form-control" minlength="6" name="password" required>
                    </div>
                  </div>              
                  <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-9">
                      <div class="checkbox">
                        <label>
                          <input type="checkbox" name="conditions" value="1" required> I agree to the <a href="terms-and-conditions.html">terms and Conditions</a>
                        </label>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-9">
                      <button type="submit" name="signup" class="btn btn-theme btn-block btn-flat">Sign Up</button>
                    </div>
                    <div class="col-sm-offset-3 col-sm-9">
                      <hr class="or-do" />
                      <a href="index.php" class="pull-left text-red text-bold">Sign In </a>
                      <a href="https://www.richmedia.biz/" class="pull-right text-red text-bold">Back to Homepage</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!--<div class="col-md-4">
            <div class="white-box">
              <h3 class="box-title text-orange">PUBLISHERS</h3>
              <div class="text-center advertiser-image-cover">
                <img src="<?php echo baseurl.'/images/publisher.png'; ?>">
              </div>
              <div class="text-cover">
                <ul class="advertiser-keys">
                  <li>Return All Investment can be done at ease</li>
                  <li>Problem free and safe Campaigns are run</li>
                  <li>The quality of the campaigns are always at is pinnacle</li>
                  <li>Payments are always On - Time</li>
                </ul>
              </div>
            </div>
          </div>-->
        </div>
      </form>
      <br/>
    </div>
  </div>
  <footer class="foot">
    <div class="pull-right hidden-xs">
      <a href="../terms-and-conditions.html">Terms And Conditions&nbsp;&nbsp;&nbsp;&nbsp;</a><a href="../privacypolicy.html">Privacy Policy</a>
    </div>
    <strong>Copyright &copy; 2019-2020 <a href="https://www.richmedia.biz/" target="_blank">Richmedia Advertising</a>.</strong> All rights
  reserved.
  </footer>
<?php include('common/footer-script.php') ?>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script>
  $('#signup').validate({
    errorElement : 'div',
    errorPlacement: function(error, element) {
      var placement = $(element).parents('.col-sm-9').data('error');
      if (placement) {
        $(placement).append(error)
      } else {
        $(element).parents('.col-sm-9').append(error);
      }
    }
  });
</script>
</body>
</html>
