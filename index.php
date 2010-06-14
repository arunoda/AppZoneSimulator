<?php 

include_once 'Session.php';
include_once 'AppZoneException.php';
include_once 'Logger.php';
include_once 'errors.php';

$response="";
$request=null;
$logger=new Logger();

try{
	authentication();
	$request=getRequest();
	
	validateRequest($request);
	
	//message sending
	sendMessage($request);
	
	//responsing
	$statusCode="SBL-SMS-MT-2000";
	$response=generateResponse($statusCode, $errors[$statusCode]);
	$logger->logSever($request['address'], $request['message'], $statusCode, $errors[$statusCode]);
	
}
catch(AppZoneException $ex){
	$response=generateResponse($ex->getStatusCode(), $ex->getStatusMessage());
	$logger->logSever($request['address'], $request['message'], $ex->getStatusCode(), $ex->getStatusMessage());
}



echo $response;


/***************************************************
 * 
 * 
 * 
 ***************************************************/

/**
 * get the response object or throws and AppZoneException
 */
function getRequest(){
	global $errors;
	if(isset($_POST['version']) && $_POST['address'] && $_POST['message']){
		$rtn=array();
		$rtn['version']=$_POST['version'];
		$rtn['address']=$_POST['address'];
		$rtn['message']=$_POST['message'];
		
		return $rtn;
	}
	else{
		throw new AppZoneException($errors['400'], "400");
	}
}

/**
 * get the header Auth
 * return true  or throws a an AppZoneException
 */
function authentication(){
	global $errors;
	$session=new Session();
		
	if(
		($session->appName==$_SERVER['PHP_AUTH_USER']) && 
		md5($session->password)==$_SERVER['PHP_AUTH_PW']){
		return true;
	}else{
		throw new AppZoneException($errors['401'], "401");
	}
	
}

/** 
 * validate the request
 * @return true 
 * @throws AppZoneException
 */
function validateRequest(){
	
}
/**
 * @param unknown_type $statusCode
 * @return String (XML output)
 */
function generateResponse($statusCode,$statusMessage){
	$xml=
	"<mchoice_sdp_sms_response>".
   	"	<version>1.0</version>".
   	"	<correlator>10051016580002</correlator>".
   	"	<status_code>$statusCode</status_code>".
   	"	<status_message>$statusMessage</status_message>".
	"</mchoice_sdp_sms_response>";
	
	
	return $xml;
}


function sendMessage($request){
	global $logger;
	$address=explode(":", $request['address']);
	if($address[0]=='tel'){
		$logger->sendSMS($request['message'], $address[1]);
	}
	else if($address[0]=='list'){
		throw new Exception("Not Implemented");
	}
}


