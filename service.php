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
} else if($type=='sendSMS'){
	$no=(isset($_GET['phone']))?$_GET['phone']:null;
	$message=(isset($_GET['message']))?$_GET['message']:null;
	//get the listener and pass the request for it.
	$session=new Session();
	$params=array();
	$params['address']=$no;
	$params['message']=$message;
	$params['correlator']=(int)(rand()*100000);
	
	$res=sendRequest($session->reciever, $params);
	
	$logger=new Logger();
	$logger->logPhone($no, $session->appName, $params['correlator'], $message);
	echo json_encode($res);
}else{
	echo json_encode(array("error"=>'not implemented yet'));
}

function sendRequest($server,$postfields){
		
		$ch = curl_init($server);
		
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		$res = curl_exec($ch);       
		curl_close($ch);
		return $this->handleResponse($res);
}