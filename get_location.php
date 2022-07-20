<?php

include_once dirname(__FILE__).'/operations.php';
$response=array(); 
if($_SERVER['REQUEST_METHOD']=='POST'){

    if(isset($_POST['patient_id'])){

        $db = new Operations();
                $patient = $db->getUserById($_POST['patient_id']);
                $response['status'] = 1;
                $response['message'] = 'Operation Successfully done';
                $response['lat']  = $patient['lat'];
                $response['lon']  = $patient['lon'];
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