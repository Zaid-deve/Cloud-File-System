<?php

require_once "../../config/autoload.php";
require_once "../b2/b2file.php";

function deleteFile(B2File $b2, Db $db, $uid, $fileId)
{
    $uploader = $db->qry("SELECT file_uploader_id FROM file_uploads WHERE file_id = ?", [$fileId]);
    if ($uploader) {
        if ($uploader != $uid) {
            return;
        }
    } else {
        return;
    }

    $r = $b2->deleteFile([
        'BucketId' => $b2->getCurrentBucketId(),
        'FileId' => $fileId
    ]);

    if ($r) {
        $dr = $db->qry("DELETE FROM file_uploads WHERE file_id = ? AND file_uploader_id = ?", [$fileId, $uid]);
    }

    return $r && $dr;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $data = $_POST['data'];

    if (!$data) {
        $resp['Err'] = 'Missing File !';
        die(json_encode($resp));
    }

    $decData = json_decode($data, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        $decData = htmlentities($data);
    }

    $delErrs = [];
    $b2 = new B2File();

    if (is_array($decData)) {
        foreach ($decData as $f) {
            if (!deleteFile($b2, $db, $uid, $f)) {
                $delErrs[] = $f;
            }
        }
    } else {
        if (!deleteFile($b2, $db, $uid, $decData)) {
            $delErrs[] = $decData;
        }
    }

    if (!empty($delErrs)) {
        if (is_array($decData)) {
            $resp['Err'] = "Some files may not have been deleted from server and not from records, i will be in some time.";
        } else {
            $resp['Err'] = "Failed to delete file, please try again !";
        }
    } else {
        $resp['Success'] = true;
    }
}


echo json_encode($resp);
