<?php
namespace App\Repositories\Comic\Logic;

use App\Helpers\CurlRequest;
use App\Models\Logs\ComicDownloadLogs;
use App\Services\Cdn\SmCdnService;
use Illuminate\Support\Facades\Redis;

class YiRenZhiXiaComicLogic
{
    const CURL_PER_SEC = 10; // 每秒爬取次数限制
    const PIC_API      = 'https://m.tohomh.com/action/play/read'; // 漫面接口
    const PIC_CDN_HOST = 'https://manhua.wzlzs.com'; // 漫画资源域名

    /**
     * 一人之下，爬取站点数据
     * @return void
     */
    public static function yi_ren_zhi_xia()
    {

        \LogService::debug('《一人之下》.----------------DOING');
        // 第 x 话
        for ($i = 1;; $i++) {
            $path = storage_path('comic/yirenzhixia/' . $i);
            @mkdir($path, 0700, true); // 递归创建文件
            $succes_counter = 0;
            // 每话里面 多少内容，遇到 404 状态码则退出
            for ($j = 0; $j < 99999; $j++) {
                $succes_counter ++ ;
                // 每30秒检测一次程序是否需要重启
                $token_name = 'test_download';
                $token_life = time() + 30;
                Redis::set($token_name, 1);
                $redis_expire = Redis::expireAt($token_name, $token_life);

                $current_pic = $j + 1;

                $log_name_format = '《一人之下》.' . $i . '话.' . $current_pic . '张';

                if (self::is_exists($i, $current_pic)) {
                    \LogService::info($log_name_format . '.已经被下载过了');
                    continue;
                }

                $content = self::request_api($i, $current_pic);
                $res     = json_decode($content);

                $res_code = $res->Code ?? '--';

                if ('--' == $res_code) {
                    \LogService::debug($log_name_format . '接口异常 ' . $content);
                } elseif ('' != $res_code) {

                    $pic_local_path = $path . '/' . $current_pic . '.jpg';
                    $pic            = file_get_contents(self::PIC_CDN_HOST . $res_code);

                    $fp = fopen($pic_local_path, 'a+');
                    fwrite($fp, $pic);
                    fclose($fp);
                    // 上传到图床 sm.ms
                    $cdn_path = SmCdnService::get_instance()->upload($pic_local_path);
                    // 每四张图片，休息3秒再传，防止被封
                    if( $j % 4 == 0 ){
                        sleep(3);
                    }
                    $data     = [
                        'comic_id'   => ComicDownloadLogs::COMMIC_ID_YIRENZHIXIA,
                        'page'       => $i,
                        'inner_page' => $current_pic,
                        'src'        => $cdn_path,
                    ];
                    ComicDownloadLogs::create($data);
                } else {
                    $log_name_format = '《一人之下》.' . $i . '话.共' . $j . '张';
                    \LogService::warn($log_name_format . '.下载完毕 ');
                    break;
                }
            }
            if( 0 == $succes_counter ){
                \LogService::debug('《一人之下》.第 '. $i .'话，还未更新');
            }
        }
        \LogService::debug('《一人之下》.----------------DONE');

    }

    /**
     * 获取动漫网的图片资源地址
     */
    public static function request_api(&$i, &$current_pic)
    {

        $header = [
            'Accept:text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
            'Accept-Encoding:gzip, deflate, sdch, br',
            'Accept-Language:zh-CN,zh;q=0.8',
            'Cache-Control:no-cache',
            'Connection:keep-alive',
            'Cookie:Hm_lvt_4be6660a7fb279361739554296e9954e=1543279998,1543565488; Hm_lpvt_4be6660a7fb279361739554296e9954e=1543567559',
            'Host:m.tohomh.com',
            'Pragma:no-cache',
            'Upgrade-Insecure-Requests:1',
            'User-Agent:Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1',
        ];

        $data = null;

        $get = [
            'did' => 7155,
            'sid' => $i, // 第多少话
            'iid' => $current_pic, // 页内第几张
            'tmp' => microtime(true),
        ];

        $url     = self::PIC_API . '?' . http_build_query($get);
        $content = CurlRequest::run($url, $data, $header);

        return $content;
    }

    /**
     * 判断资源是否下载过了
     */
    public static function is_exists(&$i, &$current_pic)
    {
        return ComicDownloadLogs::where('comic_id', ComicDownloadLogs::COMMIC_ID_YIRENZHIXIA)
            ->where('page', $i)
            ->where('inner_page', $current_pic)
            ->where('status', ComicDownloadLogs::STATUS_VALID)
            ->count();
    }

}
