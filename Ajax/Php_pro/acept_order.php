<?php

$Hid = $_POST['data'];
$Mid = $_POST['data1'];
$Oid = $_POST['data2'];





    require_once('../../php_lib/db_info.php');
        $sql = "Update tb_history set acept = ".$Mid." where Hid = '".$Hid."';";

        
        $e = $db->exec($sql);
        $sql = "Update tb_objinfo set Ostate = 2 where Oid = '".$Oid."';";

        
        $e = $db->exec($sql);
        $e = $db->query("select Oname from tb_objinfo where Oid = '".$Oid."'");
        $r = $e->fetch(PDO::FETCH_ASSOC);
        $e1 = $db->query("select * from tb_history where Hid = '".Hid."'");
        $r1 = $e1->fetch(PDO::FETCH_ASSOC);
        
if($e){
    echo 'suess:'.$Mid.":".$r['Oname'].":".$r1['Mid'];
}else{
    echo 'error';
}

?>