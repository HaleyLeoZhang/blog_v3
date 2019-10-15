@extends('admin.public.layout')
<!-- 页面标题 -->
@section('title') 人员管理 @endsection
<!-- 功能备注 -->
@section('mark')  @endsection
<!-- 内容 -->
@section('content')
@include('auth.pre_css')

<div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief">
    <ul class="layui-tab-title">
        <li class="handle_button_void layui-this" data-target_id="lay_show" id="remove_search_content">人员列表</li>
        <li class="handle_button_void" data-target_id="lay_add" >添加人员</li>
        <li class="handle_button_void" data-target_id="lay_search" >搜素</li>
    </ul>
    <div class="layui-tab-content">
        <!--活动一览-->
        <div class="layui-tab-item layui-show" id="lay_show">
            <!--这里是编辑区域-->
            <div id="this_tpl"></div>
            <div id="this_page"></div>
            <div id="this_edit_tpl"></div>
        </div>
        <!--添加职员-->
        <div class="layui-tab-item" id="lay_add">
            <blockquote class="layui-elem-quote">请注意：人员一旦注册，不能修改其帐号与昵称，只能删除</blockquote>
            <!--文字表单-->
            <form class="layui-form  layui-form-pane" id="sub_new_form">
                <div class="layui-form-item">
                    <label class="layui-form-label">邮箱</label>
                    <div class="layui-input-block">
                        <input type="text" name="email" placeholder="示例，zhangsan@xmfenqi.cn" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">姓名</label>
                    <div class="layui-input-block">
                        <input type="text" name="truename" placeholder="示例，张三" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">密码</label>
                    <div class="layui-input-block">
                        <input type="hidden" title="这里将会是经过rsa与encodeURIComponent()加密后的密码" id="yth_rsa_pwd">
                        <input type="password" name="password" placeholder="请输入 6~25位 长度的密码" id="yth_input_num" onblur="" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">确认密码</label>
                    <div class="layui-input-block">
                        <input type="password" name="re_password" placeholder="请再次输入密码" id="yth_input_num" onblur="" autocomplete="off" class="layui-input">
                    </div>
                </div>
            </form>
            <div>
                <button id="sub_new" style="
        font-family:微软雅黑;  font-weight: 700;  color: rgb(84,126,86); 
        cursor: pointer; outline: none;  padding: 10px 10px; 
        width: 100%; font-size: 17px;  border: none; 
        background: rgb(220,250,200);margin-top:20px;margin-bottom:20px">确认添加</button>
            </div>
        </div>
        <!--添加职员结束-->
        <!--搜索员工-->
        <div class="layui-tab-item" id="lay_search">
            <div class="goods_search">
                <div class="search-nav-inner">
                    <div class="search">
                        <div class="search-top">
                            <b>人员搜索</b>
                        </div>
                        <div class="search-clr"></div>
                        <div class="search-bottom">
                            <form>
                                <input type="text" name="name" id="search_title" placeholder="请输入人员帐号">
                                <input type="button" value="搜索" id="search_sub">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="search-clr"></div>
            <div id="yth_search_tpl"></div>
            <div id="yth_search_res_tpl"></div>
        </div>
        <!--搜索员工结束-->
    </div>
</div>
<!-- 页面模板，显示列表 -->
<script type="text/yth_tpl" id="yth_t1">
    <div class="layui-form">
        <table class="layui-table" lay-even="" lay-skin="nob">
            <colgroup>
                <col width="50px">
                <col width="100px">
                <col width="200px">
                <col width="100px">
                <col width="200px">
                <col width="100px">
                <col width="150px">
                <col width="300px">
            </colgroup>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>头像</th>
                    <th>帐号</th>
                    <th>昵称</th>
                    <th>创建时间</th>
                    <th style="padding-left:28px;">编辑</th>
                    <th style="padding-left:28px">删除</th>
                    <th>帐号状态</th>
                </tr>
            </thead>
            <tbody>
                <%# for(var i=0;i< d.length;i++){ %>
                    <tr id="tr_<%d[i].id%>">
                        <td>
                            <%d[i].id%>
                        </td>
                        <td ><img src="<%d[i].user_pic%>" alt="头像" width="60"></td>
                        <td>
                            <%d[i].email%>
                        </td>
                        <td>
                            <%d[i].truename%>
                        </td>
                        <td>
                            <%d[i].created_at%>
                        </td>
                        <td>
                            <button class="layui-btn layui-btn-warm act_edit" yth-data-id="<%d[i].id%>" title="编辑" >
                                <i class="layui-icon">&#xe642;</i>
                            </button>
                        </td>
                        <td>
                            <button class="layui-btn layui-btn-danger act_del" yth-data-id="<%d[i].id%>" title="删除"><i class="layui-icon">&#xe640;</i></button>
                        </td>
                        <td>
                            <!-- 基础样式 layui-unselect layui-form-switch 添加或者删除 layui-form-onswitch 开关-->
                            <%# var yth_switch= d[i].status==0? "layui-form-onswitch": ""; %>
                                <%# var yth_switch_name= d[i].status==0? "正常": "冻结"; %>
                                    <div class="layui-unselect layui-form-switch <%=yth_switch%> " yth-staff-id="<%d[i].id%>" lay-skin="switch" lay-text="正常|冻结"><em><%=yth_switch_name%></em><i></i></div>
                        </td>
                    </tr>
                    <%#  } %>
            </tbody>
        </table>
    </div>
</script>
<!-- 页面模板，修改操作，模拟checkbox -->
<script type="text/yth_tpl" id="yth_t2">
    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 50px;">
        <legend>修改 - TA的功能</legend>
    </fieldset>
    <form class="layui-form layui-form-pane" id="sub_edit_form">
        <input type="hidden" class="" yth-description="这里是临时存放group_id数据的地方" id="group_id">
        <div class="layui-form-item">
            <label class="layui-form-label">重选功能</label>
            <!--选中时 layui-unselect layui-form-checkbox layui-form-checked -->
            <%# for(var i=0;i< d.group_list.length;i++){ %>
                <div class="layui-unselect layui-form-checkbox yth-checkbox" lay-skin="" yth-data-id="<%d.group_list[i].id%>"><span><%d.group_list[i].title%></span><i class="layui-icon"></i></div>
                <%# } %>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">已有功能</label>
            <div class="layui-input-block">
                <%# for(var i=0;i< d.now_group.length;i++){ %>
                    <div class="layui-unselect layui-form-checkbox layui-form-checked" lay-skin=""><span style="background-color:#1A1A1A"><%d.now_group[i].title%></span><i class="layui-icon"></i></div>
                    <%# } %>
            </div>
            <div>
                <button id="sub_edit" style="
      font-family:微软雅黑;  font-weight: 700;  color: rgb(84,126,86); 
      cursor: pointer; outline: none;  padding: 10px 10px; 
      width: 100%; font-size: 17px;  border: none; 
      background: rgb(220,250,200);margin-top:20px;margin-bottom:20px" yth-data-id="<%d.staff_id%>" type="button">确认修改</button>
            </div>
    </form>
</script>
@endsection 

@section('script')
@include('auth.pre_script')
<!-- JS运行脚本 -->
<script src="/static_pc/plugins/pageinate/js/jq_page.js"></script>
<script src="/static_pc/admin/auth/js/human.js"></script>
<script>
        // 选中当前所在模块
        // $("#hr_all").addClass("layui-this");
        // 监听模块切换
        // handle_button_void();
        // 解决搜索与直接显示用的冲突
        // remove_conflict();

        // layui.use(['layer', 'laydate'], function () {
        //     yth_hr_init();
        //     // 搜索按钮
        //     yth_search();
        //     // 添加新的
        //     yth_activity_sub();
        //     //~~~~~~~~~~~~~~~~~~~~~~~~~~LayUI加载模块——结束~~~~~~~~~~~~~~~~~~~~~~~~~~~
        // });
    // }
</script>
@endsection