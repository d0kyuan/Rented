<?php
$pre = $_POST['data'];
require_once('../../php_lib/db_info.php');

$e = $db->query("select * from tb_bulletin where Bid = ".$pre);
$row = $e->fetch(PDO::FETCH_ASSOC); 

echo $row['Btitle'].":".$row['Bcontent'];

?>