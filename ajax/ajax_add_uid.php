<?php
	// VMware ESXi Rebooter ver.1.0.20160321.1630 By sonyandy123
	header("Content-Type: text/plain; charset=utf-8");
	if (!isset($_POST["data"]))
		die("error");
	$add_data_array = $_POST["data"]; // 0=ID, 1=總次數, 2=密碼
	$exit_code = 1; // 0=ID已存在, 1=成功
	
	$db_conn = new PDO("sqlite:../db/db.sqlite");
	$sth = $db_conn->prepare("SELECT * FROM reboot");
	$sth->execute();
	while($row = $sth->fetch(PDO::FETCH_ASSOC)){
		if ($add_data_array[0] == $row['uid']){
			$exit_code = 0;
		}
	} 
	
	if ($exit_code == 1){
		$stmt = "INSERT INTO reboot(uid, cycled, cycle, passwd) VALUES('{$add_data_array[0]}', '0', '{$add_data_array[1]}', '{$add_data_array[2]}')";
		$db_conn->exec($stmt);
		
		echo "ok";
	}else{
		echo "id_exist";
	}
?>