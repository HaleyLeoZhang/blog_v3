<?php

namespace App\Http\Controllers\Common;

/**
 * 各种用户账号管理操作相关
 */
use App\Http\Controllers\BaseController;
use App\Bussiness\Article\ArticleBussiness;
use App\Bussiness\Index\IndexBussiness;
use Illuminate\Http\Request;

class IndexController extends BaseController
{
    /**
     * 站点首页
     * @return \Illuminate\View\View
     */
    public function render(Request $request)
    {
        $params = $request->all();
        $render = IndexBussiness::dispatcher($params);
        return view('module/index/index', $render);
    }

    /**
     * 对应文章ID详情
     * @param int $article_id 文章ID
     * @return \Illuminate\View\View
     */
    public function detail($article_id)
    {
        $render = ArticleBussiness::detail($article_id);
        return view('module/article/index', $render);
    }

    /**
     * 留言板
     * @return \Illuminate\View\View
     */
    public function board(Request $request)
    {
        $params = $request->all();
        $render = IndexBussiness::board($params);
        return view('module/board/index', $render);
    }
}
