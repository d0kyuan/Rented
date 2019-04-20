<?php
$Oid = $_POST['Oid'];
$Mid = $_POST['Mid'];
$Hid = $_POST['Hid'];
date_default_timezone_set("Asia/Taipei");
$nowtime =date("Y-m-d h:i:s");


require_once('../../php_lib/db_info.php');
$sql = "Update tb_history set isreturn = '1',re_mem='$Mid',Stime='$nowtime' where Hid = '".$Hid."' AND Oid = '".$Oid."';";
$e = $db->exec($sql);
$sql = "Update tb_objinfo set Ostate = '1' where  Oid = '".$Oid."';";
$e = $db->exec($sql);
if($e){
    echo "suc@".$nowtime."@" .base64_encode($Oid);
}else{
    echo "error";
}





?>