<?php

include_once '../lib/Session.php';
//Session::create("app", "pass", "http://localhost/jobs/appZone-sim-php/test/recieve.php");
//echo "aa";
$session=new Session();
var_dump($session);
//$session->destroy();