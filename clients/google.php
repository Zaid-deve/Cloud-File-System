<?php

// using google client v2.17
require_once "$root/lib/google/vendor/autoload.php";
$googleClient = new Google_Client();

// Credentails

$googleClient->setClientId("389186226720-n9uop2khm4miqbmirh2e943r3gfe5lsa.apps.googleusercontent.com");
$googleClient->setClientSecret("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");
$googleClient->setRedirectUri("$baseurl/app/user/auth/signin-google.php");
$googleClient->addScope(['email', 'profile']);