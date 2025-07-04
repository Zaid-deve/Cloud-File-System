<?php

// authenticate and env user data
require_once "$root/app/user/user.php";
$user = new User();
$uid = $user->getUserId();
$authType = $user->getAuthType();

if (!isset($isAuthNotRequired)) {
    if (!$uid) {
        header("Location:$baseurl/app/user/auth/signin.php");
        $resp['Err'] = 'LOGIN_ERR';
        die($resp);
    } else {
        $data = $user::fetchUser($db, $authType, $uid, ['user_email', 'user_profile', 'user_name', 'user_timestamp', 'user_pass_key']);
        if ($data) {
            $user_email = $data['user_email'];
            $user_profile = $data['user_profile'];
            $user_name = $data['user_name'];
            $user_join_date = getDiff($data['user_timestamp']);
            $user_passkey = $data['user_pass_key'];
        }
    }
}
