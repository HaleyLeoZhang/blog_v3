@extends('module.index.layout')
<!-- 文章标题 -->
@section('set_title')云天河在线聊天系统@endsection
<!-- SEO 关键词-->
@section('seo_keywords')云天河,在线聊天系统@endsection
<!-- SEO 描述-->
@section('seo_description')
swoole聊天
@endsection
<!-- 内容开始-->
@section('content')
<!-- 页面模板
  <script type="yth/tpl" id="yth_chat_customer_body">
-->
<link rel="stylesheet" href="http://cdn.bootcss.com/wangeditor/2.1.20/css/wangEditor.min.css">
<link rel="stylesheet" href="{{ link_plugins('chat','core.css') }}">
<div id="yth_chat_sidebar" oncontextmenu="return false;">
    <audio id="yth_bg_music" src="/static_pc/plugins/chat/bg_music.mp3" style="display:none;"></audio>
    <div class="logo_btn"></div>
    <div class="bar">
        <div class="ngv_top">
            <div class="name" title="聊天栏">
                <span class="info">
              <font style="color:#b094e1;">云天河</font><font style="color:orange;">Blog</font>
            </span>
                <span>
              &nbsp;&nbsp;~欢迎你~ &nbsp;&nbsp;
            </span>
                <span class="back_button" title="收起">收起</span></div>
            <div class="choice">
                <span class="select selected" title="联系人" yth-data="0">
              <img src="/static/plugins/chat/img/obj.png" title="选择对话人物"></span>
                <span class="select" title="正在进行的对话" yth-data="1">
              <img src="/static/plugins/chat/img/talking.png" title="历史会话"></span>
            </div>
        </div>
        <div class="list">
            <div class="group">
                <div class="inner">
                    <div class="arrow">></div>
                    <div class="descript">智能客服</div>
                </div>
                <div class="warp" title="智能客服">
                    <div class="list_content" id="yth-s_id_-1" yth-s_id="-1">
                        <div class="pic" title="头像">
                            <img src="/static_pc/plugins/chat/img/head_pic/5.jpg" alt="头像">
                        </div>
                        <div class="info">
                            <div class="name" title="昵称" yth-descript="我是聪明的图灵机器人">
                                图灵
                            </div>
                            <div class="icons">
                                <span class="icon icon_v_yellow" title="智能客服"></span>
                                <span class="icon icon_crown" title="快速回复"></span>
                                <span class="icon icon_gendar_gentleman" title="性别"></span>
                            </div>
                        </div>
                    </div>
                    <div class="list_content" id="yth-s_id_-2" yth-s_id="-2">
                        <div class="pic" title="头像">
                            <img src="/static_pc/plugins/chat/img/head_pic/14.jpg" alt="头像">
                        </div>
                        <div class="info">
                            <div class="name" title="昵称" yth-descript="你的贴心小棉袄">
                                慧慧
                            </div>
                            <div class="icons">
                                <span class="icon icon_v_yellow" title="智能客服"></span>
                                <span class="icon icon_crown" title="快速回复"></span>
                                <span class="icon icon_gendar_lady" title="性别"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="group">
                <div class="inner">
                    <div class="arrow">></div>
                    <div class="descript">人工客服</div>
                </div>
                <div class="warp" id="yth_chat_staff_list" title="人工客服">
                    <!-- Render Field -->
                </div>
            </div>
        </div>
        <div class="list" title="聊天记录">
            <div class="group">
                <div class="warp" id="chat_logs_list" title="智能客服">
                    <!-- Render Field -->
                </div>
            </div>
        </div>
    </div>
</div>
<div id="yth_chat_box" oncontextmenu="return false;">
    <!-- Chat dialog -->
    <input type="hidden" name="fd" id="fd" value="" palceholder="fd">
    <input type="hidden" id="chating-s_id" name="s_id" value="1" palceholder="staff_id">
    <div id="yth_chat_container">
        <div class="box">
            <div class="header">
                <div class="top_left">
                    <img src="/static_pc/plugins/chat/img/head_pic/author.jpg" title="聊天对象" alt="聊天对象" id="dialog_with_whose_img">
                </div>
                <div class="top_right">
                    <div class="name">
                        <span id="dialog_with_whose_name" title="TA的昵称">云天河</span>
                        <span class="icon icon_v_yellow"></span>
                        <span class="icon icon_crown"></span>
                        <span class="icon icon_gendar_gentleman"></span>
                        <span class="close" title="收起对话框">X</span>
                    </div>
                    <div id="dialog_with_whose_descript" title="人物描述">我来告诉你怎么用...</div>
                </div>
            </div>
            <div class="container">
                <ul>
                    <!-- Here are some text about your chating-->
                </ul>
            </div>
            <div id="yth_editor"></div>
            <div id="hlz_chat_send">发送</div>
        </div>
    </div>
</div>
<!-- 页面模板 结束
  </script>
-->
<!-- Chat Text-->
<script type="yth/tpl" id="yth_chat_customer_text_tpl">
    <li class="<%d.actor%>">
        <h5 style="float:<%d.float%>;font-weight:bold"><%d.name%></h5>
        <span style="float:<%d.float%>;">
      <div class="wangEditor-container">
        <div class="wangEditor-txt"><%d.text%></div>
      </div>
    </span>
        <small style="float:<%d.float%>;color:#EE30A7;margin-bottom: 5px;margin-top: 3px;"><%d.time%></small>
    </li>
    <div class="clr_line"></div>
</script>
<!-- Chat Staff List-->
<script type="yth/tpl" id="yth_chat_staff_list_tpl">
    <%# for(var i=0; i<d.length ;i++){ %>
        <div class="list_content " id="yth-s_id_<%d[i].s_id%>" yth-s_id="<%d[i].s_id%>">
            <div class="pic" title="头像">
                <img src="<%d[i].pic%>" alt="头像"></div>
            <div class="info">
                <div class="name" title="昵称" yth-descript="追求客户满意，是我们最大的责任">
                    <%d[i].name%>
                </div>
                <div class="icons">
                    <span class="icon icon_v_purple" title="人工客服"></span>
                    <span class="icon icon_crown" title="快速回复"></span>
                    <span class="icon icon_status_success" title="已认证"></span>
                </div>
            </div>
        </div>
        <%#  }  %>
</script>
<!-- Chat Logs List-->
<script type="yth/tpl" id="yth_chat_logs_list_tpl">
    <div class="list_content" id="receive_s_id_<%d.s_id%>" yth-s_id="<%d.s_id%>">
        <div class="pic" title="头像">
            <img src="<%d.pic%>" alt="头像"></div>
        <div class="info">
            <div class="name" title="昵称" yth-descript="<%d.descript%>">
                <%d.name%>
            </div>
            <div class="icons">
                <%d.icons%>
            </div>
        </div>
    </div>
</script>
<script>
loadjs([
    "{{ link_plugins('hlz_components','alert.js') }}",
    "{{ link_plugins('chat','core.js') }}",
    "http://cdn.bootcss.com/wangeditor/2.1.20/js/wangEditor.min.js"
], {
    success: function () {
        // 模板配置
        laytpl.config({
          open: '<%',
          close: '%>'
        });
        // 选中当前所在模块
        chat_instance();
    }
});
</script>
@endsection