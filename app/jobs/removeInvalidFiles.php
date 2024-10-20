<?php

require_once "../config/autoload.php";
require_once "../php/b2/b2file.php";

try {
    $b2 = new B2File();
    $bucketId = $b2->getCurrentBucketId();
    $files = $b2->listFiles(['BucketId' => $bucketId]);

    if ($files) {
        foreach ($files as $f) {
            $fileId = $f->getId();
            $fileSize = $f->getSize();

            if ($fileSize > MAX_FILE_UPLOAD_SIZE) {
                if (!$b2->deleteFile(['BucketId' => $bucketId, 'FileId' => $fileId])) {
                    throw new Exception("Failed to delete file from B2 for FileId: $fileId");
                }

                $result = $db->qry("DELETE FROM file_uploads WHERE file_id = ?", [$fileId]);
                if ($result === false) {
                    throw new Exception("Failed to delete file from database: [{$db->getErr()}]");
                }
            }
        }
    }
} catch (Exception $e) {
    file_put_contents('error_log.log', "[Error " . date('d/m/y H:i') . "] " . $e->getMessage() . PHP_EOL, FILE_APPEND);
} finally {
    $db->closeConn();
}
