<?php

// PHP BASE SERVER CONFIG FILE
$server = $_SERVER['SERVER_NAME'];
$scheme = $_SERVER['REQUEST_SCHEME'];
$root = $_SERVER['DOCUMENT_ROOT'] . '/cfs';
$origin = $_SERVER['REQUEST_URI'];

$baseurl = "$scheme://$server/cfs";

// root constant for classes
define("DOC_ROOT", $root);
define("MAX_FILE_UPLOAD_SIZE", (1024 * 1024) * 75);
define("MAX_FILE_UPLOAD_LIMIT_PER_USER", (1024 * 1024) * 50);

// default timezone 
date_default_timezone_set("asia/kolkata");

// default json response array
$resp = [
    'Success' => false,
    'Err' => null
];


// jwt endcoding key
putenv('JwtKey=$2y$10$ItWvhcFGMnkfs.oUc3GmgusxrhragftYEjDM2cixmIUu0Q.t8914K');
putenv("JwtIdentifier=cfsidf001");