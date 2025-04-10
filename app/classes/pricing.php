<?php
class Pricing extends DB
{
    public $db;
    public $common;
    public $table='pricing';
    public $campaigns='campaign_types';

    function __construct()
    {
        $this->db=new DB();
        $this->common=new Common();
    }

    public function getPrices()
    {
        $result=$this->db->get_results("SELECT p.*,c.id,c.name,c.sortname FROM countries c LEFT JOIN pricing P ON c.id=p.country_id WHERE p.deleted_at is NULL ORDER BY c.name ASC");
        return $result;
    }

    public function save() {
        $vsql="SELECT id FROM ".$this->table." WHERE country_code='".$_POST['country']."' AND model='".$_POST['model']."' ";
        $count = $this->db->counts($vsql);
        if($count!=0){
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='danger';
            $_SESSION['flash_msg']='Price already exists';
            return false;
        }
        
        $sql="INSERT INTO ".$this->table." SET country_code='".$_POST['country']."',min_bid='".$_POST['min_bid']."',max_bid='".$_POST['max_bid']."',model='".$_POST['model']."',status='".$_POST['status']."'"; 
        $result=$this->db->insert($sql);
        if(!empty($result)){
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='success';
            $_SESSION['flash_msg']='Price has been successfully added.';
            redirect('all-pricing.php');
        }else{
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='danger';
            $_SESSION['flash_msg']='Something went wrong';
        }
    }

    public function update($id) {        
        $sql="UPDATE ".$this->table." SET model='".$_POST['model']."',min_bid='".$_POST['min_bid']."',max_bid='".$_POST['max_bid']."',status='".$_POST['status']."' WHERE id='".$id."'";
        $result=$this->db->query($sql);
        if(!empty($result)){
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='success';
            $_SESSION['flash_msg']='Price has been successfully updated.';
            redirect('all-pricing.php');
        }else{
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='danger';
            $_SESSION['flash_msg']='Something went wrong';
        }
    }

    public function getPriceByID($id) {
        $result=$this->db->get_row("SELECT * FROM ".$this->table." WHERE id='".$id."' AND deleted_at is NULL");
        return $result;
    }

    public function all() {
        $sql="SELECT * FROM ".$this->table." WHERE deleted_at is NULL ORDER BY id DESC";
        $data=$this->db->get_results($sql);
        return $data;
    }

    public function delete($id)
    {
        if(empty($id)) { redirect('all-pricing.php'); }
        $sql="UPDATE ".$this->table." SET deleted_at=now() WHERE md5(id)='".$id."'";
        $result=$this->db->query($sql);
        if($result){
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='success';
            $_SESSION['flash_msg']='pricing has been deleted successfully';
        }else{
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='danger';
            $_SESSION['flash_msg']='Something went wrong';
        }
        redirect('all-pricing.php');
    }

    public function getAllPricesCountries()
    {
        $result=$this->db->get_results("SELECT p.*,c.id,c.name FROM ".$this->table." p JOIN countries c ON c.id=p.country_id WHERE p.deleted_at is NULL AND p.status=1 ORDER BY c.name ASC");
        return $result;
    }

    public function getCampaignPrices($model,$country)
    {
        $result=NULL;
        if(!empty($country)){
            $countries=implode("','", $country);
            $sql="SELECT p.*,c.id as countryid,c.name FROM ".$this->table." p JOIN countries c ON c.sortname=p.country_code WHERE p.deleted_at is NULL AND p.status=1 AND p.model='".$model."' "; // AND p.type='".$type."' 
            $sql .=" AND c.sortname IN ('".$countries."')";
            $sql .=" ORDER BY c.name ASC";
            $result=$this->db->get_results($sql);
        }
        return $result;
    }
    
    public function getAllPricesCountriesByType($type,$model,$country=array())
    {
        $sql="SELECT p.*,c.id as country_id,c.name FROM ".$this->table." p JOIN countries c ON c.sortname=p.country_code WHERE p.deleted_at is NULL AND p.status=1 AND p.model='".$model."' AND p.type='".$type."' ";
        if(!empty($country)){
            $countries=implode("','", $country);
            $sql .=" AND c.sortname IN ('".$countries."')";
        }
        $sql .=" ORDER BY c.name ASC";
        $result=$this->db->get_results($sql);
        return $result;
    }

    public function allCampaignTypes() {
        $types="SELECT * FROM ".$this->campaigns." WHERE deleted_at is NULL";
        return $this->db->get_results($types);
    }

    public function getAllPrices($perrow='')
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
        }
        if (isset($_GET["page"])){
            $page=$_GET["page"];
        }else{
            $page=1;
        }
        $start_from = ($page-1) * $limit;
        $parem='';
        $sql="SELECT p.*,c.name FROM ".$this->table." p JOIN countries c ON c.sortname=p.country_code WHERE p.deleted_at is NULL";

        if(isset($_GET['model']) && $_GET['model']!=''){
            $sql .=" AND p.model='".$_GET['model']."'";
            $parem .='&model='.$_GET['model'];
        }

        if(isset($_GET['type']) && $_GET['type']!=''){
            $sql .=" AND p.type='".$_GET['type']."'";
            $parem .='&type='.$_GET['type'];
        }

        if(isset($_GET['status']) && $_GET['status']!=''){
            $sql .=" AND p.status='".$_GET['status']."'";
            $parem .='&status='.$_GET['status'];
        }
        
        $total_records=$this->db->counts($sql);
        $sql .=" ORDER BY c.name ASC LIMIT ".$start_from.", ".$limit."";

        $pages = ceil($total_records / $limit);
        $pagination=$this->common->getPagination('all-pricing.php',$pages,$limit,$cpage=$page,$parem);
        $data=$this->db->get_results($sql);
        return array('data'=>$data,'pagination'=>$pagination);
    }
}
$pricing=new Pricing();