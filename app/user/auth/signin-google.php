<?php

$isAuthNotRequired = false;
require_once "../../config/autoload.php";
require_once "../../../clients/google.php";

if (isset($_GET['code'])) {
    try {
        // get access token
        $token = $googleClient->getAccessToken('authorization_code', ['code' => $_GET['code']]);
        $_SESSION['access_token'] = $token->getToken();

        // Get user information
        $user = $googleClient->getResourceOwner($token);

        $email = $user->getEmail();
        $name = $user->getName();
        $profile = $user->getAvatar();
        if (!$email) {
            header("signin.php?err=auth0");
            throw new Exception("Invalid account !");
            die();
        }

        // add user data
        $params = [$name, $email, $profile];

        // auth user
        $user = new User();

        $userId = User::fetchUser($db, "google", $email, ['user_id']);
        if ($userId) {
            $user->setUserId($userId, "google");
        } else {
            $stmt = $db->qry("INSERT INTO google_users (user_name, user_email, user_profile) VALUES (?,?,?)", $params);
            if ($stmt) {
                $user->setUserId($db->getId(), "google");
            } else {
                throw new Exception("Failed to create user");
            }
        }

        header("Location:../../");
        die();
    } catch (Exception $e) {
        $e->getMessage();
    }
}

header("Location:signin.php?err=1");