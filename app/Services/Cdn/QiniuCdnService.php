<?php
namespace App\Services\Cdn;

// ----------------------------------------------------------------------
// 图片转存至 https://sm.ms/
// ----------------------------------------------------------------------
// Link  : http://www.hlzblog.top/
// GITHUB: https://github.com/HaleyLeoZhang
// ----------------------------------------------------------------------

use App\Models\Logs\UploadLog;
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;

// 引入文件

class QiniuCdnService extends BaseCdnService
{
    const API_URL = 'https://sm.ms/api/upload?inajax=1&ssl=1'; // 详见 API 文档 https://sm.ms/doc/
    /**
     * 配置项
     * @param String : secret_id 七牛鉴权ID
     * @param String : secret_key 七牛鉴权密钥
     * @param String : bucket 七牛存储对象
     * @param String : cname 配置的CNAME
     */
    protected $secret_id;
    protected $secret_key;
    protected $bucket;
    protected $cname;

    protected static $_this = null;

    public static function get_instance()
    {
        if (!self::$_this) {
            self::$_this = new self();

            self::$_this->secret_id  = env('QINIU_SECRET_ID');
            self::$_this->secret_key = env('QINIU_SECRET_KEY');
            self::$_this->bucket     = env('QINIU_BUCKET_NAME');
            self::$_this->cname      = env('QINIU_CNAME_HOST');
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
        $auth = new Auth($this->secret_id, $this->secret_key);
        // 生成上传Token
        $token = $auth->uploadToken($this->bucket);
        // 构建 UploadManager 对象
        $path    = $this->get_pic_path();
        $upload  = new UploadManager();
        $res_arr = $upload->putFile($token, $path, $temp_path);
        \LogService::debug(__FUNCTION__ . '.response ', $res_arr);

        if (count($res_arr)) {
            $url = $this->cname . '/' . $path;
            $this->log_upload($url, UploadLog::TYPE_QINIU);
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
