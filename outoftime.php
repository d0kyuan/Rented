<?php
session_start();

#if(@$_SESSION['islogin']==null || $_SESSION['islogin']  == false){
#   print('<script>document.write("您的權限不足或是非正常方式進入!");</script>');
#   sleep(2);
#   print('<script>location.href="./";</script>');
#}
require("php_lib/db_info.php");

?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="UTF-8">
        <title>設備使用狀況</title>
        <link rel="stylesheet" type="text/css" href="./css/main.css">
        <link rel="stylesheet" type="text/css" href="./css/list.css">
         <script src="js/jquery-3.2.1.min.js"></script>
    </head>

    <body>
        <div class="header">
            <div class="gobackbtn" onclick="location.href='./'">返回</div>
            <?php
        
                 
                if($_SESSION['islogin']){
                    print('<div class="welcom title_word">歡迎使用者 : '.$_SESSION['name'].'<span onclick="location.href=\'logout.php\'">登出</span></div>');
                }else{
                     print('<div class="loginbtn title_word" onclick="location.href=\'login.php\'">登入</div>');
                }
            
            ?>
        </div>
        <div class="center">
            <div class="right">
                <ul>

             
                </ul>
            </div>
            <div class="left">
                <?php
                    
                    
                require("php_lib/db_info.php");
    $count = 0;
     date_default_timezone_set("Asia/Taipei");
    $nowtime =date("Y-m-d H:i:s");
    $str = "";
   # echo "select * from tb_history INNER JOIN tb_member ON tb_history.Mid = tb_member.Mid INNER JOIN  tb_objinfo ON tb_objinfo.Oid = tb_history.Oid where tb_history.Mid = ".$a." and  tb_history.isreturn = 0";
    foreach($db->query("select * from tb_history INNER JOIN tb_member ON tb_history.Mid = tb_member.Mid INNER JOIN tb_objinfo ON tb_objinfo.Oid = tb_history.Oid where tb_history.isreturn = 0 and tb_history.acept IS NOT NULL") as $row){
        $count++;
        $temp  = $row['Ftime'];
        $nowdate = new DateTime($row['Ftime']);
        $date = new DateTime($row['Ftime']);
        $temp = explode(" ",$temp);
        $temp2 = explode("-",$temp[0]);
        $date->modify('+1 day');
        $Date2 = $date->format('Y-m-d H:i:s');
        #print($nowtime.":".$Date2);
        if($nowtime>$Date2){
            $str .= '<div class="list_obj">';
            $str.='<div class="obj_name">學生：'.$row['MemName'].'</div>'; 
            $str.='<div class="objcontent ">物品：'.$row['Oname'].'</div>'; 
            $str.='<div class="obj_time">最晚歸還日為：'.$Date2.'</div>'; 
            $str.="</div>"; 
            
        }
       
    }   
       print($str);              
                    
                ?>
            </div>

        </div>
        <div class="footer"></div>
         <script src="js/popnotif.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script>var username = "<?php echo $_SESSION['name'];  ?>";var userid = "<?php echo $_SESSION['Mid'] ?>";</script>
       <script src="js/talkroom.js"></script>
    </body>

    </html>