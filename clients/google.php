<?php

// using google client v2.17

use League\OAuth2\Client\Provider\Google;

require_once "$root/lib/google/vendor/autoload.php";
$googleClient = new Google([
    'clientId'     => '389186226720-n9uop2khm4miqbmirh2e943r3gfe5lsa.apps.googleusercontent.com',
    'clientSecret' => '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',
    'redirectUri'  => "$baseurl/app/user/auth/signin-google.php",
]);