<?php
namespace App\Services\OAuth2;

interface BaseOAuth2Service
{
    public function get_third_login_url(); // 去第三方登录的地址

    /**
     * 获取用户登录后的信息
     * - OAuth2 方式，回调获取到的 code 只能使用一次
     */
    public function get_third_user_info();
}
