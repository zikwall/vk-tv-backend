<?php

namespace vktv\helpers;

class Date
{
    public static function relativeDayName($timestamp)
    {
        $date = date('d-m-Y', $timestamp);

        if($date == date('d-m-Y',time() + (24 * 3 * 60 * 60))) {
            return 'Послепослезавтра';
        }

        if($date == date('d-m-Y',time() + (24 * 2 * 60 * 60))) {
            return 'Послезавтра';
        }

        if($date == date('d-m-Y',time() + (24 * 60 * 60))) {
            return 'Завтра';
        }

        if($date == date('d-m-Y')) {
            return 'Сегодня';
        }

        if($date == date('d-m-Y',time() - (24 * 60 * 60))) {
            return 'Вчера';
        }

        if($date == date('d-m-Y',time() - (24 * 2 * 60 * 60))) {
            return 'Позавчера';
        }

        if($date == date('d-m-Y',time() - (24 * 3 * 60 * 60))) {
            return 'Позапозавчера';
        }

        return $date;
    }

    public static function fix900seconds(int $time) : int
    {
        return $time + 900;
    }

    public static function beetweenTimestampes(int $current, int $start, int $end) : bool
    {
        return $start <= $current && $current <= $end;
    }
}
