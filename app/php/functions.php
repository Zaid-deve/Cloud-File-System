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

function getFilesMeta(Db $conn, $uid, $isReqHidden = false){
    if($uid){
        $stmt = $conn->qry("SELECT file_name name, file_id id,file_size size, file_type type, file_perms perms, file_uploader_id uploader, file_last_viewed recent FROM file_uploads WHERE file_uploader_id = ? AND file_visibility = ?", [$uid, intval($isReqHidden)]);
        return $stmt;
    }

    return false;
}