<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Services\Crypt\RsaCryptService;
use App\Services\Verify\SlideVerifyService;

class SlideVerifyController extends BaseController
{

    /**
     * @api {get} /api/slide_verify/init 初始验证码页面
     * @apiName init
     * @apiGroup SlideVerify
     *
     * @apiVersion 3.0.0
     * @apiSuccessExample Success-Response:
     * HTTP/1.1 200 OK
     *
     * 初始验证码页面的html
     *
     */
    public function init()
    {
        return SlideVerifyService::instance();
    }

    /**
     * @api {get} /api/slide_verify/captchar 获取动态加载的验证码图片
     * @apiName captchar
     * @apiGroup SlideVerify
     *
     * @apiDescription  该html里面有待验证的base64数据的图片
     *
     * @apiVersion 3.0.0
     * @apiSuccessExample Success-Response:
     * HTTP/1.1 200 OK
     *
     * html字符串
     *
     */
    public function captchar()
    {
        return SlideVerifyService::instance('init');
    }

    /**
     * @api {post} /api/slide_verify/check 验证码，校验
     * @apiName check
     * @apiGroup SlideVerify
     *
     * @apiDescription  因为前端js对不同语言、情景提示的输出，与后端成套，所以保留历史接口
     *
     * @apiVersion 3.0.0
     * @apiSuccessExample Success-Response:
     * HTTP/1.1 200 OK
     * {
     *     "status": false,
     *     "Err": 2000,
     *     "out": "验证码通过"
     * }
     */
    public function check()
    {
        // 参数过滤
        $result = SlideVerifyService::instance('check');
        return json_encode($result);
    }

    // 示例验证 [RSA版]，示例：
    public function demo_rsa()
    {
        // - 先判断验证码是否已经通过
        $verify_result = SlideVerifyService::instance('is_pass');
        // --- 验证码没通过？
        if ($verify_result['status']) {
            throw new \ApiException($verify_result['out']);
        }
        // RSA 解密 、 [使用了加密函数的，都需要 urldecode 再次解码]
        $name = RsaCryptService::decrypt(urldecode($_POST['name']));
        $pwd  = RsaCryptService::decrypt(urldecode($_POST['pwd']));
        // 待验证的 帐号与密码
        $user_account = 'admin';
        $password     = '123123';

        // 验证成功？
        if ($name == $user_account && $pwd == $password) {
            // - 返回，格式封装
            $res                = [];
            $msg['code']        = 200;
            $msg['message']     = '验证成功';
            $msg['data']        = [];
            $msg['data']['url'] = '/';
        } else {
            // - 返回，格式封装
            $res            = [];
            $msg['code']    = 401;
            $msg['message'] = '帐号或者密码不正确哟';
            $msg['data']    = [];

        }
        exit(json_encode($msg));
    }

}
