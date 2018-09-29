<?php
namespace App\Repositories\Index;

use App\Helpers\Page;
use App\Repositories\Article\Logic\ArticleLogic;
use App\Repositories\Comment\Logic\CommentLogic;
use App\Repositories\Index\Logic\IndexLogic;

// ----------------------------------------------------------------------
// 仓储 - 首页
// ----------------------------------------------------------------------
// Link  : http://www.hlzblog.top/
// GITHUB: https://github.com/HaleyLeoZhang
// ----------------------------------------------------------------------

class IndexRepository
{

    /**
     * 选择功能，调度不同逻辑
     * @param array  search（搜索功能）、其他参数（首页数据）
     * @return array
     */
    public static function dispatcher($params): array
    {
        // - 首页文章列表
        $article_list = IndexLogic::dispatcher($params);
        // - 归档分类
        $cate_list = ArticleLogic::get_cate_list();
        // - 置顶列表
        $sticky_list = IndexLogic::sticky_list();
        // - 最新评论
        $lastest_comments = IndexLogic::lastest_comments();
        // - 火热文章
        $hot_articles = IndexLogic::hot_articles();
        // - 友情链接
        $friend_links = IndexLogic::friend_links();

        $data = compact(
            'article_list',
            'cate_list',
            'sticky_list',
            'lastest_comments',
            'hot_articles',
            'friend_links'
        );
        return $data;
    }

    /**
     * 留言板，获取最新的留言
     * @return array
     */
    public static function board(): array
    {
        $parent_id   = 0;
        $location    = 0;
        $need_render = Page::IS_RENDER_NO;
        $paginage    = CommentLogic::info($parent_id, $location, $need_render);
        $data        = compact('paginage');
        return $data;
    }

}
