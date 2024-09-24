<?php

require_once "$root/clients/b2.php";

class B2File extends B2Client
{
    protected $downloadAuth;

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

    protected function getDownloadAuth()
    {
        if ($this->downloadAuth) {
            return $this->downloadAuth;
        }

        if ($this->isCacheEnabled() && apcu_exists('b2_download_authorization')) {
            $data = apcu_fetch('b2_download_authorization');
            $this->initDownloadAuthorization(json_decode($data, true));
        } else {
            $response = $this->sendAuthorizedRequest('POST', 'b2_get_download_authorization', [
                'bucketId' => $this->getCurrentBucketId(),
                'fileNamePrefix' => '',
                'validDurationInSeconds' => (604800  / 2)
            ]);

            if ($response && $response['authorizationToken']) {
                $this->downloadAuth = $response['authorizationToken'];
                if ($this->isCacheEnabled()) {
                    apcu_store("b2_download_authorization", json_encode([
                        'authorizationToken' => $this->downloadAuth,
                        'validDurationInSeconds' => (604800  / 2)
                    ]));
                }
            }
        }
    }

    protected function initDownloadAuthorization($data)
    {
        $authToken = $data['authorizationToken'];
        $expiry = $data['validDurationInSeconds'];
        if ($expiry && time() > $expiry || !$authToken) {
            apcu_delete('b2_download_authorization');
            $this->getDownloadAuth();
        } else {
            $this->downloadAuth = $authToken;
        }
    }

    public function getDownloadUrl($fileId)
    {
        return $this->apiUrl . "b2_download_file_by_id?fileId=$fileId&authToken=" . $this->authToken;
    }
}
