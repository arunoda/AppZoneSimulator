<?php

class Session{
	public $appName;
	public $password;
	public $reciever;
	
	public function __construct(){
		
		$res=file(dirname(__FILE__)."/data/session.data");
		
		$resArr=json_decode($res[0],true);
		if(!$resArr) throw new Exception("Malformed JSON String");
		$this->appName=$resArr['appName'];
		$this->password=$resArr['password'];
		$this->reciever=$resArr['reciever'];
	}
}