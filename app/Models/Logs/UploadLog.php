<?php

namespace App\Models\Logs;

use Illuminate\Database\Eloquent\Model;

// 图片上传日志

class UploadLog extends Model
{
    protected $table      = 'upload_logs';
    protected $connection = 'yth_blog_ext';
    
    protected $fillable   = [
        'url', // 图片地址  
        'crc32', // 图片crc32指纹，方便搜索  
        'type', // 上传图片类型
        'is_deleted', // 是否被删除  
    ];

    // - 模块类型
    const IS_DELETED_NO  = 0; // 图片存在
    const IS_DELETED_YES = 1; // 图片已被删除

    // - 类型列表
    public static $delete_list = [
        self::IS_DELETED_NO,
        self::IS_DELETED_YES,
    ];

    // - 类型描述
    public static $delete_text = [
        self::IS_DELETED_NO  => '图片存在',
        self::IS_DELETED_YES => '图片已被删除',
    ];

    // - CDN类型
    const TYPE_TENCENT = 1; // 腾讯
    const TYPE_SM = 2; // sm.ms
    const TYPE_QINIU = 3; // 七牛

    public static $type_list = [
        self::TYPE_TENCENT,
        self::TYPE_SM,
        self::TYPE_QINIU,
    ];

    public static $type_text = [
        self::TYPE_TENCENT => '腾讯云',
        self::TYPE_SM => 'sm.ms',
        self::TYPE_QINIU => '七牛云',
    ];
}
