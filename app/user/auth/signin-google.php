<?php

$isAuthNotRequired = false;
require_once "../../config/autoload.php";
require_once "../../../clients/google.php";

if (isset($_GET['code'])) {
    try {
        // get access token
        $googleClient->fetchAccessTokenWithAuthCode($_GET['code']);
        $token = $googleClient->getAccessToken()['access_token'];
        $_SESSION['access_token'] = $token;
        $googleClient->setAccessToken($token);

        // Get user information
        $curl = curl_init("https://www.googleapis.com/oauth2/v1/userinfo?access_token=$token");
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer $token",
                "Accept: application/json"
            ]
        ]);

        $response = curl_exec($curl);

        if (curl_error($curl) || !$response) {
            throw new Exception('Fetch User Info Failed !');
        }

        // get user data

        $response = json_decode($response, true);
        $email = $response['email'];
        $name = $response['given_name'] . ' ' . $response['family_name'];
        $profile = $response['picture'];

        if (!$email) {
            header("signin.php?err=auth0");
            throw new Exception("Invalid account !");
            die();
        }

        // add user data
        $params = [$name, $email, $profile];

        // auth user
        $user = new User();

        $userId = User::fetchUser($db, "google", $email, ['user_id'])['user_id'];
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