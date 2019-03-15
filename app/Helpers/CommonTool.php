<?php
namespace App\Helpers;

// ----------------------------------------------------------------------
// 公共工具类
// ----------------------------------------------------------------------
// Link  : http://www.hlzblog.top/
// GITHUB: https://github.com/HaleyLeoZhang
// ----------------------------------------------------------------------

class CommonTool
{
    /**
     * 依据一个数组中的键名，整合生成分组数据，以生成二维数组
     * @param array $array 待处理的数组
     * @param string|int $key 一个数组数据中的一个键名
     * @param bool $is_single true->只生成一维数据,false->生成二维数组数据
     * @return array
     */
    public static function array_group_by_key($array, $key, $is_single = true)
    {
        $result = []; // 初始化一个数组
        foreach ($array as $item) {
            if ($is_single) {
                $result[$item[$key]] = $item;
            } else {
                $result[$item[$key]][] = $item;
            }
        }
        return $result;
    }
}
