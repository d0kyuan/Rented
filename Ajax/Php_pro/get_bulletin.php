<?php
$pre = $_POST['pre'];
require_once('../../php_lib/db_info.php');

$str = '';
if($pre == "1"){
    $str .= '<button id="bulletin_btn" style="float:right" class="btn-default">新增公告</button><br>';
}

$count = 0;

foreach($db->query("select * from tb_bulletin INNER JOIN tb_member on tb_member.Mid = tb_bulletin.Mid") as $row){
    $count++;
    $str .= '<div class="list_obj can_click" data="'.$row['Bid'].'">';
    $str.='<div class="obj_name">發佈人：'.$row['MemName'].'</div>'; 
    $str.='<div class="objcontent ">公告主旨：'.$row['Btitle'].'</div>'; 
    $str.='<div class="obj_time">時間：'.$row['Btime'].'</div>'; 
    $str.="</div>"; 
}
if($count==0){
    $str.='<div class="objcontent">暫無公告</div>';
}


echo $str;

?>