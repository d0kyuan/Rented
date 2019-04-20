<?php

function check_return($a){
    require("php_lib/db_info.php");
    $count = 0;
     date_default_timezone_set("Asia/Taipei");
    $nowtime =date("Y-m-d");
    print('<script>   const toast = new siiimpleToast();');
   # echo "select * from tb_history INNER JOIN tb_member ON tb_history.Mid = tb_member.Mid INNER JOIN  tb_objinfo ON tb_objinfo.Oid = tb_history.Oid where tb_history.Mid = ".$a." and  tb_history.isreturn = 0";
    foreach($db->query("select * from tb_history INNER JOIN tb_member ON tb_history.Mid = tb_member.Mid INNER JOIN  tb_objinfo ON tb_objinfo.Oid = tb_history.Oid where tb_history.Mid = ".$a." and  tb_history.isreturn = 0 and tb_history.acept IS NOT NULL") as $row){
        $count++;
        $temp  = $row['Ftime'];
        $date = new DateTime($row['Ftime']);
         $date->modify('+1 day');
        $Date2 = $date->format('Y-m-d');
        if($nowtime>$Date2){
            print('toast.success("逾期通知!'.$row['Oname'].'最晚歸還日為：'.$Date2.'");');
        }
    
    }
      print('
      
            
        
        </script>
        
        ');
}


?>