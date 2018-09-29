<?php
namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Model;

// 图片上传日志

class Background extends Model
{
    protected $table = 'backgrounds';

    protected $fillable = [
        'url', // 图片地址
        'is_deleted', // 软删除，1->已删除
    ];

    // ---------------------- 删除状态 ----------------------

    const IS_DELETED_NO  = 0; // 未删除
    const IS_DELETED_YES = 1; // 已删除

    public static $list_delete = [
        self::IS_DELETED_NO,
        self::IS_DELETED_YES,
    ];

    public static $text_delete = [
        self::IS_DELETED_NO  => '正常',
        self::IS_DELETED_YES => '已删除',
    ];

}
