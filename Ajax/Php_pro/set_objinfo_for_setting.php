<?php
$Oid = $_REQUEST['Oid'];
$Oname = $_REQUEST['Oname'];
$Ostate = $_REQUEST['Ostate'];
$OBuytime = $_REQUEST['Buytime'];
$OEndtime = $_REQUEST['Endtime'];
$Oclass = $_REQUEST['Oclass'];

 require_once('../../php_lib/db_info.php');
if($Ostate=="1"){
    $sql  = "select isreturn,Hid from tb_history where Oid =  ".$Oid." Order by Hid Desc";
    $e = $db->query($sql);
    $r = $e->fetch(PDO::FETCH_ASSOC);
    print($r['isreturn']);
    if($r['isreturn']=="0"){
        $sql1 = "Update tb_history set isreturn = 1 where Oid = '".$row['Hid']."';";

        $e1 = $db->exec($sql1);
    }
}
if(!isset($OEndtime)){
    $sql = "Update tb_objinfo set Oname = '".$Oname."',Ostate = '".$Ostate."',Obuytime = '".$OBuytime."',Oendtime = '".$OEndtime."',Oclass='".$Oclass."' where Oid = '".$Oid."';";
}else{
    $sql = "Update tb_objinfo set Oname = '".$Oname."',Ostate = '".$Ostate."',Obuytime = '".$OBuytime."',Oclass='".$Oclass."' where Oid = '".$Oid."';";
}

// echo $sql;

$e = $db->exec($sql);

if($e){
    echo "suc";
}else{
    print_r( $db->errorInfo());
    echo "error";
}



?>