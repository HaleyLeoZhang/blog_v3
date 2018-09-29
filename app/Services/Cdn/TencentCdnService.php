<?php
namespace App\Services\Cdn;

// ----------------------------------------------------------------------
// 图片转存腾讯CDN
// ----------------------------------------------------------------------
// Link  : http://www.hlzblog.top/
// GITHUB: https://github.com/HaleyLeoZhang
// ----------------------------------------------------------------------

require_once app_path('Libs/qcloudcos/include.php');

use App\Models\Logs\UploadLog;
use qcloudcos\Cosapi;

// 引入文件

class TencentCdnService extends BaseCdnService
{
    /**
     * 配置项
     * @param String : web_prefix 取回的域名，默认cdn域名[file][官网开启cdn才行]，cos源站[cos]
     * @param String : bucket_name 存储容器名
     */
    protected $web_prefix;
    protected $bucket_name;

    protected static $_this = null;

    public static function get_instance()
    {
        if (!self::$_this) {
            self::$_this              = new self();
            self::$_this->web_prefix  = env('COS_CNAME_HOST');
            self::$_this->bucket_name = env('COS_BUCKET_NAME');
            Cosapi::setRegion(env('COS_SET_REGION'));
        }
        return self::$_this;
    }

    /**
     * 文件上传
     * @param  $_FILE  临时文件的路径
     * @param  Boolean detail 是否返回详细信息
     * @return string CDN图片地址
     */
    public function upload($temp_path)
    {
        $path = '/'. $this->get_pic_path();
        // 创建文件夹
        $dst_folder        = substr($path, 0, strripos($path, '/'));
        $create_folder_ret = Cosapi::createFolder($this->bucket_name, $dst_folder);
        // 上传文件
        $scr_path = $temp_path; // 本地文件路径
        $dst_path = $path; // 上传的文件路径
        // @动作：上传
        $upload_ret = Cosapi::upload($this->bucket_name, $scr_path, $dst_path);

        $response_code = $upload_ret['code'] ?? 500;

        \Log::debug(__FUNCTION__ . '.request.', [
            'scr_path'          => $scr_path,
            'dst_path'          => $dst_path,
            'create_folder_ret' => $create_folder_ret,
        ]);
        \Log::debug(__FUNCTION__ . '.response.', $upload_ret);

        if (!$response_code) {
            $url = $this->web_prefix . $path;
            $this->log_upload($url, UploadLog::TYPE_TENCENT);
            return $url;
        } else {
            $exception = new \ApiException(null, \Consts::SERVICE_UPLOAD_CDN_FAILED);
            app('sentry')->captureException($exception);
            throw $exception;
        }
    }

    /**
     * 删除文件
     * @param  String  url  图片url
     * @param  Boolean detail 是否返回详细信息
     * @return Boolean
     */
    public function delete($url)
    {
        $this->log_upload_update($url);

        // $rule = quotemeta($this->web_prefix);
        // // 取出绝对路径
        // $path = str_replace($this->web_prefix, '', $url);
        // // @动作：删除 Object
        // $result = Cosapi::delFile($this->bucket_name, $path);

        // $response_code = $result['code'] ?? 500;

        // \Log::debug(__FUNCTION__, $result);

        // if (!$response_code) {
        //     return true;
        // } else {
        //     $text      = json_encode($result);
        //     $exception = new \ApiException($text);
        //     app('sentry')->captureException($exception);
        //     throw $exception;
        // }
    }

}
