<?php
session_start();


require("php_lib/db_info.php");
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
                <button id="addobj">新增物品物品</button>
            </div>
            <div class="left">
               <form class="ui-filterable">
                <input id="myFilter" data-type="search">
            </form>
            <ul data-role="listview" data-filter="true" data-input="#myFilter" >
                <?php

                foreach($db->query("select * from tb_objinfo INNER JOIN tb_objgroup
ON tb_objgroup.Ogid = tb_objinfo.Ogid  ORDER BY OGname ASC,OGname ASC,Oclass Asc") as $row){
                    $Ostate = "";
                    switch($row['Ostate']){
                        case "1":
                            $Ostate = "<span style='color:green'>空閑中</span>";
                            break;
                        case "2":
                            $Ostate = "<span style='color:blue'>使用中</span>";
                            break;
                        case "3":
                            $Ostate = "<span style='color:gray'>已報修</span>";
                        case "4":
                            $Ostate = "<span style='color:red'>維修中</span>";
                            break;
                        case "5":
                            $Ostate = "<span style='color:red'>等待同意中</span>";
                            break;
                    }
                    print('<li id="obj'.$row['Oid'].'" class="list_obj">
                        <div id="objclass'.$row['Oid'].'name" class="obj_name">
                        '.$row['OGname'].'  
                        </div>
                        <div id="objclass'.$row['Oid'].'stat" class="obj_state">
                        空閑中
                        </div>
                        <div id="obj'.$row['Oid'].'name" class="obj_name">
                        '.$row['Oname'].'  
                        </div>
                        <div id="objclass'.$row['Oid'].'stat" class="obj_state">
                        '.$Ostate.'
                        </div>
                        ');
                    if($row['Ostate']==5){

                        $sql1 = "select MAX(Hid) from tb_history where Oid like '".$row['Oid']."'";


                        $e1 = $db->query($sql1);
                        $row1 = $e1->fetch(PDO::FETCH_ASSOC);

                        print('<div id="obj'.$row1['MAX(Hid)'].'bro" class="objbtn" onclick="acept_order('.$row1['MAX(Hid)'].','.$_SESSION['Mid'].','.$row['Oid'].')">
                                        同意租借
                                    </div>');
                    }


                    print('<div id="obj'.$row['Oid'].'bro" class="objbtn" onclick="change(\''.$row['Oid'].'\')">
                                        修改
                                    </div>

                            
                                ');

                        print('   </li>');
                }  

                  
                ?>
                </ul>
            </div>
        </div>
    </body>
    <script type="text" id="form-modal">
        <div class="popup-wrapper" style="min-width: 400px;">
            <div class="popup-header"></div>
            
            <div class="popup-content">
            <form actio="post" id="change_obj">
                <div class="form-group">
                    <input placeholder="物件名稱" name="Oname" id="Oname"  required/>
                </div>
                <div class="form-group">
                    <select id="Ostate" name="Ostate" required >
                        <option value="0">物件狀態</option>
                        <option value="1">空間中</option>
                        <option value="2">使用中</option>
                        <option value="3">已報修</option>
                        <option value="4">維修中</option>
                        <option value="5">被預約</option>
                    </select>
                </div>
                <div class="form-group">
                    <input type='date' placeholder="購買時間" name="Buytime" id="Buytime" required/>
                </div>
                <div class="form-group">
                    <input type='date' placeholder="淘汰時間" name="Endtime" id="Endtime" />
                </div>
                <div class="form-group">
                    <select id="Oclass" name="Oclass" required >
                        <option value="0">物件類別</option>
                        <option value="1">電腦</option>
                        <option value="2">教室</option>
                        <option value="3">筆電</option>
                        <option value="4">其他</option>
                    </select>
                </div>
                 <div class="form-group">
                    <select id="Ogroup" name="Ogroup" required >
                        <option value="0">電腦群組</option>
                    </select>
                </div>
               </form>
                <div class="form-group">
                    <button class="btn-danger ok" id="send" style="width: 45%;">修改</button>
                    <button class="btn-success cancel" style="width: 45%;">取消</button>

                </div>
                
            </div>
        </div>
    </script>

    <script src="js/popnotif.js"></script>
    <script src="js/timodal.min.js" charset="utf-8"></script>

  
    <script>
        var username = "<?php echo $_SESSION['name'];  ?>";
        var userid = "<?php echo $_SESSION['Mid'] ?>";
    </script>
    <script src="js/talkroom.js"></script>
    <script>
        $('#addobj').click(function(){
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
             $.get("Ajax/Php_pro/get_objgroup.php",function(data){
                 $('#Ogroup').append(data);
             });
               $('#send').click(function(){
                    
                    if(!$('#Buytime').val()){
                      alert("請填寫購買時間");  
                    }else{
                         var post = $('#change_obj').serializeArray();
                          
                          console.log(post);  $.post("Ajax/Php_pro/add_objinfo_for_setting.php",post).done(function(data){
                                console.log(data);
                                   // alert(data);
                                    
                                    alert("新增成功");
                                tiModal.close();
                              location.reload();
                            });
                            console.log(post);
                    }
                    
                    
                   
                });
        });
        function change(a) {
            $.post("Ajax/Php_pro/get_objinfo_for_setting.php", {
                "Oid": a
            }).done(function (data) {
                console.log(data);
                var html = $('#form-modal').html();
                var temp = data.split('@');

                tiModal.create(html, {
                    events: {
                        'click .cancel': function (e) {
                            //this.close();
                            this.close();
                        },
                        
                    },
                    modal: true
                }).show();

                const toast = new siiimpleToast();
                $('.popup-header').html(temp[0]);
                $('#Oname').val(temp[0]);
                $('#Ostate').val(temp[1]);
                $('#Buytime').val(temp[2]);
                $('#Endtime').val(temp[3]);
               // alert(temp[4]);
                $('#Oclass').val(temp[4]);
                
                $('#send').click(function(){
                    
                    if(!$('#Buytime').val()){
                      toast.alert("請填寫購買時間");  
                    }else{
                         var post = $('#change_obj').serializeArray();
                            post.push({name:"Oid",value:a});
                            $.post("Ajax/Php_pro/set_objinfo_for_setting.php",post).done(function(data){
                                //console.log(data);
                                    //alert(data);
                                    
                                    toast.alert("修改成功");
                                    tiModal.close();
                                    location.reload();
                            });
                            console.log(post);
                    }
                    
                    
                   
                });
            });

        }

        function acept_order(a, b, c) {
            $.post("Ajax/Php_pro/acept_order.php", {
                "data": a,
                "data1": b,
                "data2": c
            }).done(function (data) {
                console.log(data);
                if (data.indexOf('error') < 0) {
                    var a = data.split(':');
                    ws.send('{"type":"say","room_id":"1","to_client_id":"all","to_client_name":"' + a[1] + '","content":"acept@' + a[2] + '@' + a[3] + '"}');
                    const toast = new siiimpleToast();
                    toast.alert("已完成同意");
                    // $('#obj' + a + 'bro').remove();
                    location.reload();
                }
            });
        }
    </script>

    </html>