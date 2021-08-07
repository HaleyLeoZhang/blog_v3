<?php
namespace App\Bussiness\Spa\Logic;

use App\Helpers\Page;
use App\Bussiness\Article\Logic\ArticleLogic;
use App\Bussiness\Index\Logic\IndexLogic;

class ArticleSpaLogic
{

    /**
     * @return array
     */
    public static function category_list()
    {
        $category_list = ArticleLogic::get_cate_list();
        return $category_list;
    }

    /**
     * @return array
     */
    public static function article_list($params)
    {
        $article_list = IndexLogic::dispatcher($params, Page::IS_RENDER_NO);
        return $article_list;
    }

    /**
     * @return \App\Models\Blog\Article
     */
    public static function article_detail($article_id)
    {
        $article_obj = ArticleLogic::get_article($article_id);
        if (isset($article_obj->raw_content)) {
            unset($article_obj->raw_content); // 线上生数据不外露
            // 前端不需要的数据
            unset($article_obj->sticky);
            unset($article_obj->sequence);
            unset($article_obj->is_deleted);
            unset($article_obj->is_online);
            unset($article_obj->descript);
            unset($article_obj->cover_url);
            unset($article_obj->bg_id);
        }
        // 阅读量记录
        ArticleLogic::statistic_read($article_obj);
        return $article_obj;
    }

}
