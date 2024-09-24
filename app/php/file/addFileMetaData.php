<?php


require_once "../../config/autoload.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // file
    $fileName = htmlentities($_POST['fileName']);
    $fileSize = htmlentities($_POST['fileSize']);
    $fileType = htmlentities($_POST['fileType']);
    $fileId = htmlentities($_POST['fileId']);

    if ($user->isFileUploadLimitExceeded($db, $uid, $fileSize)) {
        $response['Err'] = 'ACCOUNT_LIMIT_ERROR';
        die(json_encode($response));
    }

    if ($fileSize > MAX_FILE_UPLOAD_SIZE) {
        $response['Err'] = 'Failed To Upload File (to large file)';
    } else if (!$fileName && !$fileId) {
        $response['Err'] = "Invalid File, Failed to upload !";
    } else {
        $params = ["{$authType}_{$uid}", $fileName, $fileSize, $fileType, $fileId];
        $params = array_map(function ($v) {
            return filter_var($v, FILTER_SANITIZE_SPECIAL_CHARS);
        }, $params);

        $stmt = $db->qry("INSERT INTO file_uploads (file_uploader_id, file_name,file_size,file_type,file_id) VALUES(?,?,?,?,?)", $params);
        $response['Success'] = $stmt;
    }
}

echo json_encode($response);
