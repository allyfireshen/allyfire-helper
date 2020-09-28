<?php
// +----------------------------------------------------------------------
// | Alpicool [ WE MAKE YOU FEEL COOL ]
// +----------------------------------------------------------------------
// | Copyright (c) 2020-2021 http://alpicool.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: Allyfireshen <allyfireshen@alpicool.com>
// +----------------------------------------------------------------------

namespace allyfireshen\helper;


class Timer
{
    /**
     * 返回今日开始和结束的时间戳
     * @return array
     */
    public static function today()
    {
        list($year, $month, $day) = explode('-', date('Y-m-d'));
        return [
            mktime(0, 0, 0, $month, $day, $year),
            mktime(23, 59, 59, $month, $day, $year)
        ];
    }

    /**
     * 返回昨日开始和结束的时间戳
     * @return array
     */
    public static function yesterday()
    {
        $yesterday = date('d') - 1;
        return [
            mktime(0, 0, 0, date('m'), $yesterday, date('Y')),
            mktime(23, 59, 59, date('m'), $yesterday, date('Y'))
        ];
    }

    /**
     * 返回本周开始和结束的时间戳
     * @return array
     */
    public static function week()
    {
        list($year, $month, $day, $week) = explode('-', date('Y-m-d-w'));
        if ($week == 0) $week = 7; //修正周日的问题
        return [
            mktime(0, 0, 0, $month, $day - $week + 1, $year), mktime(23, 59, 59, $month, $day - $week + 7, $year)
        ];
    }

    /**
     * 返回上周开始和结束的时间戳
     * @return array
     */
    public static function lastWeek()
    {
        $timestamp = time();
        return [
            strtotime(date('Y-m-d', strtotime("last week Monday", $timestamp))),
            strtotime(date('Y-m-d', strtotime("last week Sunday", $timestamp))) + 24 * 3600 - 1
        ];
    }

    /**
     * 返回本月开始和结束的时间戳
     * @return array
     */
    public static function month()
    {
        list($year, $month, $time) = explode('-', date('Y-m-t'));
        return [
            mktime(0, 0, 0, $month, 1, $year),
            mktime(23, 59, 59, $month, $time, $year)
        ];
    }

    /**
     * 返回上个月开始和结束的时间戳
     * @return array
     */
    public static function lastMonth()
    {
        $year = date('Y');
        $month = date('m');
        $begin = mktime(0, 0, 0, $month - 1, 1, $year);
        $end = mktime(23, 59, 59, $month - 1, date('t', $begin), $year);

        return [$begin, $end];
    }

    /**
     * 返回今年开始和结束的时间戳
     * @return array
     */
    public static function year()
    {
        $year = date('Y');
        return [
            mktime(0, 0, 0, 1, 1, $year),
            mktime(23, 59, 59, 12, 31, $year)
        ];
    }

    /**
     * 返回去年开始和结束的时间戳
     * @return array
     */
    public static function lastYear()
    {
        $year = date('Y') - 1;
        return [
            mktime(0, 0, 0, 1, 1, $year),
            mktime(23, 59, 59, 12, 31, $year)
        ];
    }
}