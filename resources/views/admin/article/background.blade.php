<!-- 继承页面 -->
@extends('admin.public.layout')
<!-- 页面标题 -->
@section('title') 背景图 @endsection
<!-- 功能备注 -->
@section('mark') @endsection
<!-- CSS -->
@section('css')
<link rel="stylesheet" href="/static_pc/admin/css_v2.0/categroy.css"> @endsection
<!-- 内容 -->
@section('content')
<div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief">
    <ul class="layui-tab-title">
        <li class="layui-this">背景图片</li>
    </ul>
    <div class="layui-tab-content">
        <!--分类一览-->
        <div class="layui-tab-item layui-show">
            <blockquote class="layui-elem-quote" style="font-size:15px">
                背景图，建议尺寸 16 / 9 建议尺寸 1920 * 1080 而且 体积不超过 500KB为宜</blockquote>
            <!--添加按钮 -->
            <button class="layui-btn layui-btn-normal act_add" onclick="bckground.bg_create()" title="添加背景图"><i class="layui-icon">&#xe654;</i><i class="layui-icon" style="margin-left:10px;">&#xe64a;</i></button>
            <div>
                <div id="background_list_html" style="padding-bottom:100px;"></div>
                <div style="clear:both;"></div>
            </div>
            <div id="background_list_pagenation" style="padding:30px 30px 50px 10px;"></div>
        </div>
    </div>
</div>
<!-- 页面模板，显示无限极分类 -->
<script type="text/yth_tpl" id="background_list_tpl">
    <%# for(var i=0; i <d.length ;i++){ %>
        <!--第一层结束-->
        <div class=" categroy_bar_1  tr_<%d[i].id%>" style="float:left;">
            <!-- 内容 -->
            <span class="categroy_bar_content">
          <a href="<%d[i].url%>" target="_blank" title="查看原图">
            <img src="<%d[i].url%>" width="380px" height="200px"
              class="img_<%d[i].id%>" alt="背景图">
          </a>
        </span>
            <!-- 按钮 -->
            <span class="categroy_bar_button">
          <button class="layui-btn layui-btn-warm layui-btn-radius "
          onclick="bckground.bg_change(this)" data-bg_id="<%d[i].id%>" 
          title="修改"><i class="layui-icon">&#xe642;</i></button>

          <button class="layui-btn layui-btn-danger  layui-btn-radius " 
          yth-data-id="<%d[i].id%>" 
          onclick="bckground.bg_delete(this)" data-bg_id="<%d[i].id%>" 
           title="删除"><i class="layui-icon">&#xe640;</i></button>
        </span>
        </div>
        <%# } %>
</script>
@endsection
<!-- js -->
@section('script') @include('admin.article.common_script')
<!-- JS运行脚本 -->
<script>
loadjs(["/static_pc/admin/js_v3.0/background.js", ], {
    success: function () {
        layui.use(['layer'], function () {
            // 模板配置
            laytpl.config({
                open: '<%',
                close: '%>'
            });
            // 选中当前所在模块
            $("#background_list").addClass("layui-this");
            // 初始化，添加界面 => 背景列表
            yth_pageination({
                "api": admin_api("article", "background_info"),
                "render_tpl": "background_list_tpl",
                "render_html": "background_list_html",
                "pageination_id": "background_list_pagenation",
                "loading_switch": true,
            });
        });
    }
});
</script>
@endsection