<?php

session_start();

$ObjId = $_GET['data'];

#echo base64_decode($ObjId);
require("php_lib/db_info.php");



$showstr = "";
$showstr2 = "";
$ObjHistCounter = 0;
$isreturn = 1;
$a  = 0;

    if(base64_decode($ObjId)){$a = base64_decode($ObjId);} 
    else{ $a = 0;echo ('<script>alert("請勿隨意嘗試手動輸入url");location.href="uselist.php"</script>');}
    $temp  = $db->query("select * from tb_history INNER JOIN tb_member ON tb_history.Mid = tb_member.Mid INNER JOIN  tb_objinfo ON tb_objinfo.Oid = tb_history.Oid  where tb_objinfo.Oid = ".$a."  order by Ftime desc") ;
    // print("select * from tb_history INNER JOIN tb_member ON tb_history.Mid = tb_member.Mid INNER JOIN  tb_objinfo ON tb_objinfo.Oid = tb_history.Oid  where tb_objinfo.Oid = ".$a."  order by Ftime desc");
    if ($temp->fetchColumn() > 0) {
    foreach($temp as $row){
#print_r($row);

    $ObjHistCounter++;
    $OGstat = "";
    $str2 = "";
    $date = new DateTime($row['Ftime']);
#@echo "isreturn ".$row['isreturn'];
    $isreturn=$row['isreturn'];
                    switch($row['isreturn']){
                        case "0":
                            $OGstat = "借用中";
                            $date->modify('+7 day');
                            $Date2 = $date->format('Y-m-d');
                            $str2 = '<div id="obj'.$row['Oid'].'name" class="obj_name">最晚歸還時間：'.$Date2.'</div></div>';
                            break;
                        case "1":
                            $OGstat = "已歸還";
                            $str2 = '<div id="obj'.$row['Oid'].'name" class="obj_name">歸還時間：'.$row['Stime'].'</div></div>';
                            break;
                    }
                   $showstr.='
                    <div id="obj'.$row['Oid'].'" class="list_obj">
                        <div id="objclass'.$row['Oid'].'name" class="obj_name">
                        '.$row['MemName'].'  
                        </div>
                        <div id="objclass'.$row['Oid'].'stat" class="obj_state">
                        '.$OGstat.'
                        </div>
                        <div id="obj'.$row['Oid'].'name" class="obj_name">借用時間：
                        '.$row['Ftime'].'  
                        </div>
                    </div>
                    ';


                }
            }else{
                $showstr.='<div id="obj" class="list_obj">目前尚無借用紀錄</div>';
            }

   


    // if($ObjHistCounter==0){
       
    // }

    #check last user is return 
 

	#echo $isreturn;
    switch($isreturn){
            case 0:
                 $showstr2 ='<div id="obj'.base64_decode($ObjId).'showtxt" class="selection">使用中！</div>';

                break;
            case 1:
                     $showstr2='<div id="obj'.base64_decode($ObjId).'showtxt" class="selection" onclick="location.href=\'show_rented_info.php?data='.$ObjId.'\'">確認租借</div>';
            break;
    }



?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>設備使用狀況</title>
    <link rel="stylesheet" type="text/css" href="./css/main.css">
    <link rel="stylesheet" type="text/css" href="./css/list.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>

<body>
    <div class="header">
      
        <?php
            print('  <div class="gobackbtn" onclick="location.href=\'uselist.php\'">返回</div>');
            if($_SESSION['islogin']){
                print('<div class="welcom title_word">歡迎使用者 : '.$_SESSION['name'].'<span onclick="location.href=\'logout.php\'">登出</span></div>');
            }else{
                 print('<div class="loginbtn title_word" onclick="location.href=\'login.php\'">登入</div>');
            }

        ?>
    </div>
    <div class="center">
        <div class="right">
        <?php
            echo  $showstr2;
            
        ?>
        </div>
        <div class="left">
            <?php
            
            echo $showstr;
        
            
            ?>
        </div>
    </div>
</body>
<script>var username = "<?php echo $_SESSION['name'];  ?>";var userid = "<?php echo $_SESSION['Mid'] ?>";</script>
       <script src="js/talkroom.js"></script>
</html>
