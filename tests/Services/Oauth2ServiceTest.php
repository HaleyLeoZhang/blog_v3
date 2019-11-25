<?php
namespace tests\Services;

use App\Helpers\CurlRequest;
use App\Models\User;
use App\Bussiness\OAuth2\Logic\ActionOAuth2Logic;
use App\Services\OAuth2\QqOAuth2Service;
use LogService;

class Oauth2ServiceTest extends \TestCase
{
    const CHUNK_LEN = 20;

    public function qq_redirect()
    {
        $qq  = new QqOAuth2Service();
        $url = $qq->get_third_login_url();
        $log = compact('url');
        LogService::debug(__CLASS__ . '@' . __FUNCTION__ . '.log', $log);
        LogService::debug(__CLASS__ . '@' . __FUNCTION__ . '.info');
    }

    public function qq_back()
    {
        $url  = 'http://web.test.com/oauth2/qq?code=E6C34E6D35E04B4F97281089A8EFF35B&state=32b08d42f344e330ef2eb58139a5b2a6';
        $post = [
            'response_type' => 'code',
            'client_id'     => '101309589',
            'redirect_uri'  => 'http://www.hlzblog.top/Userentrance/from_qq',
            'scope'         => 'get_user_info',
            'state'         => '32b08d42f344e330ef2eb58139a5b2a6',
            'switch'        => '',
            'from_ptlogin'  => '1',
            'src'           => '1',
            'update_auth'   => '1',
            'openapi'       => '80901010',
            'g_tk'          => '388030792',
            'auth_time'     => '1537795209693',
            'ui'            => 'E0C07E3D-8B56-43AB-B0C6-FEBE453A43A3',
        ];
        $result = CurlRequest::run($url, $post);
        LogService::debug(__CLASS__ . '@' . __FUNCTION__ . '.info', [$result]);
    }

    public function user_login()
    {
        $user = User::find(28);
        ActionOAuth2Logic::user_login($user);
    }

    /**
     * 刷用户表数据，计算 crc32 值
     */
    public function test_flush_user_crc32(){
        LogService::debug(__CLASS__ . '@' . __FUNCTION__ . '.start');
        User::chunk(self::CHUNK_LEN, function($models){
            foreach ($models as $model) {
                $model->crc32 = crc32($model->oauth_key . $model->type);
                $model->save();
            }
        });
        LogService::debug(__CLASS__ . '@' . __FUNCTION__ . '.end');
    }

}
