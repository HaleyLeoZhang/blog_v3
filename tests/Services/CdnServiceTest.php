<?php
namespace tests\Services;

use App\Jobs\EmailJob;
use App\Services\Api\ExpressDeliveryApi;
use App\Services\Api\TuringRobotApiService;
use App\Services\Cdn\QiniuCdnService;
use App\Services\Cdn\TencentCdnService;
use App\Services\Cdn\SmCdnService;
use Log;
use LogService;

class ToolServiceTest extends \TestCase
{
    public static $headers = [
        'X-Requested-With: XMLHttpRequest', // AJAX头
        'Q-AppVersion: 1.3.0', // 版本号
        'token: MTczMDAyMzg0ODg=dd7afbf41798e4b43ef87d8f792e21b9', // token
    ];

    public function test_upload_and_delete()
    {
        $path = base_path('public/static_pc/img/default/loading_400x400.gif');
        $url = TencentCdnService::get_instance()
            ->upload($path);
        TencentCdnService::get_instance()
            ->delete($url);

        $url = SmCdnService::get_instance()
            ->upload($path);
        SmCdnService::get_instance()
            ->delete($url);


        $url = QiniuCdnService::get_instance()
            ->upload($path);
        QiniuCdnService::get_instance()
            ->delete($url);

        LogService::debug(__CLASS__ . '@' . __FUNCTION__ . '.info' , [$url]);
    }

}
