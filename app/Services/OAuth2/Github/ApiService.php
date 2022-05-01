<?php
namespace App\Services\OAuth2\Github;

use App\Helpers\CurlRequest;

class ApiService
{
    public $app_id;
    public $app_key;
    public $callback;
    public $code;
    public $state; // CSRF 防护，本项目暂不需要

    public function __construct($app_id, $app_key, $callback)
    {
        // 接收从qq登陆页返回来的值
        $this->code  = isset($_REQUEST['code']) ? $_REQUEST['code'] : '';
        $this->state = isset($_REQUEST['state']) ? $_REQUEST['state'] : '';
        // 将参数赋值给成员属性
        $this->app_id   = $app_id;
        $this->app_key  = $app_key;
        $this->callback = $callback;
    }

    /**
     * 获取 access_token 值
     * @return string
     */
    public function get_token()
    {
        $params                  = [];
        $params['client_id']     = $this->app_id;
        $params['client_secret'] = $this->app_key;
        $params['code']          = $this->code;
        $params['redirect_uri']  = $this->callback;
        $params['state']         = '';

        $url = 'https://github.com/login/oauth/access_token?' . http_build_query($params);

        // - 发起 POST 请求
        $post = [
            'rand' => time(),
        ];

        $content = CurlRequest::run($url, $post);

        parse_str($content, $arr);
        if (!isset($arr['access_token'])) {
            \LogService::info('登陆失败.info: access_token 不存在', $arr);
            throw new \ApiException("登陆失败");
        }
        return $arr['access_token'];
    }

    /**
     * 获取用户信息
     * @param $access_token
     * @return array 用户的信息数组
     */
    public function user_info($access_token)
    {
        $params                 = [];
        //$params['access_token'] = $access_token;

        $header = [
            "User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36 SE 2.X MetaSr 1.0",
	    "Authorization: token {$access_token}",
        ];

        $url     = 'https://api.github.com/user?' . http_build_query($params);
        $content = CurlRequest::run($url, null, $header);
        // - 示例 $content 字符串
        // {
        //     "login": "HaleyLeoZhang",
        //     "id": 18374677,
        //     "node_id": "MDQ6VXNlcjE4Mzc0Njc3",
        //     "avatar_url": "https://avatars0.githubusercontent.com/u/18374677?v=4",
        //     "gravatar_id": "",
        //     "url": "https://api.github.com/users/HaleyLeoZhang",
        //     "html_url": "https://github.com/HaleyLeoZhang",
        //     "followers_url": "https://api.github.com/users/HaleyLeoZhang/followers",
        //     "following_url": "https://api.github.com/users/HaleyLeoZhang/following{/other_user}",
        //     "bio": "Full-Stack Engineer",
        //     "public_repos": 7,
        //     "public_gists": 0,
        //     "followers": 6,
        //     "following": 2,
        //     "created_at": "2016-04-10T05:50:30Z",
        //     "updated_at": "2018-09-25T07:54:56Z"
        // }
        $arr = json_decode($content, true);
        return $arr;

    }

    /**
     * 获取登录地址
     * @return string
     */
    public function get_third_login_url()
    {
        // CSRF 防护，暂不考虑，默认先带上，但是回调的时候不校验
        $this->state = md5(uniqid(rand(), true));

        $params                 = [];
        $params['client_id']    = $this->app_id;
        $params['redirect_uri'] = $this->callback;
        $params['scope']        = 'get_user_info';
        $params['state']        = '';

        $url = 'https://github.com/login/oauth/authorize?' . http_build_query($params);
        return $url;
    }

}
