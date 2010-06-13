<?php 

$response="";
$request=null;

try{
	authentication();
	$request=getRequest();
	validateRequest($request);
	//send the message
	
	$response=generateResponse("65653", "ererer");
	//log it
}
catch(AppZoneException $ex){
	$response=generateResponse($ex->getStatusCode(), $ex->getStatusMessage());
	//log it
}

//echo $response;
var_dump($_SERVER);


/***************************************************
 * 
 * 
 * 
 ***************************************************/

/**
 * get the response object or throws and AppZoneException
 */
function getRequest(){
	
}

/**
 * get the header Auth
 * return true  or throws a an AppZoneException
 */
function authentication(){
	
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
	
}
