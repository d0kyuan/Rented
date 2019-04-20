<?php
session_start();

#if(@$_SESSION['islogin']==null || $_SESSION['islogin']  == false){
#   print('<script>document.write("您的權限不足或是非正常方式進入!");</script>');
#   sleep(2);
#   print('<script>location.href="./";</script>');
#}
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
         <link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
       <link rel="stylesheet" href="js/jquery.mobile.min.css">

    <script src="js/jquery.min.js"></script>
    <script src="js/jquery.mobile.min.js"></script>
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <style>
        .notebook{
            background-image: url('img/outline_laptop_notebook_computer_-24.png');
            width:24px;
            height: 24px;
             background-repeat:no-repeat;
        }
        </style>
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
                <ul>

                    <?php
                    
                        $list_1 = '<li class="selection" onclick="location.href=\'?class=1\'">電腦</li>';
                        $list_2 = '<li class="selection" onclick="location.href=\'?class=3\'">筆記型電腦</li>';
                        $list_3 = ' <li class="selection" onclick="location.href=\'?class=4\'">其他</li>';
                    $list_4 = ' <li class="selection" id="show_pic">圖示</li>';
                     if($_SERVER['REQUEST_METHOD'] == 'GET'){
                        if($_SESSION['islogin']){
                            require("php_lib/update_per.php");
                            require("php_lib/get_fa.php");
                            update_per();
//                            if(!isset($_SESSION['ask'])){
//                                 get_fa($_SESSION['Mid']);
//                            }
                           
                            if($_SESSION['pre'][5]=="1"){
                                print($list_1.$list_2);
                            }
                             if($_SESSION['pre'][6]=="1"){
                                print($list_3);
                            }
                           #print( $list_4);
                        }else{
                            print($list_1.$list_3);
                        }
                        if(isset($_GET['class'])){
                             print('<li class="selection" onclick="location.href=\'?\'">全部</li>');
                        }
                     }
                    
                    
                    ?>
                </ul>
            </div>
            <div class="left">
                <form class="ui-filterable">
                <input id="myFilter" data-type="search">
            </form>
            <ul data-role="listview" data-filter="true" data-input="#myFilter" >
                <?php
                    
                    
                   
                    
                    if($_SERVER['REQUEST_METHOD'] == 'GET'){
                        
                        if(isset($_GET['class'])){
                            
                          
                            foreach($db->query("select * from tb_objinfo INNER JOIN tb_objgroup
ON tb_objgroup.Ogid = tb_objinfo.Ogid where Oclass = '".$_GET['class']."' ORDER BY OGname ASC,OGname ASC") as $row){
                                 $odjdata = base64_encode($row['Oid']);    
                                $OGstat = "";
                                 $output_icon= "";
                             switch($row['Oclass']){
                                    case 1:
                                     $output_icon ='<i class="fa fa-windows obj_name" aria-hidden="true"></i>';
                                     #$output_icon =$row['Oclass'];
                                     break;
                                 case 2:
                                     break;
                                 case 3:
                                      $output_icon =  '<i class="fa obj_name notebook" aria-hidden="true"></i>';
                                     break;
                                 case 4:
                                     $output_icon =  '<i class="fa fa-wheelchair-alt obj_name" aria-hidden="true"></i>';
                                     break;
                                }   
                                switch($row['OGstat']){
                                    case "1":
                                        $OGstat = "空閑中";
                                        break;
                                    case "2":
                                        $OGstat = "使用中";
                                        break;
                                    case "3":
                                        $OGstat = "已報修";
                                    case "4":
                                        $OGstat = "維修中";
                                        break;
                                    case "5":
                                        $OGstat = "已預約";
                                        break;
                                }
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
                                        $Ostate = "<span style='color:Gray'>已預約</span>";
                                        break;
                                }
                               #echo $row['OGstat'].":".$row['Ostate'].":".$row['OGstat'];
                                print('
                               <li id="obj'.$row['Oid'].'" class="list_obj">
                                    '.$output_icon.'
                                    <div id="objclass'.$row['Oid'].'name" class="obj_name">
                                    '.$row['OGname'].'  
                                    </div>
                                    <div id="objclass'.$row['Oid'].'name" class="obj_state">
                                    '.$OGstat.'
                                    </div>
                                    <div id="obj'.$row['Oid'].'name" class="obj_name">
                                    '.$row['Oname'].'  
                                    </div>
                                    <div id="obj'.$row['Oid'].'state" class="obj_state">'.$Ostate.'
                                    </div>
                                    
                                ');
                                if($row['OGstat']=="1" && $row['Ostate'] =="1" && $_SESSION['islogin']!=null && $_SESSION['islogin'] == true && $row['OGstat'] == "1"){
                                    print('<div id="obj'.$row['Oid'].'bro" class="objbtn" onclick="location.href=\'rented.php?data='.$odjdata.'\'">
                                    租借
                                    </div>
                                </li>');
                                }else{
                                    print('</li>');
                                }
                            }
                        }else{
                            $temp = "";
                           
                            if($_SESSION['islogin']!=null && $_SESSION['islogin']==true){
                                   if($_SESSION['pre'][5]=="1"){
                                        $temp .="1,3,";
                                    }
                                     if($_SESSION['pre'][6]=="1"){
                                       $temp.="4,";
                                    }
                                if($_SESSION['islogin']==null && $_SESSION['islogin'] == false){
                                    $temp="";
                                }
                                    
                               if(strlen($temp) >0){
                                     $temp[strlen($temp)-1] = " ";
        foreach($db->query("select * from tb_objinfo INNER JOIN tb_objgroup
ON tb_objgroup.Ogid = tb_objinfo.Ogid where Ostate = 1 and OGstat = 1   ORDER BY OGname ASC,OGname ASC,Oclass Asc") as $row){
           
            # print($row['Oclass']);
                               $Ostate = "";
                            $output_icon= "";
                             switch($row['Oclass']){
                                    case 1:
                                     $output_icon ='<i class="fa fa-windows obj_name" aria-hidden="true"></i>';
                                     #$output_icon =$row['Oclass'];
                                     break;
                                 case 2:
                                     break;
                                 case 3:
                                      $output_icon =  '<i class="fa obj_name notebook" aria-hidden="true"></i>';
                                     break;
                                 case 4:
                                     $output_icon =  '<i class="fa fa-wheelchair-alt obj_name" aria-hidden="true"></i>';
                                     break;
                                }                                
                                switch($row['OGstat']){
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
                                        $Ostate = "<span style='color:red'>已預約</span>";
                                        break;
                                }
                                   # echo $row['OGstat'].":".$row['Ostate'].$row['OGstat'];                                   
                                $odjdata = base64_encode($row['Oid']);                                       
                                print('
                                <li id="obj'.$row['Oid'].'" class="list_obj">
                                '.$output_icon.'
                                    <div id="objclass'.$row['Oid'].'name" class="obj_name">
                                    '.$row['OGname'].'  
                                    </div>
                                    <div id="objclass'.$row['Oid'].'stat" class="obj_state">
                                    空閑中
                                    </div>
                                    <div id="obj'.$row['Oid'].'name" class="obj_name">
                                    '.$row['Oname'].'  
                                    </div>
                                    <div id="obj'.$row['Oid'].'state" class="obj_state">'.$Ostate.'
                                    </div>
                                   
                                ');
                                                                       
                                    if( $_SESSION['islogin']!=null && $_SESSION['islogin'] == true){
                                    print('<div id="obj'.$row['Oid'].'bro" class="objbtn" onclick="location.href=\'rented.php?data='.$odjdata.'\'">
                                    租借
                                    </div>
                                </li>');
                                   }else{
                                        print('
                                </li>');
                                   }                                     
                                                                       
                            }
                               }else{
                                      print('<script>alert("沒有權限租借設備");</script>');
                                sleep(2);
                               print('<script>location.href="./"</script>');
                               }
                              

                            }else{
                                foreach($db->query("select * from tb_objinfo INNER JOIN tb_objgroup
ON tb_objgroup.Ogid = tb_objinfo.Ogid where Ostate = 1 and OGstat = 1 ORDER BY OGname ASC,OGname ASC,Oclass Asc") as $row){
                                   
                                $output_icon= "";
                             switch($row['Oclass']){
                                    case 1:
                                     $output_icon ='<i class="fa fa-windows obj_name" aria-hidden="true"></i>';
                                     #$output_icon =$row['Oclass'];
                                     break;
                                 case 2:
                                     break;
                                 case 3:
                                      $output_icon =  '<i class="fa obj_name notebook" aria-hidden="true"></i>';
                                     break;
                                 case 4:
                                     $output_icon =  '<i class="fa fa-wheelchair-alt obj_name" aria-hidden="true"></i>';
                                     break;
                                }       
                                print('
                                <li id="obj'.$row['Oid'].'" class="list_obj">
                                    '.$output_icon.'
                                    <div id="objclass'.$row['Oid'].'name" class="obj_name">
                                    '.$row['OGname'].'  
                                    </div>
                                    <div id="objclass'.$row['Oid'].'stat" class="obj_state">
                                    空閑中
                                    </div>
                                    <div id="obj'.$row['Oid'].'name" class="obj_name">
                                    '.$row['Oname'].'  
                                    </div>
                                    <div id="obj'.$row['Oid'].'state" class="obj_state"><span style="color:green">空閑中</span>
                                    </div>
                                    
                               
                                ');
                                   if( $_SESSION['islogin']!=null && $_SESSION['islogin'] == true){
                                    print('<div id="obj'.$row['Oid'].'bro" class="objbtn" onclick="location.href=\'rented.php?data='.$odjdata.'\'">
                                    租借
                                    </div>
                                </li>');
                                   }else{
                                        print('
                                </li>');
                                   }
                            }
                            }
                            
                        }
                        
                    }
                
                
                ?>
                </ul>
            </div>
            
    
        </div>
        <div class="footer"></div>

         <script src="js/popnotif.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script>var username = "<?php echo $_SESSION['name'];  ?>";var userid = "<?php echo $_SESSION['Mid'] ?>";</script>
       <script src="js/talkroom.js"></script>


    </body>

    </html>