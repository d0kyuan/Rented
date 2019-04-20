<?php
require_once('../../php_lib/db_info.php');
date_default_timezone_set("Asia/Taipei");
$nowtime =date("Y-m-d h:i:s");
$temp  = explode(':',$_REQUEST['obj']);

$Oid = $temp[0];
$Hid = $temp[1];

$Mid = $_REQUEST['Mid'];
$content = $_REQUEST['content'];

$sql = "update tb_objinfo set Ostate = 3 where Oid = ".$Oid." ;";
$e = $db->exec($sql);
$sql = "update tb_history set isreturn = 1,re_mem=0,Stime='".$nowtime."' where Hid = ".$Hid." ;";
$e = $db->exec($sql);

print($Hid.":");
print($sql);
$sql = "insert into tb_repayment(Mid,Oid,Rcontent,Rtime) values(".$Mid.",".$Oid.",'".$content."','".$nowtime."') ;";
print($sql);
$e = $db->exec($sql);
if($e){
    echo 'suc:'.$Oid;
}else{
    echo 'error';
}
?>