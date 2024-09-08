<?php


require_once "../../config/autoload.php";
require_once "./b2file.php";

if (!empty($_POST)) {
    $fileName = $_POST['fileName'];
    $fileSize = $_POST['fileSize'];
    if (!$fileName) {
        $response['Err'] = "Failed to generate upload url !";
        die(json_encode($response));
    }

    if ($fileSize > MAX_FILE_UPLOAD_SIZE) {
        $response['Err'] = "Max file size limit exceeded!";
        die(json_encode($response));
    }

    if ($user->isFileUploadLimitExceeded($db, $uid, $fileSize)) {
        $response['Err'] = "ACCOUNT_LIMIT_ERR";
        die(json_encode($response));
    }

    $b2File = new B2File();
    $data = $b2File->getPresignedUploadUrl();
    if ($data) {
        $response['Success'] = true;
        $response['Data'] = $data;
    }
}

echo json_encode($response);
