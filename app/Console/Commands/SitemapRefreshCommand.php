<?php

namespace App\Console\Commands;

use App\Models\Blog\Article;
use Illuminate\Console\Command;
use LogService;

class SitemapRefreshCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:refresh {type?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'sitemap 更新';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $type = $this->argument('type');

        LogService::info(__CLASS__ . '.start');
        LogService::info(__CLASS__ . '.type.' . $type . '.start');

        switch ($type) {
            case 'daily':
                $this->task_sitemap();
                break;
            default:
                throw new \ApiException('参数输入错误');
        }
        LogService::info(__CLASS__ . '.type.' . $type . '.end');
        LogService::info(__CLASS__ . '.end');
    }

    /**
     * 页面在站内的权重
     */
    const INNER_WEBSITE_WEGITH_INDEX  = 1; // 一般只有首页是这个
    const INNER_WEBSITE_WEGITH_MIDDLE = 0.9; // 从首页点进去的页面是这个
    const INNER_WEBSITE_WEGITH_SMALL  = 0.8; // 首页点进去的页面，再点一级页面就是这个

    /**
     * Sitemap 临时数据
     * @param  String : sitemap_tpl 模板
     * @param  String : sitemap_xml 渲染后的数据
     * @param  String : host        站点名
     */
    private $sitemap_tpl;
    private $sitemap_xml;
    private $host;

    // [每天闲时（凌晨3点）] 生成sitemap.xml
    public function task_sitemap()
    {
        $date              = date("Y-m-d H:i:s");
        $this->host        = config('app.hostname');
        $site_path         = base_path('public');
        $this->sitemap_tpl = '
            <url>
                <loc>%s</loc>
                <lastmod>' . $date . '</lastmod>
                <changefreq>daily</changefreq>
                <priority>%s</priority>
            </url>
        ';
        $this->sitemap_xml = '<?xml version="1.0" encoding="UTF-8"  ?>
        <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        // +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        // 首页
        $this->sitemap_render('/', self::INNER_WEBSITE_WEGITH_INDEX);
        // 大事记
        $this->sitemap_render('/memorabilia.html', self::INNER_WEBSITE_WEGITH_MIDDLE);
        // 关于我
        $this->sitemap_render('/about', self::INNER_WEBSITE_WEGITH_MIDDLE);
        // 留言
        $this->sitemap_render('/board', self::INNER_WEBSITE_WEGITH_MIDDLE);
        // 法律声明
        $this->sitemap_render('/Info/law.html', self::INNER_WEBSITE_WEGITH_MIDDLE);

        // 文章 List
        $blog_text = Article::select('id')
            ->where('is_deleted', '=', Article::IS_DELETED_NO)
            ->where('is_online', '=', Article::IS_ONLINE_YES)
            ->get();
        $this->sitemap_list($blog_text, '/', '/article', \CommonService::BLOG_INDEX_PAGE_SIZE);

        // +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        $this->sitemap_xml .= '</urlset>';
        // XML结束，并生成 XML
        $write_path = $site_path . '/sitemap.xml';
        $this->write($write_path, $this->sitemap_xml);
        $this->sitemap_xml = null;

        // 生成 robots
        $text = 'User-agent: *' . PHP_EOL;

        $text .= 'Disallow: /admin' . PHP_EOL; // 禁止访问的目录，若违规将负法律责任
        $text .= 'Disallow: /doc' . PHP_EOL; // 禁止访问的目录，若违规将负法律责任
        $text .= 'Disallow: /err' . PHP_EOL; // 禁止访问的目录，若违规将负法律责任

        $text .= 'Sitemap: ' . $this->host . '/sitemap.xml';
        $write_path = $site_path . '/robots.txt';
        $this->write($write_path, $text);
    }

    // ---------------------------------- Lib ----------------------------------

    /**
     * sitemap xml 分页列表页与详情页 [write_sitemap函数的部分逻辑]
     * @param  Array : list        数据列表
     * @param  String: url_list    分页列表页
     * @param  String: url_show    详情页
     * @param  Int   : _size       列表页，分页偏移量
     * @param  String: field       接收字段
     */
    private function sitemap_list($list, $url_list, $url_show, $_size, $field = 'id')
    {
        $count_page = ceil(count($list) / $_size);
        $this->sitemap_render($url_list, self::INNER_WEBSITE_WEGITH_MIDDLE);
        // 分页列表页面
        for ($i = 1; $i <= $count_page; $i++) {
            $url = $url_list . '?to_page=' . $i;
            $this->sitemap_render($url, self::INNER_WEBSITE_WEGITH_MIDDLE);
        }
        // 资讯详情页面
        foreach ($list as $article) {
            $url = $url_show . '/' . $article->id . '.html'; // SEO用
            $this->sitemap_render($url, self::INNER_WEBSITE_WEGITH_SMALL);
        }
    }

    /**
     * sitemap xml 分页列表页与详情页 [write_sitemap函数的部分逻辑]
     * @param  String : absolute_url 网站绝对路径
     * @param  String : priority     链接的优先级 [一级目录1 、二级0.9 、 三级0.8]
     */
    private function sitemap_render($absolute_url, $priority = 0.8)
    {
        $url = $this->host . $absolute_url;
        $this->sitemap_xml .= sprintf($this->sitemap_tpl, $url, $priority);
    }

    /**
     * 覆盖写入文件
     * @param  String : set_path 绝对路径
     * @param  String : text     写入内容
     */
    private function write($set_path, $text)
    {
        $fp = fopen($set_path, 'w');
        fwrite($fp, $text);
        fclose($fp);
    }

}
