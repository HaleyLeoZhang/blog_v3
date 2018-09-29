<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{

    /**
     * 对应表
     */
    protected $table = 'users';

    /**
     * 填充字段
     */
    protected $fillable = [
        'oauth_key', // 第三方的识别号
        'crc32', // 'oauth_key 与 type 字段值拼接为一个字符后，计算的crc32值，用于用户搜索
        'remember_token', // 如果一个账号只能登录一次，则每次登录，会删掉上一次记录的登录信息
        'type', // 第三方类别
        'name', // 用户昵称
        'pic', // 用户头像地址
        'status', // 用户状态：0->正常，-1->锁定，-10->注销
        'is_deleted', // 软删除，1->已删除
    ];

    const IS_DELETED_NO  = 0; // 数据正常
    const IS_DELETED_YES = 1; // 已软删

    // ---- 全部类型 ----
    const SHOW_ALL = -200; // 显示全部内容

    /**
     * 用户状态
     */
    const STATUS_NORMAL_USER  = 0; // 正常用户
    const STATUS_LOCK_USER    = -1; // 锁定用户帐号
    const STATUS_DELETED_USER = -10; // 已注销

    public static $message_status = [
        self::SHOW_ALL            => '---全部---',
        self::STATUS_NORMAL_USER  => '正常',
        self::STATUS_LOCK_USER    => '锁定中',
        self::STATUS_DELETED_USER => '已注销',
    ];

    // - 用户类型
    const USER_TYPE_ADMIN  = 0;
    const USER_TYPE_SINA   = 1;
    const USER_TYPE_QQ     = 2;
    const USER_TYPE_GITHUB = 3;
    // const USER_TYPE_WECHAT = 4; // - TEST 已封装 通过认证的（企业才行，个人的不可以）公众号可用

    public static $message_user_type = [
        self::SHOW_ALL         => '---全部---',
        self::USER_TYPE_ADMIN  => '管理员',
        self::USER_TYPE_SINA   => '新浪',
        self::USER_TYPE_QQ     => 'QQ',
        self::USER_TYPE_GITHUB => 'Github',
    ];

    public static $src_user_type = [
        self::USER_TYPE_ADMIN  => '/static_pc/img/default/icon_qzone.ico',
        self::USER_TYPE_SINA   => '/static_pc/img/third/sina.png',
        self::USER_TYPE_QQ     => '/static_pc/img/third/qq.png',
        self::USER_TYPE_GITHUB => '/static_pc/img/third/github.png',
    ];

    public static $user_type_map = [
        "qq"     => self::USER_TYPE_QQ,
        "sina"   => self::USER_TYPE_SINA,
        "github" => self::USER_TYPE_GITHUB,
        // "wechat" => self::USER_TYPE_WECHAT, // - TEST
    ];

}
