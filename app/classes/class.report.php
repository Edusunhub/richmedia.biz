<?php
class Report extends DB
{
    public $db;
    public $table='reports';
    public $campaigns='campaigns';
    public $transactions='transactions';

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
        $this->macros=new Macros();
    }

    public function reports($limit=15,$user_id='') {
        if (isset($_GET["page"])){
            $page=$_GET["page"];
        }else{
            $page=1;
        }
        if (isset($_GET["limit"])){
            $limit=$_GET["limit"];
        }
        $start_from = ($page-1) * $limit;
        $parem='';
        $sql="SELECT r.campaign_id,c.io,r.user_id,sum(r.impression) impression, sum(r.clicks) clicks, sum(r.conversions) conversions, sum(r.ctr) ctr, sum(r.unit_price) unit_price, sum(r.spent) spent FROM ".$this->table." r JOIN ".$this->campaigns." c ON c.id=r.campaign_id WHERE r.deleted_at is NULL ";
        if(!empty($user_id)){
            $sql .=" AND r.created_at='".$user_id."' ";
        }
        if(isset($_GET['campaign']) && !empty($_GET['campaign'])){
            $sql .=" AND (c.id = '".$_GET['campaign']."' OR c.name LIKE '%".$_GET['campaign']."%')";
            $parem .='&campaign='.$_GET['campaign'];
        }
        
        $sql .=" GROUP BY r.campaign_id ";
        $total_records=$this->db->counts($sql);
        $sql .=" ORDER BY r.id DESC LIMIT ".$start_from.", ".$limit."";
        $pages = ceil($total_records / $limit);
        $pagination=$this->common->getPagination('all-reports.php',$pages,$limit,$cpage=$page,$parem);
        $data=$this->db->get_results($sql);
        return array('datas'=>$data,'pagination'=>$pagination,'total'=>$total_records);

        return $this->db->get_results($sql);
    }

    public function getReportHistoryByGroupID($limit=15,$user_id='') {
        if (isset($_GET["page"])){
            $page=$_GET["page"];
        }else{
            $page=1;
        }
        $start_from = ($page-1) * $limit;
        $parem='&id='.$_REQUEST['id'].'&token='.$_REQUEST['token'];
        $sql="SELECT r.*,c.name as campaign_name,c.io FROM ".$this->table." r JOIN ".$this->campaigns." c ON c.id=r.campaign_id WHERE r.deleted_at is NULL AND md5(r.campaign_id)='".$_REQUEST['id']."' ";
        if(!empty($user_id)){
            $sql .=" AND r.user_id='".$user_id."' ";
        }
        if(isset($_GET['from']) && !empty($_GET['from'])){
            $sql .=" AND DATE(c.created_at) >= '".date('Y-m-d',strtotime($_GET['from']))."'";
            $parem .='&from='.$_GET['from'];
        }
        if(isset($_GET['to']) && !empty($_GET['to'])){
            $sql .=" AND DATE(c.created_at) <= '".date('Y-m-d',strtotime($_GET['to']))."'";
            $parem .='&to='.$_GET['to'];
        }
        if(isset($_GET['country']) && !empty($_GET['country'])){
            $sql .=" AND r.country LIKE '%".$_GET['country']."%'";
            $parem .='&country='.$_GET['country'];
        }
        if(isset($_GET['type']) && !empty($_GET['type'])){
            $sql .=" AND r.type LIKE '%".$_GET['type']."%'";
            $parem .='&type='.$_GET['type'];
        }
        if(isset($_GET['model']) && !empty($_GET['model'])){
            $sql .=" AND r.model LIKE '%".$_GET['model']."%'";
            $parem .='&model='.$_GET['model'];
        }
        $total_records=$this->db->counts($sql);
        $sql .=" ORDER BY r.id DESC LIMIT ".$start_from.", ".$limit."";
        $pages = ceil($total_records / $limit);
        $pagination=$this->common->getPagination('report-history.php',$pages,$limit,$cpage=$page,$parem);
        $data=$this->db->get_results($sql);
        return array('datas'=>$data,'pagination'=>$pagination,'total'=>$total_records);

        return $this->db->get_results($sql);
    }

    public function getReportHistoryByID($id,$limit=15,$user_id='') {
        if (isset($_GET["page"])){
            $page=$_GET["page"];
        }else{
            $page=1;
        }
        if (isset($_GET["limit"])||isset($_POST["limit"])){
            if($_GET["limit"]){
             $limit=$_GET["limit"];   
            }
            if($_POST["limit"]){
             $limit=$_POST["limit"];   
            }
        }
        $start_from = ($page-1) * $limit;
        $parem='&id='.$_REQUEST['id'].'&token='.$_REQUEST['token'];
        $sql="SELECT r.*,c.name as campaign_name, c.io FROM ".$this->table." r JOIN ".$this->campaigns." c ON c.id=r.campaign_id WHERE r.deleted_at is NULL AND md5(r.campaign_id)='".$id."' ";
        if(!empty($user_id)){
            $sql .=" AND r.user_id='".$user_id."' ";
        }
        if(isset($_GET['from']) && !empty($_GET['from'])){
            $sql .=" AND DATE(r.created_at) >= '".date('Y-m-d',strtotime($_GET['from']))."'";
            $parem .='&from='.$_GET['from'];
        }
        if(isset($_GET['to']) && !empty($_GET['to'])){
            $sql .=" AND DATE(r.created_at) <= '".date('Y-m-d',strtotime($_GET['to']))."'";
            $parem .='&to='.$_GET['to'];
        }
        if(isset($_GET['country']) && !empty($_GET['country'])){
            $sql .=" AND r.country LIKE '%".$_GET['country']."%'";
            $parem .='&country='.$_GET['country'];
        }
        if(isset($_GET['type']) && !empty($_GET['type'])){
            $sql .=" AND r.type LIKE '%".$_GET['type']."%'";
            $parem .='&type='.$_GET['type'];
        }
        if(isset($_GET['model']) && !empty($_GET['model'])){
            $sql .=" AND r.model LIKE '%".$_GET['model']."%'";
            $parem .='&model='.$_GET['model'];
        }
        $total_records=$this->db->counts($sql);
        $sql .=" ORDER BY r.created_at DESC LIMIT ".$start_from.", ".$limit."";
        $pages = ceil($total_records / $limit);
        $pagination=$this->common->getPagination('report-history.php',$pages,$limit,$cpage=$page,$parem);
        $data=$this->db->get_results($sql);
        return array('datas'=>$data,'pagination'=>$pagination,'total'=>$total_records);

        return $this->db->get_results($sql);
    }

    public function reportsByUser($limit=15) {
        if (isset($_GET["page"])){
            $page=$_GET["page"];
        }else{
            $page=1;
        }
        $start_from = ($page-1) * $limit;
        $parem='';

        $sql="SELECT r.campaign_id,r.user_id,c.io,r.type,r.model,sum(r.impression) impression, sum(r.clicks) clicks, sum(r.conversions) conversions, sum(r.ctr) ctr, sum(r.unit_price) unit_price, sum(r.spent) spent,c.name as campaign_name,c.created_at as campaign_date FROM ".$this->table." r JOIN ".$this->campaigns." c ON c.id=r.campaign_id WHERE r.deleted_at is NULL AND r.user_id='".$_SESSION['userid']."' ";
        if(isset($_GET['from']) && !empty($_GET['from'])){
            $sql .=" AND DATE(c.created_at) >= '".date('Y-m-d',strtotime($_GET['from']))."'";
            $parem .='&from='.$_GET['from'];
        }
        if(isset($_GET['to']) && !empty($_GET['to'])){
            $sql .=" AND DATE(c.created_at) <= '".date('Y-m-d',strtotime($_GET['to']))."'";
            $parem .='&to='.$_GET['to'];
        }
        if(isset($_GET['country']) && !empty($_GET['country'])){
            $sql .=" AND r.country LIKE '%".$_GET['country']."%'";
            $parem .='&country='.$_GET['country'];
        }
        if(isset($_GET['type']) && !empty($_GET['type'])){
            $sql .=" AND r.type LIKE '%".$_GET['type']."%'";
            $parem .='&type='.$_GET['type'];
        }
        if(isset($_GET['model']) && !empty($_GET['model'])){
            $sql .=" AND r.model LIKE '%".$_GET['model']."%'";
            $parem .='&model='.$_GET['model'];
        }
        if(isset($_GET['key']) && !empty($_GET['key'])){
            $sql .=" AND (c.name LIKE '%".$_GET['key']."%' OR r.type LIKE '%".$_GET['key']."%')";
            $parem .='&key='.$_GET['key'];
        }
        $sql .=" GROUP BY r.campaign_id ";
        $total_records=$this->db->counts($sql);
        $sql .=" ORDER BY c.id DESC LIMIT ".$start_from.", ".$limit."";
        $pages = ceil($total_records / $limit);
        $pagination=$this->common->getPagination('reports.php',$pages,$limit,$cpage=$page,$parem);
        $data=$this->db->get_results($sql);
        return array('datas'=>$data,'pagination'=>$pagination,'total'=>$total_records);
    }

    public function userReports($limit=15) {
        if (isset($_GET["page"])){
            $page=$_GET["page"];
        }else{
            $page=1;
        }
        $start_from = ($page-1) * $limit;
        $parem='';
        $sql="SELECT r.campaign_group,r.user_id,c.io,r.type,m.name model,sum(r.impression) impression, sum(r.clicks) clicks, sum(r.conversions) conversions, sum(r.ctr) ctr, sum(r.unit_price) unit_price, sum(r.spent) spent,c.name as campaign_name,c.created_at as campaign_date FROM ".$this->table." r JOIN ".$this->campaigns." c ON c.id=r.campaign_id JOIN models m ON m.id=r.model WHERE r.deleted_at is NULL AND r.user_id='".$_SESSION['userid']."' ";
        if(isset($_GET['from']) && !empty($_GET['from'])){
            $sql .=" AND DATE(c.created_at) >= '".date('Y-m-d',strtotime($_GET['from']))."'";
            $parem .='&from='.$_GET['from'];
        }
        if(isset($_GET['to']) && !empty($_GET['to'])){
            $sql .=" AND DATE(c.created_at) <= '".date('Y-m-d',strtotime($_GET['to']))."'";
            $parem .='&to='.$_GET['to'];
        }
        if(isset($_GET['key']) && !empty($_GET['key'])){
            $sql .=" AND (c.name LIKE '%".$_GET['key']."%' OR r.type LIKE '%".$_GET['key']."%')";
            $parem .='&key='.$_GET['key'];
        }
        $sql .=" GROUP BY r.campaign_group ";
        $total_records=$this->db->counts($sql);
        $sql .=" ORDER BY c.id DESC LIMIT ".$start_from.", ".$limit."";
        $pages = ceil($total_records / $limit);
        $pagination=$this->common->getPagination('reports.php',$pages,$limit,$cpage=$page,$parem);
        $data=$this->db->get_results($sql);
        return array('datas'=>$data,'pagination'=>$pagination,'total'=>$total_records);
    }

    public function report($id) {
        $sql="SELECT * FROM ".$this->table." WHERE md5(id)='".$id."' AND deleted_at is NULL ORDER BY id DESC ";
        return $this->db->get_row($sql);
    }

    public function getSpentAmount($id) {
        $sql="SELECT user_id,SUM(spent) as amt FROM ".$this->table." WHERE campaign_id='".$id."' AND deleted_at is NULL";
        $spent=$this->db->get_row($sql);

        return $spent;

    }

    public function UpdateImportReport() {        
        if((isset($_POST['id']))&&(!empty($_POST['id']))){
            $sql="SELECT * FROM ".$this->table." WHERE id='".$_POST['id']."' AND deleted_at is NULL ORDER BY id DESC ";
            $spent=$this->db->get_row($sql); 
            $sql="SELECT * FROM users WHERE id='".$_POST['user_id']."' ";
            $userwallet=$this->db->get_row($sql);
            $oldspent=$spent['spent'];
            $totalspentdiff=0;
            $totalspent=$oldspent;
            if($oldspent>$_POST['spent']){
                $totalspentdiff=$oldspent-$_POST['spent'];
                $totalspent=$_POST['spent'];
                
                $sql="UPDATE users SET wallet=wallet+'".$totalspentdiff."' WHERE id='".$_POST['user_id']."' ";
                $result=$this->db->update($sql);

                $wsql="UPDATE wallet SET amount=amount+'".$totalspentdiff."' WHERE campaign_id='".$_POST['campaign_id']."' AND user_id='".$_POST['user_id']."' ";
                $this->db->update($wsql);
            }
            if($oldspent<$_POST['spent']){
                $totalspentdiff=$_POST['spent']-$oldspent;
                $totalspent=$_POST['spent'];
                $sql="UPDATE users SET wallet=wallet-'".$totalspentdiff."' WHERE id='".$_POST['user_id']."' ";
                $result=$this->db->update($sql);

                $wsql="UPDATE wallet SET amount=amount-'".$totalspentdiff."' WHERE campaign_id='".$_POST['campaign_id']."' AND user_id='".$_POST['user_id']."' ";
                $this->db->update($wsql);
            }
            $sql="UPDATE ".$this->table." SET  
                    `type`='".$_POST['type']."',
                    `model`='".$_POST['model']."',
                    `created_at`='".$_POST['created_at']."',
                    `operating_system`='".$_POST['operating_system']."',
                    `ssp`='".$_POST['ssp']."',
                    `City`='".$_POST['City']."',
                    `hour`='".$_POST['hour']."',
                    `month`='".$_POST['month']."',
                    `application_id`='".$_POST['application_id']."',
                    `domain`='".$_POST['domain']."',
                    `in_mobile_app`='".$_POST['in_mobile_app']."',
                    `landing_domain`='".$_POST['landing_domain']."',
                    `browser`='".$_POST['browser']."',
                    `country`='".$_POST['country']."',
                    `bid_deal_id`='".$_POST['bid_deal_id']."',
                    `site`='".$_POST['site']."',
                    `site_id`='".$_POST['site_id']."',
                    `DMA_code`='".$_POST['DMA_code']."',
                    `video`='".$_POST['video']."',
                    `page_URL`='".$_POST['page_URL']."',
                    `zip_code`='".$_POST['zip_code']."',
                    `threshold_CPM`='".$_POST['threshold_CPM']."',
                    `server`='".$_POST['server']."',
                    `position_on_screen`='".$_POST['position_on_screen']."',
                    `campaign`='".$_POST['campaign']."',
                    `creative_id`='".$_POST['creative_id']."',
                    `device_type`='".$_POST['device_type']."',
                    `player_size`='".$_POST['player_size']."',
                    `screen_size`='".$_POST['screen_size']."',
                    `advertiser`='".$_POST['advertiser']."',
                    `creative_size`='".$_POST['creative_size']."',
                    `creative_Type`='".$_POST['creative_Type']."',
                    `carrier`='".$_POST['carrier']."',
                    `page_language`='".$_POST['page_language']."',
                    `transaction`='".$_POST['transaction']."',
                    `browser_Version`='".$_POST['browser_Version']."',
                    `conversion_rule`='".$_POST['conversion_rule']."',
                    `revealed_domain`='".$_POST['revealed_domain']."',
                    `keywords`='".$_POST['keywords']."',
                    `region`='".$_POST['region']."',
                    `top_level_domain`='".$_POST['top_level_domain']."',
                    `campaign_currency`='".$_POST['campaign_currency']."',
                    `campaign_group`='".$_POST['campaign_group']."',
                    `campaign_group_id`='".$_POST['campaign_group_id']."',
                    `video_inventory_format`='".$_POST['video_inventory_format']."',
                    `billed_segments_3RDP_ID`='".$_POST['billed_segments_3RDP_ID']."',
                    `VAST_error_type`='".$_POST['VAST_error_type']."',
                    `skippable`='".$_POST['skippable']."',
                    `closed`='".$_POST['closed']."',
                    `skipped`='".$_POST['skipped']."',
                    `API`='".$_POST['API']."',
                    `secure`='".$_POST['secure']."',
                    `watched`='".$_POST['watched']."',
                    `anonymous`='".$_POST['anonymous']."',
                    `is_native`='".$_POST['is_native']."',
                    `full_screen`='".$_POST['full_screen']."',
                    `impression`='".$_POST['impression']."',
                    `clicks`='".$_POST['clicks']."',
                    `CPM`='".$_POST['CPC']."',
                    `CPC`='".$_POST['CPC']."',
                    `ctr`='".$_POST['ctr']."',
                    `spent`='".$_POST['spent']."',
                    `view_rate`='".$_POST['view_rate']."',
                    `PCC`='".$_POST['PCC']."',
                    `PVC`='".$_POST['PVC']."',
                    `25_video_completion`='".$_POST['25_video_completion']."',
                    `50_video_completion`='".$_POST['50_video_completion']."',
                    `75_video_completion`='".$_POST['75_video_completion']."',
                    `100_video_completion`='".$_POST['100_video_completion']."',
                    `VAST_fill_rate`='".$_POST['VAST_fill_rate']."',
                    `opportunities`='".$_POST['opportunities']."',
                    `third_party_revenue`='".$_POST['third_party_revenue']."',
                    `datacosts`='".$_POST['datacosts']."' 
            WHERE id='".$_POST['id']."' ";
            $result=$this->db->update($sql);
                if($result){
                    $_SESSION['flash']=TRUE;
                    $_SESSION['flash_class']='success';
                    $_SESSION['flash_msg']='Campaign report has been update successfully';
                    redirect('report-history.php?id='.md5($_POST['campaign_id']).'&token='.md5($_POST['id']).'');
                }else{
                    $_SESSION['flash']=TRUE;
                    $_SESSION['flash_class']='danger';
                    $_SESSION['flash_msg']='Something went wrong';
                    redirect('report-history.php?id='.md5($_POST['campaign_id']).'&token='.md5($_POST['id']).'');
                }
        }
        
    }

    public function addReport() {
        $sql="INSERT INTO ".$this->table." SET 
        user_id='".$_POST['user_id']."',
        campaign_id='".$_POST['campaign_id']."',
        campaign_group='".$_POST['campaign_parent_id']."',
        type='".$_POST['type']."',
        model='".$_POST['model']."',
        impression='".$_POST['impression']."',
        clicks='".$_POST['clicks']."',
        conversions='".$_POST['conversions']."',
        ctr='".$_POST['ctr']."',
        unit_price='".$_POST['unit_price']."',
        spent='".$_POST['spent']."'";

        $result=$this->db->insert($sql);
        if(!empty($result)){
            
            $q="INSERT INTO ".$this->transactions." SET user_id='".$_POST['user_id']."',campaign_id='".$_POST['campaign_id']."',model='".$_POST['model']."',type='".$_POST['type']."',payment_date=now(),method='report',description='Campaign Spent report',expenses='".$_POST['spent']."',credits='0',available='available-".$_POST['spent']."'";

            $sql="UPDATE users SET wallet=wallet-".$_POST['spent']." WHERE id='".$_POST['user_id']."'";
            $userresult = $this->db->query($sql);

            $wsql="UPDATE wallet SET amount=amount-'".$_POST['spent']."' WHERE campaign_id='".$_POST['campaign_id']."' AND user_id='".$_POST['user_id']."' ";

            $this->db->update($wsql);

            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='success';
            $_SESSION['flash_msg']='Campaign report has been successfully added';
            redirect('all-reports.php');
        }else{
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='danger';
            $_SESSION['flash_msg']='Something went wrong';
        }
    }

    public function updateReport($id) {
        $sql="UPDATE ".$this->reports." SET 
        campaign_id='".$_POST['campaign_id']."',
        campaign_group='".$_POST['campaign_group']."',
        type='".$_POST['type']."',
        impression='".$_POST['impression']."',
        clicks='".$_POST['clicks']."',
        conversions='".$_POST['conversions']."',
        ctr='".$_POST['ctr']."',
        unit_price='".$_POST['unit_price']."',
        spent='".$_POST['spent']."'
        WHERE md5(id)='".$id."'";

        $result=$this->db->query($sql);
        if(!empty($result)){
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='success';
            $_SESSION['flash_msg']='Campaign report has been successfully updated';
            redirect('reports.php');
        }else{
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='danger';
            $_SESSION['flash_msg']='Something went wrong';
        }
    }

    public function deleteReport($id) {
        if(empty($id)){
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='danger';
            $_SESSION['flash_msg']='Something went wrong';
            redirect('all-reports.php');
        }
        $sql="SELECT user_id,SUM(spent) as amt FROM ".$this->table." WHERE md5(campaign_id)='".$id."' AND deleted_at is NULL";
        $spent=$this->db->get_row($sql);
        $sql="UPDATE ".$this->table." SET deleted_at=now() WHERE md5(campaign_id)='".$id."'";
        $result=$this->db->query($sql);
        if($result){
            $sql="UPDATE users SET wallet=wallet+".$spent['amt']." WHERE id='".$spent['user_id']."'";
            $user = $this->db->query($sql);
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='success';
            $_SESSION['flash_msg']='Campaign report has been successfully deleted';
        }else{
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='danger';
            $_SESSION['flash_msg']='Something went wrong';
        }
        redirect('all-reports.php');
    }

    public function DleteReportHistoryByID(){
        $idno=count($_POST['checked_id']);
        $deleted=$_POST['checked_id'];
        $userid=$_POST['user_id'];
        $spented =$_POST['spent'];
        $delete=implode(",", $deleted ); 
        $spent=implode(",", $spented );
        if ( !empty($_POST['checked_id']) ) {
            $amt='';
            for($i=0;$i<$idno;$i++) {
                $amt+=$_POST['spent'][$i];
            } 
        }        
        $sql = "UPDATE ".$this->table." SET deleted_at=now() WHERE id IN (".implode(",", $deleted ) . ")";
        $result=$this->db->query($sql);
        if($result){
            $sql="UPDATE users SET wallet=wallet+".$amt." WHERE id='".$_POST['user_id'][0]."'";
            $user = $this->db->query($sql);
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='success';
            $_SESSION['flash_msg']='Campaign report has been successfully deleted';
        }else{
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='danger';
            $_SESSION['flash_msg']='Something went wrong';
        }
        redirect('all-reports.php');
    }

    public function import() {
        if(!empty($_FILES['file']['tmp_name'])){
            $file = $_FILES['file']['tmp_name'];
            $handle = fopen($file, "r");
            $fp = file($file,FILE_SKIP_EMPTY_LINES);
            $rowcount=count($fp);

            if ($file == NULL) {
                return '<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                File size is too large
                </div>';
            }
            $row=0;
            $sqlinsert="INSERT INTO ".$this->table." 
                (
                    `user_id`,
                    `type`,
                    `model`,
                    `created_at`,
                    `operating_system`,
                    `ssp`,
                    `City`,
                    `hour`,
                    `month`,
                    `application_id`,
                    `domain`,
                    `in_mobile_app`,
                    `landing_domain`,
                    `browser`,
                    `country`,
                    `bid_deal_id`,
                    `site`,
                    `site_id`,
                    `DMA_code`,
                    `video`,
                    `page_URL`,
                    `zip_code`,
                    `threshold_CPM`,
                    `server`,
                    `position_on_screen`,
                    `campaign`,
                    `campaign_id`,
                    `creative_id`,
                    `device_type`,
                    `player_size`,
                    `screen_size`,
                    `advertiser`,
                    `advertiser_id`,
                    `creative_size`,
                    `creative_Type`,
                    `carrier`,
                    `page_language`,
                    `transaction`,
                    `browser_Version`,
                    `conversion_rule`,
                    `revealed_domain`,
                    `keywords`,
                    `region`,
                    `top_level_domain`,
                    `campaign_currency`,
                    `campaign_group`,
                    `campaign_group_id`,
                    `video_inventory_format`,
                    `billed_segments_3RDP_ID`,
                    `VAST_error_type`,
                    `skippable`,
                    `closed`,
                    `skipped`,
                    `API`,
                    `secure`,
                    `watched`,
                    `anonymous`,
                    `is_native`,
                    `full_screen`,
                    `impression`,
                    `clicks`,
                    `CPM`,
                    `CPC`,
                    `ctr`,
                    `spent`,
                    `view_rate`,
                    `PCC`,
                    `PVC`,
                    `25_video_completion`,
                    `50_video_completion`,
                    `75_video_completion`,
                    `100_video_completion`,
                    `VAST_fill_rate`,
                    `opportunities`,
                    `third_party_revenue`,
                    `datacosts`,
                    `status`
                ) VALUES ";

            $i=30;
            if($rowcount <= $i){
              $i=$rowcount;
            }
            $page=1;
            while(($filesop = fgetcsv($handle, 1020, ",")) !== false){
                $row++;
                if($row <= 1){
                    //echo $filesop[25];
                    //die();
                }else{

                    $sql .=" (
                        '".$filesop[31]."',
                        '".$filesop[7]."',
                        '".$filesop[25]."',
                        '".date('Y-m-d',strtotime($filesop[0]))."',
                        '".$filesop[1]."',
                        '".$filesop[2]."',
                        '".$filesop[3]."',
                        '".$filesop[4]."',
                        '".$filesop[5]."',
                        '".$filesop[6]."',
                        '".$filesop[8]."',
                        '".$filesop[9]."',
                        '".$filesop[10]."',
                        '".$filesop[11]."',
                        '".$filesop[12]."',
                        '".$filesop[13]."',
                        '".$filesop[14]."',
                        '".$filesop[15]."',
                        '".$filesop[16]."',
                        '".$filesop[17]."',
                        '".$filesop[18]."',
                        '".$filesop[19]."',
                        '".$filesop[20]."',
                        '".$filesop[21]."',
                        '".$filesop[22]."',
                        '".$filesop[23]."',
                        '".$filesop[24]."',
                        '".$filesop[26]."',
                        '".$filesop[27]."',
                        '".$filesop[28]."',
                        '".$filesop[29]."',
                        '".$filesop[30]."',
                        '".$filesop[31]."',
                        '".$filesop[32]."',
                        '".$filesop[33]."',
                        '".$filesop[34]."',
                        '".$filesop[35]."',
                        '".$filesop[36]."',
                        '".$filesop[37]."',
                        '".$filesop[38]."',
                        '".$filesop[39]."',
                        '".$filesop[40]."',
                        '".$filesop[41]."',
                        '".$filesop[42]."',
                        '".$filesop[43]."',
                        '".$filesop[44]."',
                        '".$filesop[45]."',
                        '".$filesop[46]."',
                        '".$filesop[47]."',
                        '".$filesop[48]."',
                        '".$filesop[49]."',
                        '".$filesop[50]."',
                        '".$filesop[51]."',
                        '".$filesop[52]."',
                        '".$filesop[53]."',
                        '".$filesop[54]."',
                        '".$filesop[55]."',
                        '".$filesop[56]."',
                        '".$filesop[57]."',
                        '".$filesop[58]."',
                        '".$filesop[59]."',
                        '".$filesop[60]."',
                        '".$filesop[61]."',
                        '".$filesop[62]."',
                        '".$filesop[63]."',
                        '".$filesop[64]."',
                        '".$filesop[65]."',
                        '".$filesop[66]."',
                        '".$filesop[68]."',
                        '".$filesop[69]."',
                        '".$filesop[70]."',
                        '".$filesop[71]."',
                        '".$filesop[72]."',
                        '".$filesop[73]."',
                        '".$filesop[74]."',
                        '".$filesop[67]."',
                        '2'
                    )";

                    $campaign_id=$filesop[24];

                    if($rowcount>$row AND $i!=$row){
                        $sql .=",";
                    }
                    if($i==$row){
                        $page++;
                        $i=$i*$page;
                        if($i > $rowcount){
                            $i=$rowcount;
                        }
                        $sql=$sqlinsert.$sql;
                        $result=$this->db->insert($sql);
                        $sql='';
                    }
                }
            }

            //echo $sql;
            //die();
            //$result=$this->db->insert($sql);
            if($result){
                $sql="SELECT SUM(spent) as totalspent,user_id FROM ".$this->table." WHERE status=2 GROUP BY user_id";
                $spent=$this->db->get_results($sql);
                if(!empty($spent)){
                    foreach ($spent as $key => $value) {
                        $sql="UPDATE users SET wallet=wallet-".$value['totalspent']." WHERE id='".$value['user_id']."'";
                        $this->db->query($sql);

                        $wsql="UPDATE wallet SET amount=amount-'".$value['totalspent']."' WHERE campaign_id='".$campaign_id."' AND user_id='".$value['user_id']."' ";

                        $this->db->update($wsql);

                        $rsql="UPDATE ".$this->table." SET status='0' WHERE status='2'";
                        $this->db->query($rsql);
                    }
                }

                return '<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                Report has been successfully Imported
                </div>';
                //redirect('import-report.php');
            }else{
                return '<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                Something went wrong
                </div>';
                //redirect('import-report.php');
            }
        }else{
            return '<div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    Please select a file to import
                    </div>';
        }
    }

    public function export()
    {
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=report.csv');
        $output = fopen("php://output", "w");
        $column=array('date', 'user_id', 'campaign_id', 'type', 'model', 'impression', 'clicks', 'conversions', 'CPM','CPC','CTR','spent');
        $grouping='';
        if(!empty($_POST['grouping'])){
            $column=array_merge($column,$_POST['grouping']);
            $grouping=',r.'.implode(',r.', $_POST['grouping']);
        }
        fputcsv($output, $column);

        $sql="SELECT date(r.created_at), r.user_id,r.campaign_id,r.type,r.model,r.impression,r.clicks,r.conversions,r.CPM,r.CPC,r.ctr,r.spent ".$grouping." FROM ".$this->table." r JOIN ".$this->campaigns." c ON c.id=r.campaign_id WHERE r.deleted_at is NULL AND r.user_id='".$_SESSION['userid']."' ";

        if(isset($_POST['from']) && !empty($_POST['from'])){
            $sql .=" AND DATE(r.created_at) >= '".date('y-m-d',strtotime($_POST['from']))."'";
        }
        if(isset($_POST['to']) && !empty($_POST['to'])){
            $sql .=" AND DATE(r.created_at) <= '".date('y-m-d',strtotime($_POST['to']))."'";
        }
        if(isset($_POST['country']) && !empty($_POST['country'])){
            $sql .=" AND r.country LIKE '%".$_POST['country']."%'";
        }
        if(isset($_POST['type']) && !empty($_POST['type'])){
            $sql .=" AND r.type LIKE '%".$_POST['type']."%'";
        }
        if(isset($_POST['model']) && !empty($_POST['model'])){
            $sql .=" AND r.model LIKE '%".$_POST['model']."%'";
        }

        $result = $this->db->get_results($sql);
        
        foreach ($result as $key => $value) {
            fputcsv($output, $value);
        }
        fclose($output);
        exit();
    }
}

$reportModule=new Report();