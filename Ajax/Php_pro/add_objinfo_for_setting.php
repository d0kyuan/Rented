<?php

$Oname = $_POST['Oname'];
$Ostate = $_POST['Ostate'];
$OBuytime = $_POST['Buytime'];
$OEndtime = $_POST['Endtime'];
$Oclass = $_POST['Oclass'];
$OGroup = $_POST['Ogroup'];
if(!isset($OEndtime)){
    $OEndtime = "null";
}
 require_once('../../php_lib/db_info.php');
$sql = "insert into tb_objinfo(Oname,Ostate,Obuytime,Oendtime,Oclass,OGid) values('$Oname','$Ostate','$OBuytime','$OEndtime','$Oclass','$OGroup')";
echo $sql;

$e = $db->exec($sql);
if($e){
    echo "suc";
}else{
    echo "error";
}


?>