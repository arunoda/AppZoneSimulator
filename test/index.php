<?php

/**
 * Listen to the AppZone MO Message and reply back
 */
include_once 'AppZoneSender.php';
include_once 'AppZoneReciever.php';

try{
	$reciever=new AppZoneReciever();
	$parts=explode(" ", $reciever->getMessage());
	$url="http://localhost".str_replace("/test", "", $_SERVER['PHP_SELF'])."/";
	
	$sender=new AppZoneSender($url, "demo-app", "pass");
	$res=$sender->sms("Your message has been delivered!", $reciever->getAddress());
	$res=$sender->smsToAll($parts[1] . " says " . str_replace("{$parts[0]} {$parts[1]}","", $reciever->getMessage()));
}
catch(AppZoneException $ex){
	echo $ex->getStatusMessage();
}

