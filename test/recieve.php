<?php

/**
 * Listen to the AppZone MO Message and reply back
 */
include_once 'AppZoneSender.php';
include_once 'AppZoneReciever.php';


try{
	$reciever=new AppZoneReciever();
	$parts=explode(" ", $reciever->getMessage());
	
	$sender=new AppZoneSender("http://localhost/jobs/appZone-sim-php/", "app", "pass");
	$res=$sender->sms("Thank you for join our network", $reciever->getAddress());
	$res=$sender->smsToAll("We have an new Member: " . $parts[1]);
}
catch(AppZoneException $ex){
	echo $ex->getStatusMessage();
}

