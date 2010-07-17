<?php

/*********************************
 * @author Arunoda Susiripala
 * @copyright Arunoda Susiripala
 * @licence http://www.gnu.org/licenses/gpl-3.0.txt
 */

include_once 'lib/init.php';

$logger;$session;$registrar;
if(Session::isExists()){
	$logger=new Logger();
	$session=new Session();
	$registrar=new Registrar($session->appName);
}

$type=(isset($_GET['service']))?$_GET['service']:null;

if($type=='serverLog'){
	$log=$logger->getServerLog();
	echo json_encode($log);
} else if($type=='phoneLog'){
	$log=$logger->getPhoneLog();
	echo json_encode($log);
} else if($type=='smsLog'){
	$no=(isset($_GET['phone']))?$_GET['phone']:null;
	$log=$logger->getSMSLog($no);
	echo json_encode($log);
} else if($type=='sendSMS'){
	$no=(isset($_GET['phone']))?$_GET['phone']:null;
	$message=(isset($_GET['message']))?$_GET['message']:null;
	//get the listener and pass the request for it.
	$params=array();
	$params['address']=$no;
	$params['message']=$message;
	$params['correlator']=(int)(rand()*100000);
	
	$parts=explode(' ', $params['message']);
	if($parts[0]==$session->appName){
		if(isset($parts[1]) && $parts[1]=='reg'){
			$registrar->register($params['address']);
			echo "You are now registered with AppZone app: " . $session->appName;
		}else if(isset($parts[1]) && $parts[1]=='unreg'){
			$registrar->unregister($params['address']);
			echo "Your registration now revoked from AppZone app: " . $session->appName;
		}else{
			$res=sendRequest($session->reciever, $params);
			$logger->logPhone($no, $session->appName, $params['correlator'], $message);
			echo $res;	
		}
	}
	else{
		echo json_encode("Not related to an Appzone application");
	}
	
}else if($type=='session'){
	$action=(isset($_GET['action']))?$_GET['action']:null;
	if($action=='destroy'){
		Session::destroy();
	}else if($action=='create'){
		$appName=(isset($_GET['appName']))?$_GET['appName']:null;
		$password=(isset($_GET['password']))?$_GET['password']:null;
		$reciever=(isset($_GET['reciever']))?$_GET['reciever']:null;
		
		Session::create($appName, $password, $reciever);
	}else if($action=='isExists'){
		echo json_encode(Session::isExists());
	}
}else{
	echo json_encode('not implemented yet');
}

function sendRequest($server,$postfields){
		if(substr($server, -1)!='/') $server.="/";
		$ch = curl_init($server);
		
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		$res = curl_exec($ch);       
		curl_close($ch);
		return $res;
}