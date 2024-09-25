<?php

require_once "$root/clients/b2.php";

class B2File extends B2Client
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Generate a presigned URL for uploading a file
     *
     * @param string $bucketName The name of the Backblaze B2 bucket
     * @param string $fileName The name of the file to be uploaded
     * @param int $expiresInSeconds The number of seconds the presigned URL is valid for
     * @return array An array containing the presigned URL and authorization token
     */
    public function getPresignedUploadUrl()
    {
        $this->getAuthorizationToken();
        $response = $this->sendAuthorizedRequest('POST', 'b2_get_upload_url', [
            'bucketId' => $this->getCurrentBucketId(),
        ]);

        if ($response) {
            return $response;
        }
    }

    public function delFile($fileId)
    {
        if ($fileId) {
            $req = $this->deleteFile([
                'BucketId' => $this->getCurrentBucketId(),
                'FileId' => $fileId
            ]);

            return $req;
        }

        return false;
    }

    public function getDownloadUrl($fileName)
    {
        return $this->downloadUrl . "/file/clouduserfiles/$fileName?Authorization=" . $this->authToken;
    }
}
