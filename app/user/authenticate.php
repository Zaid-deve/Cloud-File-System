<?php

// authenticate and env user data
require_once "$root/app/user/user.php";
$user = new User();
$uid = $user->getUserId();
$authType = $user->getAuthType();

if (!isset($isAuthNotRequired)) {
    if (!$uid) {
        header("Location:$baseurl/app/user/auth/signin.php");
        die("An error occured !");
    } else {
        $data = $user::fetchUser($db, $authType, $uid, ['user_email', 'user_profile', 'user_name']);
        if ($data) {
            $user_email = $data['user_email'];
            $user_profile = $data['user_profile'];
            $user_name = $data['user_name'];
        }
    }
}
