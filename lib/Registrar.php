<?php
/*********************************
 * @author Arunoda Susiripala
 * @copyright Arunoda Susiripala
 * @licence http://www.gnu.org/licenses/gpl-3.0.txt
 */

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
		$filename=dirname(dirname(__FILE__)).DS."data".DS."phones".DS.$this->appName.".lst";
		if(!file_exists($filename)){
			return  array();
		}
		
		$lines=file($filename);
		$json=implode("\n", $lines);
		$rtn=json_decode($json,true);
		return (count($rtn)>0)?$rtn:array();	
	}
	
	public function writeIt($str){
		$filename=(dirname(dirname(__FILE__)).DS."data".DS."phones".DS.$this->appName.".lst");
		$f=fopen($filename,"w+");
		fwrite($f, $str . "\n");
		fclose($f);
	}
}