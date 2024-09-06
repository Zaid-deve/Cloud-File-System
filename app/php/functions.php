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
