{{-- 继承页面 --}}
@extends('module/index/layout')
{{-- 页面标题 --}}
@section('set_title') 留言板_云天河博客 @endsection
{{-- 页面描述 --}}
@section('seo_description') 留言板 @endsection
{{-- 文章详情 --}}
@section('content')

<link rel="stylesheet" href="{{ link_src('board.css') }}">
<div class="board_container" >
        <div class="reply">
            <div class="message_board" onclick="board.reply_floor()" title="点此留言"><img src="{{ static_host() }}/static_pc/img/default/leave_message.png" alt="留言图标"></div>
            <div class="clr"></div>
        </div>
		<ul class="message_list" id="message_list" 
            yth_to_page="1" 
            yth_page_count="{{ $paginage['page_count'] }}" 
            yth_total="{{ $paginage['total'] }}">
        @foreach($paginage['info'] as $item)
            <li>
                <!-- Right user_pic -->
                <div class="right_box">
                    <img src="{{ $item->pic }}" alt="头像">
                </div>
                <div class="arrow_box">
                    <!--triangle-->
                    <div class="ti"></div>
                    <div class="textinfo">
                        {{ $item->content }}
                    </div>
                    <ul class="details">
                        <li class="icon-time" title="昵称">
                            @if( $item->type == 0 )
                            <img class="login_method_icon" src="{{ static_host() }}/static_pc/img/default/icon_v_yellow.png" title="博主">
                            @elseif( $item->type == 1 )
                                <i class="fa fa-weibo" title="Sina 用户"></i>
                            @elseif( $item->type == 2 )
                                <i class="fa fa-qq" title="QQ 用户"></i>
                            @elseif( $item->type == 3 )
                                <i class="fa fa-github" title="Github 用户"></i>
                            @endif
                            {{ $item->name }}
                        </li>
                        <li class="comments" title="留言时间">
                          <i class="fa fa-clock-o"></i> {{ $item->time }}
                        </li>
                        <li style="list-style: none; display: inline">
                            <div class="clr"></div>
                        </li>
                    </ul>
                </div><!--arrow_box end-->
            </li>
        @endforeach
        </ul>
  <div class="clr"></div>
</div>
@endsection

@section('script')
<script type="text/yth_tpl" id="message_list_tpl">
    <%#  for( var i in d ){   %>
            <li>
                <div class="right_box">
                    <img src="<%d[i].pic%>" alt="头像">
                </div>
                <div class="arrow_box">
                    <div class="ti"></div>
                    <div class="textinfo">
                        <%d[i].content%>
                    </div>
                    <ul class="details">
                        <li class="icon-time" title="昵称">
                            <%  login_method_icon_src(d[i].type) %>
                            <%d[i].name%>
                        </li>
                        <li class="comments" title="留言时间">
                          <i class="fa fa-clock-o"></i> <%d[i].time%>
                        </li>
                        <li style="list-style: none; display: inline">
                            <div class="clr"></div>
                        </li>
                    </ul>
                </div>
            </li>
    <%#  }  %>
</script>


<script src="//cdn.staticfile.org/layer/2.3/layer.js"></script>
<script type="text/javascript">
	loadjs([
        "{{ link_src('modules.js') }}",
        "{{ link_plugins('hlz_components', 'alert.js') }}",
	], {
		success: function() {
			$("#hide_box img").attr({"src":""});
            $(".global_container").attr({"style":"background:none"});
			article.change_bg("http://img.cdn.hlzblog.top/17-6-29/38918642.jpg"); // 设置背景图
            // Event: if  it scrolled down on the bottom of the browser
            board.is_page_bottom();
		}
	});

</script>

@endsection