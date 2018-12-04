<?php

namespace App\Models\Logs;

use Illuminate\Database\Eloquent\Model;

// 用户访问某些模块的日志

class ComicDownloadLogs extends Model
{
    protected $table      = 'comic_download_logs';
    protected $connection = 'yth_blog_ext';

    protected $fillable = [
        'comic_id', // comic编号，如，1->一人之下
        'page', // 第多少话
        'inner_page', // 这页的第多少张
        'src', // 图片地址（目前转存至sm.ms）
    ];

    // - 可用状态
    const STATUS_INVALID = 0; // 不可用
    const STATUS_VALID   = 1; // 可用

    // 漫画名称
    const COMMIC_ID_YIRENZHIXIA = 1; // 一人之下
}
