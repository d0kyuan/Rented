<?php
session_start();

if(@$_SESSION['islogin']!=null){
    $_SESSION['password'];
    $_SESSION['account'];
    $_SESSION['pre'];
    $_SESSION['name'];
    require_once("php_lib/update_per.php");
    update_per();
}else{
    $_SESSION['islogin']  = false;
}

?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="UTF-8">
        <title>租借網站</title>
        <link rel="stylesheet" type="text/css" href="./css/main.css">
        <link rel="stylesheet" type="text/css" href="./css/style.css">
        <link rel="stylesheet" type="text/css" href="./css/list.css">
        <script src="js/jquery-3.2.1.min.js"></script>

    </head>

    <body>
        <div class="header">
            <img src="" alt="" class="logo">
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
                    <?php 
                        $list_1 = '<li class="selection" onclick="location.href=\'uselist.php\'">設備使用狀況</li>';
                        $list_2 = '<li class="selection" onclick="location.href=\'add_Repayment.php\'">新增報修單</li>';
                        $list_3 = '<li class="selection" onclick="location.href=\'show_Repayment_history.php\'">報修單紀錄</li>';
                        #$list_4 = '<li class="selection">設備租借</li>';
                        $list_5 = '<li class="selection" onclick="location.href=\'rented_history.php\'">租借紀錄</li>';
                        $list_6 = '<li class="selection" onclick ="location.href=\'accountcontrol.php\'">帳號管理</li>';
                        $list_7 = '<li class="selection" onclick="location.href=\'person_rented_history.php\'">個人租借紀錄</li>';
                        $list_8 = '<li class="selection" onclick="location.href=\'objcontrol.php\'">物品管理</li>';
                    $list_10 = '<li class="selection" id="setting">設定</li>';
                    $list_9 = '<li class="selection" onclick="location.href=\'outoftime.php\'">逾時未還清單</li>';
                        if($_SESSION['islogin']){
                            print($list_1);
                             #租借權限
                            #if($_SESSION['pre'][1]=="1"){
                            if($_SESSION['pre'][5]=="1"||$_SESSION['pre'][6]=="1"){
                                #給予租借 租借紀錄 報修 全縣
                                print($list_2.$list_7);
                            }
                            if($_SESSION['pre'][1]=="1"){
                                #給予查看報修單權限
                                print($list_5);
                            }
                            #查看報修單紀錄權限
                            if($_SESSION['pre'][2]=="1"){
                                #給予查看報修單權限
                                print($list_3);
                            }
                            #物品管理權限
                            if($_SESSION['pre'][3]=="1"){
                               
                                print($list_8);
                            }
                            print($list_10);
                            print($list_9);
                            
                            #帳號管理權限
                            if($_SESSION['pre'][7]=="1"){
                                print($list_6);
                            }
                             
                        }else{
                            print($list_1.$list_9);
                           
                        }
                    ?>
                </ul>
            </div>
            <div id="bulletin" class="left">
                <h1 style=" text-align: center;">公告</h1>

            </div>

        </div>
        <div class="footer"></div>

        <script src="js/timodal.min.js" charset="utf-8"></script>
        <script type="text" id="form-modal">
            <div class="popup-wrapper" style="min-width: 400px;">
                <div class="popup-header">新增公告</div>

                <div class="popup-content">
                    <form actio="post" id="change_obj">
                        <div class="form-group">
                            <input type="text" placeholder="主旨" name="Btitle" id="Btitle" required>
                        </div>
                        <div class="form-group">
                            <textarea style="width:100%;min-height:300px;resize: none;" name="Bcontent" id="Bcontent" required></textarea>
                        </div>

                    </form>
                    <div class="form-group">
                        <button class="btn-danger ok" id="send" style="width: 45%;">送出</button>
                        <button class="btn-success cancel" style="width: 45%;">取消</button>

                    </div>

                </div>
            </div>
        </script>
        <script type="text" id="form-modal1">
            <div class="popup-wrapper" style="min-width: 400px;">
                <div class="popup-header">公告</div>

                <div class="popup-content">
                    <form actio="post" id="change_obj">
                        <div class="form-group">
                            <input type="text" placeholder="主旨" name="Btitle" id="Btitle">
                        </div>
                        <div class="form-group">
                            <textarea style="width:100%;min-height:300px;resize: none;" name="Bcontent" id="Bcontent"></textarea>
                        </div>

                    </form>
                    <div class="form-group">
                        <button class="btn-danger cancel" style="width: 45%;">關閉</button>


                    </div>

                </div>
            </div>
        </script>
        <script type="text" id="form-modal2">
            <div class="popup-wrapper" style="min-width: 400px;">
                <form id="ac">
                    <div class="popup-header">設定</div>

                    <div class="popup-content">
                        <form actio="post" id="change_obj">
                            <div class="form-group">
                                <input type="text" placeholder="姓名" name="name" id="name">
                            </div>
                            <div class="form-group">
                                <input type="date" placeholder="生日" name="birth" id="birth">
                            </div>
                            <div class="form-group">
                                <input type="text" placeholder="帳號" name="account" id="account" readonly>
                            </div>
                            <div class="form-group">
                                <input type="password" placeholder="密碼" name="password" id="password" required>
                            </div>
                            <div class="form-group">
                                <input type="password" placeholder="新密碼" name="newpassword" id="password">
                            </div>
                        </form>
                        <div class="form-group">
                            <button class="btn-danger cancel" style="width: 45%;">關閉</button>
                            <button class="btn-ok ok" id="send" style="width: 45%;">送出</button>

                        </div>

                    </div>
                </form>
            </div>
        </script>
        <script src="js/popnotif.js"></script>
        <?php
        
        require("php_lib/check_return.php");
        if(isset($_SESSION['Mid'])){
            check_return($_SESSION['Mid']); 
        }

        ?>
    </body>
    <script>
        var username = "<?php echo $_SESSION['name'];  ?>";
        var userid = "<?php echo $_SESSION['Mid'] ?>";
    </script>
    <script src="js/talkroom.js"></script>
    <script>
        $(document).ready(function () {


            var pre = "<?php echo  $_SESSION['pre'][4]; ?>";
            if (!pre) {
                pre = 0;
            }

            $('#setting').click(function () {
                var html = $('#form-modal2').html();


                tiModal.create(html, {
                    events: {
                        'click .cancel': function (e) {
                            //this.close();
                            this.close();
                        },

                    },
                    modal: true
                }).show();
                $.post('Ajax/Php_pro/get_userinfo.php', {
                    id: userid
                }).done(function (response) {

                    if (response instanceof Object)
                        var json = response;
                    else
                        var json = $.parseJSON(response);

                    $('#name').val(json['name']);
                    $('#number').val(json['number']);
                    $('#account').val(json['account']);
                    $( "#account" ).attr( "readonly", true );
                    $('#birth').val(json['birth']);
                    $( "#send" ).attr( "disabled", true );
                }, "json");
                $('#ac').bind("submit", function () {
                    //alert('123');
                    return false;
                });
                $('input').change(function(){
                    $( "#send" ).attr( "disabled", false );
                });
                $('#send').click(function () {
                    var a = $("#ac").serializeArray();
                    a.push({name:"id",value:userid});
                    console.log(a);
                    $.post('Ajax/Php_pro/set_userinfo.php', a).done(function (response) {
                        console.log(response);
                        if (response instanceof Object)
                            var json = response;
                        else
                            var json = $.parseJSON(response);
                        
                        if(json['static']=="suc"){
                            alert("成功...請重新登入");
                            tiModal.close();
                            location.href="logout.php";
                        }else{
                            alert(json['msg']);
                        }
                    });
                });
            });
            $.post("Ajax/Php_pro/get_bulletin.php", {
                "pre": pre
            }).done(function (data) {
                console.log(data);

                $('#bulletin').append(data);
                $('.list_obj').click(function () {

                    var list_num = $(this).attr('data');
                    $.post('Ajax/Php_pro/get_all_bulletin.php', {
                        "data": list_num
                    }).done(function (data) {
                        var bul = data.split(':');
                        var html = $('#form-modal1').html();


                        tiModal.create(html, {
                            events: {
                                'click .cancel': function (e) {
                                    //this.close();
                                    this.close();
                                },

                            },
                            modal: true
                        }).show();
                        $('#Btitle').val(bul[0]);
                        $('#Bcontent').val(bul[1]);
                    });
                });
                $('#bulletin_btn').click(function () {
                    var html = $('#form-modal').html();


                    tiModal.create(html, {
                        events: {
                            'click .cancel': function (e) {
                                //this.close();
                                this.close();
                            },

                        },
                        modal: true
                    }).show();
                    $('#send').click(function () {

                        if (!$('#Bcontent').val()) {
                            toast.alert("請填寫購買時間");
                        } else {

                            var post = $('#change_obj').serializeArray();
                            post.push({
                                name: "Mid",
                                value: userid
                            });
                            $.post("Ajax/Php_pro/set_bulletin.php", post).done(function (data) {
                                console.log(data);
                                //alert(data);

                                toast.alert("修改成功");



                                if (ws.readyState === 1) {

                                    ws.send('{"type":"say","to_client_id":"all","room_id":"1","content":"bulletin@"}');

                                    location.href = './';
                                } else {
                                    setTimeout(function () {
                                        ws.send('{"type":"say","room_id":"1","to_client_id":"all","content":"bulletin@"}');

                                        location.href = './';
                                    }, 1000);
                                }

                                tiModal.close();
                            });
                            console.log(post);
                        }



                    });

                });
            });
        });
    </script>

    </html>