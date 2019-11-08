<?php
namespace App\Http\Controllers\Api;

use App\Helpers\Response;
use App\Http\Controllers\BaseController;
use App\Repositories\Common\CommonRepository;
use Illuminate\Http\Request;

class GeneralController extends BaseController
{

    /**
     * @api {get} /api/general/memorabilia_bg 大事记 - 背景音乐
     * @apiName kugou_music
     * @apiGroup General
     *
     * @apiDescription  大事记 - 背景音乐接口，获取酷狗对应音乐的播放地址
     *
     * @apiVersion 3.0.0
     * @apiSuccessExample Success-Response:
     * HTTP/1.1 200 OK
     * {
     *     "code": 200,
     *     "message": "请求成功",
     *     "data":
     *     {
     *         "url": "http:\/\/fs.w.kugou.com\/201809291650\/b16704e072bc4b64d73c2274b2e406b3\/G087\/M06\/01\/05\/94YBAFiHguyALcJ1ADJXXPiRjh8038.mp3"
     *     }
     * }
     */
    public function memorabilia_bg()
    {
        $data = CommonRepository::memorabilia_bg();
        return Response::success($data);
    }

    /**
     * @api {get} /api/general/express_delivery 快递查询
     * @apiName express_delivery
     * @apiGroup General

     * @apiParam {string}  tracking_number 快递单号
     *
     * @apiDescription  快递查询
     *
     * @apiVersion 3.0.0
     * @apiSuccessExample Success-Response:
     * HTTP/1.1 200 OK
     * {
     *     "code": 200,
     *     "message": "请求成功",
     *     "data":
     *     {
     *         "track_info": [
     *         {
     *             "time": "2018-10-17 00:54:46",
     *             "ftime": "2018-10-17 00:54:46",
     *             "context": "【佛山市】 快件离开 【佛山中心】 发往 【北京】",
     *             "location": "佛山中心"
     *         },
     *         {
     *             "time": "2018-10-17 00:52:23",
     *             "ftime": "2018-10-17 00:52:23",
     *             "context": "【佛山市】 快件到达 【佛山中心】",
     *             "location": "佛山中心"
     *         },
     *         {
     *             "time": "2018-10-16 21:10:31",
     *             "ftime": "2018-10-16 21:10:31",
     *             "context": "【广州市】 快件离开 【番禺新大石】 发往 【北京】",
     *             "location": "番禺新大石"
     *         },
     *         {
     *             "time": "2018-10-16 15:08:53",
     *             "ftime": "2018-10-16 15:08:53",
     *             "context": "【广州市】 【番禺新大石】（020-31063349、020-31065201、020-39292257） 的 客户曼曼 （13222222222） 已揽收",
     *             "location": "番禺新大石"
     *         }]
     *     }
     * }
     */
    public function express_delivery(Request $request)
    {
        $tracking_number = $request->input('tracking_number', '');
        $data            = CommonRepository::express_delivery($tracking_number);
        return Response::success($data);
    }

    /**
     * @api {post} /api/general/short_url 短地址
     * @apiName short_url
     * @apiGroup General

     * @apiParam {string}  long_url 长地址
     * @apiParam {string}  channel 获取渠道.枚举值: third 对应 t.cn ; bitly 对应 bit.ly
     *
     * @apiDescription  长地址转短地址（新浪短地址服务）
     *
     * @apiVersion 3.0.0
     * @apiSuccessExample Success-Response:
     * HTTP/1.1 200 OK
     * {
     *     "code": 200,
     *     "message": "请求成功",
     *     "data": {
     *         "short_url": "http:\/\/t.cn\/Aije77x4" // 短地址链接
     *     }
     * }
     */
    public function short_url(Request $request)
    {
        $filter = [
            'long_url' => 'required',
        ];
        $this->validate($request, $filter);
        $long_url = $request->input('long_url', '');
        $channel  = $request->input('channel', 'third');

        $data = CommonRepository::short_url($long_url, $channel);
        return Response::success($data);
    }
}
