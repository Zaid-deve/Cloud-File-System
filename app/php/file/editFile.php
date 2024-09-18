<?php

require_once "../../config/autoload.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if (!empty($_POST['filename']) && !empty($_POST['fileId'])) {
            $fileId = htmlentities($_POST['fileId']);
            $filename = htmlentities($_POST['filename']);
            $readPerm = filter_var($_POST['r'], FILTER_VALIDATE_BOOLEAN);
            $writePerm = filter_var($_POST['w'], FILTER_VALIDATE_BOOLEAN);

            if ($filename && preg_match('/[\/\\:*?"<>|]/', $filename)) {
                throw new Exception("Invalid filename.");
            }

            $filePerms = '';
            if ($readPerm) {
                $filePerms .= 'r';
            }
            if ($writePerm) {
                $filePerms .= 'w';
            }

            $filePerms = $filePerms ?: null;

            $qry = "UPDATE file_uploads SET file_name = ?, file_perms = ? WHERE file_id = ? && file_uploader_id = ?";
            $stmt = $db->qry($qry, [$filename, $filePerms, $fileId, $uid]);

            if ($stmt) {
                $resp['Success'] = true;
            } else {
                throw new Exception("Failed to update file Or no changes had made !");
            }
        }
    } catch (Exception $e) {
        $resp['Err'] = $e->getMessage() ?? 'Something Went Wrong !';
    }
}

echo json_encode($resp);
