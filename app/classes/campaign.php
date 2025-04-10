<?php
class Campaign extends DB
{
    public $db;
    public $table='campaigns';
    public $entity='campaign_entity';
    public $type='campaign_types';
    public $reports='reports';
    public $video='videosize';
    public $users_table='users';
    public $payments='payments';

    function __construct()
    {
        $this->db=new DB();
        $this->common=new Common();
        $this->models=new Models();
        $this->devices=new Devices();
        $this->os=new OS();
        $this->pricing=new Pricing();
        $this->browsers=new Browsers();
        $this->browsers_languages=new BrowsersLanguages();
        $this->isp=new ISP();
        $this->ssp=new SSP();
        $this->publishers=new Publishers();
        $this->campaign_languages=new CampaignLanguages();
        $this->macros=new Macros();
        $this->mimeModule=new Mime();
        $this->performancemodel=new Performancemodel();
        $this->videosobj=new Videos();
    }

    public function allCampaignTypes() {
        $types="SELECT * FROM ".$this->type." WHERE deleted_at is NULL";
        return $this->db->get_results($types);
    }

    public function getTypeByID($id) {
        if(empty($id))
            return NULL;
        $types="SELECT * FROM ".$this->type." WHERE id='".$id."' AND deleted_at is NULL";
        return $this->db->get_row($types);
    }

    public function saveType() {
        redirect('campaign-types.php');
        return NULL;
         $sql="INSERT INTO ".$this->type." SET name='".trim($_POST['name'])."',type='".trim($_POST['type'])."',status='".trim($_POST['status'])."',created_by='".$_SESSION['userid']."'";
        $result=$this->db->insert($sql);
        if(!empty($result)){
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='success';
            $_SESSION['flash_msg']='Campaign type has been successfully added';
            redirect('campaign-types.php');
        }else{
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='danger';
            $_SESSION['flash_msg']='Something went wrong';
        }
    }

    public function updateType($id) {
        if(empty($id)){
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='danger';
            $_SESSION['flash_msg']='Something went wrong';
            redirect('campaign-types.php');
        }
        $sql="UPDATE ".$this->type." SET name='".trim($_POST['name'])."',type='".trim($_POST['type'])."',status='".trim($_POST['status'])."' WHERE id='".$id."'";
        $result=$this->db->query($sql);
        if(!empty($result)){
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='success';
            $_SESSION['flash_msg']='Campaign type has been successfully updated';
            redirect('campaign-types.php');
        }else{
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='danger';
            $_SESSION['flash_msg']='Something went wrong';
        }
    }

    public function typeDelete($id) {
        if(empty($id)){
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='danger';
            $_SESSION['flash_msg']='Something went wrong';
            redirect('campaign-types.php');
        }
        $sql="UPDATE ".$this->type." SET deleted_at=now() WHERE id='".$id."'";
        $result=$this->db->query($sql);
        if($result){
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='success';
            $_SESSION['flash_msg']='Campaign type has been successfully deleted';
        }else{
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='danger';
            $_SESSION['flash_msg']='Something went wrong';
        }
        redirect('campaign-types.php');
    }

    public function getCampaignByIdEncript($id) {
        $sql="SELECT * FROM ".$this->table." WHERE md5(id)='".$id."' AND deleted_at is NULL";
        return $this->db->get_row($sql);
    }

    public function getCampaignsCountByUserId($user_id)
    {
        $sql="SELECT id FROM ".$this->table." WHERE created_by='".$user_id."' AND parent=1";
        return $this->db->counts($sql);
    }

    public function getAllCampaignsByEncriptGroupId($id) {
        $sql="SELECT * FROM ".$this->table." WHERE md5(campaign_group)='".$id."' AND deleted_at is NULL ORDER BY id DESC";
        return $this->db->get_results($sql);
    }

    public function getCampaignByEncriptIO($id) {
        $sql="SELECT * FROM ".$this->table." WHERE md5(campaign_group)='".$id."'";
        return $this->db->get_row($sql);
    }

    public function getCampaignByIO($id) {
        $sql="SELECT * FROM ".$this->table." WHERE io='".$id."' AND parent=1 AND deleted_at is NULL";
        return $this->db->get_results($sql);
    }

    public function getAllCampaigns() {
        $sql="SELECT * FROM ".$this->table." WHERE status!=10 AND deleted_at is NULL ORDER BY campaign_group DESC";
        return $this->db->get_results($sql);
    }

    public function getAllCampaignsByGroupId($id) {
        $sql="SELECT * FROM ".$this->table." WHERE campaign_group='".$id."' AND deleted_at is NULL ORDER BY id DESC";
        return $this->db->get_results($sql);
    }

    public function getAllActiveCampaignsByGroupId($id) {
        $sql="SELECT * FROM ".$this->table." WHERE campaign_group='".$id."' AND deleted_at is NULL AND status=2 ORDER BY id DESC";
        return $this->db->get_results($sql);
    }

    public function deleteCamp($id){
        $sql="UPDATE ".$this->table." SET deleted_at=now() WHERE md5(id)='".$id."'";
        $result=$this->db->query($sql);
        $sql="UPDATE ".$this->table." SET deleted_at=now() WHERE md5(campaign_group)='".$id."'";
        $result=$this->db->query($sql);
        if($result){
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='success';
            $_SESSION['flash_msg']='Campaign has been successfully deleted';
        }else{
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='danger';
            $_SESSION['flash_msg']='Something went wrong';
        }
        redirect('all-campaigns.php');
    }

    public function renewCamp($id){
        $sql="UPDATE ".$this->table." SET renewstatus=1 WHERE md5(id)='".$id."'";
        $result=$this->db->update($sql);
        $sql="UPDATE ".$this->table." SET renewstatus=1 WHERE md5(campaign_group)='".$id."'";
        $result=$this->db->update($sql);
        $sql="UPDATE ".$this->payments." SET renewstatus=1 WHERE md5(campaign_id)='".$id."'";
        $result=$this->db->update($sql);

        if($result){
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='success';
            $_SESSION['flash_msg']='Campaign has been renew successfully';
        }else{
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='danger';
            $_SESSION['flash_msg']='Something went wrong';
        }
        redirect('view-campaign.php?id='.$_REQUEST['id']);
    }

    public function cancelRenewCamp($id){
        $sql="UPDATE ".$this->table." SET renewstatus=NULL WHERE md5(id)='".$id."'";
        $result=$this->db->update($sql);
        $sql="UPDATE ".$this->table." SET renewstatus=NULL WHERE md5(campaign_group)='".$id."'";
        $result=$this->db->update($sql);
        $sql="UPDATE ".$this->payments." SET renewstatus=NULL WHERE md5(campaign_id)='".$id."'";
        $result=$this->db->update($sql);

        if($result){
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='success';
            $_SESSION['flash_msg']='Hey, Campaign renew request was successfully cancelled';
        }else{
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='danger';
            $_SESSION['flash_msg']='Something went wrong';
        }
        redirect('view-campaign.php?id='.$_REQUEST['id']);
    }

    public function mandateApprove()
    {
        $approvecomment=mysqli_real_escape_string($this->db->connection(),$_POST['approvecomment']);
        $sql="UPDATE ".$this->table." SET mandate_comment='".htmlentities($approvecomment,ENT_QUOTES, "UTF-8")."',mandate_camp_status='1' WHERE (md5(id)='".$_REQUEST['id']."' OR md5(campaign_group)='".$_REQUEST['id']."')"; 

        $result=$this->db->query($sql); 
        if($result){
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='success';
            $_SESSION['flash_msg']='Campaign Approve has been successfully';
        }else{
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='danger';
            $_SESSION['flash_msg']='Something went wrong';
        }
        redirect('view-campaign.php?id='.$_REQUEST['id'].'');        

    }

    public function campaignActive()
    {
        if($_SESSION['role']==1){
            $sql="UPDATE ".$this->table." SET mandate_camp_status='1' WHERE (md5(id)='".$_REQUEST['id']."' OR md5(campaign_group)='".$_REQUEST['id']."')";
            $this->db->update($sql);
        }

        $dsql="DELETE FROM ".$this->table." WHERE md5(campaign_id)='".$_REQUEST['id']."'";
        $this->db->query($dsql);
            $sql="UPDATE ".$this->table." SET status='2',camppausetype='".$_POST['type']."', editstatus=NULL WHERE (md5(id)='".$_REQUEST['id']."' OR md5(campaign_group)='".$_REQUEST['id']."')";
            $result=$this->db->query($sql);
            if($result){
                $_SESSION['flash']=TRUE;
                $_SESSION['flash_class']='success';
                $_SESSION['flash_msg']='Campaign Active has been successfully';
            }else{
                $_SESSION['flash']=TRUE;
                $_SESSION['flash_class']='danger';
                $_SESSION['flash_msg']='Something went wrong';
            }
            redirect('view-campaign.php?id='.$_REQUEST['id'].'');        

    }

    public function campaignPause()
    {
        $dsql="DELETE FROM ".$this->table." WHERE md5(campaign_id)='".$_REQUEST['id']."'";
        $this->db->query($dsql);
            $sql="UPDATE ".$this->table." SET status='3',camppausetype='".$_POST['type']."', editstatus=NULL WHERE (md5(id)='".$_REQUEST['id']."' OR md5(campaign_group)='".$_REQUEST['id']."')";
            $result=$this->db->query($sql);
            if($result){                
                $_SESSION['flash']=TRUE;
                $_SESSION['flash_class']='success';
                $_SESSION['flash_msg']='Campaign Pause has been successfully';
            }else{
                $_SESSION['flash']=TRUE;
                $_SESSION['flash_class']='danger';
                $_SESSION['flash_msg']='Something went wrong';
            }
            redirect('view-campaign.php?id='.$_REQUEST['id'].'');

    }

    public function getCampaigns() {
        if($_GET['limit']||$_POST['limit']){
            if($_GET['limit']) {
                $limit = $_GET['limit'];
            }
            if($_POST['limit']) {
               $limit = $_GET['limit']; 
            }
        }else{
            $limit=15;
        }
        if (isset($_GET["page"])){
            $page=$_GET["page"];
        }else{
            $page=1;
        }
        $start_from = ($page-1) * $limit;
        $parem='';
        $sql="SELECT c.*,u.name as username FROM ".$this->table." c JOIN users u ON u.id=c.created_by WHERE c.deleted_at is NULL AND c.parent=1 AND c.status NOT IN (5,40,50) ";
        if(isset($_GET['key']) && $_GET['key']!=''){
            $sql .=" AND c.name LIKE '%".$_GET['key']."%' ";
            $parem .='&key='.$_GET['key'];
        }
        
        if(isset($_GET['status']) && $_GET['status']!=''){
            $sql .=" AND c.status='".$_GET['status']."'";
            $parem .='&status='.$_GET['status'];
        }

        if(isset($_GET['id']) && $_GET['id']!=''){
            $sql .=" AND c.id='".$_GET['id']."'";
            $parem .='&id='.$_GET['id'];
        }

        if(isset($_GET['advertiser']) && $_GET['advertiser']!=''){
            $sql .=" AND (u.id='".$_GET['advertiser']."' OR u.name LIKE '%".$_GET['advertiser']."%')";
            $parem .='&advertiser='.$_GET['advertiser'];
        }

        if(isset($_GET['type']) && $_GET['type']!=''){
            $sql .=" AND c.type='".$_GET['type']."'";
            $parem .='&type='.$_GET['type'];
        }
        
        $total_records=$this->db->counts($sql);
        $sql .=" ORDER BY c.id DESC LIMIT ".$start_from.", ".$limit."";

        $pages = ceil($total_records / $limit);
        $pagination=$this->common->getPagination('all-campaigns.php',$pages,$limit,$cpage=$page,$parem);
        $data=$this->db->get_results($sql);
        return array('data'=>$data,'pagination'=>$pagination);
    }

    public function getUserCampaigns($user_id='') {
        if(empty($user_id)){
            $user_id=$_SESSION['userid'];
        }
        if($perrow){
            $limit = $perrow;
        }else{
            $limit=15;
        }
        if (isset($_GET["page"])){
            $page=$_GET["page"];
        }else{
            $page=1;
        }
        $start_from = ($page-1) * $limit;
        $parem='';
        $sql="SELECT c.*,m.name as modelname, m.type as modeltype FROM ".$this->table." c JOIN ".$this->models->table." m ON m.id=c.model WHERE c.deleted_at is NULL AND c.parent=1 AND c.created_by='".$user_id."' AND c.status NOT IN (50) ";
        if(isset($_GET['key']) && $_GET['key']!=''){
            $sql .=" AND c.name LIKE '%".$_GET['key']."%' ";
            $parem .='&key='.$_GET['key'];
        }
        
        if(isset($_GET['status']) && $_GET['status']!=''){
            $sql .=" AND c.status='".$_GET['status']."'";
            $parem .='&status='.$_GET['status'];
        }

        if(isset($_GET['type']) && $_GET['type']!=''){
            $sql .=" AND c.type='".$_GET['type']."'";
            $parem .='&type='.$_GET['type'];
        }
        
        $total_records=$this->db->counts($sql);
        $sql .=" ORDER BY c.id DESC LIMIT ".$start_from.", ".$limit."";

        $pages = ceil($total_records / $limit);
        $pagination=$this->common->getPagination('all-campaigns.php',$pages,$limit,$cpage=$page,$parem);
        $data=$this->db->get_results($sql);
        return array('data'=>$data,'pagination'=>$pagination);
    }

     public function getAllManagerWaitingCampaigns($limit='',$id) {
        $sql="SELECT id FROM users WHERE managerid='".$id."' "; 
        $userid=$this->db->get_results($sql);
        if(!empty($userid)){
            $id=array();
                foreach ($userid as $value) {
                    $id[]=$value['id'];
                }
            $idstr=implode( ",", $id);
            $sql="SELECT * FROM ".$this->table." WHERE created_by IN(".$idstr.") AND status IN(0,1) AND deleted_at is NULL AND parent=1 ORDER BY id DESC "; 
                if(!empty($limit)){
                    $sql .=" LIMIT 0,".$limit;
                }
            return $this->db->get_results($sql);
        }
        return array();
    }

    public function getAllManagerPausedCampaigns($limit='',$id) {
        $sql="SELECT id FROM users WHERE managerid='".$id."' "; 
        $userid=$this->db->get_results($sql);
        if(empty($userid)){
            return array();
        }
        $id=array();
            foreach ($userid as $value) {
                $id[]=$value['id'];
            }
        $idstr=implode( ",", $id);
        $sql="SELECT * FROM ".$this->table." WHERE created_by IN(".$idstr.") AND status IN(3) AND deleted_at is NULL AND parent=1 ORDER BY id DESC "; 
            if(!empty($limit)){
                $sql .=" LIMIT 0,".$limit;
            }
        return $this->db->get_results($sql);
    }

    public function getAllManagerActiveCampaigns($limit='',$id) {
        $sql="SELECT id FROM users WHERE managerid='".$id."' "; 
        $userid=$this->db->get_results($sql);
        if(empty($userid)){
            return array();
        }
        $id=array();
            foreach ($userid as $value) {
                $id[]=$value['id'];
            }
        $idstr=implode( ",", $id);
        $sql="SELECT * FROM ".$this->table." WHERE created_by IN(".$idstr.") AND status IN(2) AND deleted_at is NULL AND parent=1 ORDER BY id DESC "; 
            if(!empty($limit)){
                $sql .=" LIMIT 0,".$limit;
            }
        return $this->db->get_results($sql);
    }

    public function getUserCampaignsByMangerID($manager) {

        if($perrow){
        $limit = $perrow;
        }else{
        $limit=15;
        }
        if (isset($_GET["page"])){
        $page=$_GET["page"];
        }else{
        $page=1;
        }
        $start_from = ($page-1) * $limit;
        $parem='';
        $sql="SELECT c.*,m.name as modelname, m.type as modeltype, u.name as advname FROM ".$this->table." c JOIN ".$this->models->table." m ON m.id=c.model JOIN ".$this->users_table." u ON u.id=c.created_by WHERE u.managerid='".$manager."' AND c.deleted_at is NULL AND c.parent=1 AND c.created_by=u.id AND c.status NOT IN (50) ";
        if(isset($_GET['key']) && $_GET['key']!=''){
        $sql .=" AND c.name LIKE '%".$_GET['key']."%' ";
        $parem .='&key='.$_GET['key'];
        }

        if(isset($_GET['status']) && $_GET['status']!=''){
        $sql .=" AND c.status='".$_GET['status']."'";
        $parem .='&status='.$_GET['status'];
        }

        if(isset($_GET['type']) && $_GET['type']!=''){
        $sql .=" AND c.type='".$_GET['type']."'";
        $parem .='&type='.$_GET['type'];
        }

        $total_records=$this->db->counts($sql);
        $sql .=" ORDER BY c.id DESC LIMIT ".$start_from.", ".$limit."";

        $pages = ceil($total_records / $limit);
        $pagination=$this->common->getPagination('all-campaigns.php',$pages,$limit,$cpage=$page,$parem);
        $data=$this->db->get_results($sql);
        return array('data'=>$data,'pagination'=>$pagination);
    }


    public function getRunningCampaigns() {
        $sql="SELECT id FROM ".$this->table." WHERE status=2 AND deleted_at is NULL AND parent=1 AND created_by='".$_SESSION['userid']."'";
        return $this->db->counts($sql);
    }

    public function getWaitingCampaigns() {
        $sql="SELECT id FROM ".$this->table." WHERE status IN(0,1) AND deleted_at is NULL AND parent=1 AND created_by='".$_SESSION['userid']."'";
        return $this->db->counts($sql);
    }

    public function getAllWaitingCampaigns($limit='') {
        $sql="SELECT * FROM ".$this->table." WHERE status IN(0,1) AND deleted_at is NULL AND parent=1 ORDER BY id DESC ";
        if(!empty($limit)){
            $sql .=" LIMIT 0,".$limit;
        }
        return $this->db->get_results($sql);
    }

    public function getAllCoreEditCampaigns($limit='') {
        $sql="SELECT * FROM ".$this->table." WHERE editstatus=1 AND deleted_at is NULL AND parent=1 AND campaign_id is NULL ORDER BY id DESC ";
        if(!empty($limit)){
            $sql .=" LIMIT 0,".$limit;
        }
        return $this->db->get_results($sql);
    }

    public function getAllMinorEditCampaigns($limit='') {
        $sql="SELECT * FROM ".$this->table." WHERE editstatus=2 AND deleted_at is NULL AND campaign_id is NULL AND parent=1 ORDER BY id DESC ";
        if(!empty($limit)){
            $sql .=" LIMIT 0,".$limit;
        }
        return $this->db->get_results($sql);
    }

    public function getPausedCampaigns() {
        $sql="SELECT id FROM ".$this->table." WHERE status=3 AND deleted_at is NULL AND parent=1 AND created_by='".$_SESSION['userid']."'";
        return $this->db->counts($sql);
    }

    public function newCampaignForm($id,$step=1,$type='')
    {
        switch ($step) {
            case '1':
                include('campaign-details.php');
                break;
            case '2':
                include('campaign-geo.php');
                break;
            case '3':
                include('choose-campaign.php');
                break;
            case '4':
                break;
            case '5':
                if($type=='Banner'){
                    include('banner-campaign.php');
                }
                if($type=='Pop'){
                    include('pop-campaign.php');
                }
                if($type=='Video'){
                    include('video-campaign.php');
                }
                if($type=='Push'){
                    include('push-campaign.php');
                }
                if($type=='Native'){
                    include('native-campaign.php');
                }
                break;
            case '6':
                    include('campaign-price.php');
                break;
            case '7':
                    include('campaign-duration-budget.php');
                break;
            case '8':
                    include('save-campaign.php');
                break;
            default:
                # code...
                break;
        }
    }


    public function save() {
        if(isset($_POST['step']) && $_POST['step']==1 && empty($_REQUEST['token'])){
            $model = explode ("-", $_POST['model']);
            $sql="INSERT INTO ".$this->table." SET 
                    parent=1,
                    name='".htmlspecialchars(htmlentities($_POST['name'], ENT_QUOTES, "UTF-8"))."',
                    model='".$model[0]."',
                    type='".$model[1]."',
                    performodel='".$_POST['performodel']."',
                    device='".json_encode($_POST['device'])."',
                    os='".json_encode($_POST['ostype'])."',
                    versions='".json_encode($_POST['osversions'])."',
                    browser='".json_encode($_POST['browser'])."',
                    language='".json_encode($_POST['language'])."',
                    isp='".json_encode($_POST['isp'])."',
                    status=50,
                    connection='".$_POST['connection']."',
                    created_by='".$_SESSION['userid']."'";
            $result=$this->db->insert($sql);
            if($result){
                redirect('new-campaign.php?step=2&token='.md5($result));
            }
        }elseif(isset($_POST['step']) && $_POST['step']==1 && !empty($_REQUEST['token']) && !isset($_REQUEST['edit'])){
            $model = explode ("-", $_POST['model']);
            $sql="UPDATE ".$this->table." SET 
                    name='".htmlspecialchars(htmlentities($_POST['name'], ENT_QUOTES, "UTF-8"))."',
                    model='".$model[0]."',
                    type='".$model[1]."',
                    performodel='".$_POST['performodel']."',
                    device='".json_encode($_POST['device'])."',
                    os='".json_encode($_POST['ostype'])."',
                    versions='".json_encode($_POST['osversions'])."',
                    browser='".json_encode($_POST['browser'])."',
                    language='".json_encode($_POST['language'])."',
                    isp='".json_encode($_POST['isp'])."',
                    connection='".$_POST['connection']."' 
                    WHERE md5(id)='".$_REQUEST['token']."'";
            $result=$this->db->query($sql);
            if($result){
                redirect('new-campaign.php?step=2&token='.$_REQUEST['token']);
            }
        }elseif(isset($_POST['step']) && $_POST['step']==1 && !empty($_REQUEST['token']) && isset($_REQUEST['edit'])){

            $camp=self::getCampaignByIdEncript($_REQUEST['token']);
            $this->revision($camp);

            //$model = explode ("-", $_POST['model']);
            $sql="UPDATE ".$this->table." SET 
                    name='".htmlspecialchars(htmlentities($_POST['name'], ENT_QUOTES, "UTF-8"))."',                    
                    device='".json_encode($_POST['device'])."',
                    os='".json_encode($_POST['ostype'])."',
                    versions='".json_encode($_POST['osversions'])."',
                    browser='".json_encode($_POST['browser'])."',
                    language='".json_encode($_POST['language'])."',
                    isp='".json_encode($_POST['isp'])."',
                    connection='".$_POST['connection']."'
                    WHERE md5(id)='".$_REQUEST['token']."'";
            $result=$this->db->update($sql);

            if($result){

                if(in_array($camp['status'], array(2))){
                    $editstatus=2;
                    if($camp['device']!=json_encode($_POST['device'])){
                        $editstatus=1;
                        $status=3;
                        $sql="SELECT * FROM users WHERE id='".$_SESSION['userid']."' AND deleted_at is NULL";
                        $manage=$this->db->get_row($sql);
                        $mail="SELECT * FROM users WHERE id='".$manage['managerid']."'  AND deleted_at is NULL";
                        $mmail=$this->db->get_row($mail);
                        $admin="SELECT * FROM users WHERE type=10 AND deleted_at is NULL";
                        $amail=$this->db->get_row($admin);
                        $name=$manage['name'];
                        $amt=$campaigndetails['total_budget'];
                        $tid=$_POST['transactionid'];
                        $message='<p>Hi,</p>
                        <p>Name Of Advertiser:'.$name.'</p>
                        <p>Campaign ID:'.$camp['id'].'</p>
                        <p>Campaign Name:'.$camp['name'].'</p>';
                        $cc=$mmail['email'];
                        sendmail($amail['email'],'Campaign Paused By Major Edit',$message,$cc);

                        $note=array(
                            'user_id'       => $_SESSION['userid'],
                            'campaign_id'   => $camp['id'],
                            'type'          => 1,
                            'note'          => $camp['name'].' campaign was paused for major edited',
                            'status'        => 1
                        );
                        $this->common->setNotification($note);
                        $this->common->setNotificationLog($camp,$camp['id']);
                    }else{

                        $note=array(
                            'user_id'       => $_SESSION['userid'],
                            'campaign_id'   => $camp['id'],
                            'type'          => 1,
                            'note'          => $camp['name'].' campaign was edited',
                            'status'        => 1
                        );

                        $this->common->setNotification($note);
                        $this->common->setNotificationLog($camp,$camp['id']);
                    }

                    $sql="UPDATE ".$this->table." SET 
                        status='".$status."',
                        editstatus='".$editstatus."',
                        camppausetype='".$_SESSION['userid']."'
                        WHERE md5(id)='".$_REQUEST['token']."'";
                    $this->db->query($sql);
                }                
            }
            redirect('new-campaign.php?step=2&token='.$_REQUEST['token'].'&edit='.$_REQUEST['edit']);
        }

        if(isset($_POST['step']) && $_POST['step']==2){
            $camp=self::getCampaignByIdEncript($_REQUEST['token']);

            $sql="UPDATE ".$this->table." SET  geo_targeting='".json_encode($_POST['geo'])."',";
            if($_POST['targeting']['advance_target']=='yes'){
                $sql .="coordinates='".json_encode($_POST['location'])."',";
            }
            $sql .="advanced_targeting='".json_encode($_POST['targeting'])."' WHERE md5(id)='".$_REQUEST['token']."'";

            $update=$this->db->update($sql);


            if(!empty($_REQUEST['edit'])){
                if($update){
                    $sql="UPDATE ".$this->table." SET 
                        status='1',
                        editstatus='2'
                        WHERE md5(id)='".$_REQUEST['token']."'";
                    $result=$this->db->update($sql);
                    
                    if(is_null($camp['editstatus'])){
                        $note=array(
                            'user_id'       => $_SESSION['userid'],
                            'campaign_id'   => $camp['id'],
                            'type'          => 1,
                            'note'          => $camp['name'].' campaign was edited',
                            'status'        => 1
                        );

                        $this->common->setNotification($note);

                        $this->common->setNotificationLog($camp,$camp['id']);
                    }
                }
                redirect('new-campaign.php?step=3&token='.$_REQUEST['token'].'&edit='.$_REQUEST['edit']);
            }
            if($update){
                redirect('new-campaign.php?step=3&token='.$_REQUEST['token']);
            }
        }

        if(isset($_POST['step']) && $_POST['step']==3){
            $sql="UPDATE ".$this->table." SET coordinates='".json_encode($_POST['coordinates'])."' WHERE md5(id)='".$_REQUEST['token']."'";
            $result=$this->db->update($sql);
            if(!empty($_REQUEST['edit'])){
                redirect('new-campaign.php?step=4&token='.$_REQUEST['token'].'&edit='.$_REQUEST['edit']);
            }
            if($result){
                redirect('new-campaign.php?step=4&token='.$_REQUEST['token']);
            }
        }

        if(isset($_POST['step']) && $_POST['step']==4){
            
            if(!empty($_REQUEST['token']) && isset($_REQUEST['edit']) && !empty($_REQUEST['edit'])){
                $camp=self::getCampaignByIdEncript($_REQUEST['token']);
                $editstatus=$camp['editstatus'];
                $status=$camp['status'];
                if($camp['type']!=$_POST['type']){
                    $editstatus=1;
                    if($camp['status']==2){
                        $status=3;
                    }
                }
                $sql="UPDATE ".$this->table." SET  status='".$status."', editstatus='".$editstatus."',camppausetype='".$_SESSION['userid']."' WHERE md5(id)='".$_REQUEST['token']."'";
                $this->db->query($sql);

            }

            $sql="UPDATE ".$this->table." SET type='".$_POST['type']."' WHERE md5(id)='".$_REQUEST['token']."'";
            $result=$this->db->query($sql);
            if(!empty($_REQUEST['edit'])){
                redirect('new-campaign.php?step=5&type='.$_POST['type'].'&token='.$_REQUEST['token'].'&edit='.$_REQUEST['edit']);
            }
            if($result){
                redirect('new-campaign.php?step=5&type='.$_POST['type'].'&token='.$_REQUEST['token']);
            }
        }
        if(isset($_POST['step']) && $_POST['step']==5){
            $campaigndata=self::getCampaignByIdEncript($_REQUEST['token']);
            if($_POST['type']=='Banner'){
                $_POST['banner']['width']=htmlspecialchars(htmlentities($_POST['banner']['width'], ENT_QUOTES, "UTF-8"));
                $_POST['banner']['height']=htmlspecialchars(htmlentities($_POST['banner']['height'], ENT_QUOTES, "UTF-8"));
                $sql="UPDATE ".$this->table." SET banner_type='".htmlspecialchars(htmlentities($_POST['banner_type'], ENT_QUOTES, "UTF-8"))."', creative_name='".htmlspecialchars(htmlentities($_POST['creative_name'], ENT_QUOTES, "UTF-8"))."',banner_size='".json_encode($_POST['banner'])."',macros='".json_encode($_POST['macros'])."',url='".htmlspecialchars(htmlentities($_POST['url'], ENT_QUOTES, "UTF-8"))."' ";
                if($_POST['banner_type']=='url'){
                    if(!empty($_FILES['banner'])&&($_FILES['banner']['error']==0)){
                        $banner=$this->common->upload($_FILES['banner']);
                        $sql .=",image='".$banner."'";
                    }elseif (!empty($_POST['oldimage'])&&($_FILES['banner']['error']=='4')) {
                        $sql .=",image='".$_POST['oldimage']."'";
                    }
                }elseif($_POST['banner_type']=='js'){
                    $sql .=",js_tag='".mysqli_real_escape_string($this->db->connection(),$_POST['js'])."'";
                }
                $sql .=" WHERE md5(id)='".$_REQUEST['token']."'";
                $result=$this->db->update($sql);
            }
            if($_POST['type']=='Pop'){
                $sql="UPDATE ".$this->table." SET creative_name='".htmlspecialchars(htmlentities($_POST['creative_name'], ENT_QUOTES, "UTF-8"))."',macros='".json_encode($_POST['macros'])."',url='".htmlspecialchars(htmlentities($_POST['destination'], ENT_QUOTES, "UTF-8"))."' WHERE md5(id)='".$_REQUEST['token']."'";
                $result=$this->db->update($sql);
            }
            if($_POST['type']=='Video'){
                $_POST['video']['domain']=htmlspecialchars(htmlentities($_POST['video']['domain'], ENT_QUOTES, "UTF-8"));
                $_POST['video']['length']=htmlspecialchars(htmlentities($_POST['video']['length'], ENT_QUOTES, "UTF-8"));
                $_POST['video']['url']=htmlspecialchars(htmlentities($_POST['video']['url'], ENT_QUOTES, "UTF-8"));
                $sql="UPDATE ".$this->table." SET creative_name='".htmlspecialchars(htmlentities($_POST['creative_name'], ENT_QUOTES, "UTF-8"))."',macros='".json_encode($_POST['macros'])."',video='".json_encode($_POST['video'])."' WHERE md5(id)='".$_REQUEST['token']."'";
                $result=$this->db->update($sql);
            }
            if($_POST['type']=='Push'){
                $image1=$this->common->upload($_FILES['image1']);
                //$image2=$this->common->upload($_FILES['image2']); && $image2
                if($_FILES['image1']['error']==0){
                    $_POST['push']['image']=array($image1); //,$image2
                }elseif($_FILES['image1']['error']==4){
                    $_POST['push']['image']=array($_POST['oldimage']);
                }
                $_POST['push']['description']=htmlspecialchars(htmlentities($_POST['push']['description'], ENT_QUOTES, "UTF-8"));
                $_POST['push']['page']=htmlspecialchars(htmlentities($_POST['push']['page'], ENT_QUOTES, "UTF-8"));
                $_POST['push']['title']=htmlspecialchars(htmlentities($_POST['push']['title'], ENT_QUOTES, "UTF-8"));
                $sql="UPDATE ".$this->table." SET creative_name='".htmlspecialchars(htmlentities($_POST['creative_name'], ENT_QUOTES, "UTF-8"))."',push='".json_encode($_POST['push'])."',url='".htmlspecialchars(htmlentities($_POST['destination'], ENT_QUOTES, "UTF-8"))."' WHERE md5(id)='".$_REQUEST['token']."'";
                $result=$this->db->update($sql);
            }
            if($_POST['type']=='Native'){
                $image1=$this->common->upload($_FILES['image1']); 
                //$_POST['native']['image'][]=$image2=$this->common->upload($_FILES['image2']);
                //$_POST['native']['image'][]=$image3=$this->common->upload($_FILES['image3']);
                if($_FILES['image1']['error']==0){
                    $_POST['native']['image'][]=array($image1); //,$image2
                }elseif($_FILES['image1']['error']==4){
                    $_POST['native']['image'][]=array($_POST['oldimage']);
                }
                $_POST['native']['page']=htmlspecialchars(htmlentities($_POST['native']['page'], ENT_QUOTES, "UTF-8"));
                $_POST['native']['title']=htmlspecialchars(htmlentities($_POST['native']['title'], ENT_QUOTES, "UTF-8"));
                $_POST['native']['address']=htmlspecialchars(htmlentities($_POST['native']['address'], ENT_QUOTES, "UTF-8"));
                $_POST['native']['phone']=htmlspecialchars(htmlentities($_POST['native']['phone'], ENT_QUOTES, "UTF-8"));
                $_POST['native']['sponsored']=htmlspecialchars(htmlentities($_POST['native']['sponsored'], ENT_QUOTES, "UTF-8"));
                
                
                $sql="UPDATE ".$this->table." SET creative_name='".htmlspecialchars(htmlentities($_POST['creative_name'], ENT_QUOTES, "UTF-8"))."',native='".json_encode($_POST['native'])."',macros='".json_encode($_POST['macros'])."',url='".htmlspecialchars(htmlentities($_POST['destination'], ENT_QUOTES, "UTF-8"))."' WHERE md5(id)='".$_REQUEST['token']."'";
                $result=$this->db->update($sql);
            }
            if(!empty($_REQUEST['edit'])){
                $cam=self::getCampaignByIdEncript($_REQUEST['token']);
                if($result) {
                    $camp=self::getCampaignByIdEncript($_REQUEST['token']);
                    if($camp['status']==2){
                        $editstatus=1;
                        $status=3;
                        if($camp['editstatus']!=1){
                            $sql="SELECT * FROM users WHERE id='".$_SESSION['userid']."' AND deleted_at is NULL";
                            $manage=$this->db->get_row($sql);
                            $mail="SELECT * FROM users WHERE id='".$manage['managerid']."'  AND deleted_at is NULL";
                            $mmail=$this->db->get_row($mail);
                            $admin="SELECT * FROM users WHERE type=10 AND deleted_at is NULL";
                            $amail=$this->db->get_row($admin);
                            $name=$manage['name'];
                            $message='<p>Hi,</p>
                            <p>Name Of Advertiser:'.$name.'</p>
                            <p>Campaign ID:'.$camp['id'].'</p>
                            <p>Campaign Name:'.$camp['name'].'</p>';
                            $cc=$mmail['email'];
                            sendmail($amail['email'],'Campaign Paused By Major Edit',$message,$cc);

                            $note=array(
                                'user_id'       => $_SESSION['userid'],
                                'campaign_id'   => $campaigndata['id'],
                                'type'          => 1,
                                'note'          => $campaigndata['name'].' campaign was paused for major edited',
                                'status'        => 1
                            );
                            $this->common->setNotification($note);
                            $this->common->setNotificationLog($campaigndata,$campaigndata['id']);
                        }
                    }
                    if(is_null($campaigndata['editstatus'])){
                        $note=array(
                            'user_id'       => $_SESSION['userid'],
                            'campaign_id'   => $campaigndata['id'],
                            'type'          => 1,
                            'note'          => $campaigndata['name'].' campaign was edited',
                            'status'        => 1
                        );

                        $this->common->setNotification($note);
                        $this->common->setNotificationLog($campaigndata,$campaigndata['id']);
                    }
                    $sql="UPDATE ".$this->table." SET  status='".$status."', editstatus='".$editstatus."',camppausetype='".$_SESSION['userid']."' WHERE md5(id)='".$_REQUEST['token']."'";
                    $this->db->query($sql);
                }
                redirect('new-campaign.php?step=6&type='.$_POST['type'].'&typeid='.$_POST['typeid'].'&model='.$cam['model'].'&token='.$_REQUEST['token'].'&edit='.$_REQUEST['edit']);
            }
            
            $cam=self::getCampaignByIdEncript($_REQUEST['token']); 
            redirect('new-campaign.php?step=6&type='.$_POST['type'].'&typeid='.$_POST['typeid'].'&model='.$cam['model'].'&token='.$_REQUEST['token']);
            
        }

        if(isset($_POST['step']) && $_POST['step']==6){
            $campaigndetails=$this->getCampaignByIdEncript($_REQUEST['token']);
            if(!empty($_POST['country'])&&!isset($_REQUEST['edit'])){
                $dsql="DELETE FROM ".$this->table." WHERE `campaign_group`='".$campaigndetails['id']."' AND reversion !=1";
                $this->db->query($dsql);
                foreach ($_POST['country'] as $key => $value) {
                    $sql="INSERT INTO ".$this->table." SET 
                    campaign_group='".$campaigndetails['id']."',
                    name='".$campaigndetails['name']."',
                    model='".$campaigndetails['model']."',
                    type='".$campaigndetails['type']."',
                    device='".$campaigndetails['device']."',
                    performodel='".$campaigndetails['performodel']."',
                    os='".$campaigndetails['os']."',
                    versions='".$campaigndetails['versions']."',
                    browser='".$campaigndetails['browser']."',
                    language='".$campaigndetails['language']."',
                    isp='".$campaigndetails['isp']."',
                    connection='".$campaigndetails['connection']."',
                    geo_targeting='".$campaigndetails['geo_targeting']."',
                    advanced_targeting='".$campaigndetails['advanced_targeting']."',
                    coordinates='".$campaigndetails['coordinates']."',
                    image='".$campaigndetails['image']."',
                    url='".$campaigndetails['url']."',
                    js_tag='".mysqli_real_escape_string($this->db->connection(),$campaigndetails['js_tag'])."',
                    startdate='".$campaigndetails['startdate']."',
                    enddate='".$campaigndetails['enddate']."',
                    total_budget='".$campaigndetails['total_budget']."',
                    daily_amount='".$campaigndetails['daily_amount']."',
                    cap='".$campaigndetails['cap']."',
                    country='".$value."',
                    min_bid='".$_POST['min_bid'][$value]."',
                    max_bid='".$_POST['max_bid'][$value]."',
                    status='".$campaigndetails['status']."',
                    creative_name='".$campaigndetails['creative_name']."',
                    banner_size='".$campaigndetails['banner_size']."',
                    macros='".$campaigndetails['macros']."',
                    created_by='".$_SESSION['userid']."'";
                    $result=$this->db->insert($sql);
                }

                if($result){ 
                    redirect('new-campaign.php?step=7&type='.$_POST['type'].'&typeid='.$_POST['typeid'].'&model='.$_REQUEST['model'].'&token='.$_REQUEST['token']);
                }
            }elseif (!empty($_POST['country']) && isset($_REQUEST['edit'])) {
                foreach ($_POST['country'] as $key => $value) {
                    $sql="UPDATE ".$this->table." SET                    
                    name='".$campaigndetails['name']."',
                    model='".$campaigndetails['model']."',
                    type='".$campaigndetails['type']."',
                    device='".$campaigndetails['device']."',
                    performodel='".$campaigndetails['performodel']."',
                    os='".$campaigndetails['os']."',
                    versions='".$campaigndetails['versions']."',
                    browser='".$campaigndetails['browser']."',
                    language='".$campaigndetails['language']."',
                    isp='".$campaigndetails['isp']."',
                    connection='".$campaigndetails['connection']."',
                    geo_targeting='".$campaigndetails['geo_targeting']."',
                    advanced_targeting='".$campaigndetails['advanced_targeting']."',
                    coordinates='".$campaigndetails['coordinates']."',
                    image='".$campaigndetails['image']."',
                    url='".$campaigndetails['url']."',
                    js_tag='".mysqli_real_escape_string($this->db->connection(),$campaigndetails['js_tag'])."',
                    startdate='".$campaigndetails['startdate']."',
                    enddate='".$campaigndetails['enddate']."',
                    total_budget='".$campaigndetails['total_budget']."',
                    daily_amount='".$campaigndetails['daily_amount']."',
                    cap='".$campaigndetails['cap']."',
                    country='".$value."',
                    min_bid='".$_POST['min_bid'][$value]."',
                    max_bid='".$_POST['max_bid'][$value]."',
                    status='".$campaigndetails['status']."',
                    creative_name='".$campaigndetails['creative_name']."',
                    banner_size='".$campaigndetails['banner_size']."',
                    macros='".$campaigndetails['macros']."',
                    created_by='".$_SESSION['userid']."' 
                WHERE campaign_group='".$campaigndetails['id']."'";
                    $result=$this->db->update($sql);
                }
                if($result){
                    if(!empty($_REQUEST['edit'])){

                        $camp=self::getCampaignByIdEncript($_REQUEST['token']);

                        if($camp['status']==2){
                            $editstatus=1;
                            $status=3;
                            if($camp['editstatus']!=1){
                                $sql="SELECT * FROM users WHERE id='".$_SESSION['userid']."' AND deleted_at is NULL";
                                $manage=$this->db->get_row($sql);
                                $mail="SELECT * FROM users WHERE id='".$manage['managerid']."'  AND deleted_at is NULL";
                                $mmail=$this->db->get_row($mail);
                                $admin="SELECT * FROM users WHERE type=10 AND deleted_at is NULL";
                                $amail=$this->db->get_row($admin);
                                $name=$manage['name'];
                                $message='<p>Hi,</p>
                                <p>Name Of Advertiser:'.$name.'</p>
                                <p>Campaign ID:'.$camp['id'].'</p>
                                <p>Campaign Name:'.$camp['name'].'</p>';
                                $cc=$mmail['email'];
                                sendmail($amail['email'],'Campaign Paused By Major Edit',$message,$cc);

                                $note=array(
                                    'user_id'       => $_SESSION['userid'],
                                    'campaign_id'   => $camp['id'],
                                    'type'          => 1,
                                    'note'          => $camp['name'].' campaign was paused for major edited',
                                    'status'        => 1
                                );
                                $this->common->setNotification($note);
                            }
                        }
                        $sql="UPDATE ".$this->table." SET  status='".$status."', editstatus='".$editstatus."',camppausetype='".$_SESSION['userid']."' WHERE md5(id)='".$_REQUEST['token']."'";
                        $this->db->query($sql);
                    }
                }
                redirect('new-campaign.php?step=7&type='.$_POST['type'].'&typeid='.$_POST['typeid'].'&model='.$_REQUEST['model'].'&token='.$_REQUEST['token'].'&edit='.$_REQUEST['edit']);
            }
        }

        if(isset($_POST['step']) && $_POST['step']==7){
            if(!empty($_REQUEST['edit'])){
                $sql="UPDATE ".$this->table." SET startdate='".$_POST['start_date']."', enddate='".$_POST['end_date']."',daily_amount='".$_POST['daily_amount']."',cap='".$_POST['cap']."',schedule_time='".json_encode($_POST['time'])."' WHERE md5(id)='".$_REQUEST['token']."'";
                $result=$this->db->update($sql);

                $sql="UPDATE ".$this->table." SET startdate='".$_POST['start_date']."', enddate='".$_POST['end_date']."',daily_amount='".$_POST['daily_amount']."',cap='".$_POST['cap']."',schedule_time='".json_encode($_POST['time'])."' WHERE md5(campaign_group)='".$_REQUEST['token']."'";

                $result=$this->db->update($sql);

                if($result){
                    $camp=self::getCampaignByIdEncript($_REQUEST['token']);
                    if($camp['status']==2){
                        $editstatus=1;
                        $status=3;
                        if($camp['editstatus']!=1){
                            $sql="SELECT * FROM users WHERE id='".$_SESSION['userid']."' AND deleted_at is NULL";
                            $manage=$this->db->get_row($sql);
                            $mail="SELECT * FROM users WHERE id='".$manage['managerid']."'  AND deleted_at is NULL";
                            $mmail=$this->db->get_row($mail);
                            $admin="SELECT * FROM users WHERE type=10 AND deleted_at is NULL";
                            $amail=$this->db->get_row($admin);
                            $name=$manage['name'];
                            $message='<p>Hi,</p>
                            <p>Name Of Advertiser:'.$name.'</p>
                            <p>Campaign ID:'.$camp['id'].'</p>
                            <p>Campaign Name:'.$camp['name'].'</p>';
                            $cc=$mmail['email'];
                            sendmail($amail['email'],'Campaign Paused By Major Edit',$message,$cc);

                            $note=array(
                                'user_id'       => $_SESSION['userid'],
                                'campaign_id'   => $camp['id'],
                                'type'          => 1,
                                'note'          => $camp['name'].' campaign was paused for major edited',
                                'status'        => 1
                            );
                            $this->common->setNotification($note);
                            $this->common->setNotificationLog($camp,$camp['id']);
                        }else{
                            if(is_null($campaigndata['editstatus'])){
                                $note=array(
                                    'user_id'       => $_SESSION['userid'],
                                    'campaign_id'   => $camp['id'],
                                    'type'          => 1,
                                    'note'          => $camp['name'].' campaign was paused for major edited',
                                    'status'        => 1
                                );
                                $this->common->setNotification($note);
                                $this->common->setNotificationLog($camp,$camp['id']);
                            }
                        }
                        $sql="UPDATE ".$this->table." SET  status='".$status."', editstatus='".$editstatus."',camppausetype='".$_SESSION['userid']."' WHERE md5(id)='".$_REQUEST['token']."'";
                        $this->db->query($sql);
                        $sql="UPDATE ".$this->table." SET  status='".$status."', editstatus='".$editstatus."' WHERE md5(campaign_group)='".$_REQUEST['token']."'";
                        $this->db->query($sql);
                    }
                    $_SESSION['flash']=TRUE;
                    $_SESSION['flash_class']='success';
                    $_SESSION['flash_msg']='Campaign has been successfully updated.';
                    
                }
                redirect('all-campaigns.php');
            }else{
             $sql="UPDATE ".$this->table." SET startdate='".$_POST['start_date']."', enddate='".$_POST['end_date']."', total_budget='".$_POST['total_budget']."',daily_amount='".$_POST['daily_amount']."',cap='".$_POST['cap']."',schedule_time='".json_encode($_POST['time'])."' WHERE md5(id)='".$_REQUEST['token']."'";
                $result=$this->db->query($sql);

                $sql="UPDATE ".$this->table." SET startdate='".$_POST['start_date']."', enddate='".$_POST['end_date']."', total_budget='".$_POST['total_budget']."',daily_amount='".$_POST['daily_amount']."',cap='".$_POST['cap']."',schedule_time='".json_encode($_POST['time'])."' WHERE md5(campaign_group)='".$_REQUEST['token']."'";

                $result=$this->db->query($sql);

                if($result){
                    if(isset($_REQUEST['renew']) && !empty($_REQUEST['renew'])){
                       redirect('campaign-payment.php?token='.$_REQUEST['token'].'&type='.$_POST['type'].'&typeid='.$_POST['typeid'].'&model='.$_REQUEST['model'].'&renew='.$_REQUEST['renew']);  
                    } else{
                        redirect('campaign-payment.php?token='.$_REQUEST['token'].'&type='.$_POST['type'].'&typeid='.$_POST['typeid'].'&model='.$_REQUEST['model']);    
                    }
                                  
                }   
            }
            
        }
    }

    public function deleteCampaignByGroupID($id) {
        $sql="UPDATE ".$this->table." SET deleted_at=now() WHERE id='".$id."' AND parent!=1 AND deleted_at is NULL";
        return $this->db->get_results($sql);
    }

    public function revision($camp)
    {
        $sql="INSERT INTO ".$this->table." SET 
                parent=1,
                io='".$camp['io']."',
                campaign_io='".$camp['campaign_io']."',
                name='".$camp['name']."',
                model='".$camp['model']."',
                performodel='".$camp['performodel']."',
                type='".$camp['type']."',
                device='".$camp['device']."',
                os='".$camp['os']."',
                versions='".$camp['versions']."',
                browser='".$camp['browser']."',
                language='".$camp['language']."',
                isp='".$camp['isp']."',
                connection='".$camp['connection']."',
                banner_type='".$camp['banner_type']."',
                geo_targeting='".$camp['geo_targeting']."',
                advanced_targeting='".$camp['advanced_targeting']."',
                coordinates='".$camp['coordinates']."',
                image='".$camp['image']."',
                url='".$camp['url']."',
                js_tag='".$camp['js_tag']."',
                video='".$camp['video']."',
                push='".$camp['push']."',
                native='".$camp['native']."',
                startdate='".$camp['startdate']."',
                enddate='".$camp['enddate']."',
                total_budget='".$camp['total_budget']."',
                daily_amount='".$camp['daily_amount']."',
                cap='".$camp['cap']."',
                country='".$camp['country']."',
                min_bid='0',
                max_bid='0',
                schedule_time='".$camp['schedule_time']."',
                remark='".$camp['remark']."',
                status='50',
                cos=1,
                editstatus='1',
                created_by='".$camp['created_by']."',
                created_at='".$camp['created_at']."',
                updated_at='".$camp['updated_at']."',
                deleted_at=now(),
                creative_name='".$camp['creative_name']."',
                banner_size='".$camp['banner_size']."',
                reversion=1,
                reversion_campaign='".$camp['id']."',
                macros='".$camp['macros']."'";
        $rid=$this->db->insert($sql);
        
        $camps=self::getAllCampaignsByGroupId($camp['id']);

        if(!empty($camps)){
            foreach ($camps as $key => $campn) {
                $sql="INSERT INTO ".$this->table." SET 
                    parent='".$campn['parent']."',
                    campaign_group='".$rid."',
                    io='".$campn['io']."',
                    campaign_io='".$campn['campaign_io']."',
                    name='".$campn['name']."',
                    model='".$campn['model']."',
                    performodel='".$campn['performodel']."',
                    type='".$campn['type']."',
                    device='".$campn['device']."',
                    os='".$campn['os']."',
                    versions='".$campn['versions']."',
                    browser='".$campn['browser']."',
                    language='".$campn['language']."',
                    isp='".$campn['isp']."',
                    connection='".$campn['connection']."',
                    banner_type='".$campn['banner_type']."',
                    geo_targeting='".$campn['geo_targeting']."',
                    advanced_targeting='".$campn['advanced_targeting']."',
                    coordinates='".$campn['coordinates']."',
                    image='".$campn['image']."',
                    url='".$campn['url']."',
                    js_tag='".$campn['js_tag']."',
                    video='".$campn['video']."',
                    push='".$campn['push']."',
                    native='".$campn['native']."',
                    startdate='".$campn['startdate']."',
                    enddate='".$campn['enddate']."',
                    total_budget='".$campn['total_budget']."',
                    daily_amount='".$campn['daily_amount']."',
                    cap='".$campn['cap']."',
                    country='".$campn['country']."',
                    min_bid='".$campn['min_bid']."',
                    max_bid='".$campn['max_bid']."',
                    schedule_time='".$campn['schedule_time']."',
                    remark='".$campn['remark']."',
                    status='50',
                    editstatus='1',
                    created_by='".$campn['created_by']."',
                    created_at='".$campn['created_at']."',
                    updated_at='".$campn['updated_at']."',
                    deleted_at=now(),
                    creative_name='".$campn['creative_name']."',
                    reversion=1,
                    reversion_campaign='".$rid."',
                    banner_size='".$campn['banner_size']."',
                    macros='".$campn['macros']."'";

                $this->db->insert($sql);
            }
        }
    }

    public function reversionCampaign($id,$rid=NULL)
    {
        $sql="SELECT * FROM ".$this->table." WHERE md5(reversion_campaign)='".$id."' AND reversion=1 ";
        if($rid){
            $sql .=" AND md5(id)='".$rid."'";
        }
        $sql .=" ORDER by id DESC";
        return $this->db->get_row($sql);
    }

    public function getAllReversionCampaign($id)
    {
        $sql="SELECT * FROM ".$this->table." WHERE md5(reversion_campaign)='".$id."' AND reversion=1 ORDER by id DESC";
        return $this->db->get_results($sql);
    }

    public function getAllReversionCampaignsByGroupId($rid) {
        $sql="SELECT * FROM ".$this->table." WHERE campaign_group='".$rid."' AND reversion_campaign='".$rid."' AND reversion=1 ORDER BY id DESC";
        return $this->db->get_results($sql);
    }
}
$campaign=new Campaign();