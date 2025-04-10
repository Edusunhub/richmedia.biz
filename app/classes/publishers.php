<?php
class Publishers
{
    public $db;
    public $common;
    public $table='publishers';

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
            $_SESSION['flash_msg']='New Domains has been successfully added';
            redirect('all-publishers.php');
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
            $_SESSION['flash_msg']='Domains was successfully updated';
            redirect('all-publishers.php');
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
            $_SESSION['flash_msg']='Domains was successfully deleted';
            redirect('all-publishers.php');
        }else{
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='red';
            $_SESSION['flash_msg']='Something went wrong';
        }
    }

    public function getPublisherByEncryptID($id)
    {
        $sql="SELECT * FROM ".$this->table." WHERE md5(id)='".$id."' AND deleted_at is NULL";
        return $this->db->get_row($sql);
    }

    public function getPublisherByID($id)
    {
        $sql="SELECT * FROM ".$this->table." WHERE id='".$id."'";
        return $this->db->get_row($sql);
    }

    public function getrexPublisherByID($id)
    {
        $sql="SELECT * FROM ".$this->table." WHERE id REGEXP '[[:<:]](".$id.")[[:>:]]' AND deleted_at is NULL ORDER BY id DESC";
        return $this->db->get_results($sql);
    }

    public function getPublisherByIds($ids) {
        $sql="SELECT * FROM ".$this->table." WHERE id IN(".$ids.") ORDER BY name ASC";
        $data=$this->db->get_results($sql);
        return $data;
    }

    public function getAllPublishers()
    {
        $sql="SELECT * FROM ".$this->table." WHERE deleted_at is NULL ORDER BY name ASC";
        return $this->db->get_results($sql);
    }

    public function getPublishers($perrow='')
    {
        if($_GET["limit"]||$_POST["limit"]){
            if($_GET["limit"]){
                $limit = $_GET["limit"];
            }
            if($_POST["limit"]){
                $limit = $_POST["limit"];
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
        $pagination=$this->common->getPagination('all-publishers.php',$pages,$limit,$cpage=$page,$parem);
        $data=$this->db->get_results($sql);
        return array('data'=>$data,'pagination'=>$pagination);
    }
}
$publishers=new Publishers();