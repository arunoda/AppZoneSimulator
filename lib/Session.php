<?php
/*********************************
 * @author Arunoda Susiripala
 * @copyright Arunoda Susiripala
 * @licence http://www.gnu.org/licenses/gpl-3.0.txt
 */

include_once 'recursive_delete.php';

class Session{
	public $appName;
	public $password;
	public $reciever;
	
	public function __construct(){
		
		$dataFile=dirname(dirname(__FILE__)).DS."data".DS."session.data";
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
		$res=recursive_remove_directory(dirname(dirname(__FILE__)). DS."data",true);
		if($res==false) throw new Exception("Cannot access data folder");
	}
	
	public static function create($appName,$password,$reciever){
		
		$session=array(
			"appName"=>$appName,
			"password"=>$password,
			"reciever"=>$reciever
		);
		
		Session::writeIt(
			dirname(dirname(__FILE__)).DS."data".DS."session.data", 
			json_encode($session)
		);
		
		$res=mkdir(dirname(dirname(__FILE__)).DS."data".DS."phones".DS);
	}
	
	public static function isExists(){
		return file_exists(dirname(dirname(__FILE__)).DS."data".DS."session.data");
	}
	
	private static function writeIt($filename,$str){
		
		$f=fopen($filename,"w+");
		fwrite($f, $str . "\n");
		fclose($f);
	}	
}