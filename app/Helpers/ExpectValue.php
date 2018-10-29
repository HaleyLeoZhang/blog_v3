<?php

namespace App\Helpers;

// -------------------------------------------------------------
// 一元线性回归，预期数据计算
// -------------------------------------------------------------
// 算法介绍：https://baike.baidu.com/item/回归直线方程/4291406
// -------------------------------------------------------------
// Link  : http://www.hlzblog.top/
// GITHUB: https://github.com/HaleyLeoZhang
// ----------------------------------------------------------------------

class ExpectValue
{
    private function __construct()
    {
        // - 
    }

    /**
     * 主输出程序
     * @param array $sample_arr 按顺序的一维数组
     * @return string
     * - 预期值
     */
    public static function compute($sample_arr)
    {
        $ins = new self();
        $avg_x = $ins->get_avg_x($sample_arr);
        $avg_y = $ins->get_avg_y($sample_arr);
        $const_b = $ins->get_const_b($avg_x, $avg_y, $sample_arr);
        $const_a = $ins->get_const_a($avg_x, $avg_y, $const_b);
        $expect = $ins->get_expect_y($const_a, $const_b, count($sample_arr));
        return $expect;
    }

    /**
     * 这个值与顺序号相关联
     * @param array $sample_arr 样本值
     * @return int
     */
    protected function get_avg_x(&$sample_arr)
    {
        $total = count($sample_arr);
        return $total;
    }

    /**
     * 这个值与顺序号相关联
     * @param array $sample_arr 样本值
     * @return int
     */
    protected function get_avg_y(&$sample_arr)
    {
        $sum = 0;
        $len = count($sample_arr);
        for ($x = 0; $x < $len; $x++) {
            $sum += $sample_arr[$x];
        }
        $avg = $sum / $len;
        return $avg;
    }

    /**
     * 计算常量 b
     * @param int $avg_x 平均值x
     * @param int $avg_y 平均值y
     * @param array $sample_arr 按顺序的一维数组
     * @return int
     */
    protected function get_const_b($avg_x, $avg_y, &$sample_arr)
    {
        $child_sum = 0;
        $len = count($sample_arr);
        // 分子计算
        for ($x = 0; $x < $len; $x++) {
            $child_sum += ($x - $avg_x) * ($sample_arr[$x] - $avg_y );
        }
        // 分母计算
        $monther_sum = 0;
        for ($x = 0; $x < $len; $x++) {
            $monther_sum += ($x - $avg_x) ^ 2;
        }
        // 常量 b
        $const_b = $child_sum / $monther_sum;
        return $const_b;
    }

    /**
     * 计算常量 a
     * @param int $avg_x 平均值x
     * @param int $avg_y 平均值y
     * @param int $const_b 线性回归常量 b
     * @return int
     */
    protected function get_const_a($avg_x, $avg_y, $const_b)
    {
        $const_a = $avg_y - $const_b * $avg_x;
        return $const_a;
    }

    /**
     * 依据线性回归表达式，计算预期值
     * @param int $const_a 线性回归常量 a
     * @param int $const_b 线性回归常量 b
     * @param int $len     当前传入数组的长度
     * @return int
     */
    protected function get_expect_y($const_a, $const_b, $len)
    {
        $x = $len + 1;
        $expect = $const_b * $x + $const_a;
        return $expect;
    }


}
