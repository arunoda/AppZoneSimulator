<?php

/**
 * Listen to the AppZone MO Message and reply back
 */
include_once 'AppZoneSender.php';
include_once 'AppZoneReciever.php';


try{
	$reciever=new AppZoneReciever();
	$rtn="{$reciever->getAddress()} :: {$reciever->getMessage()} :: {$reciever->getCorrelator()}";
	
	$sender=new AppZoneSender("http://localhost/jobs/appZone-sim-php/", "app", "pass");
	$res=$sender->sms("Thanks", $reciever->getAddress());
	$res=$sender->smsToAll("Hi all, we got a new message");
}
catch(AppZoneException $ex){
	echo "ss";
}

