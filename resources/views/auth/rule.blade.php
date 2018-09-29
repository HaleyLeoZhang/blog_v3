@extends('admin.public.layout')
<!-- 页面标题 -->
@section('title') 权限管理 @endsection
<!-- 功能备注 -->
@section('mark')  @endsection
<!-- 内容 -->
@section('content')
@include('auth.pre_css')

<div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief">
  <ul class="layui-tab-title">
    <li class="handle_button_void layui-this" data-target_id="activity-show">总览</li>
    <li class="handle_button_void" data-target_id="rule_add">添加</li></ul>
  <div class="layui-tab-content">
    <!--活动一览-->
    <div class="layui-tab-item layui-show " id="activity-show">
      <!--这里是编辑区域-->
      <div id="this_tpl"></div>
      <div id="this_page"></div>
      <div id="this_edit_tpl"></div>
    </div>
    <!--添加规则-->
    <div class="layui-tab-item" id="rule_add">
      <blockquote class="layui-elem-quote">请注意：为了方便管理，一但权限规则被创建，则不能被修改，只能被删除</blockquote>
      <!--文字表单-->
      <form class="layui-form  layui-form-pane" id="sub_new_form">
        <div class="layui-form-item">
          <label class="layui-form-label">名称</label>
          <div class="layui-input-block">
            <input type="text" name="title" id="yth_rule_add_title" placeholder="请输入形如：权限模块/添加" autocomplete="off" class="layui-input"></div>
        </div>
        <div class="layui-form-item">
          <label class="layui-form-label">规则</label>
          <div class="layui-input-block">
            <input type="text" name="rule" id="yth_rule_add_rule" placeholder="请输入形如：con/Admin_common/index" autocomplete="off" class="layui-input"></div>
        </div>
      </form>
      <div>
        <button id="sub_new" style="
        font-family:微软雅黑;  font-weight: 700;  color: rgb(84,126,86); 
        cursor: pointer; outline: none;  padding: 10px 10px; 
        width: 100%; font-size: 17px;  border: none; 
        background: rgb(220,250,200);margin-top:20px;margin-bottom:20px">确认添加</button>
      </div>
      <div id="yth_show_block" style="margin-top: 50px;margin-bottom:10px;display:none; ">
        <blockquote class="layui-elem-quote">以下为新添内容 - 可点击删除</blockquote>
        <div id="yth_rule_add_result"></div>
      </div>
    </div>
    <!--添加规则结束--></div>
</div>

<!-- 页面模板，显示列表-->
<script type="text/yth_tpl" id="yth_t1">
  <div class="layui-form">
    <table class="layui-table" lay-even="" lay-skin="nob" >
      <colgroup>
        <col width="150">
        <col width="240">
        <col width="200">
        <col width="100">
        <col width="240">
        <col >
      </colgroup>
      <thead>
        <tr>
          <th>名称</th>
          <th>规则</th>
          <th>当前状态&nbsp;|&nbsp;删除</th>
          <th>名称</th>
          <th>规则</th>
          <th>当前状态&nbsp;|&nbsp;删除</th>
        </tr> 
      </thead>
      <tbody>
       <%# for(var i=0;i< d.length;i++){ %>
        <tr id="tr_<%d[i].id%>">
          <td class="td_<%d[i].id%>"><%d[i].title%></td>
          <td class="td_<%d[i].id%>"><%d[i].rule%></td>
          <td>
          <%# var yth_switch= d[i].status==1? "layui-form-onswitch": ""; %>
          <%# var yth_switch_name= d[i].status==1? "正常": "冻结"; %>
            <!--状态-->
            <div class="td_<%d[i].id%>">
              <div class="layui-unselect layui-form-switch <%=yth_switch%> "yth-staff-id="<%d[i].id%>"  lay-skin="switch" lay-text="正常|冻结"><em><%=yth_switch_name%></em><i></i></div>
              <!--删除-->
              <button class="layui-btn layui-btn-danger act_del td_<%d[i].id%>" yth-data-id="<%d[i].id%>" title="删除"><i class="layui-icon">&#xe640;</i></button>
            </div>
          </td>
          <%# i++; %>
          <%# if( i< d.length ){ %>
            <td class="td_<%d[i].id%>"><%d[i].title%></td>
              <td class="td_<%d[i].id%>"><%d[i].rule%></td>
              <td>
              <%# var yth_switch= d[i].status==1? "layui-form-onswitch": ""; %>
              <%# var yth_switch_name= d[i].status==1? "正常": "冻结"; %>
                <!--状态-->
                <div class="td_<%d[i].id%>">
                  <div class="layui-unselect layui-form-switch <%=yth_switch%> "yth-staff-id="<%d[i].id%>"  lay-skin="switch" lay-text="正常|冻结"><em><%=yth_switch_name%></em><i></i></div>
                  <!--删除-->
                  <button class="layui-btn layui-btn-danger act_del td_<%d[i].id%>" yth-data-id="<%d[i].id%>" title="删除"><i class="layui-icon">&#xe640;</i></button>
                </div>
              </td>
          <%#  } %>

          
        </tr>
        <%#  } %>
      </tbody>
    </table>
  </div>
</script>



@endsection

@section('script')
@include('auth.pre_script')
<!-- JS运行脚本 -->
<script>
loadjs([
  "/static_pc/admin/auth/js/super_rule.js",
], {
  success: function() {
    // 选中当前所在模块
    $("#super_rule").addClass("layui-this");
    layui.use(['layer', 'laydate'], function() {
      handle_button_void();
      show_rules(); 
      // 添加新的
      yth_activity_sub();
      //~~~~~~~~~~~~~~~~~~~~~~~~~~LayUI加载模块——结束~~~~~~~~~~~~~~~~~~~~~~~~~~~
    }); 
  }
});
</script>
@endsection