<?php

namespace App\Http\Controllers\Common;

/**
 * 各种用户账号管理操作相关
 */
use App\Http\Controllers\BaseController;
use App\Repositories\Article\ArticleRepository;
use App\Repositories\Index\IndexRepository;
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
        $render = IndexRepository::dispatcher($params);
        return view('module/index/index', $render);
    }

    /**
     * 对应文章ID详情
     * @param int $article_id 文章ID
     * @return \Illuminate\View\View
     */
    public function detail($article_id)
    {
        $render = ArticleRepository::detail($article_id);
        return view('module/article/index', $render);
    }

    /**
     * 站点首页
     * @return \Illuminate\View\View
     */
    public function board(Request $request)
    {
        $params = $request->all();
        $render = IndexRepository::board($params);
        return view('module/board/index', $render);
    }
}
