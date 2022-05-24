<?php 
require_once('../connect/connect.php');
extract($_POST);

$query = $conn->query("INSERT INTO `poblacion` (`complete_name`,`id_card`,`birthdate`,`gender`,`department`,`sidewalk`) VALUE ('{$complete_name}','{$id_card}','{$birthdate}','{$gender}','{$department}','{$sidewalk}')");
if($query){
    $resp['status'] = 'success';
}else{
    $resp['status'] = 'failed';
    $resp['msg'] = 'An error occured while saving the data. Error: '.$conn->error;
}

echo json_encode($resp);