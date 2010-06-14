<?php

include_once 'AppZoneSender.php';

$sender=new AppZoneSender("http://localhost/jobs/appZoneSimulator", "aa", "sss");
$sender->sms("Hi all", "0721678345");