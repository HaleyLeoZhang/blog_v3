<?php
namespace App\Http\Controllers\Api;

use App\Helpers\Response;
use App\Http\Controllers\BaseController;
use App\Bussiness\Spa\SpaBussiness;
use Illuminate\Http\Request;

class SpaController extends BaseController
{

    /**
     * @api {get} /api/spa/category_list 获取分类列表
     * @apiName category_list
     * @apiGroup Spa
     *
     * @apiDescription  SPA 一次性获取全部分类信息
     *
     * @apiVersion 3.0.0
     * @apiSuccessExample Success-Response:
     * HTTP/1.1 200 OK
     * {
     *     "code": 200,
     *     "message": "请求成功",
     *     "data":
     *     {
     *         "categories": [
     *         {
     *             "id": 17, // 分类ID
     *             "title": "HTTP", // 分类名
     *             "total": 6 // 包含文章数
     *         },
     *         {
     *             "id": 19,
     *             "title": "JAVA",
     *             "total": 4
     *         },
     *         {
     *             "id": 4,
     *             "title": "Javascript",
     *             "total": 11
     *         },]
     *     }
     * }
     */
    public function category_list(Request $request)
    {
        $data = SpaBussiness::category_list();
        return Response::success($data);
    }

    /**
     * @api {get} /api/spa/article_list 分页获取文章列表
     * @apiName article_list
     * @apiGroup Spa
     *
     * @apiParam {int} to_page 页码
     * @apiParam {string} search  选填，搜索关键词
     * @apiParam {string} cate_id  选填，分类ID
     *
     * @apiDescription  SPA 分页获取文章列表
     *
     * @apiVersion 3.0.0
     * @apiSuccessExample Success-Response:
     * HTTP/1.1 200 OK
     * {
     *     "code": 200,
     *     "message": "请求成功",
     *     "data":
     *     {
     *         "articles":
     *         {
     *             "info": [
     *             {
     *                 "id": 51,
     *                 "title": "Vue2.0进阶回顾随笔（一）",
     *                 "descript": "书写Vue时候的一些规范、使用细节、Vuex理解等",
     *                 "cate_id": 4,
     *                 "sticky": 0,
     *                 "cover_url": "http:\/\/img.cdn.hlzblog.top\/17-6-18\/35121526.jpg",
     *                 "statistic": 262,
     *                 "created_at": "2018-08-05 15:17:41",
     *                 "cate_name": "Javascript"
     *             },
     *             {
     *                 "id": 50,
     *                 "title": "Vue2.0进阶规划",
     *                 "descript": "云天河对Vue2.0深入进阶规划，以及认为这期间需要了解的一些内容",
     *                 "cate_id": 4,
     *                 "sticky": 0,
     *                 "cover_url": "http:\/\/img.cdn.hlzblog.top\/17-6-18\/35121526.jpg",
     *                 "statistic": 341,
     *                 "created_at": "2018-08-05 15:17:41",
     *                 "cate_name": "Javascript"
     *             }],
     *             "page_count": 5,
     *             "total": 48
     *         }
     *     }
     * }
     */
    public function article_list(Request $request)
    {
        $params = $request->all();
        $data   = SpaBussiness::article_list($params);
        return Response::success($data);
    }

    /**
     * @api {get} /api/spa/article_detail 获取文章详情
     * @apiName article_detail
     * @apiGroup Spa
     *
     * @apiParam {int} article_id 文章ID
     *
     * @apiDescription  SPA 获取某篇文章详情
     *
     * @apiVersion 3.0.0
     * @apiSuccessExample Success-Response:
     * HTTP/1.1 200 OK
     * {
     *     "code": 200,
     *     "message": "请求成功",
     *     "data":
     *     {
     *         "article":
     *         {
     *             "id": 11,
     *             "title": "微信开发，快速入门", // 标题
     *             "type": 0, // 文本类型，0->markdown,1->富文本
     *             "original": 0, // 是否原创：1->是 0->不是
     *             "content": "<h2>开发前提<\/h2>\n\n<h6>先申请一个公众号中的订阅号，然后...", // 文章详细内容
     *             "cate_id": 5, // 分类ID
     *             "statistic": 2076, // 阅读量
     *             "updated_at": "2018-09-13 15:48:44", // 最后更新时间，后续可能会用到
     *             "created_at": "2018-08-05 15:17:41", // 创建时间
     *             "cate_name": "PHP", // 分类名
     *             "bg_url": "http:\/\/img.cdn.hlzblog.top\/17-8-13\/64417605.jpg" // 背景图地址
     *         }
     *     }
     * }
     */
    public function article_detail(Request $request)
    {
        $filter = [
            'article_id' => 'required',
        ];
        $this->validate($request, $filter);
        $article_id = $request->input('article_id');
        $data       = SpaBussiness::article_detail($article_id);
        return Response::success($data);
    }

}
