<?php

  require_once('../../php_lib/db_info.php');
$Oid = $_POST['Oid'];

$e = $db->query("select * from tb_objinfo where Oid = '".$Oid."'");
$r = $e->fetch(PDO::FETCH_ASSOC);

echo $r['Oname']."@".$r['Ostate']."@".$r['Obuytime']."@".$r['Oendtime']."@".$r['Oclass'];


?>