<?php

#$a all per  $b where per it need 
function check_per($a,$b){
    
    if($_SESSION['islogin']==null || $_SESSION['islogin'] == false){
         print('<script>alert("非正常手段進入或是權限不足")</script>');
         print('<script>location.href="./";</script>');
   
    }
    foreach($b as $val){
        if($a[$val]!="1"){
            print('<script>alert("權限不足")</script>');
             print('<script>location.href="./";</script>');
        }
        
    }
    

    
    
}





?>


