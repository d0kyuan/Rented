<?php

function update_per(){
        require('db_info.php');
        #require('getnotif.php');
       $sql = "select * from tb_member where MemAc like '".$_SESSION['account']."'";


        $e = $db->query($sql);
        $row = $e->fetch(PDO::FETCH_ASSOC); 
        $pre = decbin($row['Memper']);
        $temp = "";
        if(strlen($pre)<8){
            $pre1 = str_pad($pre,8,'0',STR_PAD_LEFT);
        }else{
            $pre1 = $pre; 
        }
        $_SESSION['pre'] = $pre1;
    #echo $pre1;

    if($pre1[0]=="0"){
        $_SESSION['islogin'] = false;
        $_SESSION['account'] = null;
        $_SESSION['password'] = null;
        $_SESSION['pre'] = null;
        $_SESSION['name'] = null;
        print('<script>alert("很抱歉您的帳號目前無法登入!已經自動登出");</script>');
        print('<script>location.href="./";</script>');

    }
}


?>