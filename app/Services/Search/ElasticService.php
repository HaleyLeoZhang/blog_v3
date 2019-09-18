<?php
namespace App\Services\Search;

use Elasticsearch\ClientBuilder;

// ----------------------------------------------------------------------
// ElasticSearch
// ----------------------------------------------------------------------
// 使用说明  https://www.elastic.co/guide/cn/elasticsearch/php/current/_quickstart.html
// ----------------------------------------------------------------------
// Link  : http://www.hlzblog.top/
// GITHUB: https://github.com/HaleyLeoZhang
// ----------------------------------------------------------------------

class ElasticService
{
    static $client = null;

    const CONF_PREFIX = 'search.elastic.';

    private function __construct()
    {}
    private function __clone()
    {}

    /**
     * 获取配置前缀名
     * @return string
     */
    protected static function get_config_prefix()
    {
        $conf_prefix = self::CONF_PREFIX;
        if ('production' == env('APP_ENV')) {
            $conf_prefix .= 'pro';
        } else {
            $conf_prefix .= 'dev';
        }
        return $conf_prefix;
    }

    /**
     * 判断 es 功能是否可用
     * @return bool
     */
    public static function is_avaiable()
    {
        $switch_status = config(self::CONF_PREFIX . 'switch');
        if ('on' == $switch_status) {
            return true;
        }
        return false;
    }

    /**
     * 单例获取客户端
     * @return Elasticsearch\ClientBuilder
     */
    public static function get_client()
    {
        if (null === self::$client) {
            $prefix = self::get_config_prefix();
            $hosts  = config($prefix . '.hosts');

            self::$client = ClientBuilder::create()
                ->setHosts($hosts)
                ->build();
        }
        return self::$client;
    }

}
