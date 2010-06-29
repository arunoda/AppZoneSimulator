<?php

include_once '../lib/init.php';

$reg=new Registrar("app");

$reg->register('03');
var_dump($reg->getPhoneNoList());