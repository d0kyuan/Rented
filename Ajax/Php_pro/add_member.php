<?php
require_once('../../php_lib/db_info.php');
$name = $_POST['name'];
$account  = $_POST['account'];
$password = md5($_POST['password']);


$sql = "insert into tb_member(MemAc,MemPsw,MemName) values('$account','$password','$name') ;";
$e = $db->exec($sql);
if($e){
    echo 'suc';
}else{
    echo 'error';
}


?>
