<?php 
require_once("connect.php");
extract($_POST);

$totalCount = $conn->query("SELECT * FROM `usuarios` ")->num_rows;
$search_where = "";
if(!empty($search)){
    $search_where = " where ";
    $search_where .= " OR username LIKE '%{$search['value']}%' ";
    $search_where .= " OR created_at LIKE '%{$search['value']}%' ";
    $search_where .= " OR role_id LIKE '%{$search['value']}%' ";
}
$columns_arr = array("id",
                     "username",
                     "created_at",
                     "rol_id");
$query = $conn->query("SELECT * FROM `usuarios` {$search_where} ORDER BY {$columns_arr[$order[0]['column']]} {$order[0]['dir']} limit {$length} offset {$start} ");
$recordsFilterCount = $conn->query("SELECT * FROM `usuarios` {$search_where} ")->num_rows;

$recordsTotal= $totalCount;
$recordsFiltered= $recordsFilterCount;
$data = array();
$i= 1 + $start;
while($row = $query->fetch_assoc()){
    $row['no'] = $i++;
    $row['birthdate'] = date("F d, Y",strtotime($row['birthdate']));
    $data[] = $row;
}
echo json_encode(array('draw'=>$draw,
                       'recordsTotal'=>$recordsTotal,
                       'recordsFiltered'=>$recordsFiltered,
                       'data'=>$data
                       )
);
