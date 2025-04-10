<?php
class DB {

    public $con;

    function __construct() {
        //$this->con = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
    }

    function connection() {
        $con=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
        mysqli_set_charset($con,"utf8mb4");
        return $con;
    }

    public function deconnection($connection) {
        if (!is_null($connection)) {
            mysqli_close($connection);
        }
    }

    public function query($query)
    {
        $conn=$this->connection();
        $results=mysqli_query($conn,$query);
        if($results){
            //$this->$db->con->close();
            $this->deconnection($conn);
            return TRUE;
        }
        echo mysqli_error($conn);
        return FALSE;
    }

    public function get_row($query)
    {
        $conn=$this->connection();
        $results=mysqli_query($conn,$query);
        if($results){
           $data=mysqli_fetch_array($results);
           $this->deconnection($conn);
            return $data;
        }else{
            echo mysqli_error($conn);
            $this->deconnection($conn);
            return FALSE;
        }
    }

    public function get_results($query)
    {
        $conn=$this->connection();
        $results=mysqli_query($conn,$query);
        if($results){
           
           for ($output = array (); $row = mysqli_fetch_assoc($results); $output[] = $row);
            
            $this->deconnection($conn);
            return $output;
        }
        echo mysqli_error($conn);
        $this->deconnection($conn);
        return FALSE;
    }

    public function counts($query)
    {
        $conn=$this->connection();
        $results=mysqli_query($conn,$query);
        if($results){
            $data=mysqli_num_rows($results);
            $this->deconnection($conn);
            return $data;
        }
        echo mysqli_error($conn);
        return FALSE;
    }

    public function insert($query){
        $conn=$this->connection();
        $results=mysqli_query($conn,$query);
        if($results){
            $mysqli_insert_id=mysqli_insert_id($conn);
            $this->deconnection($conn);
            return $mysqli_insert_id;
        }
        echo mysqli_error($conn);
        return FALSE;
    }

    public function update($query){
        $conn=$this->connection();
        mysqli_query($conn,$query);
        $results=mysqli_affected_rows($conn);
        $this->deconnection($conn);
        if($results){
            return TRUE;
        }
        return FALSE;
    }
} 

$db=new DB();