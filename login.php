<?php
session_start();
header("Content-Type:text/html; charset=utf-8");


    if($_SESSION['islogin']==null && $_SESSION['islogin'] == false){
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        print('<script>document.write("登入中...請稍候....");</script>');
        
   
        require_once('./php_lib/db_info.php');
        $sql = "select count(*) from tb_member where MemAc like '".$_POST['ac']."'";


        $e = $db->query($sql);
        if($e){
            $row = $e->fetch(PDO::FETCH_ASSOC);
        }else{
            die('<script>alert("很抱歉發生錯誤...請稍候登入....");location.href="./"</script>');
        }
        
        if($row){
            if($row['count(*)']<1){
            print('<script>alert("無此帳號");</script>');
            sleep(2);
            print('<script>location.href="";</script>');
        }else{
             $sql = "select * from tb_member where MemAc like '".$_POST['ac']."'";


            $e = $db->query($sql);
            $row = $e->fetch(PDO::FETCH_ASSOC); 
            if($row['MemPsw']==md5($_POST['psw'])){
                $pre = decbin($row['Memper']);
                $temp = "";
                if(strlen($pre)<8){
                    $pre1 = str_pad($pre,8,'0',STR_PAD_LEFT);
                }else{
                   $pre1 = $pre; 
                }
                if(substr($pre1,0,1)=="1"){
                    print('<script>alert("登入成功...即將自動轉頁....");</script>');
                    sleep(3);
                    $_SESSION['Mid'] = $row['Mid'];
                    $_SESSION['account'] = $_POST['ac'];
                    $_SESSION['password'] = $_POST['psw'];
                    $_SESSION['pre'] = $pre1;
                    $_SESSION['name'] = $row['MemName'];
                    $_SESSION['islogin'] = true;
                
                    print('<script>location.href="'.$_SESSION['from'].'";</script>');
                }else{
                      print('<script>alert("很抱歉您的帳號目前無法登入!");</script>');
                        print('<script>location.href="'.$_SESSION['from'].'";</script>');
                }
                
            
            }else{
                
                print('<script>alert("密碼錯誤！");</script>');
                sleep(2);
                print('<script>location.href="";</script>');
            }
        }
        }else{
            echo "<script>alert('發生錯誤');location.href='./'";
        }
        
    }else{
        $_SESSION['from'] = $_SERVER['HTTP_REFERER'];
    }
    
}else{
    print('<script>document.write("");alert("您已經登入過了");location.href="./index.php"</script>');
}


#print('<script>alert("'.$_SERVER['REQUEST_METHOD'].'");</script>');

?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="UTF-8">
        <title>登入</title>
        <link type="text/css" rel="stylesheet" href="./css/login.css">
      

        <script src="js/jquery-3.2.1.min.js"></script>
        <script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
        <link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">

        <script>
            var onloadCallback = function () {
                login_test = grecaptcha.render('html_element', {
                    'sitekey': '6Lf6IyETAAAAAAUu955FyJcNB314srUS68pAfgL-'
                });
            };
        </script>
    </head>

    <body>
        <div data-role="page">
            <div data-role="main" class="ui-content">

                <form id="send_out" action="" method="POST" data-ajax="true">

                    <div class="group">
                        <input id="ac" name="ac" onkeyup="if(this.value.match(/[^A-z0-9 \u4e00-\u9fa5０-９　]/)){showAndroidToast('不接受特殊符號!');this.value=this.value.replace(/[^A-z0-9 \u4e00-\u9fa5０-９　]/g,'')}" required>
                        <span class="highlight"></span>
                        <span class="bar"></span>
                        <label>帳號</label>
                    </div>
                    <div class="group">
                        <input id="psw" name="psw" type="password" onkeyup="if(this.value.match(/[^A-z0-9 \u4e00-\u9fa5０-９　]/)){showAndroidToast('不接受特殊符號!');this.value=this.value.replace(/[^A-z0-9 \u4e00-\u9fa5０-９　]/g,'')}" required>
                        <span class="highlight"></span>
                        <span class="bar"></span>
                        <label>密碼</label>
                    </div>
                    <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>
                    <div id="html_element"></div>
                    <div class="group">
                        <button type="submit">送出</button>
                    </div>
                </form>
            </div>
        </div>
        <script>
            $('#send_out').submit(function () {
                var user_account = $('#ac').val();
                var user_password = $('#psw').val();
                var test_resp = grecaptcha.getResponse(login_test);
//                if (test_resp == "") {
//                    alert("請先驗證");
//                    document.getElementById('html_element').focus();
//                    return false;
//                } else
                if (user_account == "") {
                    alert("帳號不得為空白");
                    document.getElementById('account').focus();
                    return false;
                } else if (user_password == "") {
                    alert("密碼不得為空白");
                    document.getElementById('password').focus();
                    return false;
                } else {
                    return true;
                }
                // return false to cancel form action
            });
        </script>
    </body>

    </html>