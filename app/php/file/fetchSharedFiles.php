<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

require_once "../../config/autoload.php";
require_once "../../../lib/jwt/vendor/autoload.php";

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    try {
        $data = $_POST['data'] ?? null;
        if ($data) {
            $token = JWT::decode($data, new Key(getenv('Jwtkey'), 'HS256'));

            if (!$token || !$token->Identifier || $token->Identifier != getenv("JwtIdentifier")  || !$token->ShareBy || !$token->AuthType) {
                throw new Exception('Invalid Sharing Link, please request the sender to generate again !');
            }

            $expiry = $token->Expiry ?? null;
            if($expiry){
                if(time() > $expiry){
                    throw new Exception("Link is expired !");
                }
            }

            $sharedBy = $token->ShareBy;
            $authType = $token->AuthType;
            $sharer = getFilesMeta($db, $authType, $sharedBy);
            if ($sharer === false) {
                throw new Exception('Invalid Sharing Link, please request the sender to generate again !');
            }

            $resp['Success'] = true;
            $resp['Files'] = $sharer;
        }
    } catch (Exception $e) {
        $resp['Err'] = $e->getMessage() ?? 'Something Went Wrong';
    }
}

echo json_encode($resp);
