<?php 

class AppZoneException extends Exception{
	var $code;
	var $response;
	var $message;
	
	public function __construct($message,$code,$response=null){
		parent::__construct($message);
		$this->message=$message;
		$this->code=$code;
		$this->response=$response;
	}
	
	public function getStatusCode(){
		return $this->code;
	}
	
	public function getStatusMessage(){
		return $this->message;
	}
	
	public function getRawResponse(){
		return $this->response;
	}
}