{{-- 继承页面 --}}
@extends('module/index/layout')
{{-- 页面标题 --}}
@section('set_title'){{ $article_obj->title }}@endsection
{{-- 页面SEO --}}
@section('seo_keywords'){{ $article_obj->title }},云天河博客@endsection
{{-- 页面描述 --}}
@section('seo_description')这篇文章主要阐述了{{ $article_obj->descript }}的相关内容@endsection
{{-- 文章详情 --}}
@section('content')

<!-- 右侧悬浮 -->
@include('module/index/header_right_sidebar')

<link rel="stylesheet" href="{{ link_src('article.css') }}">
<div class="left" >
	
	<div class="article_list article_animated fadeInUp" add-class=" article_animated fadeInUp">
		<div class="article_title" >
			<h1 yth_original="{{ $article_obj->original }}" id="yth_original">{{ $article_obj->title }}</h1>
		</div>
		<div class="article_field">
			<div class="basic_info">
				<div class="others">
					<span title="发布时间">
						<i class="fa fa-clock-o" aria-hidden="true"></i>
						{{ $article_obj->created_at }}
						<font></font>
					</span>
					<span title="所属分类">
						<i class="fa fa-folder-open-o"></i>
						<a href="/?cate_id={{ $article_obj->cate_id }}">{{ $article_obj->cate_name }}</a>
						<font></font>
					</span>
					<span title="浏览量">
						<i class="fa fa-eye" aria-hidden="true"></i>
						{{ $article_obj->statistic }}
						<font></font>
					</span>
					<span title="总评论数">
						<a href="#nav">
						<i class="fa fa-commenting-o" aria-hidden="true"></i>
						{{ $comments_counter }}
						</a>
					</span>
					<div class="clr"></div>
				</div>
			</div>
			<div class="clr"></div>
			
			<div class="real_html" id="markdown_container" yth-article_id="{{ $article_obj->id }}" yth-article_type="{{ $article_obj->type }}" yth-bg_url="{{ $article_obj->bg_url }}">
				{!! $article_obj->content !!}
			</div>
			<div class="clr"></div>
		</div>	
	</div>

	<div class="plus_descript">
		<div class="info">
			<i class="fa fa-warning" style="padding-right: 10px;"></i>注：若无特殊说明，文章均为云天河原创，请尊重作者劳动成果，转载前请一定要注明出处
		</div>
	</div>

	<div class="comments_logo" id="nav">
		<h4>
			<i class="fa fa-comments-o"></i> 评论列表<span class="comment_main" title="点此评论"
			 onclick="article.reply_floor(this)" yth-article_id="{{ $article_obj->id }}">点此评论</span>

			 <div class="bdsharebuttonbox"  style="display:inline-block;height:30px;float: right;"><a href="#" class="bds_more" data-cmd="more"></a><a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a><a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a><a href="#" class="bds_sqq" data-cmd="sqq" title="分享到QQ好友"></a><a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a><a href="#" class="bds_fbook" data-cmd="fbook" title="分享到Facebook"></a><a href="#" class="bds_twi" data-cmd="twi" title="分享到Twitter"></a></div>
			 

		</h4>
	</div>
	
	<!-- Comments List -->
	<div class="article_comment" id="article_comment">
		<!-- 一会儿取出来作为模板 -->
		<!-- pic_test_src: http://tva1.sinaimg.cn/crop.0.0.640.640.180/65c897f9jw8faclt19le1j20hs0hsdgl.jpg -->
	</div>
	<div id="article_comment_pagenation"></div>
</div>

<div class="right">
	<div class="search_article">
		<form action="/" method="get">
			<input type="text" name="search" placeholder="博文搜索">
			<button type="submit" title="立即搜索" onclick="">
				<i class="fa fa-location-arrow  fa-lg" style="margin-right:10px;"></i>
			</button>
		</form>
		<div class="clr"></div>
	</div>

	<div class="catalog">
		<div class="right_bar_title">
			<h2><span><i class="fa fa-windows"></i> 文章目录</span></h2>
		</div>
		<div>
			<div id="catalog"></div>
		</div>
		<div class="clr"></div>
	</div>

	<div class="donation">
		<div class="right_bar_title">
			<h2><span><i class="fa fa-money"></i> 赞助天河 --- 支付宝</span></h2>
		</div>
		<div>
			<img src="http://img.cdn.hlzblog.top/18-1-15/32749214.jpg" alt="捐赠资助">
		</div>
		<div class="clr"></div>
	</div>
	<div class="recommands">
		<div class="right_bar_title">
			<h2><span><i class="fa fa-cogs"></i> 相关推荐</span></h2>
		</div>
		@foreach( $recommands as $recommand )
		<div class="one_recommand">
			<a href="/article/{{ $recommand->id }}.html" target="_blank" title="{{ $recommand->title }}">
				{{ $recommand->title }}
			</a>
			<div class="clr"></div>
		</div>
		@endforeach
	</div>
	<div class="categories">
		<div class="right_bar_title">
			<h2><span><i class="fa fa-folder-open-o"></i> 归档分类</span></h2>
		</div>
		<div class="clr"></div>
		@foreach( $cate_list as $category )
		<a href="/?cate_id={{ $category->id }}">
			<div class="one_category">
				<i class="fa fa-tag" aria-hidden="true"></i>
				{{ $category->title }}（{{ $category->total }}）
			</div>
		</a>
		@endforeach
	</div>
</div>

<div class="clr"></div>

<div style="width:100%;height:30px;"></div>

<!-- 主楼  模板-->
<script type="text/yth_tpl"  id="article_comment_tpl">
    <%#  for(var i=0,len=d.length ; i<len ;i++) { %>
        <div class="one_comment">
            <div class="left">
                <img class="user_pic"   src="<%d[i].pic%>" alt="头像">
            </div>
            <div class="right">
                <pre class="content" title="回复内容"><%d[i].content%></pre>
                <div class="other_info">
                    <p class="name" title="人物昵称">
                        <%login_method_icon_src(d[i].type)%>
                        <%d[i].name%>
                    </p>
                    <p class="time" title="回复时间">
                        <i class="fa fa-clock-o" title="回复时间"></i>
                        <%d[i].time%>
                    </p>
                    <p class="reply_him" onclick="article.reply_main_floor(this)" 
                    yth_main_floor="<%d[i].id%>" yth_name="<%d[i].name%>">
                        回复TA
                    </p>
                </div>
            </div>
            <div class="clr"></div>
        </div>
        <div class="reply_div one_comment">
            <div class="reply_his"  id="floor_id_<%d[i].id%>"></div>
            <div id="reply_his_pagination_<%d[i].id%>"></div>
        </div>
        <div class="clr"></div>
    <%#  }  %>
</script>

<!-- 楼中楼 模板-->
<script type="text/yth_tpl"  id="article_comment_reply_tpl">
    <%#  for(var i in d) { %>
            <div class="left">
                <img class="user_pic"   src="<%d[i].pic%>" alt="头像">
            </div>
            <div class="right">
                <pre class="content"  title="回复内容"><%d[i].content%></pre>
                <div class="other_info">
                    <p class="name">
                        <%login_method_icon_src(d[i].type)%>
                        <%d[i].name%>
                    </p>
                    <p class="time">
                        <i class="fa fa-clock-o" title="回复时间"></i>
                        <%d[i].time%>
                    </p>
                </div>
            </div>
            <div class="clr"></div>
    <%#  }  %>
</script>
@endsection



{{-- 脚本 --}}
@section('script')

<!-- All compoents about "lay" do not to load it by async way-->
<script src="{{ link_plugins('pageinate','laypage.js') }}"></script>
<script src="{{ config('static_source_cdn.layer') }}"></script>

<script type="text/javascript">
	var loadjs_src_arr = [
		"{{ link_src('modules.js') }}",
		"{{ link_plugins('hlz_components','alert.js') }}"
	];

	// If it is a markdown source ,load those
	if (0 == $("#markdown_container").attr("yth-article_type")) {
		loadjs_src_arr.push("{{ link_plugins('hlz_components','markdown.js') }}");
		console.log('Render Markdown success');
	}

	loadjs(loadjs_src_arr, {
		success: function() {
			var bg_url = $("#markdown_container").attr("yth-bg_url");
			article.change_bg(  bg_url  );
			article.get_comments_main();
			article.set_open_event();
			// Baidu Share
			window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"1","bdSize":"24"},"share":{}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];
		}
	});

</script>
@endsection