<?php
	// VMware ESXi Rebooter ver.1.0.20160321.1630 By sonyandy123
	header("Content-Type: text/plain; charset=utf-8");
	if (!isset($_POST["data"]))
		die("error");
	$add_data_array = $_POST["data"]; // 0=ID, 1=密碼, 2=目標次數
	$exit_code = 0; // 0=密碼錯誤, 1=成功
	
	$db_conn = new PDO("sqlite:../db/db.sqlite");
	$sth = $db_conn->prepare("SELECT * FROM reboot");
	$sth->execute();
	while($row = $sth->fetch(PDO::FETCH_ASSOC)){
		if ($add_data_array[0] == $row['uid'] && $add_data_array[1] == $row['passwd']){
			$exit_code = 1;
			break;
		}
	} 
	
	if ($exit_code == 1){
		$stmt = "UPDATE reboot SET cycle = {$add_data_array[2]} WHERE uid = '{$add_data_array[0]}'; ";
		$db_conn->exec($stmt);
		
		echo "ok";
	}else{
		echo "pwd_error";
	}
?>