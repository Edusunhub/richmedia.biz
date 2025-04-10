<?php
class Users
{
    public $db;
    public $table='users';
    public $userentity='userentity';
    public $usermeta='usermeta';
    public $billing='billing';
    function __construct()
    {
        $this->db=new DB();
        $this->common=new Common();
    }

    public function emailExist($email,$accounttype) {
        if(!empty($email)){
            $result=$this->db->counts("SELECT id FROM ".$this->table." WHERE type='".$accounttype."' AND email='".$email."' AND deleted_at is NULL");
            if ($result>0) {
                return FALSE;
            }else{
                return TRUE;
            }
        }
        return FALSE;
    }

    public function register()
    {
        $_POST['accounttype']=1;
        $valid=$this->emailExist(trim($_POST['email']),trim($_POST['accounttype']));
        if(!$valid){
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='danger';
            $_SESSION['flash_msg']='Email already exist';
            redirect('signup.php');
            return false;
        }

        $sql="INSERT INTO ".$this->table." (name,phone,company_name,skype,managerid,type,currency,email,password,role,status,token) VALUES ('".$_POST['name']."','".$_POST['phone']."','".$_POST['company_name']."','".$_POST['skype']."','".$_POST['manager']."','".$_POST['accounttype']."','".trim($_POST['currency'])."','".trim($_POST['email'])."','".md5($_POST['password'])."','10',2,'".strtotime("now")."')";
        $result=$this->db->insert($sql);

        if(!empty($result)){
            
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='success';
            $_SESSION['flash_msg']='Welcome! you have signed up successfully.';

            $result=$this->getUser($result);
            $admindata=$this->getUser(1);

            if($result['type']==1){
                $manager=$this->db->get_row("SELECT * FROM ".$this->table." WHERE id='".$result['managerid']."'");
                $to=$admindata['email'];
				echo '<pre>';print_r($to); echo '</pre>';exit;
                $message="Hello,<br/>New Advertiser registered on RMA Platform. The details as follow :<br/>
                Full Name : ".$result['name']."<br/>
                Email : ".$result['email']."<br/>
                Account Manager Name : ".$manager['name']."<br/><br/>
                From,<br/>
                Rich Media Advertising<br/><br/>
                This is the auto responder mail for the new user registration. Please do not reply.";
                sendmail($admindata['email'],'New Advertiser Registered',$message,$manager['email']);
            }
            /*
            $_SESSION['managerid']=$result['managerid'];
            $_SESSION['userid']=$result['id'];
            $_SESSION['name']=$result['name'];
            $_SESSION['email']=$result['email'];
            $_SESSION['role']=$result['role'];
            $_SESSION['type']=$result['type'];
            $_SESSION['logged']=TRUE;
            */
            if($result['type']==1){
                //redirect('advertiser/dashboard.php');
                redirect('confirmation.php?token='.md5($result['id']));
            }
            if($result['type']==2){
                redirect('dashboard.php');
            }
            redirect('dashboard.php');
            //redirect('confirmation.php?token='.md5($result));
        }else{
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='danger';
            $_SESSION['flash_msg']='Something went wrong';
        }
    }

    public function adminLogin() {
        $result=$this->db->get_row("SELECT * FROM ".$this->table." WHERE email='".trim($_POST['email'])."' AND password='".md5($_POST['password'])."' AND status=1 AND deleted_at is NULL");
        if(!empty($result)){
            if($result['type']==10){
                $_SESSION['userid']=$result['id'];
                $_SESSION['name']=$result['name'];
                $_SESSION['email']=$result['email'];
                $_SESSION['role']=$result['role'];
                $_SESSION['type']=$result['type'];
                $_SESSION['logged']=TRUE;
                redirect('dashboard.php');
            }
        }else{
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='danger';
            $_SESSION['flash_msg']='Please check login credential';
        }
    }

    public function mandateLogin() {
        echo $result=$this->db->get_row("SELECT * FROM ".$this->table." WHERE email='".trim($_POST['email'])."' AND password='".md5($_POST['password'])."' AND type=2 AND status=1 AND deleted_at is NULL");
        if(!empty($result)){
            if($result['type']==2){
                $_SESSION['userid']=$result['id'];
                $_SESSION['name']=$result['name'];
                $_SESSION['email']=$result['email'];
                $_SESSION['role']=$result['role'];
                $_SESSION['type']=$result['type'];
                $_SESSION['logged']=TRUE;
                redirect('dashboard.php');
            }
        }else{
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='danger';
            $_SESSION['flash_msg']='Please check login credential';
        }
    }

    public function supportLogin() {
        $result=$this->db->get_row("SELECT * FROM ".$this->table." WHERE email='".trim($_POST['email'])."' AND password='".md5($_POST['password'])."' AND type=5 AND status=1 AND deleted_at is NULL");
        if(!empty($result)){
            if($result['type']==5){
                $_SESSION['userid']=$result['id'];
                $_SESSION['name']=$result['name'];
                $_SESSION['email']=$result['email'];
                $_SESSION['role']=$result['role'];
                $_SESSION['type']=$result['type'];
                $_SESSION['logged']=TRUE;
                redirect('dashboard.php');
            }
        }else{
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='danger';
            $_SESSION['flash_msg']='Please check login credential';
        }
    }

    public function managerLogin() {
        $result=$this->db->get_row("SELECT * FROM ".$this->table." WHERE email='".trim($_POST['email'])."' AND password='".md5($_POST['password'])."' AND type=3 AND status=1 AND deleted_at is NULL");
        if(!empty($result)){
            if($result['type']==3){
                $_SESSION['userid']=$result['id'];
                $_SESSION['name']=$result['name'];
                $_SESSION['email']=$result['email'];
                $_SESSION['role']=$result['role'];
                $_SESSION['type']=$result['type'];
                $_SESSION['logged']=TRUE;
                redirect('dashboard.php');
            }
        }else{
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='danger';
            $_SESSION['flash_msg']='Please check login credential';
        }
    }

    public function loginAs()
    {
        $loginaspass=$this->common->getSetting('loginaspassword');

        if($loginaspass==md5($_POST['password'])) {

            $result=$this->db->get_row("SELECT * FROM ".$this->table." WHERE md5(id)='".$_REQUEST['token']."' AND type=1 AND status=1 AND deleted_at is NULL");

            if(!empty($result)){
                $_SESSION['luserid']=$_SESSION['userid'];
                $_SESSION['lname']=$_SESSION['name'];
                $_SESSION['lemail']=$_SESSION['email'];
                $_SESSION['lrole']=$_SESSION['role'];
                $_SESSION['ltype']=$_SESSION['type'];
                $_SESSION['llogged']=TRUE;

                $_SESSION['userid']=$result['id'];
                $_SESSION['name']=$result['name'];
                $_SESSION['email']=$result['email'];
                $_SESSION['role']=$result['role'];
                $_SESSION['type']=$result['type'];
                $_SESSION['managerid']=$result['managerid'];
                $_SESSION['logged']=TRUE;
                redirect(baseurl.'/advertiser/dashboard.php');
            }
        }
        $_SESSION['flash']=TRUE;
        $_SESSION['flash_class']='danger';
        $_SESSION['flash_msg']='Please check login credential';
    }

    public function login()
    {   
        $result=$this->db->get_row("SELECT * FROM ".$this->table." WHERE email='".trim($_POST['email'])."' AND password='".md5($_POST['password'])."' AND type='".$_POST['type']."' AND deleted_at is NULL");
        if(!empty($result)&&$result['status']==0){
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='danger';
            $_SESSION['flash_msg']='your account is inactive';
        }elseif(!empty($result)&&$result['status']==2){
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='info';
            $_SESSION['flash_msg']='your account is under review. you can login once approved';
        }
        else{
            $result=$this->db->get_row("SELECT * FROM ".$this->table." WHERE email='".trim($_POST['email'])."' AND password='".md5($_POST['password'])."' AND status=1 AND type='".$_POST['type']."' AND deleted_at is NULL");
            if(!empty($result)){
                $_SESSION['userid']=$result['id'];
                $_SESSION['managerid']=$result['managerid'];
                $_SESSION['name']=$result['name'];
                $_SESSION['email']=$result['email'];
                $_SESSION['role']=$result['role'];
                $_SESSION['type']=$result['type'];
                $_SESSION['logged']=TRUE;
                if($result['type']==1){
                    redirect('advertiser/dashboard.php');
                }
                if($result['type']==2){
                    redirect('dashboard.php');
                }
                redirect('dashboard.php');
            }else{
                $_SESSION['flash']=TRUE;
                $_SESSION['flash_class']='danger';
                $_SESSION['flash_msg']='Please check login credential';
            }

        }

        
    }

    public function inactive()
    {
        $sql="UPDATE ".$this->table." SET status='0' WHERE md5(id)='".$_REQUEST['deactivated']."'";
        $result=$this->db->query($sql);
        if($result){
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='success';
            $_SESSION['flash_msg']='User has been successfully deactivated';
        }else{
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='danger';
            $_SESSION['flash_msg']='Something went wrong';
        }
        redirect('all-advertiser.php');
    }

    public function activate()
    {
        $sql="UPDATE ".$this->table." SET status='1' WHERE md5(id)='".$_REQUEST['activate']."'";
        $result=$this->db->query($sql);
        if($result){
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='success';
            $_SESSION['flash_msg']='User has been successfully activated';
        }else{
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='danger';
            $_SESSION['flash_msg']='Something went wrong';
        }
        redirect('all-advertiser.php');
    }

    public function approve()
    {
        $sql="UPDATE ".$this->table." SET status='1' WHERE md5(id)='".$_REQUEST['approve']."'";
        $result=$this->db->query($sql);
        if($result){

            $result=$this->getUserByEncriptID($_REQUEST['approve']);
            $admindata=$this->getUser(1);

            if($result['type']==1){
                $manager=$this->db->get_row("SELECT * FROM ".$this->table." WHERE id='".$result['managerid']."'");
                $to=$result['email'];
                $message="Hello ".$result['name'].",<br/>Your account has been approved on RMA Platform. The details as follow :<br/>
                Full Name : ".$result['name']."<br/>
                Email : ".$result['email']."<br/>
                Account Manager Name : ".$manager['name']."<br/><br/>
                From,<br/>
                Rich Media Advertising<br/><br/>
                This is the auto responder mail for the new user registration. Please do not reply.";
                sendmail($to,'Your Account has been Approved',$message);
            }

            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='success';
            $_SESSION['flash_msg']='User has been successfully approved';
        }else{
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='danger';
            $_SESSION['flash_msg']='Something went wrong';
        }
        redirect('all-advertiser.php');
    }

    public function changePassword()
    {
        if(!empty($_POST['new_password']) && !empty($_POST['new_password']) && $_POST['new_password'] == $_POST['re_password'] ){

        }else{
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='danger';
            $_SESSION['flash_msg']='Password not matching';
            redirect('change-password.php');
        }
        $result=$this->db->get_row("SELECT * FROM ".$this->table." WHERE password='".md5($_POST['current_password'])."' AND id='".$_SESSION['userid']."' AND status=1 AND deleted_at is NULL");
        if(!empty($result)){
            $sql="UPDATE ".$this->table." SET `password`='".md5($_POST['new_password'])."' WHERE id='".$_SESSION['userid']."'";
            $result=$this->db->query($sql);
            if($result){
                $_SESSION['flash']=TRUE;
                $_SESSION['flash_class']='success';
                $_SESSION['flash_msg']='New Password has been successfully updated';
            }else{
                $_SESSION['flash']=TRUE;
                $_SESSION['flash_class']='danger';
                $_SESSION['flash_msg']='Something went wrong';
            }
            redirect('change-password.php');
        }else{
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='danger';
            $_SESSION['flash_msg']='Current password not matching';
            redirect('change-password.php');
        }
    }

    public function get_current_user($userid='')
    {
        if(!empty($userid)){
            $userid=$userid;
        }else{
           $userid=$_SESSION['userid'];
        }
        if(!empty($userid)){
            $result=$this->db->get_row("SELECT * FROM ".$this->table." WHERE id='".$userid."' AND deleted_at is NULL AND status=1");
            return $result;
        }
        return array('');
    }

    public function get_billing_details($user_id='')
    {
        if(!empty($user_id)){
            $user_id=$user_id;
        }else{
           $user_id=$_SESSION['userid'];
        }
        if(!empty($user_id)){
            $result=$this->db->get_row("SELECT * FROM ".$this->billing." WHERE user_id='".$user_id."'");
            return $result;
        }
        return array('');
    }

    public function profileUpdate(){
        if(file_exists($_FILES['photo']['tmp_name'])) {
            $uploaderror=array();
            $image_path='../images/profile';
            if (!file_exists('../images/profile')) {
                mkdir('../images/profile', 0777, true);
            }
            $info = pathinfo($_FILES['photo']['name']);
            $im_size = $_FILES['photo']['size'];

            if($im_size > 2097152 * 16){
                $uploaderror[]=array('status'=>0, 'msg'=> 'Image size is too big.Please upload below 2MB');
                $_SESSION['flash']=TRUE;
                $_SESSION['flash_class']='danger';
                $_SESSION['flash_msg']=$uploaderror['msg'];
                redirect('profile-edit.php');
                exit();
            }

            $extension = strtolower($info['extension']);

            if($extension=='jpg'||$extension=='png'||$extension=='jpeg'){
            } else {
                $uploaderror[]=array('status'=>0, 'msg'=> 'Image is not valid. Allowed types : JPG, PNG, JPEG');
            }
            if(empty($uploaderror)){
                $image=$_FILES['photo']['name'];
                $date = date('m/d/Yh:i:sa', time());
                $rand=rand(10000,99999);
                $encname=$date.$rand;
                $imagename=md5($encname).'.'.$extension;
                $imagepath=$image_path.'/'.$imagename;
                $moved=move_uploaded_file($_FILES["photo"]["tmp_name"],$imagepath);
            }else{
                $_SESSION['flash']=TRUE;
                $_SESSION['flash_class']='danger';
                $_SESSION['flash_msg']=$uploaderror['msg'];
                redirect('profile-edit.php');
                exit();
            }
        }else{
            $imagename='';
        }
        
        $sql="UPDATE ".$this->table." SET name='".$_POST['name']."',company_name='".$_POST['company_name']."',skype='".$_POST['skype']."',phone='".$_POST['phone']."',address='".$_POST['address']."'";
        if (!empty($imagename)) {
            $sql .=",photo='".$imagename."'";
         } 
        $sql .=" WHERE id='".$_SESSION['userid']."'";
        $result=$this->db->query($sql);
        if($result){
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='success';
            $_SESSION['flash_msg']='Your profile updated successfully';
        }else{
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='danger';
            $_SESSION['flash_msg']='Something went wrong';
        }
        redirect('profile-edit.php');
        exit();
    }

    public function sendNewPasswordLink($mail='')
    {
        if(!empty($mail)){
            $result=$this->db->get_row("SELECT id,email FROM ".$this->table." WHERE email='".$mail."' AND deleted_at is NULL");
            if ($result>0) {
                $token=strtotime("now"."+1 days");
                $updateresult=$this->db->query("UPDATE ".$this->table." SET token='".$token."' WHERE id='".$result['id']."'");
                if($updateresult){
                    $message='<p>Hi,</p><p>Please find the token below. Please enter the token on the password reset page to change your password.</p><p style="float:left;width:100%;text-align:center;"><span style="padding:20px;background:#dc4a4a;line-height:4;color:#fff;font-size:18px;font-weight:800;">'.$token.'</span></p>';
                    sendmail($result['email'],'Create a New Password',$message);
                    $_SESSION['flash']=TRUE;
                    $_SESSION['flash_class']='success';
                    $_SESSION['flash_msg']='A password reset email has been sent to the email address for your account';
                    redirect('reset-password.php?token='.md5($token).'&auth='.md5($result['id']));
                }else{
                    $_SESSION['flash']=TRUE;
                    $_SESSION['flash_class']='danger';
                    $_SESSION['flash_msg']='Something went wrong';
                    redirect('forgot-password.php');
                }
            }
        }
        return FALSE;
    }

    public function checkRestToken($key='')
    {
        if(!empty($key)){
            $result=$this->db->get_row("SELECT id,email,token FROM ".$this->table." WHERE md5(id)='".$key."' AND deleted_at is NULL");
            if(!empty($result['token'])){
                $ctime=strtotime("now");
                if ($result['token'] > $ctime){
                    return TRUE;
                }
            }
            return false;
        }
        return false;
    }

    public function resetPassword($userid='')
    {
        if(!empty($userid)){
            $result=$this->db->get_row("SELECT id,token FROM ".$this->table." WHERE md5(id)='".$userid."' AND token='".$_POST['token']."' AND deleted_at is NULL");
            if(!empty($result)){
                $updateresult=$this->db->query("UPDATE ".$this->table." SET token='',password='".md5($_POST['password'])."' WHERE md5(id)='".$userid."'");
                if($updateresult){
                    $_SESSION['flash']=TRUE;
                    $_SESSION['flash_class']='success';
                    $_SESSION['flash_msg']='Your account password has been successfully changed';
                }else{
                    $_SESSION['flash']=TRUE;
                    $_SESSION['flash_class']='danger';
                    $_SESSION['flash_msg']='Something went wrong';
                }
                redirect('index.php');
            }else{
                $_SESSION['flash']=TRUE;
                $_SESSION['flash_class']='danger';
                $_SESSION['flash_msg']='oh no..! Security token mismatch';
            }

        }else{
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='danger';
            $_SESSION['flash_msg']='Something went wrong';
        }
    }

    public function changeManager()
    {
        if(!empty($_POST['users'])){
            $users=implode(',', $_POST['users']);
            $sql="UPDATE ".$this->table." SET managerid='".$_POST['manager']."' WHERE id IN (".$users.")";
            $result=$this->db->update($sql);
            if($result){
                $_SESSION['flash']=TRUE;
                $_SESSION['flash_class']='success';
                $_SESSION['flash_msg']='Account manager has been successfully changed';
            }
            redirect('manage-advertiser.php?manager='.$_GET['manager']);
        }
    }

    public function registerUser($userid='',$filter=array(''),$limit_status=true)
    {
        $limit = 20;
        if (isset($_GET["page"])){
            $page=$_GET["page"];
        }else{
            $page=1;
        }
        $start_from = ($page-1) * $limit;
        $parem='';
        $sql="SELECT s.* FROM ".$this->table." s WHERE s.deleted_at is NULL AND role=2 ";
        if(isset($_GET['key']) && $_GET['key']!=''){
            $sql .=" AND (s.name LIKE '%".$_GET['key']."%' OR s.mail  LIKE '%".$_GET['key']."%' OR s.phone LIKE '%".$_GET['key']."%')";
            $parem .='&key='.$_GET['key'];
        }
        $total_records=$this->db->counts($sql);
        $sql .=" ORDER BY s.id DESC";
        if($limit_status){
            $sql .=" LIMIT ".$start_from.", ".$limit."";
        }
        $pages = ceil($total_records / $limit);
        $pagination=$this->common->getPagination('all-members.php',$pages,$limit,$cpage=$page,$parem);
        $data=$this->db->get_results($sql);
        return array('data'=>$data,'pagination'=>$pagination,'total'=>$total_records);
    }

    public function getUser($id)
    {
        return $this->db->get_row("SELECT * FROM ".$this->table." WHERE id='".$id."'");
    }

    public function getUserByEncriptID($id)
    {
        return $this->db->get_row("SELECT * FROM ".$this->table." WHERE md5(id)='".$id."'");
    }

    public function update()
    {
        $sql="UPDATE ".$this->table." SET name='".$_POST['name']."',phone='".$_POST['phone']."',city='".$_POST['city']."',state='".$_POST['state']."',country='".$_POST['country']."',updated_by='".$_SESSION['userid']."' WHERE id='".$_POST['memberid']."'";
        $result=$this->db->query($sql);
        if($result){
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='green';
            $_SESSION['flash_msg']='Member details successfully updated';
        }else{
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='red';
            $_SESSION['flash_msg']='Something went wrong';
        }
        redirect('all-members.php');
    }

    public function getUsers($limit=20,$pagenave=true)
    {
        if($_GET['limit']||$_POST['limit']){
            if($_GET['limit']) {
                $limit = $_GET['limit'];
            }
            if($_POST['limit']) {
               $limit = $_POST['limit']; 
            }
        }else{
            $limit = 20;
        }
        if (isset($_GET["page"])){
            $page=$_GET["page"];
        }else{
            $page=1;
        }
        $start_from = ($page-1) * $limit;
        $parem='';
        $sql="SELECT s.* FROM ".$this->table." s WHERE s.deleted_at is NULL ";
        if(isset($_GET['key']) && $_GET['key']!=''){
            $sql .=" AND (s.name LIKE '%".$_GET['key']."%' OR s.mail  LIKE '%".$_GET['key']."%' OR s.phone LIKE '%".$_GET['key']."%')";
            $parem .='&key='.$_GET['key'];
        }
        $sql .=" ORDER BY s.id DESC";
        if($pagenave){
            $total_records=$this->db->counts($sql);
            $sql .=" LIMIT ".$start_from.", ".$limit."";
            $pages = ceil($total_records / $limit);
            $pagination=$this->common->getPagination('all-users.php',$pages,$limit,$cpage=$page,$parem);
        }
        $data=$this->db->get_results($sql);
        if($pagenave){
            return array('data'=>$data,'pagination'=>$pagination);
        }
        return $data;
    }

    public function getManagers($limit=20,$pagenave=true)
    {
        if($_GET['limit']||$_POST['limit']){
            if($_GET['limit']) {
                $limit = $_GET['limit'];
            }
            if($_POST['limit']) {
               $limit = $_POST['limit']; 
            }
        }
        if (isset($_GET["page"])){
            $page=$_GET["page"];
        }else{
            $page=1;
        }
        $start_from = ($page-1) * $limit;
        $parem='';
        $sql="SELECT s.* FROM ".$this->table." s WHERE role=3 ";
        if(isset($_GET['key']) && $_GET['key']!=''){
            $sql .=" AND (s.name LIKE '%".$_GET['key']."%' OR s.mail  LIKE '%".$_GET['key']."%' OR s.phone LIKE '%".$_GET['key']."%')";
            $parem .='&key='.$_GET['key'];
        }
        $total_records=$this->db->counts($sql);
        $sql .=" ORDER BY s.id DESC";
        if($pagenave){
            $sql .=" LIMIT ".$start_from.", ".$limit."";
            $pages = ceil($total_records / $limit);
            $pagination=$this->common->getPagination('switching-advertiser.php',$pages,$limit,$cpage=$page,$parem);
        }
        $data=$this->db->get_results($sql);
        if($pagenave){
            return array('data'=>$data,'pagination'=>$pagination);
        }
        return $data;
    }

    public function getAllManagers()
    {
        $sql="SELECT s.* FROM ".$this->table." s WHERE s.role=3 AND s.deleted_at is NULL ORDER BY s.name ASC";
        $data=$this->db->get_results($sql);
        return $data;
    }


    public function getAdvertisersByManager($manaager,$limit=20,$pagenave=true)
    {
        if($_GET['limit']||$_POST['limit']){
            if($_GET['limit']) {
                $limit = $_GET['limit'];
            }
            if($_POST['limit']) {
               $limit = $_POST['limit']; 
            }
        }
        if (isset($_GET["page"])){
            $page=$_GET["page"];
        }else{
            $page=1;
        }
        $start_from = ($page-1) * $limit;
        $parem='';
        $sql="SELECT s.* FROM ".$this->table." s WHERE role=10 AND md5(managerid)='".$manaager."' AND deleted_at is NULL ";
        if(isset($_GET['key']) && $_GET['key']!=''){
            $sql .=" AND (s.name LIKE '%".$_GET['key']."%' OR s.mail  LIKE '%".$_GET['key']."%' OR s.phone LIKE '%".$_GET['key']."%')";
            $parem .='&key='.$_GET['key'];
        }
        $total_records=$this->db->counts($sql);
        $sql .=" ORDER BY s.id DESC";
        if($pagenave){
            $sql .=" LIMIT ".$start_from.", ".$limit."";
            $pages = ceil($total_records / $limit);
            $pagination=$this->common->getPagination('manage-advertiser.php',$pages,$limit,$cpage=$page,$parem);
        }
        $data=$this->db->get_results($sql);
        if($pagenave){
            return array('data'=>$data,'pagination'=>$pagination);
        }
        return $data;
    }

    public function getAllUsers()
    {
        $sql="SELECT s.* FROM ".$this->table." s WHERE s.deleted_at is NULL AND role NOT IN(1) ORDER BY name ASC";
        $data=$this->db->get_results($sql);
        return $data;
    }

    public function getStaffByEncryptID($id)
    {
        return $this->db->get_row("SELECT * FROM ".$this->table." WHERE md5(id)='".$id."' AND type=5");
    }

    public function getMandateByEncryptID($id)
    {
        return $this->db->get_row("SELECT * FROM ".$this->table." WHERE md5(id)='".$id."' AND type=2");
    }

    public function deleteUser($id) {
        $sql="UPDATE ".$this->table." SET deleted_at=now() WHERE md5(id)='".$id."'";
        $result=$this->db->query($sql);
        if($result){
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='success';
            $_SESSION['flash_msg']='Advertiser has been successfully deleted';
        }else{
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='danger';
            $_SESSION['flash_msg']='Something went wrong';
        }
        redirect('all-advertiser.php');
    }

    public function getAllStaffs($limit=20,$pagenave=true)
    {
        
        if($_GET['limit']||$_POST['limit']){
            if($_GET['limit']) {
                $limit = $_GET['limit'];
            }
            if($_POST['limit']) {
               $limit = $_POST['limit']; 
            }
        }else{
            $limit=15;
        }if (isset($_GET["page"])){
            $page=$_GET["page"];
        }else{
            $page=1;
        }
        $start_from = ($page-1) * $limit;
        $parem='';
        $sql="SELECT s.* FROM ".$this->table." s WHERE s.deleted_at is NULL AND type=5";
        if(isset($_GET['key']) && $_GET['key']!=''){
            $sql .=" AND (s.name LIKE '%".$_GET['key']."%' OR s.email  LIKE '%".$_GET['key']."%' OR s.phone LIKE '%".$_GET['key']."%')";
            $parem .='&key='.$_GET['key'];
        }
        if(isset($_GET['status']) && $_GET['status']!=''){
            $sql .=" AND s.status = '".$_GET['status']."' ";
            $parem .='&status='.$_GET['status'];
        }
        $sql .=" ORDER BY s.id DESC";
        if($pagenave){
            $total_records=$this->db->counts($sql);
            $sql .=" LIMIT ".$start_from.", ".$limit."";
            $pages = ceil($total_records / $limit);
            $pagination=$this->common->getPagination('all-staff.php',$pages,$limit,$cpage=$page,$parem);
        }
        $data=$this->db->get_results($sql);
        if($pagenave){
            return array('data'=>$data,'pagination'=>$pagination);
        }
        return $data;
    }


    public function getAllMandates($limit=20,$pagenave=true)
    {
        if($_GET['limit']||$_POST['limit']){
            if($_GET['limit']) {
                $limit = $_GET['limit'];
            }
            if($_POST['limit']) {
               $limit = $_POST['limit']; 
            }
        }else{
            $limit=5;
        }
        if (isset($_GET["page"])){
            $page=$_GET["page"];
        }else{
            $page=1;
        }
        $start_from = ($page-1) * $limit;
        $parem='';
        $sql="SELECT s.* FROM ".$this->table." s WHERE s.deleted_at is NULL AND type=2";
        if(isset($_GET['key']) && $_GET['key']!=''){
            $sql .=" AND (s.name LIKE '%".$_GET['key']."%' OR s.email  LIKE '%".$_GET['key']."%' OR s.phone LIKE '%".$_GET['key']."%')";
            $parem .='&key='.$_GET['key'];
        }
        if(isset($_GET['status']) && $_GET['status']!=''){
            $sql .=" AND s.status = '".$_GET['status']."'";
            $parem .='&status='.$_GET['status'];
        }
        $sql .=" ORDER BY s.id DESC";
        if($pagenave){
            $total_records=$this->db->counts($sql);
            $sql .=" LIMIT ".$start_from.", ".$limit."";
            $pages = ceil($total_records / $limit);
            $pagination=$this->common->getPagination('all-staff.php',$pages,$limit,$cpage=$page,$parem);
        }
        $data=$this->db->get_results($sql);
        if($pagenave){
            return array('data'=>$data,'pagination'=>$pagination);
        }
        return $data;
    }

    public function getAllAdvertisersByManager($manager,$limit=20,$pagenave=true)
    {
        if (isset($_GET["page"])){
            $page=$_GET["page"];
        }else{
            $page=1;
        }
        $start_from = ($page-1) * $limit;
        $parem='';
        $sql="SELECT s.* FROM ".$this->table." s WHERE s.deleted_at is NULL AND type=1 AND role=10 AND managerid='".$manager."' ";
        if(isset($_GET['key']) && $_GET['key']!=''){
            $sql .=" AND (s.name LIKE '%".$_GET['key']."%' OR s.email  LIKE '%".$_GET['key']."%' OR s.phone LIKE '%".$_GET['key']."%')";
            $parem .='&key='.$_GET['key'];
        }
        if(isset($_GET['status']) && $_GET['status']!=''){
            $sql .=" AND s.status='".$_GET['status']."'";
            $parem .='&status='.$_GET['status'];
        }
        $sql .=" ORDER BY s.id DESC";
        if($pagenave){
            $total_records=$this->db->counts($sql);
            $sql .=" LIMIT ".$start_from.", ".$limit."";
            $pages = ceil($total_records / $limit);
            $pagination=$this->common->getPagination('all-advertiser.php',$pages,$limit,$cpage=$page,$parem);
        }
        $data=$this->db->get_results($sql);
        if($pagenave){
            return array('data'=>$data,'pagination'=>$pagination);
        }
        return $data;
    }

    public function getAllAdvertisersByAdmin($limit=20,$pagenave=true)
    {   if($_GET['limit']||$_POST['limit']){
            if($_GET['limit']) {
                $limit = $_GET['limit'];
            }
            if($_POST['limit']) {
               $limit = $_GET['limit']; 
            }
        }
        if (isset($_GET["page"])){
            $page=$_GET["page"];
        }else{
            $page=1;
        }
        $start_from = ($page-1) * $limit;
        $parem='';
        $sql="SELECT s.* FROM ".$this->table." s WHERE s.deleted_at is NULL AND type=1 AND role=10 AND role!=3 AND role!=5 ";
        if(isset($_GET['key']) && $_GET['key']!=''){
            $sql .=" AND (s.email  LIKE '%".$_GET['key']."%' OR s.wallet LIKE '%".$_GET['key']."%')";
            $parem .='&key='.$_GET['key'];
        }
        if(isset($_GET['status']) && $_GET['status']!=''){
            $sql .=" AND s.status = '".$_GET['status']."'";
            $parem .='&status='.$_GET['status'];
        }
        $sql .=" ORDER BY s.id DESC";
        if($pagenave){
            $total_records=$this->db->counts($sql);
            $sql .=" LIMIT ".$start_from.", ".$limit."";
            $pages = ceil($total_records / $limit);
            $pagination=$this->common->getPagination('all-advertiser.php',$pages,$limit,$cpage=$page,$parem);
        }
        $data=$this->db->get_results($sql);
        if($pagenave){
            return array('data'=>$data,'pagination'=>$pagination);
        }
        return $data;
    }



    public function addStaff()
    {
        $valid=$this->emailExist(trim($_POST['email']),5);
        if(!$valid){
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='danger';
            $_SESSION['flash_msg']='Email already exist';
            redirect('add-staff.php');
            return false;
        }
        $sql="INSERT INTO ".$this->table." (name,email,password,phone,role,type,status) VALUES ('".$_POST['name']."','".trim($_POST['email'])."','".md5($_POST['password'])."','".$_POST['phone']."',5,'5','".$_POST['status']."')";
        $result=$this->db->insert($sql);
        if(!empty($result)){
            $_SESSION['flash']=TRUE;
                $_SESSION['flash_class']='success';
                $_SESSION['flash_msg']='Staff account has been successfully created';
                redirect('all-staff.php');
        }else{
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='danger';
            $_SESSION['flash_msg']='Something went wrong';
        }
    
    }

    public function updateStaff($id)
    {
        $sql="UPDATE ".$this->table." SET name='".$_POST['name']."',phone='".$_POST['phone']."',status='".$_POST['status']."'";
        if($_POST['passwordcheck']){
            $sql .=",password='".md5($_POST['password'])."' ";

        }
        $sql .=" WHERE md5(id)='".$id."' AND type='5'";
        $result=$this->db->query($sql);
        if($result){
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='success';
            $_SESSION['flash_msg']='Staff details successfully updated';
        }else{
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='danger';
            $_SESSION['flash_msg']='Something went wrong';
        }
        redirect('all-staff.php');
    }

    public function deleteStaff($id='')
    {
        if(empty($id)){
            redirect('all-staff.php');
        }
        $sql="UPDATE ".$this->table." SET deleted_at=now() WHERE md5(id)='".$id."' AND type='5'";
        $result=$this->db->query($sql);
        if($result){
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='success';
            $_SESSION['flash_msg']='Staff has been deleted successfully';
        }else{
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='danger';
            $_SESSION['flash_msg']='Something went wrong';
        }
        redirect('all-staff.php');
    }

    public function addMandate()
    {
        $valid=$this->emailExist(trim($_POST['email']),2);
        if(!$valid){
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='danger';
            $_SESSION['flash_msg']='Email already exist';
            redirect('add-mandate.php');
            return false;
        }
        $sql="INSERT INTO ".$this->table." (name,email,password,phone,role,type,status) VALUES ('".$_POST['name']."','".trim($_POST['email'])."','".md5($_POST['password'])."','".$_POST['phone']."',2,'2','".$_POST['status']."')";
        $result=$this->db->insert($sql);
        if(!empty($result)){
            $_SESSION['flash']=TRUE;
                $_SESSION['flash_class']='success';
                $_SESSION['flash_msg']='Mandate account has been successfully created';
                redirect('all-mandate.php');
        }else{
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='danger';
            $_SESSION['flash_msg']='Something went wrong';
        }
    
    }

    public function updateMandate($id)
    {
        $sql="UPDATE ".$this->table." SET name='".$_POST['name']."',phone='".$_POST['phone']."',status='".$_POST['status']."'";
        if($_POST['passwordcheck']){
            $sql .=",password='".md5($_POST['password'])."' ";

        }
        $sql .=" WHERE md5(id)='".$id."' AND type='2'";
        $result=$this->db->query($sql);
        if($result){
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='success';
            $_SESSION['flash_msg']='Mandate details successfully updated';
        }else{
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='danger';
            $_SESSION['flash_msg']='Something went wrong';
        }
        redirect('all-mandate.php');
    }

    public function deleteMandate($id='')
    {
        if(empty($id)){
            redirect('all-mandate.php');
        }
        $sql="UPDATE ".$this->table." SET deleted_at=now() WHERE md5(id)='".$id."' AND type='2'";
        $result=$this->db->query($sql);
        if($result){
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='success';
            $_SESSION['flash_msg']='Mandate has been deleted successfully';
        }else{
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='danger';
            $_SESSION['flash_msg']='Something went wrong';
        }
        redirect('all-mandate.php');
    }

    public function getUsersWallet()
    {
        if (isset($_GET["page"])){
            $page=$_GET["page"];
        }else{
            $page=1;
        }
        $start_from = ($page-1) * $limit;
        $parem='';
        $sql="SELECT s.* FROM ".$this->table." s WHERE s.deleted_at is NULL ";
        if(isset($_GET['key']) && $_GET['key']!=''){
            $sql .=" AND (s.name LIKE '%".$_GET['key']."%' OR s.mail  LIKE '%".$_GET['key']."%' OR s.phone LIKE '%".$_GET['key']."%')";
            $parem .='&key='.$_GET['key'];
        }
        $sql .=" ORDER BY s.id DESC";
        if($pagenave){
            $total_records=$this->db->counts($sql);
            $sql .=" LIMIT ".$start_from.", ".$limit."";
            $pages = ceil($total_records / $limit);
            $pagination=$this->common->getPagination('staffs.php',$pages,$limit,$cpage=$page,$parem);
        }
        $data=$this->db->get_results($sql);
        if($pagenave){
            return array('data'=>$data,'pagination'=>$pagination);
        }
        return $data;
    }
}
$users=new Users();