<?php
namespace App\Services\Crypt;

// ----------------------------------------------------------------------
// 加解密 - 基类
// ----------------------------------------------------------------------
// Link  : http://www.hlzblog.top/
// GITHUB: https://github.com/HaleyLeoZhang
// ----------------------------------------------------------------------

interface BaseCryptService
{
    
    /**
     * 加密
     * @param String : data 需要加密的数据
     * @return String: 密文
     */
    public static function encrypt();

    /**
     * 解密
     * @param String : data 需要解密的数据
     * @return String: 明文
     */
    public static function decrypt();
}
