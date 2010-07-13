<?php

/**
 * Listen to the AppZone MO Message and reply back
 */
include_once 'AppZoneSender.php';
include_once 'AppZoneReciever.php';


try{
	$reciever=new AppZoneReciever();
	$parts=explode(" ", $reciever->getMessage());
	
	$sender=new AppZoneSender("http://localhost/jobs/appZone-sim-php/", "demo-app", "pass");
	$res=$sender->sms("Your message has been delivered!", $reciever->getAddress());
	$res=$sender->smsToAll($parts[1] . " says " . str_replace("{$parts[0]} {$parts[1]}","", $reciever->getMessage()));
}
catch(AppZoneException $ex){
	echo $ex->getStatusMessage();
}

