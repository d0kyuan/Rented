
<?php

require_once('Php_pro/db_info.php');
#2017-07-11不上傳圖片,改由上傳頁面另外上傳
try {
	date_default_timezone_set("Asia/Taipei");
	$nowtime =date("Y-m-d");
	$date = new DateTime();
	$regon = $_POST['area'];
	$country= $_POST['adminis'];//行政區
	$EandC = $_POST['EandC'];//E&C
	$siteid = $_POST['machine_name'];//基站ID
	$username= $_POST['machine_set_posi'];//填寫人
	$subpro=$_POST['SubPro'];//次問題
	$usef =$_POST['UseF'];//適不適用
	$year = $_POST['Year'];//年度
	$Q = $_POST['seleQ'];//季
	$map_lat = $_POST['map_lat'];//經度   
	$map_lng = $_POST['map_lng'];//緯度         
	$addr = $_POST['addr'];//地址
	$construction = $_POST['switch'];//本次施工
	$Description = $_POST['totaltxt'];//說明
	$daytime = $nowtime;//日期
	$piccount = $_POST['total'];



	if($construction=="YES"){
		$construction = 1;
	}else{
		$construction = 0;
	}



	$sql =sprintf("INSERT INTO tb_summary(regon,country,siteid,addr,EandC,subpro,construction,Description,Year,Q,Date,Username,lat,lon,UseF)
			   VALUES  ('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s')",  $regon,$country,$siteid,$addr,$EandC,$subpro,$construction,$Description,$year,$Q,$daytime,$username,$map_lat,$map_lng,($usef-1));
	$result = $db->exec($sql);    
	//echo $sql;
   $sumid = $db->lastInsertId();
   $pic = array();
	for($i =0 ; $i <$piccount ; $i++){
		$sql = "select GrpLabel from tb_problemsubgroup where GrpSubId like '".$subpro."';";
		$e = $db->query($sql);
		$r = $e->fetch(PDO::FETCH_ASSOC);
		$image_save_url = "pic/".$siteid."_".$nowtime."_".$r['GrpLabel']."_".$username."_".$date->getTimestamp().".png";
		$sql =sprintf("INSERT INTO tb_picture(SumId,path) VALUES  ('%s','%s')",$sumid,$image_save_url);
		$result = $db->exec($sql);    
		$pic[$i]=$image_save_url;
		//array_push($pic,array("imagename"=>$image_save_url));
	}


	
	echo json_encode(array("static"=>"sucess","id"=>$sumid,"mdata"=>$pic));
} catch (Exception $e) {

    echo json_encode(array("static"=>"error","message"=>$e->getMessage()));
}
?>
