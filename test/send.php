<?php

include_once 'AppZoneSender.php';


try{
	$sender=new AppZoneSender("http://localhost/jobs/appZone-sim-php/", "demo-app", "pass");
	
	$resp=$sender->sms("Hi New One",array("0721675234","0721162733"));
	
	echo $resp;
}
catch(AppZoneException $ex){
	echo 'ERROR:: ' . $ex->getStatusCode() . ' | ' . $ex->getStatusMessage(); 
}
