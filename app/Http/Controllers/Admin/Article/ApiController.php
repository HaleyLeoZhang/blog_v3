<?php

namespace App\Http\Controllers\Admin\Article;

use App\Helpers\Response;
use App\Http\Controllers\BaseController;
use App\Bussiness\Admin\ArticleBussiness;
use Illuminate\Http\Request;

// use App\Models\Blog\Article;

class ApiController extends BaseController
{

    // ---------------------- 文章分类 ----------------------

    /**
     * @api {get} /admin/article/category_info 博文分类：查看
     * @apiName category_info
     * @apiGroup article
     *
     * @apiDescription  查看所有分类
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
     *             "id": 36,
     *             "title": "111",
     *             "is_deleted": 0,
     *             "updated_at": "2018-09-22 02:36:27",
     *             "created_at": "2018-09-22 02:36:27"
     *         },
     *         {
     *             "id": 23,
     *             "title": "Golang",
     *             "is_deleted": 0,
     *             "updated_at": "2018-08-05 15:16:22",
     *             "created_at": "2018-08-05 15:16:22"
     *         }]
     *     }
     * }
     */
    public function category_info(Request $request)
    {
        $data         = [];
        $data['info'] = ArticleBussiness::category_info();
        return Response::success($data);
    }

    /**
     * @api {post} /admin/article/category_edit 博文分类：修改
     * @apiName category_edit
     * @apiGroup article
     *
     * @apiParam {string} id 主键
     * @apiParam {string} title 分类名
     *
     * @apiDescription  修改对应分类名
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
    public function category_edit(Request $request)
    {
        $filter = [
            'id'    => 'required',
            'title' => 'required',
        ];
        $this->validate($request, $filter);
        $id    = $request->input('id');
        $title = $request->input('title');
        ArticleBussiness::category_edit($id, $title);
        return Response::success();
    }

    /**
     * @api {post} /admin/article/category_del 博文分类：删除
     * @apiName category_del
     * @apiGroup article
     *
     * @apiParam {string} id 主键
     *
     * @apiDescription  删除对应分类名
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
    public function category_del(Request $request)
    {
        $filter = [
            'id' => 'required',
        ];
        $this->validate($request, $filter);
        $id = $request->input('id');
        ArticleBussiness::category_del($id);
        return Response::success();
    }

    /**
     * @api {post} /admin/article/category_add 博文分类：添加
     * @apiName category_add
     * @apiGroup article
     *
     * @apiParam {string} title 分类名
     *
     * @apiDescription  添加博文
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
    public function category_add(Request $request)
    {
        $filter = [
            'title' => 'required',
        ];
        $this->validate($request, $filter);
        $title = $request->input('title');
        ArticleBussiness::category_add($title);
        return Response::success();
    }

    // ---------------------- 文章详情 ----------------------

    /**
     * @api {post} /api/article/detail_create 博文内容：添加
     * @apiName detail_create
     * @apiGroup article
     *
     * @apiParam {string} cate_id 对应文章分类
     * @apiParam {string} cover_url 封面图片url
     * @apiParam {string} title 标题
     * @apiParam {string} descript 文章概述
     * @apiParam {string} type 文本类型 0=>Markdown 1=>Editor
     * @apiParam {string} raw_content 未转为html之前的文章内容
     * @apiParam {string} sticky 置顶项[0=>未置顶、1=>置顶]
     * @apiParam {string} original [0=>原创,1=>转载]
     * @apiParam {string} bg_id 对应文章背景主题号【0=>没有背景主题】
     *
     * @apiDescription  添加对应博文
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
    public function detail_create(Request $request)
    {
        $filter = [
            'id'          => 'required',
            'title'       => 'required',
            'type'        => 'required',
            'sticky'      => 'required',
            'sequence'    => 'required',
            'original'    => 'required',
            'is_online'   => 'required',
            'raw_content' => 'required',
            'descript'    => 'required',
            'cover_url'   => 'required',
            'cate_id'     => 'required',
            'bg_id'       => 'required',
        ];
        $this->validate($request, $filter);
        $params = $request->all();
        ArticleBussiness::detail_create($params);
        return Response::success();
    }

    /**
     * @api {post} /admin/article/detail_edit 博文内容：修改
     * @apiName detail_edit
     * @apiGroup article
     *
     * @apiParam {string} id 文章编号
     * @apiParam {string} title 标题
     * @apiParam {string} type 文本类型 0=>Markdown 1=>Editor
     * @apiParam {string} sticky 置顶项[0=>未置顶、1=>置顶]
     * @apiParam {string} sequence 置顶顺序号（权重），选填
     * @apiParam {string} original [0=>原创,1=>转载]
     * @apiParam {string} is_online [0=>下线,1=>上线]
     * @apiParam {string} raw_content 未转为html之前的文章内容
     * @apiParam {string} descript 描述
     * @apiParam {string} cover_url 封面图片url
     * @apiParam {string} cate_id 对应文章分类
     * @apiParam {string} bg_id 对应文章背景主题号【0=>没有背景主题】
     *
     * @apiDescription  添加博文
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
    public function detail_edit(Request $request)
    {
        $filter = [
            'id'          => 'required',
            'title'       => 'required',
            'type'        => 'required',
            'sticky'      => 'required',
            // 'sequence'    => 'required',
            'original'    => 'required',
            'is_online'   => 'required',
            'raw_content' => 'required',
            'descript'    => 'required',
            'cover_url'   => 'required',
            'cate_id'     => 'required',
            'bg_id'       => 'required',
        ];
        $this->validate($request, $filter);
        $params = $request->all();
        ArticleBussiness::detail_edit($params);
        return Response::success();

    }

    /**
     * @api {post} /api/article/detail_del 博文内容：删除
     * @apiName detail_del
     * @apiGroup article
     *
     * @apiParam {string} id 主键
     *
     * @apiDescription  删除对应博文内容
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
    public function detail_del(Request $request)
    {
        $filter = [
            'id' => 'required',
        ];
        $this->validate($request, $filter);
        $id = $request->input('id');
        ArticleBussiness::detail_del($id);
        return Response::success();
    }

    /**
     * @api {get} /api/article/article_check_line 博文上下线
     * @apiName article_check_line
     * @apiGroup article
     *
     * @apiParam {string} id 文章id
     *
     * @apiDescription  修改前，查看对应文章相关内容
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
    public function article_check_line(Request $request)
    {
        $filter = [
            'id' => 'required',
        ];
        $this->validate($request, $filter);
        $id = $request->input('id');
        ArticleBussiness::article_check_line($id);
        return Response::success();
    }

    // ---------------------- 背景图片 ----------------------

    /**
     * @api {post} /article/background/background_add 背景主题：添加
     * @apiName background_add
     * @apiGroup article
     *
     * @apiParam {string} url 图片地址
     *
     * @apiDescription  添加背景主题
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
    public function background_add(Request $request)
    {
        $filter = [
            'url' => 'required',
        ];
        $this->validate($request, $filter);
        $url = $request->input('url');
        ArticleBussiness::background_add($url);
        return Response::success();
    }

    /**
     * @api {get} /article/article/background_info 背景主题：分页查看
     * @apiName background_info
     * @apiGroup article
     *
     * @apiParam {string} to_page 页码，默认值为1
     *
     * @apiDescription  获取背景主题数据
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
     *             "id": 35,
     *             "url": "http:\/\/img.cdn.hlzblog.top\/18-2-7\/74292535.jpg",
     *             "is_deleted": 0,
     *             "updated_at": "2018-08-05 15:13:34",
     *             "created_at": "0000-00-00 00:00:00"
     *         },
     *         {
     *             "id": 33,
     *             "url": "http:\/\/img.cdn.hlzblog.top\/18-2-7\/53540060.jpg",
     *             "is_deleted": 0,
     *             "updated_at": "2018-08-05 15:13:34",
     *             "created_at": "0000-00-00 00:00:00"
     *         }],
     *         "page_count": 3,
     *         "total": 26
     *     }
     * }
     */
    public function background_info(Request $request)
    {
        $data = ArticleBussiness::background_info();
        return Response::success($data);
    }

    /**
     * @api {post} /article/background/background_add 背景主题：修改
     * @apiName background_add
     * @apiGroup article
     *
     * @apiParam {string} id 主键
     * @apiParam {string} url 图片地址
     *
     * @apiDescription  修改背景主题
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
    public function background_edit(Request $request)
    {
        $filter = [
            'id'  => 'required',
            'url' => 'required',
        ];
        $this->validate($request, $filter);
        $id  = $request->input('id');
        $url = $request->input('url');
        ArticleBussiness::background_edit($id, $url);
        return Response::success();
    }

    /**
     * @api {post} /article/background/background_del 背景主题：删除
     * @apiName background_del
     * @apiGroup article
     *
     * @apiParam {string} id 主键
     *
     * @apiDescription  删除某个背景主题
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
    public function background_del(Request $request)
    {
        $filter = [
            'id' => 'required',
        ];
        $this->validate($request, $filter);
        $id = $request->input('id');
        ArticleBussiness::background_del($id);
        return Response::success();
    }

}
