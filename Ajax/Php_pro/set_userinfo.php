<?php
 require_once('../../php_lib/db_info.php');
$id=$_POST['id'];
$name = $_POST['name'];
$birth = $_POST['birth'];
$account = $_POST['account'];
$password = $_POST['password'];
$newpassword = $_POST['newpassword'];
$e = $db->query("select MemPsw from tb_member where Mid = ".$id."");
$row = $e->fetch(PDO::FETCH_ASSOC);

if($row['MemPsw']!=md5($password)){
    die(json_encode(array('static'=>'error','msg'=>'密碼錯誤')));
}else{
    if(isset($newpassword) && $newpassword !="" && $newpassword !="null"){
       $e =  $db->exec("update tb_member set MemName='".$name."',MemBirth='".$birth."',MemPsw='".md5($newpassword)."' where Mid = ".$id);
        
    }else{
        $e = $db->exec("update tb_member set MemName='".$name."',MemBirth='".$birth."' where Mid = ".$id);
    }
    if($e){
         die(json_encode(array('static'=>'suc','msg'=>'密碼錯誤')));
        }else{
               die(json_encode(array('static'=>'error','msg'=>$db->errorCode() )));
        }
}


?>