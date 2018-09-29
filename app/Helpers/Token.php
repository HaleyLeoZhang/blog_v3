<?php
namespace App\Helpers;

// ----------------------------------------------------------------------
// 获取随机数
// ----------------------------------------------------------------------
// Link  : http://www.hlzblog.top/
// GITHUB: https://github.com/HaleyLeoZhang
// ----------------------------------------------------------------------

class Token
{

    /**
     * 随机生成固定长度的随机数
     * @param string  len  截取长度，默认八位
     * @param Int     type 返回类型 [general=>字母+数字,number=>纯数字,mix=>字母+数字+特殊符号,string=>大小写字母]
     * @return string
     */
    public static function rand_str($len = 8, $type = 'general')
    {
        $general = '0123456789qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM';
        $number  = '0123456789';
        $mix     = '0123456789qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM!@#$%^&*()_+[],./<>?;';
        $string  = 'qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM';

        $str = $$type; // 取出目标类型

        // - 长度不够，则拼接类型
        $str_len = count($str);
        if ($str_len < $len) {
            $target   = '';
            $loop_len = ceil($len / $str_len);
            for ($i = 0; $i < $loop_len; $i++) {
                $target .= $str;
            }
        } else {
            $target = $str;
        }

        return substr(str_shuffle($target), 0, $len);
    }

    /**
     * 依据微秒来生成不同字符串
     * @return string 生成的 token
     */
    public static function rand_token()
    {
        return md5(microtime(true) . self::rand_str(10, 'mix'));
    }

}
