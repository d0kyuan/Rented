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
                 <?php
                
                    
                require_once('./php_lib/db_info.php');
                $sql = "select * from tb_objinfo where Oid like '".base64_decode($_GET['data'])."'";


                $e = $db->query($sql);
                $row = $e->fetch(PDO::FETCH_ASSOC);
                
                print_r($row);
                
                
                ?>
                    
            </div>
            <div class="left">
                <p>內容</p>
            </div>

        </div>
        
        
        <div class="footer"></div>
        
        
        <script type="text" id="form-modal">
            <div class="popup-wrapper" style="min-width: 400px;">
              <div class="popup-header"> Welcome back </div>

              <div class="popup-content">
                <div class="form-group">
                  <input type="email" placeholder="Email" id="email"/>
                </div>
                <div class="form-group">
                  <input type="password" placeholder="Password" id="password"/>
                </div>
                <div class="form-group">
                  <button class="btn-success" style="width: 100%;">Sign in</button>
                </div>
              </div>
            </div>
          </script>
        
        <script src="js/popnotif.js"></script>
         <script src="timodal.js" charset="utf-8"></script>

  <script>
  $(document).ready(function(){

    var button = document.querySelector('#show-default-modal');
    button.addEventListener('click', function(){
      var html = document.getElementById("default-modal").innerHTML;
      var modal = tiModal.create(html)
                        .show();
    });


    $('#show-alert-modal').click(function(){
      var html = $('#alert-modal').html();
      tiModal.create(html).show();
    });

    $('#show-confirm-modal').click(function(){

      var html = $('#confirm-modal').html();
      tiModal.create(html, {
        events: {
          'click .cancel': function(e){
            this.close();
          },
          'click .ok': function(e){
            this.close();
            alert('User has been deleted!')
          }
        }
      }).show();
    });

    $('#show-form-modal').click(function(){
      var html = $('#form-modal').html();
      tiModal.create(html,{
        events: {
          'click .btn-success': function(e){
            this.close();
            alert('Sign in successfully!');
          },
        },
        modal: true
      }).show();
    });
  });
  </script>
    </body>
  <script>var username = "<?php echo $_SESSION['name'];  ?>";var userid = "<?php echo $_SESSION['Mid'] ?>";</script>
       <script src="js/talkroom.js"></script>
    </html>