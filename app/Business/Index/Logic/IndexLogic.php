<?php
namespace App\Bussiness\Index\Logic;

use App\Helpers\Page;
use App\Models\Blog\Article;
use App\Models\Blog\Comment;
use App\Models\Blog\FriendLink;
use App\Models\Logs\VisitorLookLog;

class IndexLogic
{
    /**
     * 逻辑分发
     */
    public static function dispatcher($params, $is_render = Page::IS_RENDER_YES)
    {
        extract($params);
        if (isset($search)) {
            $pagination = self::search_vague($search);
        } elseif (isset($cate_id)) {
            $pagination = self::search_category($cate_id);
        } else {
            $pagination = self::general();
        }
        // - 统一配置分页
        $pagination->page_size = \CommonService::BLOG_INDEX_PAGE_SIZE;
        $pagination->is_render = $is_render;

        return $pagination->get_result();
    }

    /**
     * 公共搜 SQL - for search
     */
    public static function common_sql($condition_where)
    {
        $sql = "
            SELECT
                a.`id`,
                a.`title`,
                a.`descript`,
                a.`cate_id`,
                a.`sticky`,
                a.`cover_url`,
                a.`statistic`,
                a.`created_at`,
                b.`title` as 'cate_name'
            FROM
                `articles` as a
            INNER JOIN `article_categorys` as b
                On a.cate_id = b.id
            WHERE
        ";
        // 判断是否需要 where 语句
        if ('' != $condition_where) {
            $sql .= "( ${condition_where} ) AND ";
        }
        $sql .= "
            a.is_deleted = 0 AND a.is_online = 1
            ORDER BY
                a.`id` DESC
                LIMIT ?,?
        ";
        return $sql;
    }

    /**
     * 首页：模糊搜索分页：文章名、描述
     * @param string $search 搜索的关键词
     * @return \App\Helpers\Page
     */
    public static function search_vague($search)
    {
        $vague      = "%{$search}%";
        $sql        = self::common_sql('a.`title` like ? OR a.`descript` like ?');
        $pagination = new Page($sql, [$vague, $vague]);
        return $pagination;
    }

    /**
     * 首页：模糊搜索分页：文章名、描述
     * @param string $search 搜索的关键词
     * @return \App\Helpers\Page
     */
    public static function search_category($cate_id)
    {
        $sql        = self::common_sql('a.`cate_id` = ?');
        $pagination = new Page($sql, [$cate_id]);
        return $pagination;
    }

    /**
     * 首页：普通分页
     * @return \App\Helpers\Page
     */
    public static function general()
    {
        $sql        = self::common_sql('');
        $pagination = new Page($sql, []);
        return $pagination;
    }

    /**
     * 置顶列表
     * - 依据权重依次排序
     * @return array
     */
    public static function sticky_list()
    {
        $articles = Article::select('id', 'title')
            ->where('sticky', Article::IS_STICKY_YES)
            ->where('is_deleted', Article::IS_DELETED_NO)
            ->where('is_online', Article::IS_ONLINE_YES)
            ->orderBy('sequence', 'asc')
            ->get();
        return $articles;
    }

    /**
     * 最新评论
     * @return array
     */
    public static function lastest_comments()
    {
        $lastest_comments = Comment::selectRaw('
                comments.*,
                users.`pic`,
                users.`name`
            ')
            ->join('users', 'users.id', '=', 'comments.user_id')
            ->where('comments.is_deleted', Comment::IS_DELETED_NO)
            ->where('comments.status', Comment::STATUS_NORMAL)
            ->orderBy('comments.id', 'desc')
            ->limit(\CommonService::BLOG_COMMENT_LASTEST_SIZE)
            ->get();
        return $lastest_comments;
    }

    /**
     * 火热文章
     * - 以 15天 期为时间节点
     * @return array
     */
    public static function hot_articles()
    {
        $current      = date('Y-m-d H:i:s');
        $two_week_ago = date('Y-m-d H:i:s', strtotime('- 15 day'));
        $look_log     = VisitorLookLog::select('location')
            ->where('created_at', '>=', $two_week_ago)
            ->where('created_at', '<', $current)
            ->where('location', '>', 0)
            ->groupBy('location')
            ->orderByRaw('count(location) desc, id asc')
            ->limit(\CommonService::BLOG_HOST_ARTICLE_PAGE_SIZE)
            ->get();
        if (count($look_log)) {
            $look_log = $look_log->toArray();
        } else {
            $look_log = [];
        }
        $article_ids = array_column($look_log, 'location');
        $articles    = Article::select('id', 'title')
            ->whereIn('id', $article_ids)
            ->where('is_deleted', Article::IS_DELETED_NO)
            ->where('is_online', Article::IS_ONLINE_YES)
            ->get();
        return $articles;
    }

    /**
     * 友情链接
     * @return array
     */
    public static function friend_links()
    {
        $friend_links = FriendLink::select('id', 'title', 'href')
            ->where('is_deleted', FriendLink::IS_DELETED_NO)
            ->orderBy('weight', 'desc')
            ->get();
        return $friend_links;
    }

}
