<?php
session_start();


if($_SESSION['islogin']==null || $_SESSION['islogin'] == false){
  
        print('<script>alert("權限不足!或是非法手段進入!");</script>');
        sleep(2);
       print('<script>location.href="'.$_SERVER['HTTP_REFERER'].'"</script>');
    
    
    
}else{
   
    require("php_lib/db_info.php");
     require("php_lib/update_per.php");
    update_per();
    if($_SESSION['pre'][7]=="0"){
        print('<script>alert("權限不足!或是非法手段進入!");</script>');
        sleep(2);
       print('<script>location.href="'.$_SERVER['HTTP_REFERER'].'"</script>');
    }
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
         $ar = array();
     
           foreach ($_POST as $key => $value){
                try {

                $tempa = explode("_",$key);
                $tempb = explode(":",$tempa[1]);
                 
                @$ar[$tempb[0]] = $tempb[1]+$ar[$tempb[0]];
                    

            } catch (Exception $e) {
                #echo 'Caught exception: ',  $e->getMessage(), "\n";
            }
           }
            
          foreach($ar as $k => $v){
                #echo "Mid : ".$k."per : ".bindec($v)."<br>";
                $db->exec("update tb_member set Memper = ".bindec($v)." where Mid = ".$k);
          }
    }
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
<style>
	.member_pre>lable{
		min-width:100px;
		max-width:100px;
	}
</style>
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
                  
                  <li class="selection" onclick="location.href='./index.php'">返回</li>
                </ul>
            </div>
            <div class="left">
               <form action="" method="POST">
           
                <?php
                    require_once('./php_lib/db_info.php');
                    
                    foreach($db->query("select * from tb_member") as $row){
                        $pre = decbin($row['Memper']);
                        $temp = "";
                        if(strlen($pre)<8){
                            $pre1 = str_pad($pre,8,'0',STR_PAD_LEFT);
                        }else{
                           $pre1 = $pre; 
                        }
                        $tempname = str_pad($row['MemName'],10);
                        print('<div class="member_pre">');
                        print('<lable><span>使用者名稱</span><span>'.$tempname.'</span></lable>');
                        if($pre1[0]=="1"){
                             print('<lable><span>登入</span><input type="checkbox" name = "group_'.$row['Mid'].':10000000" value="pre1" checked ></lable>');
                        }else{
                             print('<lable><span>登入</span><input type="checkbox" name = "group_'.$row['Mid'].':10000000" value="pre1"></lable>');
                        }
                        
                         if($pre1[1]=="1"){
                             print('<lable><span>租借紀錄(全)</span><input type="checkbox" name = "group_'.$row['Mid'].':1000000" value="pre2" checked></lable>');
                        }else{
                             print('<lable><span>租借紀錄(全)</span><input type="checkbox" name = "group_'.$row['Mid'].':1000000" value="pre2"></lable>');
                        }
                         if($pre1[2]=="1"){
                             print('<lable><span>查看報修</span><input type="checkbox" name = "group_'.$row['Mid'].':100000" value="pre3" checked></lable>');
                        }else{
                             print('<lable><span>查看報修</span><input type="checkbox" name = "group_'.$row['Mid'].':100000" value="pre3" ></lable>');
                        }
                         if($pre1[3]=="1"){
                             print('<lable><span>物品管理</span><input type="checkbox" name = "group_'.$row['Mid'].':10000" value="pre4" checked></lable>');
                        }else{
                             print('<lable><span>物品管理</span><input type="checkbox" name = "group_'.$row['Mid'].':10000"  value="pre4"></lable>');
                        }
                         if($pre1[4]=="1"){
                             print('<lable><span>新增公告</span><input type="checkbox" name = "group_'.$row['Mid'].':1000" value="pre5" checked></lable>');
                        }else{
                             print('<lable><span>新增公告</span><input type="checkbox" name = "group_'.$row['Mid'].':1000" value="pre5"></lable>');
                        }
                         if($pre1[5]=="1"){
                             print('<lable><span>設備租借</span><input type="checkbox" name = "group_'.$row['Mid'].':100"  value="pre6" checked></lable>');
                        }else{
                             print('<lable><span>設備租借</span><input type="checkbox" name = "group_'.$row['Mid'].':100" value="pre6" ></lable>');
                        }
                         if($pre1[6]=="1"){
                             print('<lable><span>其他物品租借</span><input type="checkbox" name = "group_'.$row['Mid'].':10" value="pre7" checked></lable>');
                        }else{
                             print('<lable><span>其他物品租借</span><input type="checkbox" name = "group_'.$row['Mid'].':10" value="pre7" ></lable>');
                        }
                         if($pre1[7]=="1"){
                             print('<lable><span>帳號管理</span><input type="checkbox" name = "group_'.$row['Mid'].':1" value="pre8" checked></lable>');
                        }else{
                             print('<lable><span>帳號管理</span><input type="checkbox" name = "group_'.$row['Mid'].':1"  value="pre8"></lable>');
                        }
                       
                         print('</div>');   
                    }
                
                
                
                ?>
                       <br>
                       <br>
                   <button id="send_btn" class="btn-default" type="submit"  >
                       修改
                   </button>
     			<button id="add_btn" class="btn-default" type="button"  >
                       Add
                   </button>
               </form>
            </div>

        </div>
        <div class="footer"></div>
    </body>
 <script type="text" id="form-modal">
        <div class="popup-wrapper" style="min-width: 400px;">
            <div class="popup-header"></div>
            
            <div class="popup-content">
            <form actio="post" id="change_obj">
		 <div class="form-group">
                    <input placeholder="Name" name="name" id="name"  required/>
                </div>
                <div class="form-group">
                    <input placeholder="Account" name="account" id="account"  required/>
                </div>
               <div class="form-group">
                    <input placeholder="Password" name="password" id="password"  required/>
                </div>
               </form>
                <div class="form-group">
                    <button class="btn-danger ok" id="send" style="width: 45%;">Add</button>
                    <button class="btn-success cancel" style="width: 45%;">取消</button>

                </div>
                
            </div>
        </div>
    </script>
   <script src="js/timodal.min.js" charset="utf-8"></script>
    <script>
	$('#add_btn').click(function(){
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
		$('#send').click(function(){
			var post = $('#change_obj').serializeArray();
			$.post("Ajax/Php_pro/add_member.php",post).done(function(data){
                                console.log(data);
                                    //alert(data);
                                    
                                   alert("新增成功");
                                tiModal.close();
				location.reload();
                            });
                            console.log(post);

		});
	});

 $('#send_btn').attr("disabled", true);
        $('input').change(function(){
     $('#send_btn').attr("disabled", false);
    });  
    </script>
    </html>
