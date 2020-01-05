<?php

namespace vktv\helpers;

class Date
{
    public static function relativeDayName($timestamp)
    {
        $date = date('d-m-Y', $timestamp);

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

        return $date;
    }
}
