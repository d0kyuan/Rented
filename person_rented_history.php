<?php

session_start();

require("php_lib/check_per.php");
require("php_lib/update_per.php");
require("php_lib/db_info.php");

check_per($_SESSION['pre'],[5]);


#update_per();
?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="UTF-8">
        <title>設備使用狀況</title>
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
               foreach($db->query("select * from tb_history INNER JOIN tb_member ON tb_history.Mid = tb_member.Mid   INNER JOIN  tb_objinfo ON tb_objinfo.Oid = tb_history.Oid  where tb_history.Mid =".$_SESSION['Mid']." ORDER BY Hid desc ") as $row){
                  
    $ObjHistCounter++;
    $OGstat = "";
    $str2 = "";
    $date = new DateTime($row['Ftime']);
    $isreturn=$row['isreturn'];
                   $return_button = "";
                    switch($row['isreturn']){
                        case "0":
                            $OGstat = "借用中";
                            $date->modify('+1 day');
                            $Date2 = $date->format('Y-m-d');
                            $str2 = '<div id="obj'.$row['Oid'].'time" class="obj_time">最晚歸還：'.$Date2.'</div>';
                            $return_button = '</li>';
                            break;
                        case "1":
                            $time = "";
                            if(isset($row['Stime'])){
                                $time = $row['Stime'];
                            }else{
                                $time="無紀錄";
                            }
                            $OGstat = "已歸還";
                            $str2 = '<div id="obj'.$row['Oid'].'time" class="obj_time">歸還：'.$time.'</div>';
                            $return_button = "</li>";
                            break;
                    }
                   $showstr.='
                    <li id="obj'.$row['Oid'].'" class="list_obj">
                        <div id="objclass'.$row['Oid'].'name" class="obj_name">
                        '.$row['MemName'].'  
                        </div>
                        <div id="objclass'.$row['Oid'].'name" class="obj_name">
                        '.$row['Oname'].'  
                        </div>
                        <div id="objclass'.$row['Oid'].'stat" class="obj_state">
                        '.$OGstat.'
                        </div>
                        <div id="obj'.$row['Oid'].'name" class="obj_time">借用：
                        '.$row['Ftime'].'  
                        </div>
                        '.$str2.'
                       
                    ';
                   $sql1 = "select MemName  from tb_member where Mid like '".$row['acept']."'";


                    $e1 = $db->query($sql1);
                    $row1 = $e1->fetch(PDO::FETCH_ASSOC);
                   $showstr.=' <div id="obj'.$row['Oid'].'acept" class="obj_acept">
                        借用同意人員：'.$row1['MemName'].'
                        </div>';
                     $sql1 = "select MemName  from tb_member where Mid like '".$row['re_mem']."'";


                    $e1 = $db->query($sql1);
                    $row1 = $e1->fetch(PDO::FETCH_ASSOC);
                   $showstr.=' <div id="obj'.$row['Oid'].'acept" class="obj_acept">
                        協助歸還人員：'.$row1['MemName'].'
                        </div>';
                   $showstr .= $return_button ;

                }
    if($ObjHistCounter==0){
       $showstr.='<div id="obj" class="list_obj">目前尚無借用紀錄</div>';
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

        <script>
            function return_obj(a, b) {
               
                $.post("Ajax/Php_pro/return_obj.php", {
                        "Oid": a,
                        "Mid": userid,
                        "Hid": b
                    }).done(function (data) {
                            console.log(data);
                            if (data.indexOf('suc') > -1) {
                                var temp  = data.split('@');
            $('#obj'+a+'retrun').remove();
            $('#obj'+a+'time').html("歸還:"+temp[1]);
                                if (ws.readyState === 1) {
             
    ws.send('{"type":"say","to_client_id":"all","room_id":"1","content":"return@obj'+a+'@'+temp[2]+'"}');
                                        
                                   
                                    } else {
                                        setTimeout(function () {
    ws.send('{"type":"say","room_id":"1","to_client_id":"all","content":"return@obj'+a+'@'+temp[2]+'"}');
            
               
                                        },1000);
                                    }
                                            }
                                        });
                                    }
        </script>
    </body>

    </html>
