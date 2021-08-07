<?php
namespace App\Bussiness\Admin;

use App\Bussiness\Admin\Logic\ArticleAdminLogic;

// ----------------------------------------------------------------------
// 仓储 - 博文
// ----------------------------------------------------------------------
// Link  : http://www.hlzblog.top/
// GITHUB: https://github.com/HaleyLeoZhang
// ----------------------------------------------------------------------

class ArticleBussiness
{

    /**
     * 查看所有分类
     * @return array
     */
    public static function category_info()
    {
        return ArticleAdminLogic::category_info();
    }

    /**
     * 删除文章分类
     * @param int $id 分类ID
     * @return void
     */
    public static function category_del($id)
    {
        ArticleAdminLogic::category_del($id);
    }

    /**
     * 修改文章分类
     * @param int $id 分类ID
     * @param string $title 分类名
     * @return void
     */
    public static function category_edit($id, $title)
    {
        ArticleAdminLogic::category_edit($id, $title);
    }

    /**
     * 添加文章分类
     * @param string $title 分类名
     * @return void
     */
    public static function category_add($title)
    {
        ArticleAdminLogic::category_add($title);
    }

    // ---------------------- 文章详情 ----------------------

    /**
     * 添加文章
     * @param string title 标题
     * @param string type 文本类型 0=>Markdown 1=>Editor
     * @param string sticky 置顶项[0=>未置顶、1=>置顶]
     * @param string sequence 置顶顺序号（权重）
     * @param string original [0=>原创,1=>转载]
     * @param string is_online [0=>下线,1=>上线]
     * @param string raw_content 未转为html之前的文章内容
     * @param string descript 描述
     * @param string cover_url 封面图片url
     * @param string cate_id 对应文章分类
     * @param string bg_id 对应文章背景主题号【0=>没有背景主题】
     * @return void
     */
    public static function detail_create($params)
    {
        ArticleAdminLogic::detail_create($params);
    }

    /**
     * 博文列表
     * @param array $params 查询所需参数
     * @return RenderObject
     */
    public static function detail_info($params)
    {
        $data = ArticleAdminLogic::detail_info($params);
        return $data;
    }

    /**
     * 博文内容：模糊搜索文章
     * @param string title 文章名
     * @return array
     */
    public static function detail_search($title)
    {
        $data = ArticleAdminLogic::detail_search($title);
        return $data;
    }

    /**
     * 博文内容：修改
     * @param string id 文章编号
     * @param string title 标题
     * @param string type 文本类型 0=>Markdown 1=>Editor
     * @param string sticky 置顶项[0=>未置顶、1=>置顶]
     * @param string sequence 置顶顺序号（权重）
     * @param string original [0=>原创,1=>转载]
     * @param string is_online [0=>下线,1=>上线]
     * @param string raw_content 未转为html之前的文章内容
     * @param string descript 描述
     * @param string cover_url 封面图片url
     * @param string cate_id 对应文章分类
     * @param string bg_id 对应文章背景主题号【0=>没有背景主题】
     * @return void
     */
    public static function detail_edit($params)
    {
        ArticleAdminLogic::detail_edit($params);
    }

    /**
     * 博文内容：修改页面
     * @param int article_id 文章
     * @return array
     */
    public static function detail_edit_view($article_id)
    {
        $article  = ArticleAdminLogic::detail_edit_view($article_id);
        $category = ArticleAdminLogic::category_info();
        return [
            $article,
            $category,
        ];
    }

    /**
     * 博文内容：删除
     * @param string id 主键
     * @return void
     */
    public static function detail_del($id)
    {
        ArticleAdminLogic::detail_del($id);
    }

    /**
     * 博文上下线
     * @param string id 文章id
     * @return void
     */
    public static function article_check_line($id)
    {
        ArticleAdminLogic::article_check_line($id);
    }

    // ---------------------- 背景图片 ----------------------

    /**
     * 添加背景图
     * @param string $to_page 页码，默认值为1
     * @return void
     */
    public static function background_add($url)
    {
        ArticleAdminLogic::background_add($url);
    }

    /**
     * 背景图片信息
     * @return array
     */
    public static function background_info()
    {
        $data = ArticleAdminLogic::background_info();
        return $data;
    }

    /**
     * 修改背景图信息
     * @return void
     */
    public static function background_edit($id, $url)
    {
        $params = compact('id', 'url');
        ArticleAdminLogic::background_edit($params);
    }

    /**
     * 删除背景图片
     * @param int $id 背景图ID
     * @return void
     */
    public static function background_del($id)
    {
        $params = compact('id');
        ArticleAdminLogic::background_edit($params);
    }

}
