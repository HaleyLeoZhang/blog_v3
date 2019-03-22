<?php
namespace App\Repositories\Spa;

use App\Repositories\Spa\Logic\ArticleSpaLogic;

// ----------------------------------------------------------------------
// For 移动端 SPA 服务
// ----------------------------------------------------------------------
// Link  : http://www.hlzblog.top/
// GITHUB: https://github.com/HaleyLeoZhang
// ----------------------------------------------------------------------

class SpaRepository
{
    /**
     * 获取分类列表
     * @return array
     */
    public static function category_list()
    {
        $categories = ArticleSpaLogic::category_list();
        $data       = compact('categories');
        return $data;
    }

    /**
     * 分页获取文章列表
     * @param array params  search、cate_id、to_page
     * @return array
     */
    public static function article_list($params)
    {
        $articles = ArticleSpaLogic::article_list($params);
        $data     = compact('articles');
        return $data;
    }

    /**
     * 分页获取文章列表
     * @param array params  search、cate_id、to_page
     * @return array
     */
    public static function article_detail($article_id)
    {
        $article = ArticleSpaLogic::article_detail($article_id);
        $data    = compact('article');
        return $data;
    }

}
