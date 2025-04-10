<?php
class Macros
{
    public $db;
    public $common;
    public $table='macros';

    function __construct()
    {
        $this->db=new DB();
        $this->common=new Common();
    }

    public function save()
    {
        $sql="INSERT INTO ".$this->table." SET name='".$_POST['name']."',status='".$_POST['status']."'";
        $result=$this->db->insert($sql);
        if($result){
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='success';
            $_SESSION['flash_msg']='New macros has been successfully added';
            redirect('all-macros.php');
        }else{
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='danger';
            $_SESSION['flash_msg']='Something went wrong';
        }
    }

    public function update($id)
    {
        $icon=$this->common->upload($_FILES['icon']);
        $sql="UPDATE ".$this->table." SET name='".$_POST['name']."',status='".$_POST['status']."'";
        if(!empty($icon)){
            $sql .=",icon='".$icon."'";
        }
        $sql .=" WHERE md5(id)='".$id."'";
        $result=$this->db->query($sql);
        if($result){
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='success';
            $_SESSION['flash_msg']='Macros was successfully updated';
            redirect('all-macros.php');
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
            $_SESSION['flash_msg']='Macros was successfully deleted';
            redirect('all-macros.php');
        }else{
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='red';
            $_SESSION['flash_msg']='Something went wrong';
        }
    }

    public function getMacroByEncryptID($id)
    {
        $sql="SELECT * FROM ".$this->table." WHERE md5(id)='".$id."' AND deleted_at is NULL";
        return $this->db->get_row($sql);
    }

    public function getMacroByID($id)
    {
        $sql="SELECT * FROM ".$this->table." WHERE id='".$id."'";
        return $this->db->get_row($sql);
    }

    public function getMacroByIds($ids) {
        $sql="SELECT * FROM ".$this->table." WHERE id IN(".$ids.") ORDER BY name ASC";
        $data=$this->db->get_results($sql);
        return $data;
    }

    public function getAllMacros()
    {
        $sql="SELECT * FROM ".$this->table." WHERE deleted_at is NULL ORDER BY name ASC";
        return $this->db->get_results($sql);
    }

    public function getMacros($perrow='')
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
        $sql="SELECT * FROM ".$this->table." WHERE deleted_at is NULL";
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
        $pagination=$this->common->getPagination('all-macros.php',$pages,$limit,$cpage=$page,$parem);
        $data=$this->db->get_results($sql);
        return array('data'=>$data,'pagination'=>$pagination);
    }
}
$macros=new Macros();