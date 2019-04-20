
<?php
//$a = $_GET['test'];
//get_fa($a);
//function get_fa($a){
//    require("db_info.php");
//    $count = 0;
//    $new_array = array();
// date_default_timezone_set("Asia/Taipei");
//    $nowtime =date("Y-m-d");
//      $date = new DateTime($nowtime);
//         $date->modify('-30 day');
//        $d1 = $date->format('Y-m-d');
//   # echo "select * from tb_history INNER JOIN tb_member ON tb_history.Mid = tb_member.Mid INNER JOIN  tb_objinfo ON tb_objinfo.Oid = tb_history.Oid where tb_history.Mid = ".$a." and  tb_history.isreturn = 0";
//    foreach($db->query("select * from tb_history INNER JOIN tb_member ON tb_history.Mid = tb_member.Mid INNER JOIN  tb_objinfo ON tb_objinfo.Oid = tb_history.Oid where tb_history.Mid = ".$a." ") as $row){
//        if($row['Stime']<=$nowtime&&$row['Stime']>$d1){
//           $new_array[$row['Oid']] +=1;
//        }
//        
//    }
//    $temp = 0;
//    $tempv = 0;
// 
//   arsort($new_array);
//    //print_r($new_array);
//    $allKeys = array_keys($new_array);
//   $e= $db->query('select * from tb_objinfo  where Oid = '.$allKeys[0]);
//
//
//
//    $row = $e->fetch(PDO::FETCH_ASSOC);
//    if($row['Ostate']=="1"){
//        $_SESSION['ask'] = 1;
//        print('
//        <script>
//        if(confirm("您是否要借用'.$row['Oname'].'")){
//            location.href="http://120.96.63.168/Rented/show_rented_info.php?data='.base64_encode($allKeys[0]).'"
//        }
//        
//       
//        ');
//          $e= $db->query('select * from tb_objinfo  where Oid = '.$allKeys[1]);
//
//
//
//        $row = $e->fetch(PDO::FETCH_ASSOC);
//        if($row['Ostate']=="1"){
//            print('
//                else if(confirm("您是否要借用'.$row['Oname'].'")){
//                    location.href="http://120.96.63.168/Rented/show_rented_info.php?            data='.base64_encode($allKeys[1]).'"
//            }
//            ');
//                  
//       $e= $db->query('select * from tb_objinfo  where Oid = '.$allKeys[2]);
//
//
//
//    $row = $e->fetch(PDO::FETCH_ASSOC);
//    if($row['Ostate']=="1"){
//        print('
//            else if(confirm("您是否要借用'.$row['Oname'].'")){
//                location.href="http://120.96.63.168/Rented/show_rented_info.php?            data='.base64_encode($allKeys[2]).'"
//        }
//        ');
//    }
//        
//        }
//    }
//  
//        
//        
//  
//            
//            
//            
//    print('</script>');
     
//}


?>