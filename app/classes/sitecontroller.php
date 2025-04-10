<?php
class Site extends DB
{
    public $db;

    function __construct()
    {
        $this->db=new DB();
        $this->common=new Common();
    }

    public function upload($file){
        $filename=false;
        if(file_exists($file['tmp_name'])) {
            $image_path='../public/uploads';
            $uploaderror=array();
            if (!file_exists($image_path)) {
                mkdir($image_path, 0777, true);
            }
            $info = pathinfo($file['name']);
            $im_size = $file['size'];

            if($im_size > 2097152 * 16){
                $uploaderror[]=array('status'=>0, 'msg'=> 'Image size is too big.Please upload below 2MB');
                $_SESSION['flash']=TRUE;
                $_SESSION['flash_class']='danger';
                $_SESSION['flash_msg']=$uploaderror['msg'];
                return false;
            }

            $extension = strtolower($info['extension']);

            if($extension=='jpg'||$extension=='png'||$extension=='jpeg'){
            } else {
                $uploaderror[]=array('status'=>0, 'msg'=> 'Image is not valid. Allowed types : JPG, PNG, JPEG');
            }
            if(empty($uploaderror)){
                $image=$file['name'];
                $date = date('m/d/Yh:i:sa', time());
                $rand=rand(10000,99999);
                $encname=$date.$rand;
                $imagename=md5($encname).'.'.$extension;
                $imagepath=$image_path.'/'.$imagename;
                $moved=move_uploaded_file($file["tmp_name"],$imagepath);
                return $imagename;
            }else{
                $_SESSION['flash']=TRUE;
                $_SESSION['flash_class']='danger';
                $_SESSION['flash_msg']=$uploaderror['msg'];
                return false;
            }
        }
    }
}
$site=new Site();