<?php
/**
 * 第三方登录集成
 */


return [
    // - QQ
    'qq' => [
        'appid'    => env('qq_config_appid', ''),
        'appkey'   => env('qq_config_appkey', ''),
        'callback' => env('qq_config_callback', 'http://www.hlzblog.top/oauth2/qq'),
    ],
    // - 新浪 - 微博
    'sina'  => [
        'appid'    => env('sina_config_appid', ''),
        'appkey'   => env('sina_config_appkey', ''),
        'callback' => env('sina_config_callback', 'http://www.hlzblog.top/oauth2/sina'),
    ],
    // - Github
    'github' => [
        'appid'    => env('github_config_appid', ''),
        'appkey'   => env('github_config_appkey', ''),
        'callback' => env('github_config_callback', 'http://www.hlzblog.top/oauth2/github'),
    ],
    // - Wechat - 公众号登录（个人不可用）
    'wechat' => [
        'appid'    => env('wechat_config_appid', ''),
        'appkey'   => env('wechat_config_appkey', ''),
        'callback' => env('wechat_config_callback', 'http://www.hlzblog.top/oauth2/wechat'),
    ],

];
