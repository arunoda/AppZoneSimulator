<?php

/**
 * 
 * Used to register and unregister phone no's with a app
 * @author arunoda
 *
 */

class Registrar{
	var $appName;
	public function __construct($appName){
		$this->appName=$appName;
	}
	
	public function register($phoneNo){
		$list=$this->getPhoneNoList();
		if(!$list || !in_array($phoneNo,$list)){
			$list[]=$phoneNo;
			$this->writeIt(json_encode($list));
		}
		
		return true;
	}
	
	public function unregister($phoneNo){
		$list=$this->getPhoneNoList();
		$index=array_search($phoneNo, $list);
		if($index){
			unset($list[$index]);
			$this->writeIt(json_encode($list));
		}
		
		return true;
	}
	
	public function getPhoneNoList(){
		$filename=dirname(dirname(__FILE__))."/data/phones/".$this->appName.".lst";
		if(!file_exists($filename)){
			return  false;
		}
		
		$lines=file($filename);
		$json=implode("\n", $lines);
		$rtn=json_decode($json,true);
		return (count($rtn)>0)?$rtn:false;	
	}
	
	public function writeIt($str){
		$filename=(dirname(dirname(__FILE__))."/data/phones/".$this->appName.".lst");
		$f=fopen($filename,"w+");
		fwrite($f, $str . "\n");
		fclose($f);
	}
}