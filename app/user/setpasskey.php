<?php

require_once "../config/autoload.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $passkey = htmlentities($_POST['passkey']);
    if (strlen($passkey) >= 6 || strlen($passkey <= 24)) {
        try {
            $enc_key = password_hash($passkey, PASSWORD_BCRYPT);
            $stmt = $db->qry("UPDATE {$authType}_users SET user_pass_key = ? WHERE user_id = ? && user_pass_key IS NULL", [$enc_key, $uid]);
            $resp['Success'] = $stmt or throw new Exception();
        } catch (Exception $e) {
            $resp['Err'] = "Failed to set passkey, passkey already exists or something went wrong !";
        }
    }
}

echo json_encode($resp);
