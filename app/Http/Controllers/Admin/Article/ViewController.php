<?php

namespace App\Http\Controllers\Admin\Article;

use App\Http\Controllers\BaseController;
use App\Models\Blog\Article;
use App\Repositories\Admin\ArticleRepository;
use Illuminate\Http\Request;

class ViewController extends BaseController
{
    /**
     * 文章分类
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function category(Request $request)
    {
        return view('admin.article.category');
    }

    /**
     * 文章详情
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function detail(Request $request)
    {
        // - 状态搜索
        $original  = $request->input('original', Article::SHOW_ALL); // 资源类型
        $edit_type = $request->input('edit_type', Article::SHOW_ALL); // 编辑类型
        $sticky    = $request->input('sticky', Article::SHOW_ALL); // 置顶状态
        $online    = $request->input('online', Article::SHOW_ALL); // 上线状态
        // - 时间搜素
        $time_start = $request->input('time_start', ''); // 开始时间
        $time_end   = $request->input('time_end', ''); // 结束时间
        // - 模糊搜索
        $vague = $request->input('vague', ''); // 标题、描述
        // return view('admin.article.detail');
        // 参数注入
        $params = compact(
            'original', 'edit_type', 'sticky', 'online',
            'time_start', 'time_end', 'vague'
        );
        $render           = ArticleRepository::detail_info($params);
        $params['render'] = $render;
        return view('admin.article.detail_info', $params);
    }

    /**
     * 创建文章
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function detail_create_view(Request $request)
    {
        // - 状态搜索
        $article_id = Article::DEFAULT_ARTICLE_FOR_CREATE; // 文章ID为0，表示使用默认配置

        list($render, $category) = ArticleRepository::detail_edit_view($article_id);
        // - 初始化列表数据
        $list_edit_type = Article::$list_edit_type;
        array_shift($list_edit_type);
        $text_edit_type = Article::$text_edit_type;

        $list_sticky = Article::$list_sticky;
        array_shift($list_sticky);
        $text_sticky = Article::$text_sticky;

        $list_original = Article::$list_original;
        array_shift($list_original);
        $text_original = Article::$text_original;

        $list_online = Article::$list_online;
        array_shift($list_online);
        $text_online = Article::$text_online;

        $data = compact(
            'render', 'category',
            'list_edit_type', 'text_edit_type',
            'list_sticky', 'text_sticky',
            'list_original', 'text_original',
            'list_online', 'text_online'
        );
        return view('admin/article/detail_create', $data);
    }

    /**
     * 修改文章
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function detail_edit_view(Request $request)
    {
        // - 状态搜索
        $article_id = $request->input('id'); // 文章ID

        list($render, $category) = ArticleRepository::detail_edit_view($article_id);
        // - 初始化列表数据
        $list_edit_type = Article::$list_edit_type;
        array_shift($list_edit_type);
        $text_edit_type = Article::$text_edit_type;

        $list_sticky = Article::$list_sticky;
        array_shift($list_sticky);
        $text_sticky = Article::$text_sticky;

        $list_original = Article::$list_original;
        array_shift($list_original);
        $text_original = Article::$text_original;

        $list_online = Article::$list_online;
        array_shift($list_online);
        $text_online = Article::$text_online;

        $data = compact(
            'render', 'category',
            'list_edit_type', 'text_edit_type',
            'list_sticky', 'text_sticky',
            'list_original', 'text_original',
            'list_online', 'text_online'
        );
        return view('admin/article/detail_edit', $data);
    }

    /**
     * 背景图详情
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function background(Request $request)
    {
        return view('admin.article.background');
    }
}
