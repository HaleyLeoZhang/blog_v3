<?php

namespace App\Http\Controllers\Common;

/**
 * 各种用户账号管理操作相关
 */
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Bussiness\Article\ArticleBussiness;

class ArticleController extends BaseController
{

    /**
     * 对应文章ID详情
     * @param int $article_id 文章ID
     * @return \Illuminate\View\View
     */
    public function detail($article_id)
    {
        $data = ArticleBussiness::detail($article_id);
        return view('module/article/index', $data);
    }

}
