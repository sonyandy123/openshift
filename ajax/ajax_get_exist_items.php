<?php 
	// VMware ESXi Rebooter ver.1.0.20160321.1630 By sonyandy123
	header("Content-Type: text/plain; charset=utf-8");
	$DataArray = null;
	$count = 0;
	
	$db_conn = new PDO("sqlite:../db/db.sqlite");
	$sth = $db_conn->prepare("SELECT * FROM reboot");
	$sth->execute();
	while($row = $sth->fetch(PDO::FETCH_ASSOC)){
		$DataArray[$count]["uid"] = $row['uid'];
		$DataArray[$count]["cycled"] = $row['cycled'];
		$DataArray[$count]["cycle"] = $row['cycle'];
		$count++;
	} 
	echo json_encode($DataArray);
?>