<?php

class User
{
    public function __construct()
    {
        if (!session_id()) {
            session_start();
        }
    }

    public function setUserId($id, $authType, $isCookie = false)
    {
        if ($id) {
            if ($isCookie) {
                setcookie("user_id", $id, time() + (3600 * 24), "/");
                setcookie("auth_type", $authType, time() + (3600 * 24), "/");
                return;
            }

            $_SESSION['user_id'] = $id;
            $_SESSION['auth_type'] = $authType;
        }
    }

    public function getUserId()
    {
        return $_SESSION['user_id'] ?? $_COOKIE['user_id'] ?? null;
    }

    public function getAuthType()
    {
        return $_SESSION['auth_type'] ?? $_COOKIE['auth_type'] ?? null;
    }

    static function fetchUser(Db $conn, $authType, $where, $return = [])
    {
        $cols = !empty($return) ? implode(",", $return) : "*";
        $stmt = $conn->qry("SELECT $cols FROM {$authType}_users WHERE user_id = ? || user_email = ?", [$where, $where]);
        if ($stmt) {
            return $stmt;
        }
    }

    function getAccountSize(Db $conn, $id)
    {
        $stmt = $conn->qry("SELECT IFNULL(SUM(file_size),0) as flimit FROM file_uploads WHERE file_uploader_id = ?", [$id]);
        if ($stmt !== false) {
            return $stmt;
        }
    }

    function isFileUploadLimitExceeded(Db $conn, $id, $bytes = 0)
    {
        $limit = $this->getAccountSize($conn, $id);
        if (($limit + ($bytes ?? 0)) < MAX_FILE_UPLOAD_LIMIT_PER_USER) {
            return false;
        }

        return true;
    }

    function logout()
    {
        session_unset();
        session_destroy();
        setcookie("user_id", "null", time() - 1, "/");
        setcookie("auth_type", "null", time() - 1, "/");
    }
}
