<?php

use League\OAuth2\Client\Provider\Github;

require_once "$root/lib/github/vendor/autoload.php";

$cred = file_get_contents("$root/lib/github/credentials.json");
$cred = json_decode($cred, true);
$clientID = $cred['id'];
$clientSecret = $cred['secret'];
$redirectUri = $cred['uri'];

$github_client = new Github([
    'clientId'     => $clientID,
    'clientSecret' => $clientSecret,
    'redirectUri'  => $redirectUri,
]);

?>