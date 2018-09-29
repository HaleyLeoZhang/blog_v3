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
     * 整理结果对象中的某个值 为 whereIn 可用的数组
     * @param Set set      查询对象返回的集合
     * @param string key_name  打算整理的对应表中的字段
     * @return array
     */
    public static function getWhereInArray($set, $key_name)
    {
        $arr = []; // 准备返回的结果
        for ($i = 0, $len = count($set); $i < $len; $i++) {
            $arr[] = data_get($set[$i], $key_name, '');
        }
        return $arr;
    }

    /**
     * 金额单位转换，元转分
     * @param decimal $money 元
     * @param int 分
     */
    public static function decimalToInt($money)
    {
        $str   = sprintf('%.2f', $money); // 浮点转字符串
        $arr   = explode('.', $str); // 整数与小数分开
        $total = implode('', $arr); // 去掉小数点
        return intval($total);
    }
}
