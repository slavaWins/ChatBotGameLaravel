<?php

    namespace App\Helpers;

    class  TimeHelper
    {

       public static function dateRus($time) {
            $month_name =
                [1  => 'янв',
                 2  => 'фев',
                 3  => 'мар',
                 4  => 'апр',
                 5  => 'мая',
                 6  => 'июн',
                 7  => 'июл',
                 8  => 'авг',
                 9  => 'сен',
                 10 => 'окт',
                 11 => 'ноя',
                 12 => 'дек',
                ];

            $month = $month_name[date('n', $time)];

            $day = date('j', $time);
            $year = date('Y', $time);
            $hour = date('G', $time);
            $min = date('i', $time);

            $date = $day.' '.$month.' '.$year;

            return $date;
        }


        static function date_draw($time, $returnIfNull = 'Не указано') {
            if ($time <= 10) return $returnIfNull;


            return date("d.m.Y", $time);

        }

        /**
         * Крутая фича что бы разбавить любой интерфейс. Из юникса возвращает строку "5 минут назад".
         * @param $time unix Юникс время
         * @param $returnIfNull string Текст который вернется если дата null
         * @return string
         */
        static function time_back($time, $returnIfNull = 'Не указано') {


            if ($time <= 10) return $returnIfNull;

            if ($time > time()) {
                return time_downcounter($time);
            }

            $month_name =
                [1  => 'янв',
                 2  => 'фев',
                 3  => 'мар',
                 4  => 'апр',
                 5  => 'мая',
                 6  => 'июн',
                 7  => 'июл',
                 8  => 'авг',
                 9  => 'сен',
                 10 => 'окт',
                 11 => 'ноя',
                 12 => 'дек',
                ];

            $month = $month_name[date('n', $time)];

            $day = date('j', $time);
            $year = date('Y', $time);
            $hour = date('G', $time);
            $min = date('i', $time);

            $date = $day.' '.$month.' '.$year.'  в '.$hour.':'.$min;

            $dif = time() - $time;

            if ($dif < 59) {
                return $dif." сек. назад";
            }else if ($dif / 60 > 1 and $dif / 60 < 59) {
                return round($dif / 60)." мин. назад";
            }else if ($dif / 3600 > 1 and $dif / 3600 < 23) {
                return round($dif / 3600)." час. назад";
            }else {
                return $date;
            }
        }


    }