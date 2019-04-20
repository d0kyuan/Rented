<?php
$id = $_GET['id'];
require_once('php_lib/db_info.php');

$sql = "select * from tb_history inner join tb_objinfo on tb_history.Oid = tb_objinfo.Oid inner join tb_member on tb_member.Mid = tb_history.Mid where Hid = ".$id;
$e = $db->query($sql);
$row = $e->fetch(PDO::FETCH_ASSOC);
if($row['acept']==null){
    $isacrpt = "尚未同意";
}else{
    $isacrpt = "已被同意";
}
print('
<table style="font-size:40px;">
    <tr>
        <td>時間</td>
         <td>'.$row['Ftime'].'</td>
    </tr>
     <tr>
      <td>物品名稱</td>
          <td>'.$row['Oname'].'</td>
    </tr>
     <tr>
       <td>借用人</td>
          <td>'.$row['MemName'].'</td>
    </tr>
     <tr>
       <td>是否被同意</td>
         <td>'.$isacrpt.'</td>
    </tr>
     <tr>
         <td>ip</td>
         <td>'.$row['ip'].'</td>
    </tr>
     <tr>
         <td>國家</td>
         <td>'.$row['country'].'</td>
    </tr>
     <tr>
         <td>城市</td>
            <td>'.$row['city'].'</td>
    </tr>
     <tr>
       <td>作業系統</td>
          <td>'.$row['platform'].'</td>
    </tr>
     <tr>
      <td>瀏覽工具</td>
         <td>'.$row['browser'].'</td>
    </tr>
</table>
   
      
');
?>