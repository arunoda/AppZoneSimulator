<?php

class Logger{
	var $session=null;
	public function __construct(){
		$this->session=new Session();
		
	}
	
	public  function logSever($address,$message,$statusCode,$statusMessage){
		$data=array(
			"appName"=>$this->session->appName,
			"address"=>$address,
			"message"=>$message,
			"statusCode"=>$statusCode,
			"statusMessage"=>$statusMessage,
			"timestamp"=>time()
		);
		
		$json=json_encode($data);
		$this->log(dirname(dirname(__FILE__))."/data/server.log", $json);		
	}
	
	public  function logPhone($fromNo,$toNo,$correlator,$message){
		$data=array(
			"appName"=>$this->session->appName,
			"correlator"=>$correlator,
			"message"=>$message,
			"from"=>$fromNo,
			"to"=>$toNo,
			"timestamp"=>time()
		);
		
		$json=json_encode($data);
		$this->log(dirname(dirname(__FILE__))."/data/phone.log", $json);
	}
	
	public function sendSMS($message,$toNo){
		$data=array(
			"appName"=>$this->session->appName,
			"message"=>$message,
			"timestamp"=>time()
		);
		
		$json=json_encode($data);
		$this->log(dirname(dirname(__FILE__)).'/data/phones/'.$toNo.'.sms', $json);
		$this->logPhone($this->session->appName,$toNo, "toDo", $message);
		return true;
	}
	
	public  function getServerLog(){
		$lines=file(dirname(dirname(__FILE__))."/data/server.log");
		$json=implode(",", $lines);
		return json_decode("[$json]",true);
	}
	
	public  function getPhoneLog(){
		$lines=file(dirname(dirname(__FILE__))."/data/phone.log");
		$json=implode(",", $lines);
		return json_decode("[$json]",true);
	}
	
	public function getSMSLog($no){
		$filename=dirname(dirname(__FILE__))."/data/phones/{$no}.sms";
		if(!file_exists($filename)){
			return  false;
		}
		
		$lines=file($filename);
		$json=implode(",", $lines);
		return json_decode("[$json]",true);
	}
	
	private function log($filename,$str){
		
		$f=fopen($filename,"a+");
		fwrite($f, $str . "\n");
		fclose($f);
	}
}