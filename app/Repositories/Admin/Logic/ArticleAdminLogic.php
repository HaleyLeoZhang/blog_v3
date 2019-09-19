<?php
namespace App\Repositories\Admin\Logic;

require_once app_path('Libs/Michelf/MarkdownExtra.inc.php');
use App\Helpers\Page;
use App\Models\AdminAuth\Admin;
use App\Models\Blog\Article;
use App\Models\Blog\ArticleCategory;
use App\Models\Blog\Background;

class ArticleAdminLogic
{

    /**
     * @return array
     */
    public static function category_info()
    {
        $object = ArticleCategory::where('is_deleted', ArticleCategory::IS_DELETED_NO)
            ->orderBy('title', 'asc')
            ->get();
        return $object;
    }

    /**
     * @return void
     */
    public static function category_edit($id, $title)
    {
        $object = ArticleCategory::where('is_deleted', ArticleCategory::IS_DELETED_NO)
            ->where('title', $title)
            ->first();
        if (is_null($object)) {
            $data   = compact('title');
            $object = new ArticleCategory();
            $object->where('id', $id)
                ->update($data);
        } else {
            if ($id == $object->id) {
                throw new \ApiException("暂无变化");
            } else {

                throw new \ApiException("该分类已存在");
            }
        }
    }

    /**
     * @return void
     */
    public static function category_del($id)
    {
        $is_deleted = ArticleCategory::IS_DELETED_YES;
        $data       = compact('is_deleted');
        $object     = new ArticleCategory();
        $object->where('id', $id)
            ->update($data);
    }

    /**
     * @return void
     */
    public static function category_add($title)
    {
        $object = ArticleCategory::where('is_deleted', ArticleCategory::IS_DELETED_NO)
            ->where('title', $title)
            ->orderBy('id', 'desc')
            ->first();
        if (is_null($object)) {
            $data = compact('title');
            ArticleCategory::create($data);
        } else {
            throw new \ApiException("该分类已存在");
        }
    }

    // ---------------------- 文章详情 ----------------------

    /**
     * @return void
     */
    public static function detail_create($params)
    {
        extract($params);
        $object = Article::where('is_deleted', Article::IS_DELETED_NO)
            ->where('title', $title)
            ->first();
        if (is_null($object)) {
            $params['raw_content'] = htmlspecialchars_decode($raw_content);
            if ($type == Article::EDIT_TYPE_MARKDOWN) {
                $params['content'] = self::parse_markdown($params['raw_content']);
            } else {
                $params['content'] = self::lazy_pic($params['raw_content']);
            }
            unset($params['id']);
            Article::create($params);
        } else {
            throw new \ApiException("该文章已存在");
        }
    }

    /**
     * @param {string} to_page 页码，默认值为1
     */
    public static function detail_info($params)
    {
        extract($params);
        $chain = Article::where('articles.is_deleted', ArticleCategory::IS_DELETED_NO);
        // 'original', 'edit_type', 'sticky', 'online',
        if (Article::SHOW_ALL != $original) {
            $chain = $chain->where('original', $original);
        }
        if (Article::SHOW_ALL != $edit_type) {
            $chain = $chain->where('type', $edit_type);
        }
        if (Article::SHOW_ALL != $sticky) {
            $chain = $chain->where('sticky', $sticky);

            if (Article::IS_STICKY_YES == $sticky) {
                $chain = $chain->orderBy('sticky', 'desc')->orderBy('sequence', 'asc');
            }
        }
        if (Article::SHOW_ALL != $online) {
            $chain = $chain->where('is_online', $online);
        }
        // 'time_start', 'time_end'
        if ('' != $time_start) {
            $chain = $chain->where('articles.created_at', '>=', $time_start);
        }
        if ('' != $time_end) {
            $chain = $chain->where('articles.created_at', '<=', $time_end);
        }
        // 'vague'
        if ('' != $vague) {
            $keywords = '%' . $vague . '%';
            $chain    = $chain->whereRaw('
            (
                articles.title like ? Or articles.descript like ?
            )', [$keywords, $keywords]);
        }
        // 筛选结果
        $render = $chain
            ->select('articles.*', 'b.title as cate_name')
            ->join('article_categorys as b ', 'articles.cate_id', '=', 'b.id')
            ->orderBy('id', 'desc')
            ->paginate(\CommonService::END_ARTICLE_PAGE_SIZE);
        $render->appends($params);
        \LogService::info('params', $params);
        return $render;

    }

    /**
     * @return void
     */
    public static function detail_edit($params)
    {
        extract($params);
        $object = Article::where('id', $id)
            ->where('is_deleted', Article::IS_DELETED_NO)
            ->first();
        if (is_null($object)) {
            throw new \ApiException("该文章不存在");
        } else {
            $params['raw_content'] = htmlspecialchars_decode($raw_content);
            if ($type == Article::EDIT_TYPE_MARKDOWN) {
                $params['content'] = self::parse_markdown($params['raw_content']);
            } else {
                $params['content'] = self::lazy_pic($params['raw_content']);
            }
            $object->update($params);
        }
    }

    /**
     * @return array
     */
    public static function detail_edit_view($article_id)
    {
        $object = Article::where('id', $article_id)
            ->where('is_deleted', Article::IS_DELETED_NO)
            ->first();
        if (is_null($object)) {
            throw new \ApiException("该文章不存在");
        } else {
            return $object;
        }
    }

    /**
     * @return void
     */
    public static function detail_del($id)
    {
        $object = Article::where('id', $id)
            ->where('is_deleted', Article::IS_DELETED_NO)
            ->first();
        $is_deleted = Article::IS_DELETED_YES;
        $data       = compact('is_deleted');
        if (is_null($object)) {
            throw new \ApiException("该文章不存在");
        } else {
            $object->update($data);
        }
    }

    /**
     * @return void
     */
    public static function article_check_line($id)
    {
        $article   = Article::find($id);
        $is_online = !$article->is_online;
        $data      = compact('is_online');
        $article->update($data);
    }

    // ---------------------- 文章背景图片 ----------------------

    /**
     * @return void
     */
    public static function background_add($url)
    {
        $object = Background::where('url', $url)
            ->where('is_deleted', Article::IS_DELETED_NO)
            ->first();
        if (is_null($object)) {
            $data = compact('url');
            Background::create($data);
        } else {
            throw new \ApiException("该背景图已存在");
        }
    }

    /**
     * @return array
     */
    public static function background_info()
    {
        $page = new Page('
            SELECT
                *
            FROM
                `backgrounds`
            WHERE
                is_deleted = ?
            ORDER BY
                `id` DESC
                LIMIT ?,?
        ', [Background::IS_DELETED_NO]);
        $page->page_size = \CommonService::END_ARTICLE_BACKGROUND_PAGET_SIZE;
        $page->is_render = false;
        $data            = $page->get_result();
        return $data;
    }

    /**
     * @return void
     */
    public static function background_edit($params)
    {
        extract($params);
        $object = Background::where('id', $id)
            ->where('is_deleted', Background::IS_DELETED_NO)
            ->first();
        if (is_null($object)) {
            throw new \ApiException("该背景图不存在");
        } else {
            if (isset($url)) {
                // 更新
                if ($object->url == $url) {
                    throw new \ApiException("暂无变化");
                }
            } else {
                // 删除
                $params['is_deleted'] = Background::IS_DELETED_YES;
            }
            $object->update($params);
        }
    }

    // ---------------------- Lib ----------------------

    /**
     * 解析 Markdown
     * @param  String $html MarkDown文章
     * @return String
     */
    protected static function parse_markdown($html)
    {
        $html = \Michelf\MarkdownExtra::defaultTransform($html);
        // 图片延迟属性设为 data-original
        return self::lazy_pic($html);
    }

    /**
     * 图片延时 与 防蜘蛛出站 处理
     * @param  String $html MarkDown文章
     * @return String
     */
    protected static function lazy_pic($html)
    {
        // 图片延迟属性设为 data-original
        $rule    = '/<img(.*?)src/';
        $replace = '<img $1 class="lazy_pic" data-original';
        $html    = preg_replace($rule, $replace, $html);
        // 防蜘蛛出站
        $rule    = '/<a(.*?)href/';
        $replace = '<a rel="nofollow" $1 href';
        $html    = preg_replace($rule, $replace, $html);
        return $html;
    }
}
