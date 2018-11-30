<?php
namespace App\Http\Controllers\Api;

use App\Helpers\Response;
use App\Http\Controllers\BaseController;
use App\Repositories\Comic\ComicRepository;
use Illuminate\Http\Request;

class ComicController extends BaseController
{

    /**
     * @api {post} /api/comic/pic_list 漫画图片 - 每话图片列表
     * @apiName pic_list
     * @apiGroup Comic
     *
     * @apiParam {int} comic_id 动漫ID，如，1表示《一人之下》
     * @apiParam {int} page 第多少话，如，1表示第一话
     *
     * @apiDescription  如，爬取的《一人之下》这漫画的相关资源，已经被转存到第三方图床，
     *
     * 每话的地址都会从这里传出去，前端按顺序显示图片即可
     *
     * @apiVersion 3.0.0
     * @apiSuccessExample Success-Response:
     * HTTP/1.1 200 OK
     * {
     *     "code": 200,
     *     "message": "请求成功",
     *     "data":
     *     {
     *         "pic_list": [
     *         {
     *             "src": "https:\/\/i.loli.net\/2018\/11\/30\/5c0123b635b04.jpg"
     *         },
     *         {
     *             "src": "https:\/\/i.loli.net\/2018\/11\/30\/5c0123d5ebeaf.jpg"
     *         }]
     *     }
     * }
     * @apiErrorExample Error-Response:
     * HTTP/1.1 200 OK
     * {
     *     "code": 501,
     *     "message": "暂无资源",
     *     "data": null
     * }
     */
    public function pic_list(Request $request)
    {
        $filter = [
            'comic_id' => 'required',
            'page'     => 'required',
        ];
        $this->validate($request, $filter);

        $comic_id = $request->input('comic_id');
        $page     = $request->input('page');

        $params = compact(
            'comic_id',
            'page'
        );

        $pic_list = ComicRepository::pic_list($params);

        $data = compact('pic_list');

        return Response::success($data);
    }

}
