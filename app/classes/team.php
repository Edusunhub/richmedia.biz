<?php
class Team extends DB
{
    public $db;
    public $table='teams';
    public $users='users';
    function __construct()
    {
        $this->db=new DB();
        $this->common=new Common();
    }

    public function save()
    {
        
        // if(!empty($_POST['agents'])){
        //     foreach ($_POST['agents'] as $key => $agent) {
        //         $sql="INSERT INTO ".$this->table." (name,team_lead,agent_id,branch,created_by) VALUES ('".$_POST['name']."','".$_POST['team']."','".$agent."','".$_POST['branch']."','".$_SESSION['userid']."')";
        //         $result=$this->db->query($sql);
        //     }
        // }

        // if($result){
        //     $_SESSION['flash']=TRUE;
        //     $_SESSION['flash_class']='green';
        //     $_SESSION['flash_msg']='New Team has been successfully created';
        // }else{
        //     $_SESSION['flash']=TRUE;
        //     $_SESSION['flash_class']='red';
        //     $_SESSION['flash_msg']='Something went wrong';
        // }
        // redirect('staffs.php');
    }
}
$team=new Team();