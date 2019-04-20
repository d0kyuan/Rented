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
    if($_SESSION['pre'][5]=="0"){
        print('<script>alert("權限不足!或是非法手段進入!");</script>');

       print('<script>location.href="'.$_SERVER['HTTP_REFERER'].'"</script>');
    }else{
        $obj_select_str = "<select id='obj' name='obj'>";
         $obj_select_str.='<option value="-1" >請選擇設備</option>';
        $temp_ar = array();
        foreach($db->query("select * from tb_history inner join tb_objinfo on tb_objinfo.Oid = tb_history.Oid  where tb_history.Mid = '".$_SESSION['Mid']."' and isreturn = 0 order by Hid desc") as $row){
            #print_r($temp_ar);
            if(!in_array($row['Oname'], $temp_ar)){
                array_push($temp_ar,$row['Oname']);
               $obj_select_str.='<option value="'.$row['Oid'].':'.$row['Hid'].'" >'.$row['Oname'].'</option>'; 
            }
           
        }
         $obj_select_str.='</select>';
        
        
    }
    
    
    
    
    
}



?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>設備使用狀況</title>
    <link rel="stylesheet" type="text/css" href="./css/main.css">
        <link rel="stylesheet" type="text/css" href="./css/style.css">
         <link rel="stylesheet" type="text/css" href="./css/list.css">
</head>

<body>
    <div class="header">
        <div class="gobackbtn" onclick="location.href='./'">返回</div>
       
    </div>
    <div class="center">
        <div class="right">
         
        </div>
        <div class="left" style="  text-align: center;">
           <form id="Repay" style="width:50%;margin: 0 auto; ">
                 <br>
              <?php
                echo $obj_select_str;
           
            
                ?>
                <br>
                <br>
                <p>說明：</p>
                
            <textarea name="content" style="width:50%;min-height:300px;resize: none;"></textarea> 
           </form>
           <br>
            <button id ="send"class='btn-default'>送出</button>
        </div>
    </div>
</body>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
 <script src="js/popnotif.js"></script>
    <script src="js/timodal.min.js" charset="utf-8"></script>

    <script src="js/popnotif.js"></script>
    <script>
        var username = "<?php echo $_SESSION['name'];  ?>";
        var userid = "<?php echo $_SESSION['Mid'] ?>";
    </script>
    <script src="js/talkroom.js"></script>
<script>
    $('#send').click(function(){
       var post = $('#Repay').serializeArray();
        post.push({name:"Mid",value:userid});
        $.post("Ajax/Php_pro/add_new_repay.php",post).done(function (data) {
                console.log(data);
                if (data.indexOf('error') < 0 && data.indexOf('suc')>-1) {
                    var a = data.split(':');
                    ws.send('{"type":"say","room_id":"1","to_client_id":"all","content":"repay@' + a[1] + '"}');
                    alert('已送出維修單');
                    location.href='./';
                }
            }); 
    });
        
    
</script>
</html>
