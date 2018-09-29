<?php
namespace App\Services\Tool;

// ----------------------------------------------------------------------
// 数据过滤相关
// ----------------------------------------------------------------------
// Link  : http://www.hlzblog.top/
// GITHUB: https://github.com/HaleyLeoZhang
// ----------------------------------------------------------------------

require_once app_path('Libs/HTMLPurifier/HTMLPurifier.auto.php');

class FilterService
{

    protected function __contruct()
    {}

    /**
     * 过滤富文本中的XSS注入信息
     * @param string  $dirty_html 待过滤的HTML
     * @return string
     */
    public static function xss($dirty_html)
    {
        $config     = \HTMLPurifier_Config::createDefault();
        $purifier   = new \HTMLPurifier($config);
        $clean_html = $purifier->purify($dirty_html);
        return $clean_html;
    }

    // 通用图片类型
    public static $images_type = [
        //  $_FILES[$file_name]["type"]
        "image/gif",
        "image/jpg",
        "image/jpeg",
        "image/pjpeg",
        "image/png",
    ];

}
