<?php


// standard functions

function getDiff($timestamp)
{
    $timeDifference = time() - strtotime($timestamp);

    if ($timeDifference < 1) {
        return 'just now';
    }

    $timeIntervals = [
        12 * 30 * 24 * 60 * 60 => 'year',
        30 * 24 * 60 * 60 => 'month',
        7 * 24 * 60 * 60 => 'week',
        24 * 60 * 60 => 'day',
        60 * 60 => 'hour',
        60 => 'minute',
        1 => 'second'
    ];

    foreach ($timeIntervals as $seconds => $label) {
        $difference = $timeDifference / $seconds;
        if ($difference >= 1) {
            $rounded = round($difference);
            return $rounded . ' ' . $label . ($rounded > 1 ? 's' : '') . ' ago';
        }
    }
}

function formatBytes($bytes, $precision = 2)
{
    $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
    if ($bytes == 0) {
        return '0 B';
    }

    $log = floor(log($bytes, 1024));
    $unitIndex = (int) $log;
    $size = $bytes / pow(1024, $log);
    return round($size, $precision) . ' ' . $units[$unitIndex];
}

function getFilesMeta(Db $conn, $authType, $uid, $isReqHidden = false, $recent = false, $max = null)
{
    if ($uid) {
        $maxClouse = $max ? "LIMIT $max" : "";
        $recentClouse = $recent ? "ORDER BY fid DESC" : "";
        $stmt = $conn->qry("SELECT file_name name, file_id id,file_size size, file_type type, file_perms perms, file_last_viewed recent FROM file_uploads WHERE file_uploader_id = ? AND file_visibility = ? $maxClouse $recentClouse", ["{$uid}_{$authType}", intval($isReqHidden)]);
        return $stmt;
    }

    return false;
}


function getFile(Db $conn, $fileId)
{
    if ($fileId) {
        $stmt = $conn->qry("SELECT file_name name, file_id id,file_size size, file_type type,file_uploader_id file_uploader, file_perms perms,file_timestamp upload_time, file_last_viewed recent FROM file_uploads WHERE file_id = ?", [$fileId]);
        return $stmt;
    }

    return false;
}
function delFileMeta(Db $conn, $authType, $uid, $fileId)
{
    if ($fileId) {
        $stmt = $conn->qry("DELETE FROM file_uploads WHERE file_id = ? && file_uploader_id = ?", [$fileId, "{$authType}_{$uid}"]);
        return $stmt;
    }
}
