<?php
namespace App\Exceptions;

// ----------------------------------------------------------------------
// 报错编码与反馈信息
// ----------------------------------------------------------------------
// Link  : http://www.hlzblog.top/
// GITHUB: https://github.com/HaleyLeoZhang
// ----------------------------------------------------------------------

class Consts
{

    /**
     * 公共错误码 - HTTP型
     */
    const SUCCESS          = 200; // 请求成功
    const ACCESS_FORBIDDEN = 401; // 您的登录信息已失效，请重新登录
    const FAILED_INNER     = 500; // 服务器内部错误（对外文案：服务繁忙，请稍候重试）
    const FAILED           = 501; // 操作失败，如，一些本次的报错信息在模型里面
    const FAILED_TIMEOUT   = 504; // 操作超时

    /**
     * 公共错误码 - 通用型
     */
    const AT_API_REQUEST_LIMIT = 1001; // 您访问太快，请客官稍候重试
    const VALIDATE_PARAMS      = 1002; // 传入参数不正确

    /**
     * 业务逻辑错误码
     */
    // const USER_ACCOUNT_NOT_FOUND         = 10001; // 帐号不存在
    const USER_ACCOUNT_LOG_WRITE_FAILED  = 10002; // 用户登录日志，写入失败
    const USER_ACCOUNT_OR_PASSWORD_ERROR = 10003; // 帐号或者密码不正确
    const USER_ACCOUNT_FOUND             = 10004; // 该帐号已存在
    const USER_ACCOUNT_STATUS_NOT_EXISTS = 10005; // 该用户状态不存在
    const USER_GOOGLE_CATCHAR_NOT_CREATE = 10006; // 谷歌验证码未设置


    /**
     * 服务类错误
     */
    const SERVICE_UPLOAD_CDN_FAILED = 30001; // 图片上传到CDN服务器失败

    /**
     * 业务逻辑错误码与对应描述信息配置
     */
    public static $message = [
        /**
         * 公共错误码 - HTTP型
         */
        self::SUCCESS                        => '请求成功',
        self::ACCESS_FORBIDDEN               => '您的登录信息已失效，请重新登录',
        self::FAILED_INNER                   => '服务繁忙，请稍候重试',
        self::FAILED                         => '操作失败',

        /**
         * 公共错误码 - 通用型
         */
        self::AT_API_REQUEST_LIMIT           => '您访问太快，请客官稍候重试',
        self::VALIDATE_PARAMS                => '传入参数不正确',

        /**
         * 业务逻辑错误码
         */
        // self::USER_ACCOUNT_NOT_FOUND         => '帐号不存在',
        self::USER_ACCOUNT_LOG_WRITE_FAILED  => '用户登录日志，写入失败',
        self::USER_ACCOUNT_OR_PASSWORD_ERROR => '帐号或者密码不正确',
        self::USER_ACCOUNT_FOUND             => '该帐号已存在',
        self::USER_ACCOUNT_STATUS_NOT_EXISTS => '该用户状态不存在',
        self::USER_GOOGLE_CATCHAR_NOT_CREATE => '谷歌验证码未设置',


        /**
         * 服务类错误
         */
        self::SERVICE_UPLOAD_CDN_FAILED      => '图片上传到CDN服务器失败',

    ];

}
