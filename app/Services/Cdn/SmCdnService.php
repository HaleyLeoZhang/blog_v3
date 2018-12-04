<?php
namespace App\Services\Cdn;

// ----------------------------------------------------------------------
// 图片转存至 https://sm.ms/
// ----------------------------------------------------------------------
// Link  : http://www.hlzblog.top/
// GITHUB: https://github.com/HaleyLeoZhang
// ----------------------------------------------------------------------

use App\Helpers\CurlRequest;
use App\Models\Logs\UploadLog;

// 引入文件

class SmCdnService extends BaseCdnService
{
    const API_URL = 'https://sm.ms/api/upload?inajax=1&ssl=1'; // 详见 API 文档 https://sm.ms/doc/
    /**
     * 配置项
     * @param String : api 上传的API
     */
    protected $api;

    protected static $_this = null;

    public static function get_instance()
    {
        if (!self::$_this) {
            self::$_this = new self();
        }
        return self::$_this;
    }

    /**
     * 文件上传
     * @param  $_FILE  临时文件的路径
     * @param  Boolean detail 是否返回详细信息
     * @return Boolean false=>状态 |  true=>Array 详细信息
     */
    public function upload($temp_path)
    {
        // - 第三方配置
        $image = new \CURLFile($temp_path);
        $data  = [
            'smfile' => $image,
        ];
        $header = [
            "referer: https://sm.ms/",
            "user-agent: Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.221 Safari/537.36 SE 2.X MetaSr 1.0",
            "x-requested-with: XMLHttpRequest",
            'x-forward-for: 154.34.6.54',
        ];
        \LogService::debug(__FUNCTION__ . '.request.', $data, $header);
        $response = CurlRequest::run(self::API_URL, $data, $header);
        \LogService::debug(__FUNCTION__ . '.response ' . $response);
        $res = json_decode($response);
        if ($res->code == 'success') {
            $url = $res->data->url;
            $this->log_upload($url, UploadLog::TYPE_SM);
            return $url;
        } else {
            $exception = new \ApiException($res->msg);
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
    }

}
