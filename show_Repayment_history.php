<?php

session_start();

require("php_lib/check_per.php");
require("php_lib/update_per.php");
require("php_lib/db_info.php");
update_per();
check_per($_SESSION['pre'],[2]);



?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="UTF-8">
        <title>設備使用狀況</title>
                <link rel="stylesheet" type="text/css" href="./css/style.css">
        <link rel="stylesheet" type="text/css" href="./css/main.css">
        <link rel="stylesheet" type="text/css" href="./css/list.css">
                <script src="js/jquery-3.2.1.min.js"></script>
   <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
       <link rel="stylesheet" href="js/jquery.mobile.min.css">

    <script src="js/jquery.min.js"></script>
    <script src="js/jquery.mobile.min.js"></script>
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
            </div>
            <div class="left">
               <form class="ui-filterable">
                <input id="myFilter" data-type="search">
            </form>
            <ul data-role="listview" data-filter="true" data-input="#myFilter" >
                <?php
            $showstr = "";
$showstr2 = "";
$ObjHistCounter = 0;
$isreturn = 1;
               foreach($db->query("select * from tb_repayment inner join tb_objinfo on tb_repayment.Oid = tb_objinfo.Oid inner join tb_member on tb_member.Mid = tb_repayment.Mid ") as $row){
                  $temp = "";
                    $ObjHistCounter++;
                    if(!isset($row['Rcontent'])||$row['Rcontent']==""){
                        $temp = "無";
                    }else{
                        $temp = $row['Rcontent'];
                    }
                   $showstr.='
                    <li id="obj'.$row['Oid'].'" class="list_obj">
                        <div id="objclass'.$row['Rid'].'name" class="obj_name">
                        '.$row['Oname'].'  
                        </div>
                        <div id="objclass'.$row['Rid'].'name" class="obj_name">
                        '.$row['Rtime'].'  
                        </div>
                        <div id="objclass'.$row['Rid'].'stat" class="obj_time">
                        '.$temp.'
                        </div>
                        <div id="objclass'.$row['Rid'].'stat" class="obj_state">
                        '.$row['MemName'].'
                        </div>
                    </li>
                    ';
  

                }
    if($ObjHistCounter==0){
       $showstr.='<div id="obj" class="list_obj">目前報修紀錄</div>';
    }

    #check last user is return 



    
            echo $showstr;
            ?>
                </ul>
            </div>
        </div>

        <script src="js/popnotif.js"></script>
        <script src="js/timodal.min.js" charset="utf-8"></script>

        <script src="js/popnotif.js"></script>
        <script>
            var username = "<?php echo $_SESSION['name'];  ?>";
            var userid = "<?php echo $_SESSION['Mid'] ?>";
        </script>
        <script src="js/talkroom.js"></script>

        
    </body>

    </html>
