<?php
session_start();


$_SESSION['islogin'] = false;
$_SESSION['account'] = null;
$_SESSION['password'] = null;
$_SESSION['pre'] = null;
$_SESSION['name'] = null;
session_unset();
print('<script>localStorage.removeItem("talk");</script>');
print('<script>alert("登出成功！")</script>');
sleep(2);
print('<script>location.href="./"</script>');



?>
