<!-- 继承页面 -->
@extends('admin.public.layout')
<!-- 页面标题 -->
@section('title') 分组管理 @endsection
<!-- 功能备注 -->
@section('mark')  @endsection
<!-- 内容 -->
@section('content')

@include('auth.pre_css')
<style>
.layui-form-checkbox span {
    background-color: #5FB878;
}
</style>
<div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief">
    <ul class="layui-tab-title">
        <li class="layui-this" id="remove_search_content">分组管理</li>
        <li>添加组</li>
    </ul>
    <div class="layui-tab-content">
        <!--总览-->
        <input type="hidden" id="current_group_rule_ids" placeholder="加载出来的对应管理组的id，都存在这，以逗号隔开">
        <div class="layui-tab-item layui-show" id="activity-show">
            <blockquote class="layui-elem-quote">新增加的组，刷新一下页面才能看到哟</blockquote>
            <!--这里是编辑区域-->
            <div class="layui-collapse" id="xx_show" lay-accordion></div>
            <!-- 修改区域 -->
            <div id="xx_edit" style="display:none">
                <blockquote class="layui-elem-quote">下面是供选择的规则，点击即选中</blockquote>
                <fieldset class="layui-elem-field layui-field-title" style="margin-top: 50px;">
                    <legend>当前组：<span id="yth_group_name"></span></legend>
                </fieldset>
                <form class="layui-form layui-form-pane" id="sub_edit_form">
                    <input type="hidden" class="" yth-description="这里是临时存放rule_id数据的地方" id="xxxx_rule_list_edit">
                    <input type="hidden" yth-description="这里是临时group_id" id="xxxx_rule_list_edit_id">
                    <div class="layui-form-item">
                        <div class="layui-input-block" id="xxxxxxxxxxxxx_eidt">
                        </div>
                    </div>
                    <div>
                        <button id="sub_edit" style="
              font-family:微软雅黑;  font-weight: 700;  color: rgb(84,126,86); 
              cursor: pointer; outline: none;  padding: 10px 10px; 
              width: 100%; font-size: 17px;  border: none; 
              background: rgb(220,250,200);margin-top:20px;margin-bottom:20px" type="button">确认修改</button>
                    </div>
                </form>
            </div>
        </div>
        <!--添加组-->
        <div class="layui-tab-item">
            <blockquote class="layui-elem-quote">请注意：组名不能重复哟</blockquote>
            <!--文字表单-->
            <form class="layui-form layui-form-pane" id="sub_edit_form">
                <div class="layui-form-item">
                    <label class="layui-form-label">组名</label>
                    <div class="layui-input-block">
                        <input type="text" autocomplete="off" placeholder="请输入组名" class="layui-input" id="xx_title">
                    </div>
                </div>
                <input type="hidden" class="" yth-description="这里是临时存放rule_id数据的地方" id="xx_rule_list_add">
                <div id="yth_t3_show"></div>
                <div>
                    <button id="sub_new" style="
          font-family:微软雅黑;  font-weight: 700;  color: rgb(84,126,86); 
          cursor: pointer; outline: none;  padding: 10px 10px; 
          width: 100%; font-size: 17px;  border: none; 
          background: rgb(220,250,200);margin-top:20px;margin-bottom:20px" type="button">确认添加</button>
                </div>
            </form>
        </div>
        <!--添加职员结束-->
    </div>
</div>
<!-- 页面模板，显示列表 -->
<script type="text/yth_tpl" id="yth_t2">
    <!--这里是一个管理组-->
    <%# for(var i=0;i< d.length;i++){ %>
        <div class="layui-colla-item yth_stopPropagation" id="tr_<%d[i].id%>" yth-data-id="<%d[i].id%>">
            <h2 class="layui-colla-title"><i class="layui-icon">&#xe612;</i>&nbsp;<span id="title_<%d[i].id%>"><%d[i].title%></span></h2>
            <div class="layui-colla-content">
                <div>
                    <button class="layui-btn act_edit_name layui-btn-small layui-btn-radius" yth-data-id="<%d[i].id%>">修改组名</button>
                    <button class="layui-btn act_edit_rules layui-btn-normal layui-btn-small  layui-btn-radius" yth-data-id="<%d[i].id%>">修改规则</button>
                    <button class="layui-btn group_rule_auto_click layui-btn-small  layui-btn-radius"  data-id="<%d[i].id%>">增加规则</button>
                    <button class="layui-btn layui-btn-danger layui-btn-small  layui-btn-radius act_del" yth-data-id="<%d[i].id%>">删除该组</button>
                    <!-- 基础样式 layui-unselect layui-form-switch 添加或者删除 layui-form-onswitch 开关-->
                    <%# var yth_switch= d[i].status==1? "layui-form-onswitch": ""; %>
                        <%# var yth_switch_name= d[i].status==1? "正常": "冻结"; %>
                            <div class="layui-unselect layui-form-switch <%=yth_switch%> " yth-data-id="<%d[i].id%>" lay-skin="switch" lay-text="正常|冻结" style="margin-top: 0px;margin-left: 10px;"><em><%=yth_switch_name%></em><i></i></div>
                </div>
                <!--分组内容-->
                <fieldset class="layui-elem-field layui-field-title" style="margin-top: 50px;">
                    <legend>规则列表</legend>
                </fieldset>
                <div id="this_edit_tpl_<%d[i].id%>" title="点我刷新"></div>
            </div>
        </div>
        <%# } %>
</script>
<!-- 页面模板，（添加/修改）操作，模拟checkbox -->
<script type="text/yth_tpl" id="yth_t3">
    <div class="layui-form-item">
        <label class="layui-form-label">供选规则</label>
        <%# for(var i=0;i< d.list.length;i++){ %>
            <div class="layui-unselect layui-form-checkbox <%d.class_name%>" lay-skin="" yth-data-id="<%d.list[i].id%>"><span><%d.list[i].title%></span><i class="layui-icon"></i></div>
            <%# } %>
    </div>
    <div>
</script>
<!-- 页面模板，显示已有规则，模拟checkbox -->
<script type="text/yth_tpl" id="yth_t4">
    <div class="layui-form-item">
        <div class="layui-input-block">
            <%# for(var i=0;i< d.length;i++){ %>
                <div class="layui-unselect layui-form-checkbox layui-form-checked" lay-skin=""><span style="background-color:#1A1A1A"><%d[i].title%></span><i class="layui-icon"></i></div>
                <%# } %>
        </div>
    </div>
</script>
@endsection
<!-- js -->
@section('script')

@include('auth.pre_script')
<!-- JS运行脚本 -->
<script>
loadjs([
    "/static_pc/plugins/pageinate/js/jq_page.js",
    "/static_pc/admin/auth/js/super_group.js"
], {
    success: function () {
        // 选中当前所在模块
        $("#super_group").addClass("layui-this");
        layui.use(['layer', 'laydate', 'element'], function () {
            // 刷新页面
            remove_conflict();
            // 状态按钮
            yth_switch();
            // 添加新的
            yth_activity_sub();
            // 删除按钮
            yth_activity_del();
            // 显示规则列表
            yth_rule_list();
            // 修改组名
            yth_edit_group();
            // 修改规则
            yth_activity_edit_sub();
            // 显示某组规则列表
            yth_listen_show();
            // 显示修改界面
            yth_edit_rules_button();
            // 增量 修改规则
            yth_group_rule_auto_click();
            //~~~~~~~~~~~~~~~~~~~~~~~~~~LayUI加载模块——结束~~~~~~~~~~~~~~~~~~~~~~~~~~~
        });
    }
});
// 分组列表
function show_list() {
    $.ajax({
        "url": '/admin/auth_group_list',
        "type": "post",
        "dataType": "json",
        "async": false,
        "success": function (_data) {
            var data = _data.data;
            render('yth_t2', 'xx_show', data.info, true); // 同步渲染
        }
    });
}
show_list();
// 分组列表
</script>
@endsection