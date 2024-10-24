<?php

$isAuthNotRequired = false;
require_once "../../config/autoload.php";
require_once "../../../clients/github.php";

try {
    $accessToken = $github_client->getAccessToken('authorization_code', ['code' => $_GET['code']]);

    if ($accessToken) {
        $user = $github_client->getResourceOwner($accessToken);
        $data = $user->toArray();

        $name = $data['name'];
        $email = $data['email'];
        $profile = $data['profile'];


        if (!$email) {
            header("signin.php?err=0auth");
            throw new Exception("Invlaid user account or the account is not verified yet");
        }

        // add user data
        $params = [$name, $email, $profile];


        // auth user
        $user = new User();

        $userId = User::fetchUser($db, "github", $email, ['user_id']);
        if ($userId) {
            $user->setUserId($userId, "github");
        } else {
            $stmt = $db->qry("INSERT INTO github_users (user_name, user_email, user_profile) VALUES (?,?,?)", $params);
            if ($stmt) {
                $user->setUserId($db->getId(), "github");
            } else {
                throw new Exception("Failed to create user");
            }
        }

        header("Location:../../");
    }
} catch (Exception $e) {
    echo $e->getMessage();
}
