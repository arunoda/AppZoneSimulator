<?php

include_once 'recursive_delete.php';

class Session{
	public $appName;
	public $password;
	public $reciever;
	
	public function __construct(){
		
		$dataFile=dirname(dirname(__FILE__))."/data/session.data";
		if(file_exists($dataFile)){
			$res=file($dataFile);
			$resArr=json_decode($res[0],true);
			if(!$resArr) throw new Exception("Malformed JSON String");
			$this->appName=$resArr['appName'];
			$this->password=$resArr['password'];
			$this->reciever=$resArr['reciever'];	
		}
		else{
			throw new Exception("Session is not created yet!");
		}
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
	
	public static function isExists(){
		return file_exists(dirname(dirname(__FILE__))."/data/session.data");
	}
	
	private static function writeIt($filename,$str){
		
		$f=fopen($filename,"w+");
		fwrite($f, $str . "\n");
		fclose($f);
	}	
}