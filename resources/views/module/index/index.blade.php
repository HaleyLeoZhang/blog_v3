{{-- 继承页面 --}}
@extends('module/index/layout')
{{-- 页面标题 --}}
@section('set_title')云天河@endsection
{{-- 页面SEO --}}
@section('seo_keywords')云天河博客,云天河,hlzblog,在路上的架构师@endsection
{{-- 页面描述 --}}
@section('seo_description')云天河Blog(www.hlzblog.top)，致力于全栈开发技术的交流与资源共享。欢迎加入QQ群239734937，一起更进一步。@endsection

{{-- 容器开始 --}}
@section('content')
<!-- 容器 - 左侧 -->
<div class="left" >
	@include('module/index/index_components/article')
</div>
<!-- 容器 - 右侧 -->
<div class="right">
	<div class="search_article">
		<form action="/" method="get">
			<input type="text" name="search" placeholder="博文搜索" value="{{ $_GET['search'] ?? '' }}">
			<button type="submit" title="立即搜索" onclick="">
				<i class="fa fa-paper-plane  fa-lg" style="margin-right:10px;"></i>
			</button>
		</form>
		<div class="clr"></div>
	</div>
	@include('module/index/index_components/category')
	@include('module/index/index_components/recommand')
	@include('module/index/index_components/assignment')
	@include('module/index/index_components/hot_article')
</div>

<div class="clr"></div>

<div style="background:#eee;width:100%;height:30px;"></div>

<!-- 页足 -->
<div id="friend_link_html">
	<div class="Link_to_others">
		<div class="container">
		@include('module/index/index_components/friend_link')
		</div>
	</div>
</div>
<div class="clr"></div>
@endsection


{{-- 脚本 --}}
@section('script')
<script type="text/javascript">
	loadjs([
		"{{ link_src('modules.js') }}"
	], {
		success: function() {
			blog_text.show_banner();
		}
	});
</script>
@endsection