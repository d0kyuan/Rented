<?php

$mid = $_POST['Mid'];
$token =  $_POST['Token'];
require_once('../../php_lib/db_info.php');
$sql = "Update tb_objinfo set Oname = '$Oname',Ostate = '$Ostate',Obuytime = '$OBuytime',Oendtime='$OEndtime',Oclass='$Oclass' where Oid = '".$Oid."';";
#echo $sql;

$e = $db->exec($sql);

?>