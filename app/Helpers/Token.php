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

        $target          = '';
        $rand_last_index = strlen($str) - 1;
        for ($i = 0; $i < $len; $i++) {
            $index = mt_rand(0, $rand_last_index);
            $target .= $str[$index];
        }

        return $target;
    }

    protected static function uuid_v4(){
                return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',

            // 32 bits for "time_low"
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),

            // 16 bits for "time_mid"
            mt_rand(0, 0xffff),

            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 4
            mt_rand(0, 0x0fff) | 0x4000,

            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            mt_rand(0, 0x3fff) | 0x8000,

            // 48 bits for "node"
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }

    /**
     * 生成UUID
     * - https://baike.baidu.com/item/UUID 第5版基于名字的UUID（SHA1）
     * - https://www.php.net/manual/en/function.uniqid.php 官方文档地址
     * @param string $name 自定义字符
     * @param string $namespace 命名空间（符合uuid格式的字符串 如 1546058f-5a25-4334-85ae-e68f2a44bbaf
     * @return string
     * - 36字节长度
     */
    public static function uuid($name = 'www.hlzblog.top')
    {
        $namespace = self::uuid_v4();
        if (!preg_match('/^\{?[0-9a-f]{8}\-?[0-9a-f]{4}\-?[0-9a-f]{4}\-?' .
            '[0-9a-f]{4}\-?[0-9a-f]{12}\}?$/i', $namespace)) {
            return false;
        }

        // Get hexadecimal components of namespace
        $nhex = str_replace(array('-', '{', '}'), '', $namespace);

        // Binary Value
        $nstr = '';

        // Convert Namespace UUID to bits
        for ($i = 0; $i < strlen($nhex); $i += 2) {
            $nstr .= chr(hexdec($nhex[$i] . $nhex[$i + 1]));
        }

        // Calculate hash value
        $hash = sha1($nstr . $name);

        return sprintf('%08s-%04s-%04x-%04x-%12s',

            // 32 bits for "time_low"
            substr($hash, 0, 8),

            // 16 bits for "time_mid"
            substr($hash, 8, 4),

            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 5
            (hexdec(substr($hash, 12, 4)) & 0x0fff) | 0x5000,

            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            (hexdec(substr($hash, 16, 4)) & 0x3fff) | 0x8000,

            // 48 bits for "node"
            substr($hash, 20, 12)
        );
    }

}
