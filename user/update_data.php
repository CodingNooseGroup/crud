<?php 
require_once('../connect/connect.php');
extract($_POST);

$update = $conn->query("UPDATE `usuarios` set `username` = '{$username}', `created_at` = '{$created_at}',`rol_id` = '{$rol_id}' where id = '{$id}'");
if($update){
    $resp['status'] = 'success';
}else{
    $resp['status'] = 'failed';
    $resp['msg'] = 'An error occured while saving the data. Error: '.$conn->error;
}

echo json_encode($resp);