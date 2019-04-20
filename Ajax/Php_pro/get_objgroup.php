<?php

require_once('../../php_lib/db_info.php');



$count = 0;

foreach($db->query("select * from tb_objgroup ") as $row){
    $count++;
    $str .= '<option value="'.$row['OGid'].'">'.$row['OGname'].'</option>';
   
}


echo $str;

?>