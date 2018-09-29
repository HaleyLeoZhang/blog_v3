<?php

namespace qcloudcos;

class Conf {
    // Cos php sdk version number.
    const VERSION = 'v4.2.3';
    const API_COSAPI_END_POINT = 'http://region.file.myqcloud.com/files/v2/';

    // Please refer to http://console.qcloud.com/cos to fetch your app_id, secret_id and secret_key.

    /**
     * Get the User-Agent string to send to COS server.
     */
    public static function getUserAgent() {
        return 'cos-php-sdk-' . self::VERSION;
    }


    /**
     * 返回配置信息
     * @return 
     */
    public static function get_conf(){
        $appId = env('COS_APPID');
        $secretId = env('COS_SECRET_ID');
        $secretKey = env('COS_SECRET_KEY');
        return [
            $appId,
            $secretId,
            $secretKey,
        ];
    }
}
