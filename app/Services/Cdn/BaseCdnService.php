<?php
namespace App\Services\Cdn;

// ----------------------------------------------------------------------
// 第三方图片上传，基类封装
// ----------------------------------------------------------------------
// Link  : http://www.hlzblog.top/
// GITHUB: https://github.com/HaleyLeoZhang
// ----------------------------------------------------------------------

use App\Helpers\Token;
use App\Models\Logs\UploadLog;

abstract class BaseCdnService
{
    /**
     * 返回链式实例
     */
    // abstract public function get_instance();

    /**
     * 文件上传
     * @param  string  $temp_path  临时文件的路径 $_FILE[$name]['tmp_name']
     * @return string  文件 CDN 地址
     */
    abstract public function upload($temp_path);

    /**
     * 删除文件
     * @param  String  url  文件 CDN 地址
     * @param  Boolean detail 是否返回详细信息
     * @return void
     */
    abstract public function delete($url);

    /**
     * 图片上传日志
     * @param string $url  CDN图片日志
     * @return void
     */
    public function log_upload($url, $type)
    {
        $data = [
            'url'   => $url,
            'crc32' => crc32($url),
            'type'  => $type,
        ];
        UploadLog::create($data);
    }

    /**
     * 图片日志状态 - 修改
     * @param string $url  CDN图片日志
     * @return void
     */
    public function log_upload_update($url)
    {
        $data = [
            'is_deleted' => UploadLog::IS_DELETED_YES,
        ];
        $crc32 = crc32($url);
        \Log::info($crc32);
        UploadLog::where('crc32', '=', $crc32)
            ->update($data);
    }

    /**
     * 获取随机图片地址
     * @return string
     */
    public function get_pic_path()
    {
        $suffix   = '.jpg';
        $dir      = 'blog/upload/img/'; // 七牛的文件目录，省去第一个/，腾讯的需要第一个 /
        $date     = date('Y_m_d_');
        $rand     = Token::rand_str(8);
        $pic_path = $dir . $date . $rand . $suffix;
        return $pic_path;
    }

}
