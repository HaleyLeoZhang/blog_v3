<?php
namespace App\Bussiness\Admin\Logic;

require_once app_path('Libs/Michelf/MarkdownExtra.inc.php');
use App\Models\AdminAuth\Admin;
use App\Services\Cdn\QiniuCdnService;
use App\Services\Cdn\SmCdnService;
use App\Services\Cdn\TencentCdnService;
use App\Services\Tool\FilterService;

class UploadAdminLogic
{
    const LIMIT_PICTURE_SIZE = 300; // 单位,KB
    /**
     * @return array
     */
    public static function markdown($file_info)
    {
        try {
            $cdn_path           = self::upload_images($file_info);
            $success            = [];
            $success["success"] = 1; // 0 表示上传失败，1 表示上传成功
            $success["url"]     = $cdn_path; // 上传成功时才返回
            return $success;
        } catch (\Exception $exception) {
            $error            = [];
            $error["success"] = 0;
            $error["message"] = $exception->getMessage(); // 提示的信息，上传成功或上传失败及错误信息等。
            app('sentry')->captureException($exception);
            return $error;
        }
    }

    /**
     * @return array
     */
    public static function editor($file_info)
    {
        try {
            $cdn_path            = self::upload_images($file_info);
            $success             = [];
            $success["state"]    = "SUCCESS";
            $success["url"]      = $cdn_path;
            $success["title"]    = "查看图片";
            $success["original"] = "-";
            return $success;
        } catch (\Exception $exception) {
            $error             = [];
            $error['state']    = "error|" . $exception->getMessage(); // 提示的信息，上传成功或上传失败及错误信息等。
            $error['title']    = "查看图片";
            $error['original'] = "-";
            app('sentry')->captureException($exception);
            return $error;
        }
    }

    /**
     * 上传图片
     * @return string
     */
    protected static function upload_images($file_info): string
    {
        extract($file_info); // 'path', 'type', 'size'
        // 文件类型过滤
        if (!in_array($type, FilterService::$images_type)) {
            throw new \ApiException("文件类型不支持");
        }
        // 文件大小限制
        $limit_size = self::LIMIT_PICTURE_SIZE * 1024;
        if ($size > $limit_size) {
            throw new \ApiException('文件大小超出上限（' . self::LIMIT_PICTURE_SIZE . 'KB）');
        }
        // 上传文件，优先顺序：腾讯、七牛、sm.ms图床
        if ('' != env('COS_CNAME_HOST', '')) {
            $cdn_path = TencentCdnService::get_instance()->upload($path);
        } elseif ('' != env('QINIU_CNAME_HOST', '')) {
            $cdn_path = QiniuCdnService::get_instance()->upload($path);
        } else {
            $cdn_path = SmCdnService::get_instance()->upload($path);
        }
        return $cdn_path;
    }

}
