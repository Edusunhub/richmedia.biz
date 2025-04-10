<?php
class Browsers
{
    public $db;
    public $common;
    public $table='browsers';
    public $os='os';

    function __construct()
    {
        $this->db=new DB();
        $this->common=new Common();
    }

    public function save()
    {
        if(!empty($_POST['osid'])) {
        $osid=implode(",",$_POST['osid']);
        $sql="INSERT INTO ".$this->table." SET osid='".$osid."',name='".$_POST['name']."',status='".$_POST['status']."'";
        $result=$this->db->insert($sql);
            if($result){
                $_SESSION['flash']=TRUE;
                $_SESSION['flash_class']='success';
                $_SESSION['flash_msg']='New browser has been successfully added';
                redirect('all-browsers.php');
            }
        }else{
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='danger';
            $_SESSION['flash_msg']='Something went wrong';
        }
    }

    public function update($id)
    {
        //$icon=$this->common->upload($_FILES['icon']);
        if(!empty($_POST['osid'])){
            $osid=implode(",",$_POST['osid']);
        $sql="UPDATE ".$this->table." SET osid='".$osid."',name='".$_POST['name']."',status='".$_POST['status']."'";
        /*if(!empty($icon)){
            $sql .=",icon='".$icon."'";
        }*/
        $sql .=" WHERE md5(id)='".$id."'";
        $result=$this->db->query($sql);
        }
        if($result){
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='success';
            $_SESSION['flash_msg']='Browser was successfully updated';
            redirect('all-browsers.php');
        }else{
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='red';
            $_SESSION['flash_msg']='Something went wrong';
        }
    }

    public function delete($id)
    {
        $sql="UPDATE ".$this->table." SET deleted_at=now() WHERE md5(id)='".$id."'";
        $result=$this->db->query($sql);
        if($result){
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='success';
            $_SESSION['flash_msg']='Browser was successfully deleted';
            redirect('all-browsers.php');
        }else{
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='red';
            $_SESSION['flash_msg']='Something went wrong';
        }
    }

    public function getbrowserByEncryptID($id)
    {
        $sql="SELECT * FROM ".$this->table." WHERE md5(id)='".$id."' AND deleted_at is NULL";
        return $this->db->get_row($sql);
    }

    public function getBrowserByID($id)
    {
        $sql="SELECT * FROM ".$this->table." WHERE id='".$id."'";
        return $this->db->get_row($sql);
    }

    public function getAllBrowsers()
    {
        $sql="SELECT * FROM ".$this->table." WHERE deleted_at is NULL ORDER BY name ASC";
        return $this->db->get_results($sql);
    }

    public function getAllBrowsersByIds($id)
    {
        $sql="SELECT * FROM ".$this->table." WHERE id IN (".$id.") AND deleted_at is NULL ORDER BY name ASC";
        return $this->db->get_results($sql);
    }

    public function getAllOs()
    {
        $sql="SELECT * FROM ".$this->os." WHERE deleted_at is NULL ORDER BY name ASC";
        return $this->db->get_results($sql);
    }

    public function getBrowsers($perrow='')
    {
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
        $sql="SELECT * FROM ".$this->table." WHERE deleted_at is NULL ";
        if(isset($_GET['key']) && $_GET['key']!=''){
            $sql .=" AND name LIKE '%".$_GET['key']."%' ";
            $parem .='&key='.$_GET['key'];
        }
        
        if(isset($_GET['status']) && $_GET['status']!=''){
            $sql .=" AND status='".$_GET['status']."'";
            $parem .='&status='.$_GET['status'];
        }
        
        $total_records=$this->db->counts($sql);
        $sql .=" ORDER BY id DESC LIMIT ".$start_from.", ".$limit."";

        $pages = ceil($total_records / $limit);
        $pagination=$this->common->getPagination('all-browsers.php',$pages,$limit,$cpage=$page,$parem);
        $data=$this->db->get_results($sql);
        return array('data'=>$data,'pagination'=>$pagination);
    }
}
$browsers=new Browsers();