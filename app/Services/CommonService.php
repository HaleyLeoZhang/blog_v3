<?php
namespace App\Services;

// ----------------------------------------------------------------------
// 基础服务 - 公共静态信息存储
// ----------------------------------------------------------------------
// Link  : http://www.hlzblog.top/
// GITHUB: https://github.com/HaleyLeoZhang
// ----------------------------------------------------------------------

class CommonService
{
    /**
     * @param App\Models\User $user 用户模型，一般是获取Token后，会存储下来
     * @param App\Models\AdminAuth\Admin $admin 管理员模型，一般是获取Token后，会存储下来
     */
    public static $user = null;

    public static $admin = null;

    // ---------------------------------- 公共常量 ----------------------------------

    const LOGIN_TYPE_END_SYSTEM   = 1; // 后台系统
    const LOGIN_TYPE_FRONT_SYSTEM = 2; // 前台系统

    const AUTH_CHECK_SUCCESS = true; // 鉴权成功
    const AUTH_CHECK_FAILED  = false; // 鉴权失败

    const RSA_FILE_PUBLIC  = 'keys/rsa_public_key.pem'; // RSA公钥路径，相对于 storage 目录
    const RSA_FILE_PRIVATE = 'keys/rsa_private_key.pem'; // RSA私钥路径，相对于 storage 目录
    const RSA_FILE_JS_PATH = 'static_pc/js/hlz_rsa.js'; // RSA前端生成对应加密的JS路径

    // - 系统，登录信息
    public static $passport_system = [
        self::LOGIN_TYPE_END_SYSTEM   => [
            'redirect_url' => '/admin/login', // 没有权限的页面，跳转到固定的路由
            'token_name'   => 'End-Token', // Token 前端字段识别名称
            'token_prefix' => 'TK:EBS:', // Token 后端存储前缀
            'token_expire' => 86400, // //  Token 有效时长，单位秒，默认，1天

            'login_type'   => 'slide_verify', // 登录类型： google => 谷歌验证码 ，slide_verify => 滑动验证码验证
            'page_success' => '/admin/hall', // 登录成功后的路由
        ],
        self::LOGIN_TYPE_FRONT_SYSTEM => [
            'redirect_url' => '/', // 没有权限的页面，跳转到固定的路由
            'token_name'   => 'Front-Token', // Token 前端字段识别名称
            'token_prefix' => 'TK:FBS:', // Token 后端存储前缀
            'token_expire' => 86400, // //  Token 有效时长，单位秒，默认，1天
        ],
    ];

    /**
     * 后台配置
     */

    // - 首页
    const END_INDEX_PAGE_SIZE               = 20; // 日志列表
    const END_ARTICLE_PAGE_SIZE             = 10; // 文章列表
    const END_ARTICLE_BACKGROUND_PAGET_SIZE = 9; // 文章背景图列表
    const END_USER_LIST_PAGE_SIZE           = 15; // 用户概览
    const END_COMMENT_PAGE_SIZE             = 15; // 评论列表
    const END_VISITOR_ANALYSIS_PAGE_SIZE    = 15; // 访客分析

    /**
     * 前台配置
     */

    // - 首页
    const BLOG_INDEX_PAGE_SIZE         = 10; // 文章列表，分页尺寸
    const BLOG_COMMENT_LASTEST_SIZE    = 5; // 火热评论：最新 N 条评论
    const BLOG_COMMENT_PAGE_SIZE       = 10; // 博客评论：主楼，评论显示尺寸
    const BLOG_COMMENT_CHILD_PAGE_SIZE = 5; // 博客评论：子楼，评论显示尺寸
    const BLOG_HOST_ARTICLE_PAGE_SIZE  = 5; // 最近访问频率较高的前 N 篇文章
    // - 评论（主楼、子楼）
    const COMMENT_CHILD_YES = true; // 子楼
    const COMMENT_CHILD_NO  = false; // 主楼
}
