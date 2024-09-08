<?php

require_once "../config/autoload.php";
require_once "../php/b2/b2file.php";

try {
    $b2 = new B2File();
    $files = $b2->listFiles([
        'BucketId' => $b2->getCurrentBucketId()
    ]);
    if ($files) {
        foreach ($files as $f) {
            $fileId = $f->getId();
            $fileSize = $f->getSize();
            if ($fileSize < MAX_FILE_UPLOAD_SIZE) {
                $resp = $b2->deleteFile([
                    'BucketId' => $b2->getCurrentBucketId(),
                    'FileId' => $fileId
                ]);

                if ($resp) {
                    $r = $db->qry("DELETE FROM file_uploads WHERE file_id = ?", [$fileId]);
                    if ($r===false) {
                        throw new Exception("Failed to delete File from db: [{$db->getErr()}]");
                    }
                } else {
                    throw new Exception("Failed to Delete file at b2 ");
                }
            }
        }
    }
} catch (Exception $e) {
    $f = fopen('error_log.log', 'a');
    fwrite($f, "[Error " . date('d/m/y m:i') . "]\n" . $e->getMessage() . "\n");
    fclose($f);
}
finally{
    $db->closeConn();
}