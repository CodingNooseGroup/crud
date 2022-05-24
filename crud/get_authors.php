<?php 
require_once("../connect/connect.php");
extract($_POST);

$totalCount = $conn->query("SELECT * FROM `poblacion` ")->num_rows;
$search_where = "";
if(!empty($search)){
    $search_where = " where ";
    $search_where .= " complete_name LIKE '%{$search['value']}%' ";
    $search_where .= " OR id_card LIKE '%{$search['value']}%' ";
    $search_where .= " OR date_format(birthdate,'%M %d, %Y') LIKE '%{$search['value']}%' ";
    $search_where .= " OR gender LIKE '%{$search['value']}%' ";
    $search_where .= " OR department LIKE '%{$search['value']}%' ";
    $search_where .= " OR sidewalk LIKE '%{$search['value']}%' ";
}
$columns_arr = array("id",
                     "complete_name",
                     "id_card",
                     "unix_timestamp(birthdate)",
                     "gender",
                     "department",
                     "sidewalk");
$query = $conn->query("SELECT * FROM `poblacion` {$search_where} ORDER BY {$columns_arr[$order[0]['column']]} {$order[0]['dir']} limit {$length} offset {$start} ");
$recordsFilterCount = $conn->query("SELECT * FROM `poblacion` {$search_where} ")->num_rows;

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
