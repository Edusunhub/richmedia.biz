<?php
class CampaignLanguages
{
    public $db;
    public $common;
    public $table='languages';

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
            $_SESSION['flash_msg']='New languages has been successfully added';
            redirect('campaign-languages.php');
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
            $_SESSION['flash_msg']='languages was successfully updated';
            redirect('campaign-languages.php');
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
            $_SESSION['flash_msg']='languages was successfully deleted';
            redirect('campaign-languages.php');
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
        $pagination=$this->common->getPagination('campaign-languages.php',$pages,$limit,$cpage=$page,$parem);
        $data=$this->db->get_results($sql);
        return array('data'=>$data,'pagination'=>$pagination);
    }
}
$campaign_languages=new CampaignLanguages();