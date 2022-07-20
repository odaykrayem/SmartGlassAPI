<?php

include_once dirname(__FILE__).'/operations.php';
$response=array(); 
if($_SERVER['REQUEST_METHOD']=='POST'){

    if(isset($_POST['email']) and isset($_POST['password'])){

        $db = new Operations();
        if($db->isUserEmailAlreadyExist($_POST['email'])){
            if($db->loginPatient($_POST['email'], $_POST['password'])){
                $patient = $db->getUserByEmail($_POST['email']);
                $response['status'] = 1;
                $response['message'] = 'Logged in Successfully';
                $response['id']  = $patient['id'];
                $response['email']  = $patient['email'];
                $response['password']  = $patient['password'];
                $response['name']  = $patient['name'];
    
            }else{
                $response['status'] = 0;
                $response['message'] = 'Wrong email or password';
            }
        }else{
            $response['status'] = 0;
            $response['message'] = 'user email does not exist';
        }
    }else{
        $response['status'] = 0;
        $response['message'] = 'Required fields are missing';
    }

}else{
    $response['status'] = 0;
    $response['message'] = 'Invalid Request';
}
echo json_encode($response);

?>