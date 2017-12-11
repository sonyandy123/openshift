<?php
	/* if(!empty($_SERVER['HTTP_CLIENT_IP'])){
		$myip = $_SERVER['HTTP_CLIENT_IP'];
	}else if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
		$myip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	}else{
		$myip= $_SERVER['REMOTE_ADDR'];
	} */
	if (isset($_GET["myip"])){
		$myip = $_GET["myip"];
	} else {
		echo "Error: Need IP Address.";
		exit;
	}
	$pac_data = <<<proxy_pac
function FindProxyForURL(url, host){
	var myIp = "{$myip}";
	return "PROXY " + myIp + ":10800";
}
proxy_pac;

	if (@file_put_contents("./proxy.pac", $pac_data, LOCK_EX)){
		echo "Success: Write Completed.";
	}else{
		echo "Error: Write Failure.";
	}
?>