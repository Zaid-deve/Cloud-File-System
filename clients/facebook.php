<?php

use Facebook\Facebook;

require_once "$root/lib/facebook/vendor/autoload.php";


$fbClient = new Facebook([
    'app_id' => '880626143944748',
    'app_secret' => 'f30e7e36ac2269746c3dcd9482d62e05',
]);

$fbHelper = $fbClient->getRedirectLoginHelper();