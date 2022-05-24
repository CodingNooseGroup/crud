<?php 
require_once('../connect/connect.php');
extract($_POST);

$update = $conn->query("UPDATE `poblacion` set `complete_name` = '{$complete_name}', `id_card` = '{$id_card}',`birthdate` = '{$birthdate}', `gender` = '{$gender}',`department` = '{$department}',`sidewalk` = '{$sidewalk}' where id = '{$id}'");
if($update){
    $resp['status'] = 'success';
}else{
    $resp['status'] = 'failed';
    $resp['msg'] = 'An error occured while saving the data. Error: '.$conn->error;
}

echo json_encode($resp);