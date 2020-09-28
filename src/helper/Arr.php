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


class Arr
{
    /**
     * 将二维数组数组按某个键提取出来组成新的索引数组
     * @param array $array
     * @param string $key
     * @return array
     */
    public static function extract($array = [], $key = 'id') : array
    {
        $count = count($array);

        $new_arr = [];

        for($i = 0; $i < $count; $i++) {
            if (!empty($array) && !empty($array[$i][$key])) {
                $new_arr[] = $array[$i][$key];
            }
        }

        return $new_arr;
    }
}