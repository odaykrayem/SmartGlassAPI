<?php
   
 include_once dirname(__FILE__).'/operations.php';

 $response=array(); 
 if($_SERVER['REQUEST_METHOD']=='POST'){
    if(
       isset($_POST['email']) and
         isset($_POST['password']) and
          isset($_POST['name'])
    ){
       $db = new Operations();
       $result = $db-> createUser(
         $_POST['email'],
         $_POST['password'],
         $_POST['name']
       );
       if($result == 1){
            $response['status'] = 1;
            $response['message'] = "User registered Successfully";
            $user = $db->getUserByEmail($_POST['email']);
            $response['id']  = $user['id'];
            $response['email']  = $user['email'];
            $response['password']  = $user['password'];
            $response['name']  = $user['name'];
       }else if($result == 2){
         $response['status'] = 0;
         $response['message'] = "Registeration Error";
       }else{
         $response['status'] = 0;
         $response['message'] = "Email Already exist please try another one";
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