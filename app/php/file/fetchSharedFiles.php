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
            $sharer = $db->qry("SELECT user_id, file_name name, file_size size, file_type type, file_id id FROM {$authType}_users u LEFT JOIN file_uploads ON file_uploader_id = u.user_id WHERE user_id = ?", [$sharedBy]);
            if (!$sharer) {
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
