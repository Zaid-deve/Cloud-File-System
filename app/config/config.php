<?php

// PHP BASE SERVER CONFIG FILE
$server = $_SERVER['SERVER_NAME'];
$scheme = $_SERVER['REQUEST_SCHEME'];
$root = $_SERVER['DOCUMENT_ROOT'] . '/cfs';
$origin = $_SERVER['REQUEST_URI'];

$baseurl = "$scheme://$server/cfs";

// default timezone 
date_default_timezone_set("asia/kolkata");

// default json response array
$resp = [
    'Success' => false,
    'Err' => null
];
