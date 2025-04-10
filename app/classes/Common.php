<?php
class Common extends DB
{
    public $db;
    public $city='cities';
    public $states='states';
    public $countries='countries';
    public $branches='branches';
    public $settings='settings';
    public $note_table='notifications';

    function __construct()
    {
        $this->db=new DB();
    }

    public function getCountries()
    {
        $result=$this->db->get_results("SELECT * FROM ".$this->countries."");
        return $result;
    }

    public function getAllState()
    {
        $result=$this->db->get_results("SELECT * FROM ".$this->states."");
        return $result;
    }

    public function getstate($arg)
    {
        $result=$this->db->get_results("SELECT * FROM ".$this->states." WHERE country_id='".$arg."'");
        return $result;
    }

    public function getcity($arg)
    {
        return $this->db->get_results("SELECT * FROM ".$this->city." WHERE state_id='".$arg."'");
    }

    public function addNewCity()
    {
        $city=trim($_POST['addnewcityforstate']);
        $state=$_POST['state'];
        $sql="INSERT INTO ".$this->city." SET name='".$city."',state_id='".$state."'";
        $result=$this->db->insert($sql);
        if($result){
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='green';
            $_SESSION['flash_msg']='Successfully Saved';
        }else{
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='red';
            $_SESSION['flash_msg']='Something went wrong';
        }
        redirect('settings.php');
    }

    public function countriesByID($arg,$column='*')
    {
        $result=$this->db->get_row("SELECT ".$column." FROM ".$this->countries." WHERE id='".$arg."'");
        return $result;
    }

    public function countriesByCode($arg,$column='*')
    {
        $result=$this->db->get_row("SELECT ".$column." FROM ".$this->countries." WHERE sortname='".$arg."'");
        return $result;
    }

    public function stateByID($arg,$column='*')
    {
        $result=$this->db->get_row("SELECT ".$column." FROM ".$this->states." WHERE id='".$arg."'");
        return $result;
    }

    public function cityByID($arg,$column='*')
    {
        return $this->db->get_row("SELECT ".$column." FROM ".$this->city." WHERE id='".$arg."'");
    }

    public function getAllCity()
    {
        return $this->db->get_results("SELECT * FROM ".$this->city."");
    }

    public function getAllCountries($limit_status=true)
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
        $sql="SELECT * FROM ".$this->countries." WHERE deleted_at is NULL ";
        if(isset($_GET['key']) && $_GET['key']!=''){
            $sql .=" AND (sortname LIKE '%".$_GET['key']."%' OR name  LIKE '%".$_GET['key']."%' OR phonecode LIKE '%".$_GET['key']."%')";
            $parem .='&key='.$_GET['key'];
        }
        if(isset($_GET['status']) && $_GET['status']!=''){
            $sql .=" AND status='".$_GET['status']."'";
            $parem .='&status='.$_GET['status'];
        }
        $total_records=$this->db->counts($sql);
        $sql .=" ORDER BY name ASC";
        if($limit_status){
            $sql .=" LIMIT ".$start_from.", ".$limit."";
        }
        $pages = ceil($total_records / $limit);
        $pagination=$this->getPagination('countries.php',$pages,$limit,$cpage=$page,$parem);
        $data=$this->db->get_results($sql);
        return array('data'=>$data,'pagination'=>$pagination,'total'=>$total_records);
    }

    public function getAllStates($limit_status=true)
    {
        $limit = 20;
        if (isset($_GET["page"])){
            $page=$_GET["page"];
        }else{
            $page=1;
        }
        $start_from = ($page-1) * $limit;
        $parem='';
        $sql="SELECT s.*,c.name as cname, c.sortname as csort FROM ".$this->states." s JOIN ".$this->countries." c ON s.country_id=c.id WHERE s.deleted_at is NULL ";
        if(isset($_GET['key']) && $_GET['key']!=''){
            $sql .=" AND (s.name LIKE '%".$_GET['key']."%' OR s.state_code LIKE '%".$_GET['key']."%' )";
            $parem .='&key='.$_GET['key'];
        }
        if(isset($_GET['country']) && $_GET['country']!=''){
            $sql .=" AND s.country_id='".$_GET['country']."'";
            $parem .='&country='.$_GET['country'];
        }
        if(isset($_GET['status']) && $_GET['status']!=''){
            $sql .=" AND s.status='".$_GET['status']."'";
            $parem .='&status='.$_GET['status'];
        }
        $total_records=$this->db->counts($sql);
        $sql .=" ORDER BY s.name ASC";
        if($limit_status){
            $sql .=" LIMIT ".$start_from.", ".$limit."";
        }
        $pages = ceil($total_records / $limit);
        $pagination=$this->getPagination('states.php',$pages,$limit,$cpage=$page,$parem);
        $data=$this->db->get_results($sql);
        return array('data'=>$data,'pagination'=>$pagination,'total'=>$total_records);
    }

    public function getPagination($link='',$pages=1,$limit=15,$cpage=1,$parem=''){
        if($pages > 1){
            $html='<ul class="pagination pagination-sm no-margin pull-right">';
            $si=($cpage*$limit)-$limit;
            if($cpage > 1){
                $html .='<li><a href="'.$link.'?page=1'.$parem.'&limit='.$limit.'"><i class="fa  fa-angle-double-left"></i></a></li>';
                $html .='<li><a href="'.$link.'?page='.($cpage-1).$parem.'&limit='.$limit.'"><i class="fa fa-angle-left"></i></a></li>';
            }else{
                $html .='<li class=""><a><i class="fa fa-angle-double-left"></i></a></li>';
                $html .='<li class=""><a><i class="fa fa-angle-left"></i></a></li>';
            }
            $max = 15;
            if($cpage< $max){
                $sp = 1;
            }elseif($cpage >= ($pages-floor($max / 2)) ){
                $sp = $pages - $max + 1;
            }elseif($cpage >= $max){
                $sp = $cpage  - floor($max/2);
            }
            
            for($i = $sp; $i <= ($sp + $max -1);$i++){
                if($i > $pages){
                    continue;
                }
                if($cpage == $i){
                    $html .='<li class="active"><a>'.$i.'</a></li>';
                }else{
                    $html .='<li><a href="'.$link.'?page='.$i.$parem.'&limit='.$limit.'">'.$i.'</a></li>';
                }
            }
            if($cpage < $pages){
                $html .='<li><a href="'.$link.'?page='.($cpage + 1).$parem.'&limit='.$limit.'"><i class="fa fa-angle-right"></i></a></li>';
                $html .='<li><a href="'.$link.'?page='.$pages.$parem.'&limit='.$limit.'"><i class="fa fa-angle-double-right"></i></a></li>';
            }else{
                $html .='<li><a><i class="fa fa-angle-right"></i></a></li>';
                $html .='<li><a><i class="fa fa-angle-double-right"></i></a></li>';
            }
            $html .='</ul>';

            //$html .='<span>Total Pages : '.$pages.' </span>';
            return $html;
        }
        return NULL;
    }

    public function upload($file){
        $filename=false;
        if(file_exists($file['tmp_name'])) {
            $image_path='../public/uploads';
            $uploaderror=array();
            if (!file_exists($image_path)) {
                mkdir($image_path, 0777, true);
            }
            $info = pathinfo($file['name']);
            $im_size = $file['size'];

            if($im_size > 2097152 * 16){
                $uploaderror[]=array('status'=>0, 'msg'=> 'Image size is too big.Please upload below 2MB');
                $_SESSION['flash']=TRUE;
                $_SESSION['flash_class']='danger';
                $_SESSION['flash_msg']=$uploaderror['msg'];
                return false;
            }

            $extension = strtolower($info['extension']);

            if($extension=='jpg'||$extension=='png'||$extension=='jpeg'){
            } else {
                $uploaderror[]=array('status'=>0, 'msg'=> 'Image is not valid. Allowed types : JPG, PNG, JPEG');
            }
            if(empty($uploaderror)){
                $image=$file['name'];
                $date = date('m/d/Yh:i:sa', time());
                $rand=rand(10000,99999);
                $encname=$date.$rand;
                $imagename=md5($encname).'.'.$extension;
                $imagepath=$image_path.'/'.$imagename;
                $moved=move_uploaded_file($file["tmp_name"],$imagepath);
                return $imagename;
            }else{
                $_SESSION['flash']=TRUE;
                $_SESSION['flash_class']='danger';
                $_SESSION['flash_msg']=$uploaderror['msg'];
                return false;
            }
        }
    }

    public function sendMail($argu,$html=false)
    {
        $contents=file_get_contents(baseurl.'/email/'.$argu['template']);
        if(!empty($argu['parameter'])){
            foreach ($argu['parameter'] as $key => $value) {
                $contents = preg_replace("'{".$key."}'", $value, $contents);
            }
        }
        if($html==true){
            return $contents;
        }

        return sendMail($argu['to'],$argu['subject'],$contents);
    }

    public function getSetting($key)
    {
        $result=$this->db->get_row("SELECT * FROM ".$this->settings." WHERE `option`='".$key."'");
        if(count($result) > 0){
            return $result['value'];
        }
        return false;

    }

    public function checkSetting($key)
    {
        $result=$this->db->get_row("SELECT * FROM ".$this->settings." WHERE `option`='".$key."'");
        if(count($result) > 0){
            return true;
        }
        return false;

    }

    public function saveSetting($key,$value)
    {
        $retult=$this->checkSetting($key);
        if($retult){
            $sql=$this->db->update("UPDATE ".$this->settings." SET `value`='".$value."' WHERE `option`='".$key."'");
        }else{
            $sql=$this->db->insert("INSERT INTO ".$this->settings." SET `value`='".$value."', `option`='".$key."'");
        }
    }

    public function saveSettings()
    {
        if(!empty($_POST['setting'])){
            foreach ($_POST['setting'] as $key => $value) {
                $this->saveSetting($key,$value);
            }
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='success';
            $_SESSION['flash_msg']='Saved.';
        }
        redirect('settings.php');
    }

    public function loginAssistantPassword()
    {
        if( !empty(trim($_POST['newpassword'])) && !empty(trim($_POST['repassword'])) && $_POST['newpassword']==$_POST['repassword'] && strlen($_POST['repassword']) > 5 ){
            $cpass=$this->getSetting('loginaspassword');
            if($cpass==md5($_POST['cpassword'])){
                $this->saveSetting('loginaspassword',md5($_POST['newpassword']));
                $_SESSION['flash']=TRUE;
                $_SESSION['flash_class']='success';
                $_SESSION['flash_msg']='Password Saved.';
                redirect('settings.php#login-assistant');
            }
        }
        $_SESSION['flash']=TRUE;
        $_SESSION['flash_class']='danger';
        $_SESSION['flash_msg']='Something went wrong';
        redirect('settings.php#login-assistant');
    }

    public function setNotification($args)
    {
        $sqlval='';
        $count=count($args);
        $i=0;
        foreach($args as $key => $arg){
            $i++;
            $sqlval .=$key."='".$arg."'";
            if($count!=$i){
                $sqlval .=',';
            }
        }

        $sql="INSERT INTO ".$this->note_table." SET ".$sqlval;
        $this->db->insert($sql);
    }

    public function setNotificationLog($args,$campaign_id=NULL)
    {
        $sql="INSERT INTO ".$this->note_table." SET type=3, campaign_id='".$campaign_id."', message='".json_encode($args)."'";
        $this->db->insert($sql);
    }

    public function getNotificationCount()
    {
        $sql="SELECT count(id) as count FROM ".$this->note_table." WHERE status=1 AND type !=3";
        $count=$this->db->get_row($sql);
        return $count['count'];
    }

    public function getNotifications($limit=15,$status=NULL)
    {
        if (isset($_GET["page"])){
            $page=$_GET["page"];
        }else{
            $page=1;
        }
        $start_from = ($page-1) * $limit;
        $parem='';
        $sql="SELECT * FROM ".$this->note_table." WHERE type=1";
        
        if(isset($_GET['status']) && $_GET['status']!=''){
            $sql .=" AND status='".$_GET['status']."'";
            $parem .='&status='.$_GET['status'];
        }else{
            if(!is_null($status)){
                $sql .=" AND status='".$status."'";
            }
        }

        if(isset($_GET['type']) && $_GET['type']!=''){
            $sql .=" AND type='".$_GET['type']."'";
            $parem .='&type='.$_GET['type'];
        }
        
        $total_records=$this->db->counts($sql);
        $sql .=" ORDER BY id DESC LIMIT ".$start_from.", ".$limit."";

        $pages = ceil($total_records / $limit);
        $pagination=$this->getPagination('all-notifications.php',$pages,$limit,$cpage=$page,$parem);
        $data=$this->db->get_results($sql);
        return array('data'=>$data,'pagination'=>$pagination);
    }

    public function readNote($id){
        $sql="UPDATE ".$this->note_table." SET status=0 WHERE md5(id)='".$id."'";
        $this->db->update($sql);
    }

    public function readAllNote($id){
        $sql="UPDATE ".$this->note_table." SET status=0 WHERE type IN (1,2)";
        $this->db->update($sql);
    }

    public function logs($id){
        $sql="SELECT * FROM ".$this->note_table." WHERE md5(campaign_id)='".$id."'";
        return $this->db->get_results($sql);
    }

}
$common=new Common();