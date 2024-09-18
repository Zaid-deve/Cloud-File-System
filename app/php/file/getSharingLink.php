<?php

use Firebase\JWT\JWT;

require_once "../../config/autoload.php";
require_once "../../../lib/jwt/vendor/autoload.php";

if ($_SERVER['REQUEST_METHOD']) {
    try {
        $payload = [
            'ShareBy' => $uid,
            'AuthType' => $authType,
            'Expires' => time() * (3600 * 7),
            'Identifier' => getenv("JwtIdentifier")
        ];

        $uri = JWT::encode($payload, getenv('JwtKey'), 'HS256');
        $resp['Success'] = true;
        $resp['ShareUri'] = "$baseurl/app/view/share.php?data=" . $uri . "&shareType=folder";
    } catch (Exception $e) {
        $resp['Err'] = $e->getMessage();
    }
}

echo json_encode($resp);
