<?php

require_once "../../config/autoload.php";
require_once "../b2/b2file.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $data = $_POST['data'] ?? null;
    if (!$data) {
        $resp['Err'] = "Something Went Wrong !";
    } else {

        $data = json_decode($data, true);
        $errs = [];

        if (json_last_error() == JSON_ERROR_NONE) {

            $files = is_array($data) ? $data : [$data];
            $b2 = new B2File();

            foreach ($files as $fileId) {
                if ($fileId) {
                    try {
                        $isFileDeleted = $b2->delFile($fileId);
                        if ($isFileDeleted) {
                            delFileMeta($db, $authType, $uid, $fileId);
                        }
                    } catch (Exception $e) {
                        if (strpos($e->getMessage(), "404")) {
                            if (!delFileMeta($db, $authType, $uid, $fileId)) {
                                $errs[] = $fileId;
                            }
                        } else {
                            $errs[] = $fileId;
                        }
                    }
                }
            }

            if (empty($errs)) {
                $resp['Success'] = true;
            } else {
                $resp['Err'] = "Something Went Wrong, Some Files May Not Be Deleted Or Will Be Delete In Short Time !";
            }
        } else {
            $resp['Err'] = "Invalid File, Or The File Is Deleted !";
        }
    }
}


echo json_encode($resp);