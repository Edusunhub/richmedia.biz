<?php
class Payments extends DB
{
    public $db;
    public $table='payments';
    public $wallet='wallet';
    public $transactions='transactions';

    function __construct()
    {
        $this->db=new DB();
        $this->common=new Common();
        $this->users=new Users();
        $this->campaign=new Campaign();
    }

    public function getPaymentTransactions($user_id='',$limit=15,$pagenave=true)
    {
        if (isset($_GET["page"])){
            $page=$_GET["page"];
        }else{
            $page=1;
        }
        $start_from = ($page-1) * $limit;
        $parem='';
        $sql="SELECT p.*,c.name,c.model as cmodel,u.name as uname,u.email,c.type as ctype,c.total_budget,c.status as cstatus FROM ".$this->table." p JOIN campaigns c ON c.id=p.campaign_id JOIN users u ON u.id=p.user_id WHERE p.deleted_at is NULL AND c.parent=1 ";
        if(!empty($user_id)){
            $sql .=" AND p.user_id='".$user_id."'";
        }
        if(isset($_GET['s']) && $_GET['s']!=''){
            $sql .=" AND (p.type LIKE '%".$_GET['s']."%' OR p.id LIKE '%".$_GET['s']."%') ";
            $parem .='&s='.$_GET['s'];
        }
        if(isset($_GET['from']) && $_GET['from']!=''){
            $sql .=" AND date(p.created_at) >= '".$_GET['from']."' ";
            $parem .='&from='.$_GET['from'];
        }
        if(isset($_GET['to']) && $_GET['to']!=''){
            $sql .=" AND date(p.created_at) <= '".$_GET['to']."' ";
            $parem .='&to='.$_GET['to'];
        }
        if(isset($_GET['key']) && $_GET['key']!=''){
            $sql .=" AND c.name LIKE '%".$_GET['key']."%' ";
            $parem .='&key='.$_GET['key'];
        }
        if(isset($_GET['user']) && $_GET['user']!=''){
            $sql .=" AND u.id='".$_GET['user']."' ";
            $parem .='&user='.$_GET['user'];
        }
        
        if(isset($_GET['status']) && $_GET['status']!=''){
            $sql .=" AND p.status='".$_GET['status']."'";
            $parem .='&status='.$_GET['status'];
        }
        
        $sql .=" ORDER BY p.id DESC LIMIT ".$start_from.", ".$limit."";
        if($pagenave){
            $total_records=$this->db->counts($sql);
            $pages = ceil($total_records / $limit);
            $pagination=$this->common->getPagination('campaign-payments.php',$pages,$limit,$cpage=$page,$parem);
            $data=$this->db->get_results($sql);
            return array('data'=>$data,'pagination'=>$pagination);
        }else{
            return array('data'=>$data);
        }
    }

    public function getAllPaymentTransactions($user_id='',$limit=15,$pagenave=true,$url='campaign-payments.php')
    {
        if (isset($_GET["page"])){
            $page=$_GET["page"];
        }else{
            $page=1;
        }
        $start_from = ($page-1) * $limit;
        $parem='';
        $sql="SELECT p.*,u.id as uid, u.name as uname, u.email FROM ".$this->table." p JOIN users u ON u.id=p.user_id WHERE p.deleted_at is NULL ";
        if(!empty($user_id)){
            $sql .=" AND p.user_id='".$user_id."'";
        }
        if(isset($_GET['s']) && $_GET['s']!=''){
            $sql .=" AND (p.type LIKE '%".$_GET['s']."%' OR p.id LIKE '%".$_GET['s']."%') ";
            $parem .='&s='.$_GET['s'];
        }
        if(isset($_GET['from']) && $_GET['from']!=''){
            $sql .=" AND date(p.created_at) >= '".$_GET['from']."' ";
            $parem .='&from='.$_GET['from'];
        }
        if(isset($_GET['to']) && $_GET['to']!=''){
            $sql .=" AND date(p.created_at) <= '".$_GET['to']."' ";
            $parem .='&to='.$_GET['to'];
        }

        if(isset($_GET['user']) && $_GET['user']!=''){
            $sql .=" AND u.id='".$_GET['user']."' ";
            $parem .='&user='.$_GET['user'];
        }
        
        if(isset($_GET['status']) && $_GET['status']!=''){
            $sql .=" AND p.status='".$_GET['status']."'";
            $parem .='&status='.$_GET['status'];
        }
        
        $total_records=$this->db->counts($sql);
        $sql .=" ORDER BY p.id DESC LIMIT ".$start_from.", ".$limit."";

        if($pagenave){
            $pages = ceil($total_records / $limit);
            $pagination=$this->common->getPagination($url,$pages,$limit,$cpage=$page,$parem);
            $data=$this->db->get_results($sql);
            return array('data'=>$data,'pagination'=>$pagination);
        }else{
            return array('data'=>$data);
        }
    }

    public function getPaymentwalletTransactions($user_id='',$limit=15,$pagenave=true)
    {
        if (isset($_GET["page"])){
            $page=$_GET["page"];
        }else{
            $page=1;
        }
        $start_from = ($page-1) * $limit;
        $parem='';
        $sql="SELECT p.* FROM ".$this->table." p JOIN users u ON u.id=p.user_id WHERE p.deleted_at is NULL AND p.type='wallet' ";
        if(!empty($user_id)){
            $sql .=" AND p.user_id='".$user_id."'";
        }
        if(isset($_GET['s']) && $_GET['s']!=''){
            $sql .=" AND (p.type LIKE '%".$_GET['s']."%' OR p.id LIKE '%".$_GET['s']."%') ";
            $parem .='&s='.$_GET['s'];
        }
        if(isset($_GET['from']) && $_GET['from']!=''){
            $sql .=" AND date(p.created_at) >= '".$_GET['from']."' ";
            $parem .='&from='.$_GET['from'];
        }
        if(isset($_GET['to']) && $_GET['to']!=''){
            $sql .=" AND date(p.created_at) <= '".$_GET['to']."' ";
            $parem .='&to='.$_GET['to'];
        }
        if(isset($_GET['key']) && $_GET['key']!=''){
            $sql .=" AND c.name LIKE '%".$_GET['key']."%' ";
            $parem .='&key='.$_GET['key'];
        }
        if(isset($_GET['user']) && $_GET['user']!=''){
            $sql .=" AND u.id='".$_GET['user']."' ";
            $parem .='&user='.$_GET['user'];
        }
        
        if(isset($_GET['status']) && $_GET['status']!=''){
            $sql .=" AND p.status='".$_GET['status']."'";
            $parem .='&status='.$_GET['status'];
        }
        
        $sql .=" ORDER BY p.id DESC LIMIT ".$start_from.", ".$limit."";
        if($pagenave){
            $total_records=$this->db->counts($sql);
            $pages = ceil($total_records / $limit);
            $pagination=$this->common->getPagination('campaign-payments.php',$pages,$limit,$cpage=$page,$parem);
            $data=$this->db->get_results($sql);
            return array('data'=>$data,'pagination'=>$pagination);
        }else{
            return array('data'=>$data);
        }
    }

    public function getUsersWalletPayment($user_id='',$limit=15,$pagenave=true,$status='')
    {
        if (isset($_GET["page"])){
            $page=$_GET["page"];
        }else{
            $page=1;
        }
        $start_from = ($page-1) * $limit;
        $parem='';
        $sql="SELECT p.*,u.name as uname,u.email,u.id as uid FROM ".$this->table." p JOIN users u ON u.id=p.user_id WHERE p.deleted_at is NULL AND p.type='wallet' AND campaign_id is NULL ";
        if(!empty($user_id)){
            $sql .=" AND p.user_id='".$user_id."'";
        }
        if($status!=''){
            $sql .=" AND p.status='".$status."'";
        }
        if(isset($_GET['s']) && $_GET['s']!=''){
            $sql .=" AND (p.type LIKE '%".$_GET['s']."%' OR p.id LIKE '%".$_GET['s']."%') ";
            $parem .='&s='.$_GET['s'];
        }
        if(isset($_GET['from']) && $_GET['from']!=''){
            $sql .=" AND date(p.created_at) >= '".$_GET['from']."' ";
            $parem .='&from='.$_GET['from'];
        }
        if(isset($_GET['to']) && $_GET['to']!=''){
            $sql .=" AND date(p.created_at) <= '".$_GET['to']."' ";
            $parem .='&to='.$_GET['to'];
        }
        if(isset($_GET['key']) && $_GET['key']!=''){
            $sql .=" AND (p.transactionid LIKE '%".$_GET['key']."%' OR p.id='".$_GET['key']."')";
            $parem .='&key='.$_GET['key'];
        }
        if(isset($_GET['method']) && $_GET['method']!=''){
            $sql .=" AND (p.method='".$_GET['method']."')";
            $parem .='&method='.$_GET['method'];
        }
        if(isset($_GET['user']) && $_GET['user']!=''){
            $sql .=" AND u.id='".$_GET['user']."' ";
            $parem .='&user='.$_GET['user'];
        }

        if(isset($_GET['advertiser']) && $_GET['advertiser']!=''){
            $sql .=" AND (u.id='".$_GET['advertiser']."' OR u.name LIKE '%".$_GET['advertiser']."%')";
            $parem .='&advertiser='.$_GET['advertiser'];
        }
        
        if(isset($_GET['status']) && $_GET['status']!=''){
            $sql .=" AND p.status='".$_GET['status']."'";
            $parem .='&status='.$_GET['status'];
        }
        
        $total_records=$this->db->counts($sql);
        $sql .=" ORDER BY p.id DESC LIMIT ".$start_from.", ".$limit."";
        if($pagenave){
            $pages = ceil($total_records / $limit);
            $pagination=$this->common->getPagination('wallet.php',$pages,$limit,$cpage=$page,$parem);
            $data=$this->db->get_results($sql);
            return array('data'=>$data,'pagination'=>$pagination);
        }else{
            return array('data'=>$data);
        }
    }

    public function getCampaignPayments($limit=15,$pagenave=true)
    {   
        if($_GET['limit']||$_POST['limit']){
            if($_GET['limit']) {
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
        $sql="SELECT p.*,c.name,c.model as cmodel,u.name as uname,u.email,c.type as ctype,c.total_budget,c.status as cstatus FROM ".$this->table." p LEFT JOIN campaigns c ON c.id=p.campaign_id JOIN users u ON u.id=p.user_id WHERE p.deleted_at is NULL AND c.parent=1 ";
        if(isset($_GET['key']) && $_GET['key']!=''){
            $sql .=" AND c.name LIKE '%".$_GET['key']."%' ";
            $parem .='&key='.$_GET['key'];
        }
        
        if(isset($_GET['status']) && $_GET['status']!=''){
            $sql .=" AND p.status='".$_GET['status']."'";
            $parem .='&status='.$_GET['status'];
        }

        if(isset($_GET['advertiser']) && $_GET['advertiser']!=''){
            $sql .=" AND (u.id='".$_GET['advertiser']."' OR u.name LIKE '%".$_GET['advertiser']."%')";
            $parem .='&advertiser='.$_GET['advertiser'];
        }

        if(isset($_GET['campaign']) && $_GET['campaign']!=''){
            $sql .=" AND (c.id='".$_GET['campaign']."' OR c.name LIKE '%".$_GET['campaign']."%')";
            $parem .='&campaign='.$_GET['campaign'];
        }
        
        $total_records=$this->db->counts($sql);        
        $sql .=" ORDER BY p.id DESC LIMIT ".$start_from.", ".$limit."";

        if($pagenave){
            $pages = ceil($total_records / $limit);
            $pagination=$this->common->getPagination('campaign-payments.php',$pages,$limit,$cpage=$page,$parem);
            $data=$this->db->get_results($sql);
            return array('data'=>$data,'pagination'=>$pagination);
        }else{
            return array('data'=>$data);
        }
    }

    public function checkPayment()
    {
        $pay=$_POST['checkpaymentstatus'];
        $msg='';
        $id=$_REQUEST['id'];
        $payment=$this->getPaymentByIdEncript($id);
        $userdata=$this->users->getUser($payment['user_id']);
        $campaigndetails=$this->campaign->getCampaignByIdEncript(md5($payment['campaign_id']));

        $wallet=$_POST['amount'];
        if(!empty($userdata['wallet'])){
            $wallet+=$userdata['wallet'];
        }
        $msg='Campaign payment was decline';
        if($pay==2 AND $payment['status']!=2 ){
            $paysql="UPDATE campaigns SET status='1', io='RMAIO".$payment['id']."' WHERE (id='".$payment['campaign_id']."' || campaign_group='".$payment['campaign_id']."' ) ";
            
            $payresult = $this->db->query($paysql);

            $q="INSERT INTO ".$this->transactions." SET payment_id='".$payment['id']."',user_id='".$payment['user_id']."',campaign_id='".$payment['campaign_id']."',model='".$campaigndetails['model']."',type='".$campaigndetails['type']."',payment_date='".$payment['created_at']."',method='".$payment['type']."',description='Campaign payment approved campaign ID: ".$payment['campaign_id']."',expenses='0',credits='".$_POST['amount']."',available='".$wallet."',transfer_amount='".$payment['amount']."' ";

            $this->db->insert($q);
            
            $sql="UPDATE users SET wallet='".$wallet."' WHERE id='".$payment['user_id']."'";
            $userresult = $this->db->query($sql);

            $iopay="UPDATE ".$this->table." SET io='RMAIO".$payment['id']."' WHERE id='".$payment['id']."'";
            $iopayresult = $this->db->query($iopay);

            // $walletholdsql="INSERT INTO ".$this->wallet." SET user_id='".$payment['user_id']."', payment_id='".$payment['id']."', amount='".$_POST['amount']."', campaign_id='".$payment['campaign_id']."'";
            // $wallethold = $this->db->query($walletholdsql);

            $msg='Campaign payment was approved';
        }

        if($pay==2 AND $payment['status']==2 ){

            $msg='Campaign payment amount was changed';

            $userwallet=$userdata['wallet']-$payment['net_amount'];
            $sql="UPDATE users SET wallet='".$userwallet."' WHERE id='".$payment['user_id']."'";
            $userresult = $this->db->query($sql);

            $userwallet=$userwallet+$_POST['amount'];
            $sql="UPDATE users SET wallet='".$userwallet."' WHERE id='".$payment['user_id']."'";
            $userresult = $this->db->query($sql);
        }

        $paysql="UPDATE ".$this->table." SET status='".$pay."',net_amount='".$_POST['amount']."' WHERE id='".$payment['id']."'";
        $payresult = $this->db->query($paysql);

        if($payresult){
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='success';
            $_SESSION['flash_msg']=$msg;
            redirect('campaign-payments.php');
        }else{
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='danger';
            $_SESSION['flash_msg']='Please try again later';
        }
    }

    public function UpdatecheckPayment()
    {
        $id=$_REQUEST['id'];
        $payment=$this->getPaymentByIdEncript($id);
        $userdata=$this->users->getUser($payment['user_id']);
        if($payment['status']==2){
          $walletamt=$payment['net_amount'];
          if(!empty($userdata['wallet'])) {
            $wallet=$userdata['wallet']-$walletamt;
            $wallet+=$_POST['amount'];
          } 
          $sql="UPDATE users SET wallet='".$wallet."' WHERE id='".$payment['user_id']."'";
          $userresult = $this->db->query($sql);

          $sql="UPDATE ".$this->transactions." SET payment_date='".$payment['created_at']."',credits='".$_POST['amount']."',available='".$wallet."' WHERE payment_id='".$payment['id']."'";
          $userresult = $this->db->query($sql); 

          $paysql="UPDATE ".$this->table." SET net_amount='".$_POST['amount']."' WHERE id='".$payment['id']."'";
          $payresult = $this->db->query($paysql);
          if($payresult){
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='success';
            $_SESSION['flash_msg']='Campaign payment was Updated sussesfully';
            redirect('payment-transactions.php');
          }else{
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='danger';
            $_SESSION['flash_msg']='Please try again later';
          }
        }else{
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='danger';
            $_SESSION['flash_msg']='Please try again later';
        }

    }

    public function checkWalletPayment()
    {
        $pay=$_POST['checkpaymentstatus'];
        $msg='';
        $id=$_REQUEST['id'];
        $payment=$this->getPaymentByIdEncript($id);
        $userdata=$this->users->getUser($payment['user_id']);

        $wallet=$_POST['amount'];
        if(!empty($userdata['wallet'])){
            $wallet+=$userdata['wallet'];
        }

        $msg='Wallet payment was decline';
        if($pay==2 AND $payment['status']!=2 ){
            $q="INSERT INTO ".$this->transactions." SET payment_id='".$payment['id']."',user_id='".$payment['user_id']."',payment_date='".$payment['created_at']."',method='".$payment['type']."',description='Wallet payment approved',expenses='0',credits='".$_POST['amount']."',available='".$wallet."',transfer_amount='".$payment['amount']."' ";

            $this->db->insert($q);
            
            $sql="UPDATE users SET wallet='".$wallet."' WHERE id='".$payment['user_id']."'";
            $userresult = $this->db->query($sql);

            $msg='Wallet payment was approved';
        }

        if($pay==2 AND $payment['status']==2 ){

            $msg='Wallet amount was changed';

            $userwallet=$userdata['wallet']-$payment['net_amount'];
            $sql="UPDATE users SET wallet='".$userwallet."' WHERE id='".$payment['user_id']."'";
            $userresult = $this->db->query($sql);

            $userwallet=$userwallet+$_POST['amount'];
            $sql="UPDATE users SET wallet='".$userwallet."' WHERE id='".$payment['user_id']."'";
            $userresult = $this->db->query($sql);
        }

        $paysql="UPDATE ".$this->table." SET status='".$pay."',net_amount='".$_POST['amount']."' WHERE id='".$payment['id']."'";
        $payresult = $this->db->query($paysql);

        if($payresult){
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='success';
            $_SESSION['flash_msg']=$msg;
            redirect('wallet.php');
        }else{
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='danger';
            $_SESSION['flash_msg']='Please try again later';
        }
    }

    public function getCampaignPayment($id)
    {
        $sql="SELECT * FROM ".$this->table." WHERE campaign_id='".$id."'  AND deleted_at is NULL";
        return $this->db->get_row($sql);
    }

    public function getPaymentByIdEncript($id)
    {
        $sql="SELECT * FROM ".$this->table." WHERE md5(id)='".$id."' AND deleted_at is NULL";
        return $this->db->get_row($sql);
    }


    public function wirePayment($id) {
        $campaigndetails=$this->campaign->getCampaignByIdEncript($_REQUEST['token']);
        $payment=$this->getCampaignPayment($campaigndetails['id']);
        if (!empty($payment) && $payment['status']==0) {
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='warning';
            $_SESSION['flash_msg']='Sorry, Your transaction already completed.';
            return ;
        }
        $sql="INSERT INTO ".$this->table." SET user_id='".$_SESSION['userid']."', campaign_id='".$campaigndetails['id']."',transactionid='".$_POST['transactionid']."',type='wire',amount='".$campaigndetails['total_budget']."',status=0,remarks='".$_POST['remarks']."'";
        $result=$this->db->insert($sql);
        if($result){
            $q="UPDATE campaigns SET status='0',renewstatus='0' WHERE (id='".$campaigndetails['id']."' OR campaign_group='".$campaigndetails['id']."')";
            $result=$this->db->query($q);
            $camp="SELECT * FROM campaigns WHERE id='".$campaigndetails['id']."' AND deleted_at is NULL";
            $camname=$this->db->get_row($camp);
            $sql="SELECT * FROM users WHERE id='".$_SESSION['userid']."' AND deleted_at is NULL";
            $manage=$this->db->get_row($sql);
            $mail="SELECT * FROM users WHERE id='".$manage['managerid']."'  AND deleted_at is NULL";
            $mmail=$this->db->get_row($mail);
            $admin="SELECT * FROM users WHERE type=10 AND deleted_at is NULL";
            $amail=$this->db->get_row($admin);
            $name=$manage['name'];
            $amt=$campaigndetails['total_budget'];
            $tid=$_POST['transactionid'];
            $camp=$camname['name'];
            $message='<p>Hi,</p>
            <p>Name Of Advertiser:'.$name.'</p>
            <p>Campaign Name:'.$camp.'</p>
            <p>Transaction ID:'.$tid.';</p>
            <p>Name Of Mode:Wire</p>
            <p>Amount:$'.$amt.'</p>';
            $cc=$mmail['email'];
            sendmail($amail['email'],'New Payment Made By Advertiser',$message,$cc);           
            redirect('payment-success.php?token='.$id.'&payment='.$result);
        }else{
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='danger';
            $_SESSION['flash_msg']='Please try again later';
        }
    }

    public function walletPaymentMethod($id) {
        $campaigndetails=$this->campaign->getCampaignByIdEncript($_REQUEST['token']);
        $payment=$this->getCampaignPayment($campaigndetails['id']);
        $userdata=$this->users->getUser($_SESSION['userid']);        
        if (!empty($payment) && $payment['status']==0) {
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='warning';
            $_SESSION['flash_msg']='Sorry, Your transaction already completed.';
            return ;
        }
        //$netamt=$userdata['wallet']-$campaigndetails['total_budget']; 
        $sql="INSERT INTO ".$this->table." SET user_id='".$_SESSION['userid']."', campaign_id='".$campaigndetails['id']."',type='wallet',amount='".$campaigndetails['total_budget']."',net_amount='".$campaigndetails['total_budget']."',status=2";
        $result=$this->db->insert($sql);
        if($result){

            $iopay="UPDATE ".$this->table." SET io='RMAIO".$result."' WHERE id='".$result."'";
            $iopayresult = $this->db->query($iopay);

            $paysql="UPDATE campaigns SET io='RMAIO".$result."' WHERE (id='".$campaigndetails['id']."' || campaign_group='".$campaigndetails['id']."' ) ";
            
            $payresult = $this->db->query($paysql);

            $walletholdsql="INSERT INTO ".$this->wallet." SET user_id='".$_SESSION['userid']."', payment_id='".$result."', amount='".$campaigndetails['total_budget']."', campaign_id='".$campaigndetails['id']."'";
            $wallethold = $this->db->query($walletholdsql);


            $q="UPDATE campaigns SET status='1',renewstatus='0' WHERE (id='".$campaigndetails['id']."' OR campaign_group='".$campaigndetails['id']."')";
            $result=$this->db->query($q);
            //$w="UPDATE users SET wallet='".$netamt."' WHERE id='".$_SESSION['userid']."' ";
            //$result=$this->db->query($w);
            $camp="SELECT * FROM campaigns WHERE id='".$campaigndetails['id']."' AND deleted_at is NULL";
            $camname=$this->db->get_row($camp);
            $sql="SELECT * FROM users WHERE id='".$_SESSION['userid']."' AND deleted_at is NULL";
            $manage=$this->db->get_row($sql);
            $mail="SELECT * FROM users WHERE id='".$manage['managerid']."'  AND deleted_at is NULL";
            $mmail=$this->db->get_row($mail);
            $admin="SELECT * FROM users WHERE type=10 AND deleted_at is NULL";
            $amail=$this->db->get_row($admin);
            $name=$manage['name'];
            $amt=$campaigndetails['total_budget'];
            $camp=$camname['name'];
            $message='<p>Hi,</p>
            <p>Name Of Advertiser:'.$name.'</p>
            <p>Campaign Name:'.$camp.'</p>
            <p>Name Of Mode:Wallet</p>
            <p>Amount:$'.$amt.'</p>';
            $cc=$mmail['email'];
            sendmail($amail['email'],'New Payment Made By Advertiser',$message,$cc);              
            redirect('payment-success.php?token='.$id.'&payment='.$result);
        }else{
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='danger';
            $_SESSION['flash_msg']='Please try again later';
        }
    }

    public function doLaterPayment($id) {
        $campaigndetails=$this->campaign->getCampaignByIdEncript($_REQUEST['token']);
        $payment=$this->getCampaignPayment($campaigndetails['id']);
        if (!empty($payment)) {
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='warning';
            $_SESSION['flash_msg']='Sorry, Your transaction already completed.';
            return ;
        }

        $q="UPDATE campaigns SET status='5' WHERE (id='".$campaigndetails['id']."' OR campaign_group='".$campaigndetails['id']."')";
        $result=$this->db->query($q);
        $_SESSION['flash']=TRUE;
        $_SESSION['flash_class']='info';
        $_SESSION['flash_msg']='Campaign was created. Please make a payment';
        redirect('all-campaigns.php');
    }

    public function walletPayment() {
        $sql="INSERT INTO ".$this->table." SET user_id='".$_SESSION['userid']."',amount='".$_POST['amount']."', transactionid='".$_POST['transactionid']."',type='wallet',status=0,remarks='".$_POST['remarks']."'";
        $result=$this->db->insert($sql);
        if($result){
            redirect('payment-success.php?token='.$id.'&payment='.$result);
        }else{
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='danger';
            $_SESSION['flash_msg']='Please try again later';
        }
    }

    public function addPayment()
    {
        $sql="INSERT INTO ".$this->table." SET campaign_id='".$campaigndetails['id']."',transactionid='".$_POST['transactionid']."',type='wire',status=2";
        $result=$this->db->insert($sql);
        if($result){
            redirect('payment-success.php?token='.$id.'&payment='.$result);
        }else{
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='danger';
            $_SESSION['flash_msg']='Please try again later';
        }
    }

    public function availableWalletAmount($user_id=NULL)
    {
        if(empty($user_id)){
            $user_id=$_SESSION['userid'];
        }
        $user_data=$this->users->getUser($user_id);

        $awsql="SELECT SUM(amount) as amount FROM ".$this->wallet." WHERE user_id='".$user_id."' AND status='1'";
        $aw=$this->db->get_row($awsql);

        return $user_data['wallet']-$aw['amount'];
    }

    public function usedWalletAmount($user_id=NULL)
    {
        if(empty($user_id)){
            $user_id=$_SESSION['userid'];
        }
        $user_data=$this->users->getUser($user_id);

        $uwsql="SELECT SUM(amount) as amount FROM ".$this->wallet." WHERE user_id='".$user_id."' AND status='1'";
        $uw=$this->db->get_row($uwsql);

        return $uw['amount'];
    }
}
$payments=new Payments();