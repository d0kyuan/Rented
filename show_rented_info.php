<?php

session_start();



$_SESSION['room_id'] = "1";


?>
<!DOCTYPE html>
<html>

    <head>
        <meta charset="UTF-8">
        <title>設備使用狀況</title>
         <link rel="stylesheet" type="text/css" href="./css/main.css">
        <link rel="stylesheet" type="text/css" href="./css/style.css">
        <link rel="stylesheet" type="text/css" href="./css/list.css">
         <script src="js/jquery-3.2.1.min.js"></script>
    </head>

    <body>
     <script>var username = "<?php echo $_SESSION['name'];  ?>";var userid = "<?php echo $_SESSION['Mid'] ?>";</script>
       <script src="js/talkroom.js"></script>
        <div class="header">

            <?php
            
            
            require('php_lib/db_info.php');


            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $objid = $_SESSION['objid'];
                
                $sql = "select * from tb_objinfo where Oid = ".base64_decode( $_SESSION['objid']);
                $e = $db->query($sql);
                if($e){
                    $row = $e->fetch(PDO::FETCH_ASSOC);
                    if($row['Ostate']!="1"){
                        print('<script>alert("抱歉已經被搶先一步了 !");location.href="uselist.php"</script>');
                    }
                }else{
                    print('<script>alert("發生錯誤...請稍後再嘗試 !");location.href="uselist.php"</script>');
                }
                
                date_default_timezone_set("Asia/Taipei");
                $nowtime =date("Y-m-d H:i:s");
                
                $browser = get_browser(null, true);
                $info1 =  $browser['platform'];
                $info2 =  $browser['browser']; 
                if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                    $ip = $_SERVER['HTTP_CLIENT_IP'];
                } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                } else {
                    $ip = $_SERVER['REMOTE_ADDR'];
                }
                
                $details = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));
                $country = $details->country;
                $city = $details->city;
                 $sql =sprintf("INSERT INTO tb_history(Mid,Oid,Ftime,isreturn,platform,browser,ip,city,country) value('%s','%s','%s',%s,'%s','%s','%s','%s','%s')", $_SESSION['Mid'],base64_decode( $_SESSION['objid']),$nowtime,0,$info1,$info2,$ip,$city,$country);
                #echo $sql;
                $result = $db->exec($sql);   
                $id = $db->lastInsertId();
                if($result){
                     $sql = "UPDATE tb_objinfo SET Ostate = 5 WHERE Oid like ".base64_decode( $_SESSION['objid']);
                    
                    #echo $sql;
                    $result = $db->exec($sql);
                    print('<script>if(ws.readyState === 1){ws.send(\'{"type":"say","to_client_id":"all","room_id":"1","content":"order@obj'.base64_decode( $_SESSION['objid']).'"}\');show(\''.$id.'\');}else{setTimeout(function () {ws.send(\'{"type":"say","room_id":"1","to_client_id":"all","content":"order@obj'.base64_decode( $_SESSION['objid']).'"}\');show(\''.$id.'\');},1000);};</script>');
                    print('<script></script>');
              

                }else{
                    echo $result;
                }

            }else{
                $objid = $_GET['data'];
                $_SESSION['objid'] = $objid;
            }


            
            
     print('<div class="gobackbtn" onclick="location.href=\'rented.php?data='.$objid.'\'">返回</div>');
            if($_SESSION['islogin']){
                print('<div class="welcom title_word">歡迎使用者 : '.$_SESSION['name'].'<span onclick="location.href=\'logout.php\'">登出</span></div>');
            }else{
                 print('<div class="loginbtn title_word" onclick="location.href=\''.$_SERVER['HTTP_REFERER'].'\'">登入</div>');
            }

        ?>
        </div>
        <div class="center">
            <div class="right">
            </div>
            <div class="left">
                <form action="" method="POST">

                    <?php
                    $a = 0;
                    if(base64_decode($objid)){$a = base64_decode($objid);} 
    else{ $a = 0;echo ('<script>alert("請勿隨意嘗試手動輸入url");//location.href="uselist.php"</script>');}
                $sql = "select * from tb_objinfo where Oid like '".$a."';";
                $e = $db->query($sql);
                $r = $e->fetch(PDO::FETCH_ASSOC);
                $classname="";
                switch($r['Oclass']){
                    case "1":
                        $classname = "電腦";
                        break;
                    case "2":
                         $classname = "教室";
                        break;
                    case "3":
                         $classname = "筆電";
                        break;
                    case "4":
                         $classname = "其他設備";
                        break;
                }
                print('
                <p>設備名稱：'.$r['Oname'].'</p>
                <p>設備類別：'.$classname.'</p>
                <p>最長租借時間：1天</p>

                <input type="submit" value="確認租借"/>
                ');

            ?>

                </form>
            </div>
        </div>
    </body>
    <script src="js/timodal.min.js" charset="utf-8"></script>
    <script type="text" id="form-modal1">
            <div class="popup-wrapper" style="min-width: 400px;">
                <div class="popup-header">公告</div>

                <div class="popup-content">
                    <form actio="post" id="change_obj">
                        <div class="form-group">
                            <div id="qrcode">
                            </div>
                        </div>
                        <div class="form-group">
                            
                        </div>

                    </form>
                    <div class="form-group">
                        <button class="btn-danger cancel" id="send"  style="width: 45%;">關閉</button>
                    </div>

                </div>
            </div>
        </script>
    <script src="js/qrcode.min.js"></script>
    <script  type="text/javascript">
    function show(a){
        var html = $('#form-modal1').html();
         tiModal.create(html, {
            events: {
                'click .cancel': function (e) {
                    //this.close();
                    //this.close();
                },

            },
            modal: true
        }).show();
        console.log("http://120.96.63.168/Rented/show_detail.php?id="+a);
        new QRCode(document.getElementById("qrcode"), "http://120.96.63.168/Rented/show_detail.php?id="+a);

        $('#send').click(function(){
            if(confirm("請記得保存此qrcode並隨時追蹤進度,請問確定要離開了嗎")){
                location.href="./";
            }
        });
    }
    
    </script>

</html>