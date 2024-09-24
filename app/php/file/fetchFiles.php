<?php

require_once "../../config/autoload.php";
require_once "../b2/b2file.php";


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fileType = $_POST['fileType'] ?? 'public';
    $passkey = $_POST['passKey'] ?? null;
    $isReqHidden = false;

    $err = null;
    if ($fileType == 'private') {
        $k = $user->getUserPasskey($db, $authType, $uid);
        if (is_null($k)) {
            $err = "NO_SET_PASS_KEY";
        } else if (!password_verify($passkey, $k)) {
            $err = "PASS_KEY_ERR";
        } else $isReqHidden = true;
    }

    if (empty($err)) {
        $files = getFilesMeta($db, $uid, $authType, $isReqHidden);
        if ($files !== false) {
            if ($db->getStatement()->rowCount() == 1) {
                $files = [$files];
            }

            $b2 = new B2File();
            $authToken = $b2->getAuthorizationToken();

            $files = array_map(function($f) use ($b2){
                $f['downloadUrl'] = $b2->getDownloadUrl($f['id']);
                return $f;
            }, $files);

            $resp['Success'] = true;
            $resp['Files'] = $files;
        } else {
            $resp['Err'] = "Something Went Wrong !";
        }
    } else $resp['Err'] = $err;
}

echo json_encode($resp);
