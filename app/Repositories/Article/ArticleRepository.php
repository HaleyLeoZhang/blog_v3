<?php
namespace App\Repositories\Article;

use App\Repositories\Article\Logic\ArticleLogic;

// ----------------------------------------------------------------------
// 模块 - 文章
// ----------------------------------------------------------------------
// Link  : http://www.hlzblog.top/
// GITHUB: https://github.com/HaleyLeoZhang
// ----------------------------------------------------------------------

class ArticleRepository
{

    /**
     * 文章详情页
     * @param int $article_id 文章ID
     * @return void
     */
    public static function detail($article_id)
    {
        $article_obj = ArticleLogic::get_article($article_id);
        ArticleLogic::statistic_read($article_obj);
        $cate_list = ArticleLogic::get_cate_list();
        $recommands = ArticleLogic::get_rand_recommand($article_obj->cate_id);
        $comments_counter = ArticleLogic::get_comments_counter($article_obj->id);

        $back = compact(
            'article_obj',
            'cate_list',
            'recommands',
            'comments_counter'
        );
        // LogService::debug(__CLASS__ . '@' . __FUNCTION__ . '.info', $back);
        return $back;
    }

}
