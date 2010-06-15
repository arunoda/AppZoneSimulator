<?php

include_once 'lib/init.php';


$type=(isset($_GET['service']))?$_GET['service']:null;
if($type=='serverLog'){
	$logger=new Logger();
	$log=$logger->getServerLog();
	echo json_encode($log);
} else if($type=='phoneLog'){
	$logger=new Logger();
	$log=$logger->getPhoneLog();
	echo json_encode($log);
} else if($type=='smsLog'){
	$no=(isset($_GET['phone']))?$_GET['phone']:null;
	$logger=new Logger();
	$log=$logger->getSMSLog($no);
	echo json_encode($log);
}else{
	echo json_encode(array("error"=>'not implemented yet'));
}