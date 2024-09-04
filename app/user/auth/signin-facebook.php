<?php

$isAuthNotRequired = false;
require_once "../../config/autoload.php";
require_once "../../../clients/facebook.php";

try {
    if (isset($_GET['state'])) {
        $fbHelper->getPersistentDataHandler()->set("state", $_GET['state']);
    }

    $accessToken = $fbHelper->getAccessToken();
    if ($accessToken) {
        $response = $fbClient->get('/me?fields=name,email,picture', $accessToken->getValue());
        $data = $response->getGraphUser();

        $name = $data->getName();
        $email = $data->getEmail();
        $profile = $data->getPicture()['url'];

        if(!$email){
            header("signin.php?err=0auth");
            throw new Exception("Invlaid user account or the account is not verified yet");
        }

        // add user data
        $params = [$name, $email, $profile];
        

        // auth user
        $user = new User();

        $userId = User::fetchUser($db, "facebook", $email, ['user_id'])['user_id'];
        if ($userId) {
            $user->setUserId($userId, "facebook");
        } else {
            $stmt = $db->qry("INSERT INTO facebook_users (user_name, user_email, user_profile) VALUES (?,?,?)", $params);
            if ($stmt) {
                $user->setUserId($db->getId(), "facebook");
            } else {
                throw new Exception("Failed to create user");
            }
        }

        header("Location:../../");
    }
} catch (Exception $e) {
    echo $e->getMessage();
}