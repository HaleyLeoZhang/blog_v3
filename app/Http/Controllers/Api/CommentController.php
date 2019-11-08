<?php
namespace App\Http\Controllers\Api;

use App\Helpers\Response;
use App\Http\Controllers\BaseController;
use App\Repositories\Comment\CommentRepository;
use Illuminate\Http\Request;

class CommentController extends BaseController
{

    /**
     * @api {get} /api/comment/info 回复列表
     * @apiName info
     * @apiGroup Comment
     *
     * @apiParam {int}  parent_id 主楼ID，0>是已是主楼
     * @apiParam {int}  location x<0表示其他位置,x==0表示留言板，x>0其他表示文章ID
     *
     * @apiDescription  用户评论的列表信息
     *
     * @apiVersion 3.0.0
     * @apiSuccessExample Success-Response:
     * HTTP/1.1 200 OK
     * {
     *     "code": 200,
     *     "message": "请求成功",
     *     "data":
     *     {
     *         "info": [
     *         {
     *             "id": 17,
     *             "time": "2018-03-26 16:22:24",
     *             "content": "ლ(′◉❥◉｀ლ)",
     *             "name": "Itaustin Inc.",
     *             "type": 2,
     *             "pic": "http:\/\/thirdqq.qlogo.cn\/qqapp\/101309589\/9CDCBEF210CA8ADDEBB4C2A33EBBA2D4\/100"
     *         },
     *         {
     *             "id": 16,
     *             "time": "2017-11-16 15:41:09",
     *             "content": "云神",
     *             "name": "Naturo",
     *             "type": 2,
     *             "pic": "http:\/\/thirdqq.qlogo.cn\/qqapp\/101309589\/7FF6D43C9DCF71A26D253174AE9E696F\/100"
     *         }],
     *         "render": ""
     *     }
     * }
     */
    public function info(Request $request)
    {
        $filter = [
            'location' => 'required',
        ];
        $this->validate($request, $filter);
        $parent_id = $request->input('parent_id', \CommonService::COMMENT_CHILD_NO);
        $location  = $request->input('location');
        $data      = CommentRepository::info($parent_id, $location);
        return Response::success($data);
    }

    /**
     * @api {post} /api/comment/reply_add 回复信息
     * @apiName reply_add
     * @apiGroup Comment
     *
     * @apiParam {int}  parent_id 主楼ID，0>是已是主楼
     * @apiParam {int}  content 回复内容
     * @apiParam {int}  location x<0表示其他位置,x==0表示留言板，x>0其他表示文章ID
     *
     * @apiDescription  用户评论的列表信息
     *
     * @apiVersion 3.0.0
     * @apiSuccessExample Success-Response:
     * HTTP/1.1 200 OK
     * {
     *     "code": 200,
     *     "message": "请求成功",
     *     "data":
     *     {
     *         "id": 50
     *     }
     * }
     */
    public function reply_add(Request $request)
    {
        $filter = [
            'content' => 'required',
        ];
        $this->validate($request, $filter);
        $parent_id = $request->input('parent_id');
        $content   = $request->input('content');
        $location  = $request->input('location');
        $params    = compact(
            'parent_id',
            'content',
            'location'
        );
        $data = CommentRepository::reply_add($params);
        return Response::success($data);
    }

    /**
     * @api {get} /api/comment/check_login 用户登录检测
     * @apiName check_login
     * @apiGroup Comment
     *
     * @apiDescription  用户评论前,检测是否登录
     *
     * @apiVersion 3.0.0
     * @apiSuccessExample Success-Response:
     * HTTP/1.1 200 OK
     * {
     *     "code": 200,
     *     "message": "请求成功",
     *     "data": null
     * }
     */
    public function check_login(Request $request)
    {
        return Response::success();
    }

}
