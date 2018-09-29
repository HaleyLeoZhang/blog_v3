<?php
namespace App\Http\Controllers\Api;

use App\Helpers\Response;
use App\Http\Controllers\BaseController;
use App\Repositories\Common\CommonRepository;

class GeneralController extends BaseController
{

    /**
     * @api {get} /api/general/memorabilia_bg 大事记 - 背景音乐
     * @apiName kugou_music
     * @apiGroup Media
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

}
