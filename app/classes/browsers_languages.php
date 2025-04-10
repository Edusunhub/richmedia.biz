<?php
class BrowsersLanguages
{
    public $db;
    public $common;
    public $table='browser_language';
    public $browser='browsers';

    function __construct()
    {
        $this->db=new DB();
        $this->common=new Common();
    }

    public function save()
    {   
        if(!empty($_POST['browsersid'])){
            $browsersid=implode(",",$_POST['browsersid']);
            $sql="INSERT INTO ".$this->table." (browsersid,name,status) VALUES ('".$browsersid."','".$_POST['name']."','".$_POST['status']."')";
        }
        //$sql="INSERT INTO ".$this->table." SET browsersid='".$_POST['browsersid']."',name='".$_POST['name']."',status='".$_POST['status']."'";
        $result=$this->db->insert($sql);
        if($result){
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='success';
            $_SESSION['flash_msg']='New browser has been successfully added';
            redirect('browsers-languages.php');
        }else{
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='danger';
            $_SESSION['flash_msg']='Something went wrong';
        }
    }

    public function update($id)
    {
        if(!empty($_POST['browsersid'])){
            $browsersid=implode(",",$_POST['browsersid']);
            $sql="UPDATE ".$this->table." SET browsersid='".$browsersid."',name='".$_POST['name']."',status='".$_POST['status']."'";
            $sql .=" WHERE md5(id)='".$id."'";
            $result=$this->db->query($sql);
        }
        if($result){
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='success';
            $_SESSION['flash_msg']='browser was successfully updated';
            redirect('browsers-languages.php');
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
            $_SESSION['flash_msg']='browser was successfully deleted';
            redirect('browsers-languages.php');
        }else{
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='red';
            $_SESSION['flash_msg']='Something went wrong';
        }
    }

    public function getLanguageByEncryptID($id)
    {
        $sql="SELECT * FROM ".$this->table." WHERE md5(id)='".$id."' AND deleted_at is NULL";
        return $this->db->get_row($sql);
    }

    public function getLanguageByID($id)
    {
        $sql="SELECT * FROM ".$this->table." WHERE id='".$id."'";
        return $this->db->get_row($sql);
    }

    public function getAllLanguages()
    {
        $sql="SELECT * FROM ".$this->table." WHERE deleted_at is NULL ORDER BY name ASC";
        return $this->db->get_results($sql);
    }

    public function getAllLanguagesByIds($ids)
    {
        $sql="SELECT * FROM ".$this->table." WHERE id IN (".$ids.") AND deleted_at is NULL ORDER BY name ASC";
        return $this->db->get_results($sql);
    }

    public function getLanguages($perrow='')
    {
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
        $pagination=$this->common->getPagination('browsers-languages.php',$pages,$limit,$cpage=$page,$parem);
        $data=$this->db->get_results($sql);
        return array('data'=>$data,'pagination'=>$pagination);
    }
}
$browsers_languages=new BrowsersLanguages();