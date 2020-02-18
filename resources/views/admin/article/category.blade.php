<!-- 继承页面 -->
@extends('admin.public.layout')
<!-- 页面标题 -->
@section('title') 文章分类管理 @endsection
<!-- 功能备注 -->
@section('mark') @endsection
<!-- CSS -->
@section('css')
<link rel="stylesheet" href="/static_pc/admin/css_v2.0/categroy.css"> @endsection
<!-- 内容 -->
@section('content')
<div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief">
    <ul class="layui-tab-title">
        <li class="layui-this">文章分类</li>
    </ul>
    <div class="layui-tab-content">
        <!--分类一览-->
        <div class="layui-tab-item layui-show">
            <button class="layui-btn layui-btn-normal act_add" yth-data-fid="0" title="添加一级分类"><i class="layui-icon">&#xe654;</i>&nbsp;新分类</button>
            <div id="yth_show_list" style="padding-bottom:100px;width:1000px;"></div>
            <div class="clear"></div>
        </div>
    </div>
</div>
@endsection
<!-- js -->
@section('script')
@include('admin.article.common_script')
<!-- 页面模板，显示无限极分类 -->
<script type="text/yth_tpl" id="yth_t1">
    <%# for(var i=0; i <d.length ;i++){ %> 
        <!--第一层结束-->
        <div class=" categroy_bar_1  tr_<%d[i].id%>" style="float:left;min-width:300px;margin-right:25px;">
            <!-- 内容 -->
            <span class="categroy_bar_content">
              <%d[i].title%>
            </span>
            <!-- 按钮 -->
            <span class="categroy_bar_button">
                <button class="layui-btn layui-btn-warm layui-btn-radius  act_edit" yth-data-id="<%d[i].id%>" title="修改">
                    <i class="layui-icon">&#xe642;</i>
                </button>
                <button class="layui-btn layui-btn-danger  layui-btn-radius act_del" yth-data-id="<%d[i].id%>" yth-data-fid="0"  title="删除">
                    <i class="layui-icon">&#xe640;</i>
                </button>
            </span>
        </div>
    <%# } %>
</script>
<!-- JS运行脚本 -->
<script>
loadjs([
    "/static_pc/admin/js_v2.0/article_category.js",
], {
    success: function () {
        // 模板配置
        laytpl.config({
          open: '<%',
          close: '%>'
        });
        layui.use(['layer'], function () {
            // 选中当前所在模块
            $("#blog_category_list").addClass("layui-this");
            // 读取分类
            get_list();
            // code...
        });
    }
});
</script>
@endsection