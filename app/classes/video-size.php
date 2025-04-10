<?php
class Videos
{
    public $db;
    public $common;
    public $table='videosize';

    function __construct()
    {
        $this->db=new DB();
        $this->common=new Common();
    }

    public function save()
    {
        $sql="INSERT INTO ".$this->table." SET videosize='".$_POST['videosize']."',status='".$_POST['status']."'";

        $result=$this->db->insert($sql);
        if($result){
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='success';
            $_SESSION['flash_msg']='New video Size has been successfully created';
            redirect('video-dimensions.php');
        }else{
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='danger';
            $_SESSION['flash_msg']='Something went wrong';
        }
    }

    public function update($id)
    {
        $sql="UPDATE ".$this->table." SET videosize='".$_POST['videosize']."',status='".$_POST['status']."' WHERE md5(id)='".$id."'";
        $result=$this->db->query($sql);
        if($result){
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='success';
            $_SESSION['flash_msg']='Video Size was successfully updated';
            redirect('video-dimensions.php');
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
            $_SESSION['flash_msg']='Video Size was successfully deleted';
            redirect('video-dimensions.php');
        }else{
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='red';
            $_SESSION['flash_msg']='Something went wrong';
        }
    }

    public function getVideoByEncryptID($id)
    {
        $sql="SELECT * FROM ".$this->table." WHERE md5(id)='".$id."'";
        return $this->db->get_row($sql);
    }

    public function getVideoByID($id)
    {
        $sql="SELECT * FROM ".$this->table." WHERE id='".$id."'";
        return $this->db->get_row($sql);
    }


    public function allVideo()
    {
        $sql="SELECT * FROM ".$this->table." WHERE deleted_at is NULL ORDER BY id ASC";
        return $this->db->get_results($sql);
    }

    public function getAllVideo()
    {
        $sql="SELECT * FROM ".$this->table." WHERE deleted_at is NULL ORDER BY id ASC";
        return $this->db->get_results($sql);
    }

    public function getAllVideosSize($perrow='')
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
        $sql="SELECT * FROM ".$this->table." WHERE deleted_at is NULL";
        if(isset($_GET['video']) && $_GET['video']!=''){
            $sql .=" AND id LIKE '%".$_GET['video']."%' ";
            $parem .='&video='.$_GET['video'];
        }
        
        if(isset($_GET['status']) && $_GET['status']!=''){
            $sql .=" AND status='".$_GET['status']."'";
            $parem .='&status='.$_GET['status'];
        }
        
        $total_records=$this->db->counts($sql);
        $sql .=" ORDER BY id DESC LIMIT ".$start_from.", ".$limit."";

        $pages = ceil($total_records / $limit);
        $pagination=$this->common->getPagination('video.php',$pages,$limit,$cpage=$page,$parem);
        $data=$this->db->get_results($sql);
        return array('data'=>$data,'pagination'=>$pagination);
    }
}
$videosobj=new Videos();