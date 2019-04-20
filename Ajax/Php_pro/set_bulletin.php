<?php
$Mid = $_POST['Mid'];
require_once('../../php_lib/db_info.php');
$content = $_POST['Bcontent'];
$title = $_POST['Btitle'];
date_default_timezone_set("Asia/Taipei");
$nowtime =date("Y-m-d h:i:s");
$content = strip_tags($content);

#echo $Mid;
$sql =sprintf("INSERT INTO tb_bulletin(Mid,Bcontent,Btitle,Btime) value(%s,'%s','%s','%s')", $Mid,$content,$title,$nowtime);
                #echo $sql;
$result = $db->exec($sql);    
if($result){
    echo 'suc';
}else{
    echo 'error';
}


?>