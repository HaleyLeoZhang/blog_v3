<?php

/**
 * 解决nginx下没有函数名getallheaders的情况
 */
if (!function_exists('getallheaders')) {
    function getallheaders()
    {
        $headers = [];
        foreach ($_SERVER as $name => $value) {
            if (substr($name, 0, 5) == 'HTTP_') {
                $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
            }
        }
        return $headers;
    }
}

/**
 * 获取 CDN 域名
 */
if (!function_exists('cdn_host')) {
    function cdn_host()
    {
        $host = '';
        // 线上环境才使用 CDN
        if ('production' == env('APP_ENV')) {
            $host = env('COS_CNAME_HOST', '');
        }
        return $host;
    }
}

if (!function_exists('static_host')) {
    function static_host()
    {
        $host = '';
        // 线上环境才使用 CDN
        if ('production' == env('APP_ENV')) {
            $host = env('STATIC_HOST', '');
        }
        return $host;
    }
}

/**
 * 加载 - 插件资源
 */
if (!function_exists('link_plugins')) {
    // link_plugins
    function link_plugins($bucket_name, $name)
    {
        preg_match('/(.*?)\.(js|css)$/i', $name, $matches);
        unset($matches[0]);
        unset($matches[1]);
        return '/static_pc/plugins/' . $bucket_name . '/' . $matches[2] . '/' . $name;
    }
}

/**
 * 加载 - 静态资源
 */
if (!function_exists('link_src')) {
    // Link_source [css、js、jpg、png]
    function link_src($name)
    {
        if (preg_match('/(.*?)\.(js|css)$/i', $name, $matches)) {
            $dir = '/' . $matches[2];
            unset($matches);
            return '/static_pc' . $dir . '/' . $name;
        } elseif (preg_match('/(.*?)\.(jpg|png|gif|jpeg)$/i', $name)) {
            return '/static_pc/img/' . $name;
        }
    }
}
