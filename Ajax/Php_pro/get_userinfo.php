<?php

$id = $_REQUEST['id'];

 require_once('../../php_lib/db_info.php');

$e = $db->query("select * from tb_member where Mid = '".$id."'");
$row = $e->fetch(PDO::FETCH_ASSOC);

echo json_encode(array('name'=>$row['MemName'],'birth'=>$row['MemBirth'],'account'=>$row['MemAc'],'password'=>$row['MemPsw']));


?>