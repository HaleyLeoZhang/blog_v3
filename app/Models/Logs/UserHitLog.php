<?php

namespace App\Models\Logs;

use Illuminate\Database\Eloquent\Model;

// 用户访问或者操作某些模块的日志

class UserHitLog extends Model
{
    protected $table = 'user_hit_logs';
    protected $connection = 'yth_blog_ext';

    protected $fillable = [
        'user_id', // 用户ID
        'related_id', // 某个模块的关联ID，如，访问的文章ID、绑定关系的ID
        'type', // 模块类型
        'remark', // 备注
        'status', // 有效状态，1->有效，0->无效
    ];

    // - 模块类型
    const TYPE_READ_ARTICLE = 1; // 阅读文章
    const TYPE_BIND_ADMIN   = 2; // 管理员与用户绑定关系

    // - 类型列表
    public static $type_list = [
        self::TYPE_READ_ARTICLE,
        self::TYPE_BIND_ADMIN,
    ];

    // - 类型描述
    public static $message_type = [
        self::TYPE_READ_ARTICLE => '阅读文章',
        self::TYPE_BIND_ADMIN   => '管理员与用户绑定关系',
    ];

    // - 数据状态
    const STATUS_INVALID = 0; // 无效
    const STATUS_VALID   = 1; // 有效

}
