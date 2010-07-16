<?php 
/*********************************
 * @author Arunoda Susiripala
 * @copyright Arunoda Susiripala
 * @licence http://www.gnu.org/licenses/gpl-3.0.txt
 */

if(!isset($_REQUEST['version'])){
	header("Location: ui.php");
	exit(0);
}

include_once 'lib/init.php';

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
	$address=(isset($request['address']))?json_encode($request['address']):"list:" . $request['list'];
	$logger->logSever($address, $request['message'], $statusCode, $errors[$statusCode]);
	
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
	if(isset($_REQUEST['version']) && $_REQUEST['address'] && $_REQUEST['message']){
		$rtn=array();
		$rtn['version']=$_REQUEST['version'];
		$rtn['message']=$_REQUEST['message'];
		$rtn['address']=array();
		$qryStr=$_SERVER["QUERY_STRING"];
		if(!$_GET['address']){
			$qryStr=urldecode(@file_get_contents('php://input'));
		}
		
		$params=explode("&", $qryStr);
		//throw new AppZoneException($qryStr, "400");
		//decoding address from the query string
		foreach ($params as $param){
			$parts=explode("=", $param);
			if($parts[0]=='address'){
				$teleParts=explode(":", $parts[1]);
				if(count($teleParts)==2){
					if($teleParts[0]=="tel"){
						$rtn['address'][]=$teleParts[1];
					}
					else if($teleParts[0]=="list"){
						$rtn['list']=$teleParts[1];
						unset($rtn['address']);
						break;
					}
					else{
						throw new AppZoneException($errors['400'], "400");
					}
				}
				else{
					throw new AppZoneException($errors['400'], $qryStr);
				}
			}
		}
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
function validateRequest($request){
	checkForRegAddresses($request);
}

function checkForRegAddresses($request){
	global $errors;
	$session=new Session();
	$registrar=new Registrar($session->appName);
	$list=$registrar->getPhoneNoList();
	
	if(isset($request['address'])){
		foreach ($request['address'] as $phoneNo){
			if(!in_array($phoneNo, $list)){
				throw new AppZoneException($errors['CORE-SMS-MT-4018'], "CORE-SMS-MT-4018");
			}
		}	
	}
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
	
	if(isset($request['address'])){
		foreach ($request['address'] as $address){
			$logger->sendSMS($request['message'], $address);	
		}
	}
	else if(isset($request['list']) && $request['list']=='all_registered'){
		$session=new Session();
		$registrar=new Registrar($session->appName);
		$phoneList=$registrar->getPhoneNoList();
		foreach ($phoneList as $phoneNo){
			$logger->sendSMS($request['message'], $phoneNo);	
		}
	}
}
