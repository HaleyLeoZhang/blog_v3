<?php
namespace App\Bussiness\Admin\Logic;

use App\Models\AdminAuth\Admin;
use App\Services\Auth\CheckAuthService;

// ----------------------------------------------------------------------
// 设置后台 左侧栏目
// ----------------------------------------------------------------------
// Link  : http://www.hlzblog.top/
// GITHUB: https://github.com/HaleyLeoZhang
// ----------------------------------------------------------------------

class MenuAdminLogic
{
    /**
     * 设置导航栏
     * @return string
     */
    public static function show_menu(): string
    {
        $menu_html = ''; // 左侧导航栏

        $menu_html .= self::module('sidebar/index', '首页', 'home')
            ->sidebar('admin/hall', '概览', 'eye')
            ->sidebar('admin/login_log', '登录日志', 'video-camera')
            ->sidebar('admin/self_info', '帐号操作', 'lock') // 修改帐号密码
            ->output();

        $menu_html .= self::module('sidebar/auth', '权限', 'anchor')
            ->sidebar('admin/auth_human', '人员分配', 'soccer-ball-o ')
            ->sidebar('admin/auth_rule', '权限规则', 'filter')
            ->sidebar('admin/auth_group', '管理组', 'mortar-board')
            ->output();

        $menu_html .= self::module('sidebar/article', '博文', 'book')
            ->sidebar('admin/article/category', '分类', 'child')
            ->sidebar('admin/article/detail', '文章', 'list-ul') // 博文访问的浏览量需要拆分开来；富文本的第三方图片，需要改成CDN资源
            ->sidebar('admin/article/background', '背景图', 'picture-o') // 博文背景图
            ->output();

        $menu_html .= self::module('sidebar/user', '用户', 'user')
            ->sidebar('admin/user/user_list', '用户概览', 'apple') // 用户类型、平台、登录、用户订阅、回复总计（新文章邮件、回复邮件、层主回复、At回复），用户封杀
            ->sidebar('admin/user/comments', '评论列表', 'commenting-o') // 类型：留言板、文章回复、楼中楼
            ->output();

        $menu_html .= self::module('sidebar/visitor', '访客', 'sellsy') // 需要中间件对PC端所有视图层，增加访问日志（收集、headers、req）
            // ->sidebar('', '封杀IP历史', 'chain') // 开始封杀时间、结束封杀时间、生效状态、备注 - TODO
            ->sidebar('admin/visitor/foot_mark_analysis', '足迹分析', 'bar-chart') // 访客设备、忠实粉丝（依据不同天数内访问过的同一IP）、地理位置、访问入口、趋势分析
            // ->sidebar('', '文章概况', 'motorcycle') // 博文访问的浏览量需要拆分开来（文章ID、阅读时间） - TODO
            ->output();

        $menu_html .= self::module('sidebar/memory', '碎片记忆', 'lightbulb-o') // 该部分，计划接入 coreseek
            // ->sidebar('', '标签', 'tags')  // - TODO
            // ->sidebar('', '内容', 'file')  // - TODO
            ->output();

        $menu_html .= self::module('sidebar/common', '公共配置', 'wrench') // 该部分，计划接入 coreseek
            ->sidebar('admin/common/friend_link', '友情链接', 'binoculars') // 友情链接
            ->output();

        $menu_html .= self::module('sidebar/system', '系统配置', 'cog')
            ->sidebar('admin/system/pic_bed', '图床', 'image') // 用户配置 七牛、腾讯CDN、SM.MS 并选择让当前生效的图床
            ->output();

        return $menu_html;
    }

    // ---------------------------- Lib ----------------------------

    protected $side_bar_html;
    protected $module_rule;
    protected $module_name;
    protected $logo_name;

    /**
     * 设置 后台导航栏，以及输出导航栏的子级
     * @param String : module_rule 模块规则
     * @param String : module_name 模块名称
     * @param Stirng : logo_name  font-awesome的图标名 http://fontawesome.dashgame.com/

     */
    protected static function module($module_rule, $module_name, $logo_name = 'users')
    {
        $_this                = new self;
        $_this->side_bar_html = '';
        $_this->module_rule   = $module_rule;
        $_this->module_name   = $module_name;
        $_this->logo_name     = $logo_name;
        return $_this;
    }

    protected function output()
    {
        $view = CheckAuthService::check(
            \CommonService::$admin->id,
            $this->module_rule,
            '
           <li class="treeview">
               <a href="#">
                   <i class="fa fa-' . $this->logo_name . '"></i> <span>' . $this->module_name . '</span>
                   <i class="fa fa-angle-left pull-right"></i>
               </a>
               <ul class="treeview-menu" id="Performance">
                   ' . $this->side_bar_html . '
               </ul>
           </li>
           ');
        $this->side_bar_html = '';
        return $view;
    }

    /**
     * 设置 导航栏子级
     * @param String : module_rule 模块规则
     * @param String : module_name 模块名称
     * @param Stirng : logo_name  font-awesome的图标名 http://fontawesome.dashgame.com/
     */
    protected function sidebar($siderbar_rule, $siderbar_name, $logo_name = 'circle-o')
    {
        $this->side_bar_html .=

        $view = CheckAuthService::check(
            \CommonService::$admin->id,
            $siderbar_rule,
            '
            <li><a href="/' . $siderbar_rule . '"><i class="fa fa-' . $logo_name . '"></i> ' . $siderbar_name . '</a></li>
        ');
        return $this;
    }

}
