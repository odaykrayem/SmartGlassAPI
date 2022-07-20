<?php

 class Operations{
     private $con;
     function __construct()
     {
        require_once dirname(__FILE__).'/DbConnect.php';
        $db = new DbConnect();
        $this->con = $db->connect();    
     }
      public function createUser($email, $password, $name)
      {
        
        if($this->isUserEmailAlreadyExist($email)){
            return 0;
            echo "exist";
        }else{
            $password = md5($password);
            $stmt = $this-> con->prepare("INSERT INTO `patients` (`email`, `password`, `name`) VALUES (?, ?, ?);");
            $stmt->bind_param("sss",$email,$password,$name);
            if($stmt->execute()){
                return 1;
            }else{
                return 2;
            }
        }   
    }

    public function isUserEmailAlreadyExist($email) 
    {
        $stmt = $this-> con->prepare("SELECT * FROM patients WHERE email = ?;");
        $stmt->bind_param("s",$email);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows() > 0;  
    }

    public function loginPatient($email, $password){
        $password = md5($password);
        $stmt = $this-> con->prepare("SELECT id FROM patients WHERE email = ? AND password = ?;");
        $stmt->bind_param("ss",$email,$password);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows() > 0;
    }

    public function getUserByEmail($email){
        $stmt = $this-> con->prepare("SELECT * FROM patients WHERE email = ?;");
        $stmt->bind_param("s",$email);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    public function getUserById($id){
        $stmt = $this-> con->prepare("SELECT * FROM patients WHERE id = ?;");
        $stmt->bind_param("s",$id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    public function getAllSentences($patient_id){
        $stmt = $this->con->prepare("SELECT id, sentence FROM sentences where said = 0 and patient_id = ?;");
        $stmt->bind_param("s",$patient_id);
        $stmt ->execute();
        $stmt ->bind_result($id,$sentence);
        $stmt->store_result();
        $list = array();
        if($stmt->num_rows>0){
            while($stmt ->fetch()){

                $temp = array();
                $temp['id'] = $id;
                $temp['sentence'] = $sentence;

                array_push($list,$temp);
           }
           return $list;
        }
        else{
            return 0;
        }
    }

    public function changeSentenceStatus($sentence_id){
        $stmt = $this-> con->prepare("Update sentences set said = 1 where id = ?;");
        $stmt->bind_param("s",$sentence_id);
        $stmt->execute();
        return 1;
    }

    // public function getPatientLocation($patient_id){
    //     $stmt = $this-> con->prepare("SELECT lat,lon FROM patients WHERE id = ?;");
    //     $stmt->bind_param("s",$patient_id);
    //     $stmt->execute();
    //     return $stmt->get_result()->fetch_assoc();
    // }

    public function setPatientLocation($patient_id, $lat, $lon){
        $stmt = $this-> con->prepare("Update patients set lat = ? , lon = ? where id = ?;");
        $stmt->bind_param("sss", $lat, $lon, $patient_id);
        $stmt->execute();
        return 1;
    }
 }
 
 ?>