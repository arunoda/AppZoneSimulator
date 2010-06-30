<?php

include_once 'recursive_delete.php';

class Session{
	public $appName;
	public $password;
	public $reciever;
	
	public function __construct(){
		
		$res=file(dirname(dirname(__FILE__))."/data/session.data");
		
		$resArr=json_decode($res[0],true);
		if(!$resArr) throw new Exception("Malformed JSON String");
		$this->appName=$resArr['appName'];
		$this->password=$resArr['password'];
		$this->reciever=$resArr['reciever'];
	}
	
	public static function destroy(){
		$res=recursive_remove_directory(dirname(dirname(__FILE__)). "/data",false);
		if($res==false) throw new Exception("Cannot access data folder");
	}
	
	public static function create($appName,$password,$reciever){
		
		$session=array(
			"appName"=>$appName,
			"password"=>$password,
			"reciever"=>$reciever
		);
		
		Session::writeIt(
			dirname(dirname(__FILE__))."/data/session.data", 
			json_encode($session)
		);
		
		$res=mkdir(dirname(dirname(__FILE__))."/data/phones/");
	}
	
	private static function writeIt($filename,$str){
		
		$f=fopen($filename,"w+");
		fwrite($f, $str . "\n");
		fclose($f);
	}	
}