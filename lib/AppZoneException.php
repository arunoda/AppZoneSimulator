<?php 
/*********************************
 * @author Arunoda Susiripala
 * @copyright Arunoda Susiripala
 * @licence http://www.gnu.org/licenses/gpl-3.0.txt
 */

class AppZoneException extends Exception{
	var $code;
	var $response;
	var $statusMessage;
	
	public function __construct($message,$code,$response=null){
		parent::__construct($message);
		$this->statusMessage=$message;
		$this->code=$code;
		$this->response=$response;
	}
	
	public function getStatusCode(){
		return $this->code;
	}
	
	public function getStatusMessage(){
		return $this->statusMessage;
	}
	
	public function getRawResponse(){
		return $this->response;
	}
}