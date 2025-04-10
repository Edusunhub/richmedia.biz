<?php
class OS extends DB
{
    public $db;
    public $table='os';
    public $os_entity='os_entity';
    public $os_versions='os_versions';

    function __construct()
    {
        $this->db=new DB();
        $this->common=new Common();
    }

    public function saveOS() {
        if(!empty($_POST['devices'])) {
            $deviceid=implode(",",$_POST['devices']);
            $sql="INSERT INTO ".$this->table." (deviceid,name,status) VALUES ('".$deviceid."','".$_POST['name']."','".$_POST['status']."')";
            $result=$this->db->insert($sql);
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='success';
            $_SESSION['flash_msg']='New OS has been successfully added.';
            redirect('os-types.php');
        }else{
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='danger';
            $_SESSION['flash_msg']='Something went wrong';
        }
    }

    public function updateOS($id) {
        if(!empty($_POST['devices'])){
            $deviceid=implode(",",$_POST['devices']);
        $sql="UPDATE ".$this->table." SET deviceid='".$deviceid."',name='".$_POST['name']."', status='".$_POST['status']."' WHERE md5(id)='".$id."'";
        $result=$this->db->query($sql);

        }

        if(!empty($result)){
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='success';
            $_SESSION['flash_msg']='OS has been successfully updated.';
            redirect('os-types.php');
        }else{
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='danger';
            $_SESSION['flash_msg']='Something went wrong';
        }
    }

    public function getOSByID($id) {
        $sql="SELECT * FROM ".$this->table." WHERE id='".$id."' AND deleted_at is NULL ORDER BY id DESC";
        $data=$this->db->get_row($sql);
        return $data;
    }

    public function getOSypeByEncryptID($id) {
        $sql="SELECT * FROM ".$this->table." WHERE md5(id)='".$id."' AND deleted_at is NULL ORDER BY id DESC";
        $data=$this->db->get_row($sql);
        return $data;
    }


    public function all() {
        $sql="SELECT * FROM ".$this->table." WHERE deleted_at is NULL ORDER BY id DESC";
        $data=$this->db->get_results($sql);
        return $data;
    }

    public function getAllOSType($perrow='')
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
        $sql="SELECT * FROM os WHERE deleted_at is NULL ";
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
        $pagination=$this->common->getPagination('os-types.php',$pages,$limit,$cpage=$page,$parem);
        $data=$this->db->get_results($sql);
        return array('data'=>$data,'pagination'=>$pagination);
    }

    public function delete($id)
    {
        if(empty($id)) { redirect('os-types.php'); }
        $sql="UPDATE ".$this->table." SET deleted_at=now() WHERE md5(id)='".$id."'";
        $result=$this->db->query($sql);
        if($result){
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='success';
            $_SESSION['flash_msg']='OS has been deleted successfully';
        }else{
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='danger';
            $_SESSION['flash_msg']='Something went wrong';
        }
        redirect('os-types.php');
    }

    public function getDevicesByOSId($id)
    {
        $sql="SELECT device FROM ".$this->os_entity." WHERE os='".$id."' ORDER BY id DESC";
        $data=$this->db->get_results($sql);
        return $data;
    }

    public function getDeviceByOSId($id)
    {
        $sql="SELECT device FROM ".$this->os_entity." WHERE os='".$id."' ORDER BY id DESC";
        $data=$this->db->get_row($sql);
        return $data;
    }

    public function saveOSVersion()
    {
        if(!empty($_POST['ostype'])) {
            $osid=implode(",",$_POST['ostype']);
            $sql="INSERT INTO ".$this->os_versions." (name,os_id,status) VALUES ('".$_POST['name']."','".$osid."','".$_POST['status']."')";
            $result=$this->db->insert($sql);
        }
        if($result){
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='success';
            $_SESSION['flash_msg']='OS Version has been successfully created';
            redirect('os-versions.php');
        }else{
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='danger';
            $_SESSION['flash_msg']='Something went wrong';
        }
    }

    public function updateOSVersion($id)
    {
        if(!empty($_POST['ostype'])) {
            $osid=implode(",",$_POST['ostype']);
            echo $sql="UPDATE ".$this->os_versions." SET name='".$_POST['name']."',os_id='".$osid."',status='".$_POST['status']."' WHERE md5(id)='".$id."'";
            $result=$this->db->query($sql);
        }
        if($result){
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='success';
            $_SESSION['flash_msg']='OS Version has been successfully updated';
            redirect('os-versions.php');
        }else{
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='danger';
            $_SESSION['flash_msg']='Something went wrong';
        }
    }

    public function deleteOSVersion($id)
    {
        $sql="UPDATE ".$this->os_versions." SET deleted_at=now() WHERE md5(id)='".$id."'";
        $result=$this->db->query($sql);
        if($result){
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='success';
            $_SESSION['flash_msg']='OS Version has been successfully deleted';
            redirect('os-versions.php');
        }else{
            $_SESSION['flash']=TRUE;
            $_SESSION['flash_class']='danger';
            $_SESSION['flash_msg']='Something went wrong';
        }
    }

    public function getOSVersionByID($id) {
        $sql="SELECT * FROM ".$this->os_versions." WHERE id='".$id."'";
        $data=$this->db->get_row($sql);
        return $data;
    }

    public function getOSVersionByEncryptID($id) {
        $sql="SELECT * FROM ".$this->os_versions." WHERE md5(id)='".$id."'";
        $data=$this->db->get_row($sql);
        return $data;
    }

    public function getAllOSVersions() {
        $sql="SELECT * FROM ".$this->os_versions." ORDER BY name ASC";
        $data=$this->db->get_results($sql);
        return $data;
    }

    public function getAllOSTypesByIds($ids) {
        $sql="SELECT * FROM ".$this->table." WHERE id IN(".$ids.") ORDER BY name ASC";
        $data=$this->db->get_results($sql);
        return $data;
    }

    public function getAllOSVersionsByIds($ids) {
        $sql="SELECT * FROM ".$this->os_versions." WHERE id IN(".$ids.") ORDER BY name ASC";
        $data=$this->db->get_results($sql);
        return $data;
    }

    public function getOSVersions() {
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
        $sql="SELECT * FROM ".$this->os_versions." WHERE deleted_at is NULL";
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
        $pagination=$this->common->getPagination('os-versions.php',$pages,$limit,$cpage=$page,$parem);
        $data=$this->db->get_results($sql);
        return array('data'=>$data,'pagination'=>$pagination);
    }
}
$os=new OS();