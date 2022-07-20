<?php
   
   include_once dirname(__FILE__).'/operations.php';
   $response=array(); 
 if(isset($_POST['patient_id'])){
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $db = new Operations();
        $list = $db->getAllSentences($_POST['patient_id']);
        if($list == 0){
            $response['status'] = 0;
            $response['message'] = 'There are no Sentences';
        }else{
            $response['status'] = 1;
            $response['list'] = $list;
            $response['message'] = 'Sentences returned Successfully';
        }

    }else{
        $response['status'] = 0;
        $response['message'] = 'Invalid Request';
    }

}else{
    $response['status'] = 0;
    $response['message'] = 'Required fields are missing';
}
 
echo json_encode($response);

?>