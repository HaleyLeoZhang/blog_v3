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
    const COMMIC_ID_YIRENZHIXIA         = 1; // 一人之下
    const COMMIC_ID_ZUIJIANGNONGMINGONG = 2; // 最强农民工
    const COMMIC_ID_JIEMOREN            = 3; // 戒魔人

    // 漫画对应详细名称
    static $comic_info = [
        self::COMMIC_ID_YIRENZHIXIA         => [
            'en' => 'yirenzhixia',
            'zh' => '一人之下',
        ],
        self::COMMIC_ID_ZUIJIANGNONGMINGONG => [
            'en' => 'zuijiangnongmingong',
            'zh' => '最强农民工',
        ],
        self::COMMIC_ID_JIEMOREN            => [
            'en' => 'jiemoren',
            'zh' => '戒魔人',
        ],
    ];
}
