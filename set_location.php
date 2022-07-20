<?php

include_once dirname(__FILE__).'/operations.php';
$response=array(); 
if($_SERVER['REQUEST_METHOD']=='POST'){

    if(isset($_POST['patient_id']) and isset($_POST['lat']) and isset($_POST['lon'])){

        $db = new Operations();
        $result=$db->setPatientLocation($_POST['patient_id'],$_POST['lat'], $_POST['lon']);
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