<?php 

include_once 'Session.php';
include_once 'AppZoneException.php';

$response="";
$request=null;

try{
	authentication();
	$request=getRequest();
	
	validateRequest($request);
	sendMessage($request);
	
	$response=generateResponse("SBL-SMS-MT-2000", "SUCCESS");
	//log it
}
catch(AppZoneException $ex){
	$response=generateResponse($ex->getStatusCode(), $ex->getStatusMessage());
	//log it
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
	if(isset($_POST['version']) && $_POST['address'] && $_POST['message']){
		$rtn=array();
		$rtn['version']=$_POST['version'];
		$rtn['address']=$_POST['address'];
		$rtn['message']=$_POST['message'];
		
		return $rtn;
	}
	else{
		throw new AppZoneException("Bad   Request.    Request   missing   required parameters or parameter format is wrong.", "400");
	}
}

/**
 * get the header Auth
 * return true  or throws a an AppZoneException
 */
function authentication(){
	$session=new Session();
		
	if(
		($session->appName==$_SERVER['PHP_AUTH_USER']) && 
		md5($session->password)==$_SERVER['PHP_AUTH_PW']){
		return true;
	}else{
		throw new AppZoneException("Unauthorized. Authentication details missing or unformatted authentication details exists.", "401");
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
	
}


