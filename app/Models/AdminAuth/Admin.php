<?php

namespace App\Models\AdminAuth;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{

    /**
     * 对应表
     */
    protected $table = 'admins';

    /**
     * 填充字段
     */
    protected $fillable = [
        'secret', // 密码 - 盐值，每次生成密码时会重置 - 固定4位
        'password', // 密码加盐后
        'email', // 邮箱号只能对应一个账号
        'user_pic', // 用户头像地址
        'truename', // 用户真实姓名
        'remember_token', // 如果一个账号只能登录一次，则每次登录，会删掉上一次记录的登录信息
        'status', // 用户状态
        'user_id', // 关联users.id
    ];

    /**
     * 用户状态
     */
    const STATUS_NORMAL_USER  = 0; // 正常用户
    const STATUS_LOCK_USER    = -1;
    const STATUS_DELETED_USER = -10;

    public static $message_status = [
        self::STATUS_NORMAL_USER  => '正常',
        self::STATUS_LOCK_USER    => '已锁定',
        self::STATUS_DELETED_USER => '已注销',
    ];

    /**
     * 用户状态列表
     */
    public static $status_list = [
        self::STATUS_NORMAL_USER,
        self::STATUS_LOCK_USER,
        self::STATUS_DELETED_USER,
    ];

    /**
     * 默认头像，图片备份在 /static_pc/admin/head_pics/
     */
    public static $default_pics = [
        'https://i.loli.net/2018/09/22/5ba66470a5b3d.jpg',
        'https://i.loli.net/2018/09/22/5ba66470bd278.jpg',
        'https://i.loli.net/2018/09/22/5ba66470bd367.jpg',
        'https://i.loli.net/2018/09/22/5ba66470c6678.jpg',
        'https://i.loli.net/2018/09/22/5ba66470d3aea.jpg',
        'https://i.loli.net/2018/09/22/5ba66470d3a92.jpg',
        'https://i.loli.net/2018/09/22/5ba66470e9b9b.jpg',
        'https://i.loli.net/2018/09/22/5ba66470e9ae4.jpg',
        'https://i.loli.net/2018/09/22/5ba66470ea204.jpg',
        'https://i.loli.net/2018/09/22/5ba66470ea08f.jpg',
    ];

    /**
     * 创建用户的时候，获取默认头像
     */
    public static function get_rand_pic()
    {
        $max  = count(self::$default_pics) - 1;
        $rand = mt_rand(0, $max);
        return self::$default_pics[$rand];
    }

}
