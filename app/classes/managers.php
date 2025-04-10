<?php
class Managers
{
    public $db;
    public $common;
    public $table='users';


    function __construct()
    {
        $this->db=new DB();
        $this->common=new Common();
        $this->users=new Users();
    }

    public function save()
    {
        $result=$this->db->counts("SELECT id FROM ".$this->table." WHERE type='3' AND email='".$_POST['email']."' AND deleted_at is NULL");
        if ($result>0) {
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='danger';
            $_SESSION['flash_msg']='Email already exist';
            redirect('add-new-managers.php');
            return false;
        }

        $sql="INSERT INTO ".$this->table." SET name='".$_POST['name']."',email='".$_POST['email']."',password='".md5($_POST['password'])."',phone='".$_POST['phone']."',status='".$_POST['status']."', role=3,type=3 ";

        $result=$this->db->insert($sql);
        if($result){
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='success';
            $_SESSION['flash_msg']='New Manager has been successfully created';
            redirect('add-managers.php');
        }else{
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='danger';
            $_SESSION['flash_msg']='Something went wrong';
        }
    }

    public function update($id)
    {
        $sql="UPDATE ".$this->table." SET name='".$_POST['name']."',email='".$_POST['email']."',phone='".$_POST['phone']."',status='".$_POST['status']."' ";
        if($_POST['passwordcheck']){
            $sql .=",password='".md5($_POST['password'])."' ";

        }
        $sql .=" WHERE md5(id)='".$id."'";
        $result=$this->db->query($sql);
        if($result){
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='success';
            $_SESSION['flash_msg']='Manager was successfully updated';
            redirect('add-managers.php');
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
            $_SESSION['flash_msg']='Manager was successfully deleted';
            redirect('add-managers.php');
        }else{
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='red';
            $_SESSION['flash_msg']='Something went wrong';
        }
    }

    public function getManagerByEncryptID($id)
    {
        $sql="SELECT * FROM ".$this->table." WHERE md5(id)='".$id."' AND type=3 ";
        return $this->db->get_row($sql);
    }

    public function getManagerByID($id)
    {
        $sql="SELECT * FROM ".$this->table." WHERE id='".$id."' AND type=3 AND deleted_at is NULL";
        return $this->db->get_row($sql);
    }


    public function allManagers()
    {
        $sql="SELECT * FROM ".$this->table." WHERE type=3  AND status = 1 AND deleted_at is NULL ORDER BY name ASC";
        return $this->db->get_results($sql);
    }

    public function getManagers($perrow='')
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
        $sql="SELECT * FROM ".$this->table." WHERE deleted_at is NULL AND type=3";
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
        $pagination=$this->common->getPagination('add-managers.php',$pages,$limit,$cpage=$page,$parem);
        $data=$this->db->get_results($sql);
        return array('data'=>$data,'pagination'=>$pagination);
    }
}
$managersobj=new Managers();