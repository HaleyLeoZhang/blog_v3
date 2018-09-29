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

}
