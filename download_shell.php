<?php
	// VMware ESXi Rebooter ver.1.0.20161116.1100 By sonyandy123
	header("Content-Type: text/plain; charset=utf-8");
	if (!isset($_GET["u"]))
		die("exit 0");
	$uid = $_GET["u"];
	$cycled = 0;
	$cycle = 0;
	$exit_code = 0; // 0=ID不存在, 1=成功
	
	$db_conn = new PDO("sqlite:./db/db.sqlite");
	$sth = $db_conn->prepare("SELECT * FROM reboot");
	$sth->execute();
	while($row = $sth->fetch(PDO::FETCH_ASSOC)){
		if ($uid == $row['uid']){
			$cycled = $row['cycled'];
			$cycle = $row['cycle'];
			$exit_code = 1;
			break;
		}
	}
	
	if ($exit_code == 1){
		$cycled++;
		$stmt = "update reboot set cycled = '{$cycled}' where uid = '{$uid}'";
		$db_conn->exec($stmt);
		if ($cycled < $cycle){
			echo <<<print_script
#!/bin/bash
date>>/vmfs/volumes/datastore1/reboot.log
sleep 30
reboot
print_script;
			
		}elseif ($cycled == $cycle){
			echo "#!/bin/bash\necho \"PASS\" >> /vmfs/volumes/datastore1/reboot.log";
		}else{
			echo "exit 0";
		}
	}else{
		echo "exit 0";
	}
?>