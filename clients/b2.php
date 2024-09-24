<?php

use BackblazeB2\Client;
use Carbon\Carbon;

require_once "$root/lib/backblaze/vendor/autoload.php";

class B2Client extends Client
{
    private $credentials;
    protected $bucketId;
    protected $bucketName;

    // Init B2 Client
    public function __construct()
    {
        // load client cache
        $this->credentials = $this->loadCredentials();
        parent::__construct($this->credentials['accountId'], $this->credentials['applicationKey']);
        $this->loadClient();
    }

    /**
     * 
     * returns authorization token 
     */
    public function getAuthorizationToken()
    {
        if (!$this->authToken) {
            $this->authorizeAccount();
        }

        return $this->authToken;
    }

    /**
     * 
     * returns bucket id 
     */
    public function getCurrentBucketId()
    {
        return $this->bucketId ?? null;
    }

    /**
     * Load the Backblaze B2 credentials from credentials.json
     */
    private function loadCredentials()
    {
        $credentialsPath = DOC_ROOT . "/lib/backblaze/credentials.json";
        $jsonData = file_get_contents($credentialsPath);
        $data = json_decode($jsonData, true);
        $this->bucketId = $data['bucketId'];
        $this->bucketName = $data['bucketName'];

        return $data;
    }

    /**
     * 
     * Cache auth tokens and api urls
     */

    protected function isCacheEnabled()
    {
        return function_exists("apcu_enabled") && apcu_enabled();
    }

    protected function cacheClient()
    {
        if (!$this->isCacheEnabled()) {
            return;
        }

        if ($this->authToken) {
            $cache = [
                'authToken' => $this->authToken,
                'apiUrl' => $this->apiUrl,
                'downloadUrl' => $this->downloadUrl,
                'reAuthTime' => $this->reAuthTime
            ];
            apcu_store('b2_client_data', json_encode($cache), time() + (3600 * 12));
        }
    }

    private function loadClient()
    {
        if ($this->isCacheEnabled() && apcu_exists('b2_client_data')) {
            $data = json_decode(apcu_fetch('b2_client_data'), true);
            if ($data) {
                $reAuthTime = Carbon::parse($data['reAuthTime']);
                if (Carbon::now('UTC')->timestamp < $reAuthTime->timestamp) {
                    $this->initClient($data);
                } else {
                    $this->authorizeAccount();
                    $this->cacheClient();
                }
            }
        } else {
            $this->authorizeAccount();
            $this->cacheClient();
        }
    }

    private function initClient($data)
    {
        if ($data) {
            $this->authToken = $data['authToken'];
            $this->apiUrl = $data['apiUrl'];
            $this->downloadUrl = $data['downloadUrl'];
            $this->reAuthTime = Carbon::now('UTC');
            $this->reAuthTime->addSeconds($this->authTimeoutSeconds);
        }
    }
}
