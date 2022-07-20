<?php

include_once dirname(__FILE__).'/operations.php';
$response=array(); 
if($_SERVER['REQUEST_METHOD']=='POST'){

    if(($_POST['sentence_id'])){

        $db = new Operations();
        $result=$db->changeSentenceStatus($_POST['sentence_id']);
        if($result == 1){
            $response['status'] = 1;
            $response['message'] = "Operation successfully done";
        }else{
            $response['status'] = 0;
            $response['message'] = "Operation failed you can try again later";
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