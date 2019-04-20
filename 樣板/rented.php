<?php

session_start();





?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>設備使用狀況</title>
    <link rel="stylesheet" type="text/css" href="./css/main.css">
    <link rel="stylesheet" type="text/css" href="./css/list.css">
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
    </div>
</body>