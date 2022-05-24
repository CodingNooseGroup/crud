<?php 
require_once('../connect/connect.php');
extract($_POST);

$query = $conn->query("INSERT INTO `usuarios` (`username`,`created_at`,`rol_id`) VALUE ('{$username}','{$created_at}','{$rol_id}')");
if($query){
    $resp['status'] = 'success';
}else{
    $resp['status'] = 'failed';
    $resp['msg'] = 'An error occured while saving the data. Error: '.$conn->error;
}

echo json_encode($resp);