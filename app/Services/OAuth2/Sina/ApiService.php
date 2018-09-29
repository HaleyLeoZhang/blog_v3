<?php
namespace App\Services\OAuth2\Sina;

use App\Helpers\CurlRequest;

/**
 *
 */

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
        $this->code = isset($_REQUEST['code']) ? $_REQUEST['code'] : '';
        // 将参数赋值给成员属性
        $this->app_id   = $app_id;
        $this->app_key  = $app_key;
        $this->callback = $callback;
    }

    /**
     * 获取 access_token 值
     * - 文档地址 http://open.weibo.com/wiki/Oauth2/access_token
     * @return string
     */
    public function get_token()
    {
        $params                  = [];
        $params['client_id']     = $this->app_id;
        $params['client_secret'] = $this->app_key;
        $params['grant_type']    = 'authorization_code';
        $params['code']          = $this->code;
        $params['redirect_uri']  = $this->callback;

        $url = 'https://api.weibo.com/oauth2/access_token?' . http_build_query($params);

        // - 发起 POST 请求
        $post = [
            'rand' => time(),
        ];

        $content = CurlRequest::run($url, $post);

        $arr = json_decode($content, true);

        if (!isset($arr['access_token'])) {
            \LogService::info('登陆失败.info: access_token 不存在', $arr);
            throw new \ApiException("登陆失败");
        }
        return $arr['access_token'];
    }

    /**
     * 获取client_id 和 openid
     * @param $access_token access_token验证码
     * @return array
     * - 返回格式 ["uid" => "...", ...]
     */
    public function get_uid($access_token)
    {
        $params                 = [];
        $params['access_token'] = $access_token;

        $url = 'https://api.weibo.com/oauth2/get_token_info?' . http_build_query($params);

        // - 发起 POST 请求
        $post = [
            'rand' => time(),
        ];

        $content = CurlRequest::run($url, $post);
        $arr     = json_decode($content, true);

        if (!isset($arr['uid'])) {
            \LogService::info('登陆失败.info: uid 不存在', $arr);
            throw new \ApiException("登陆失败");
        }
        return $arr;
    }

    /**
     * 获取用户信息
     * @param $access_token access_token验证码
     * - 接口文档 http://open.weibo.com/wiki/2/users/show
     * @return array 用户的信息数组
     */
    public function user_info($access_token, $uid)
    {
        $params                 = [];
        $params['access_token'] = $access_token;
        $params['uid']          = $uid;

        $url     = 'https://api.weibo.com/2/users/show.json?' . http_build_query($params);
        $content = CurlRequest::run($url);
        // - 示例 $content 字符串
        // {
        //     "id": 1707644921,
        //     "idstr": "1707644921",
        //     "class": 1,
        //     "screen_name": "沐临风_",
        //     "name": "沐临风_",
        //     "province": "50",
        //     "city": "7",
        //     "location": "重庆 九龙坡区",
        //     "description": "",
        //     "url": "http://www.hlzblog.top/",
        //     "profile_image_url": "http://tvax3.sinaimg.cn/crop.0.0.996.996.50/65c897f9ly8fk8sh7s8r3j20ro0rodgr.jpg",
        //     "cover_image_phone": "http://ww1.sinaimg.cn/crop.0.0.640.640.640/549d0121tw1egm1kjly3jj20hs0hsq4f.jpg",
        //     "profile_url": "u/1707644921",
        //     "domain": "",
        //     "weihao": "",
        //     "gender": "m",
        //     "followers_count": 41,
        //     "friends_count": 12,
        //     "pagefriends_count": 0,
        //     "statuses_count": 3,
        //     "video_status_count": 0,
        //     "favourites_count": 0,
        //     "created_at": "Mon Aug 02 13:02:30 +0800 2010",
        //     "following": false,
        //     "allow_all_act_msg": false,
        //     "geo_enabled": false,
        //     "verified": false,
        //     "verified_type": -1,
        //     "remark": "",
        //     "insecurity":
        //     {
        //         "sexual_content": false
        //     },
        //     "status":
        //     {
        //         "created_at": "Sun Aug 12 02:54:35 +0800 2018",
        //         "id": 4272025348862206,
        //         "idstr": "4272025348862206",
        //         "mid": "4272025348862206",
        //         "can_edit": false,
        //         "text": "http://t.cn/RDl7nlR",
        //         "textLength": 19,
        //         "source_allowclick": 0,
        //         "source_type": 1,
        //         "source": "<a href=\"http://app.weibo.com/t/feed/1Nou1F\" rel=\"nofollow\">生日态</a>",
        //         "favorited": false,
        //         "truncated": false,
        //         "in_reply_to_status_id": "",
        //         "in_reply_to_user_id": "",
        //         "in_reply_to_screen_name": "",
        //         "pic_urls": [],
        //         "geo": null,
        //         "is_paid": false,
        //         "mblog_vip_type": 0,
        //         "reposts_count": 0,
        //         "comments_count": 0,
        //         "attitudes_count": 0,
        //         "pending_approval_count": 0,
        //         "isLongText": false,
        //         "hide_flag": 0,
        //         "mlevel": 0,
        //         "visible":
        //         {
        //             "type": 0,
        //             "list_id": 0
        //         },
        //         "biz_ids": [231198],
        //         "biz_feature": 0,
        //         "hasActionTypeCard": 0,
        //         "darwin_tags": [],
        //         "hot_weibo_tags": [],
        //         "text_tag_tips": [],
        //         "mblogtype": 0,
        //         "rid": "0",
        //         "userType": 0,
        //         "more_info_type": 0,
        //         "positive_recom_flag": 0,
        //         "content_auth": 0,
        //         "gif_ids": "",
        //         "is_show_bulletin": 2,
        //         "comment_manage_info":
        //         {
        //             "comment_permission_type": -1,
        //             "approval_comment_type": 0
        //         }
        //     },
        //     "ptype": 0,
        //     "allow_all_comment": true,
        //     "avatar_large": "http://tvax3.sinaimg.cn/crop.0.0.996.996.180/65c897f9ly8fk8sh7s8r3j20ro0rodgr.jpg",
        //     "avatar_hd": "http://tvax3.sinaimg.cn/crop.0.0.996.996.1024/65c897f9ly8fk8sh7s8r3j20ro0rodgr.jpg",
        //     "verified_reason": "",
        //     "verified_trade": "",
        //     "verified_reason_url": "",
        //     "verified_source": "",
        //     "verified_source_url": "",
        //     "follow_me": false,
        //     "like": false,
        //     "like_me": false,
        //     "online_status": 0,
        //     "bi_followers_count": 6,
        //     "lang": "zh-cn",
        //     "star": 0,
        //     "mbtype": 0,
        //     "mbrank": 0,
        //     "block_word": 0,
        //     "block_app": 0,
        //     "credit_score": 80,
        //     "user_ability": 33555456,
        //     "urank": 9,
        //     "story_read_state": -1,
        //     "vclub_member": 0
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
        $params                 = [];
        $params['client_id']    = $this->app_id;
        $params['redirect_uri'] = $this->callback;

        $url = 'https://api.weibo.com/oauth2/authorize?' . http_build_query($params);
        return $url;
    }

}
