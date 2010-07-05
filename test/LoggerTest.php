<?php

include_once '../lib/init.php';

$logger=new Logger();
//$logger->logSever("1111113", "Hi Message", "Statu82w282", "Status Meaasage");
//$logger->logPhone("071236256", "656466555", "A Message again");
$logger->sendSMS("Hi SMS ", "0721654646");
//$logger->sendSMS("Hi SMS ", "0721655676");
//var_dump($logger->getServerLog());
//var_dump($logger->getPhoneLog());
var_dump($logger->getSMSLog("0721654646"));