<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<meta name="keywords" content="@yield('seo_keywords')"/>
	<meta name="description" content="@yield('seo_description')"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="renderer" content="webkit">
	<meta name="author" content="云天河Blog">
	<!--
		According to my backstage data statistic in blog version 1.0,
	here is less than 10% visiters looking up my blog through mobile device
	-->
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>@yield('set_title')_云天河博客</title>
	<!-- Src -->
	<link rel="shortcut icon" href="{{ static_host() }}/favicon.ico"  />
	<link rel="stylesheet" href="{{ link_src('global.css') }}">
	<!-- ICON Compoents -->
	<link href="//cdn.staticfile.org/font-awesome/4.6.3/css/font-awesome.min.css"      rel="stylesheet">
	<link href="//cdn.staticfile.org/font-awesome/4.6.3/fonts/fontawesome-webfont.svg" rel="image/svg+xml" >
	<!-- Sentry -->
	<script src="//cdn.ravenjs.com/3.19.1/raven.min.js" crossorigin="anonymous"></script>
	<!-- JS Lib -->
	<script src="//cdn.staticfile.org/loadjs/3.4.0/loadjs.min.js"></script>
	<script src="//apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
	<script src="{{ link_src('global.js') }}"></script>
</head>
<body class="global">

<!-- Navigator -->
<header class="Navigator">
	<div class="nav" >
		<div class="global_container">
			<a href="/" class="logo" rel="nofollow">
				<img src="{{ static_host() }}/static_pc/img/default/logo_detail.png" class="animated bounceInLeft" width="160px" height="47px" alt="logo">
				<img src="{{ static_host() }}/static_pc/img/default/slogans.png" class="animated fadeInDown" style="border-right:none" alt="">
			</a>
			<!-- From right to left  -->

				<!-- List image , load them as one png -->

			<span class="login_icons">

			@if( is_null(\CommonService::$user) )
				<a href="/oauth2/redirect?gateway=qq" rel="nofollow">
					<img src="{{ static_host() }}/static_pc/img/third/qq_50.png" alt="QQ" title="QQ登陆" />
				</a>
				<a href="/oauth2/redirect?gateway=sina" rel="nofollow">
					<img src="{{ static_host() }}/static_pc/img/third/sina_50.png" alt="Sina" title="微博登陆" />
				</a>
				<a href="/oauth2/redirect?gateway=github" rel="nofollow">
					<img src="{{ static_host() }}/static_pc/img/third/github_fake_50.png" alt="Github" title="Github登陆" />
				</a>
			@else
				<a href="/oauth2/logout" rel="nofollow">
					<img src="{{ static_host() }}/static_pc/img/default/logout.png" alt="QQ" title="注销" />
				</a>
			@endif

			</span>


			<span class="item">
				<a href="/">
					首页
				</a>
				<a href="/books" target="_blank" rel="nofollow">
					书架
				</a>
				<a href="/memorabilia.html" target="_blank">
					大事记
				</a>
				<!-- 维护中... -->
				<!-- <a href="/About">
					关于我
				</a> -->
				<a href="/board">
					留言板
				</a>
			</span>


		</div>
	</div>
	<div class="banner">
		<!-- This field to set Banner in the middle -->
		<div id="hide_box">
			<img  style="left: -340px;"
			src="//img.cdn.hlzblog.top/17-6-8/33747397.jpg" alt="Banner" />
		</div>
	</div>
</header>
<div class="clr"></div>


<div class="show_container" id="show_container">
	<div class="global_container" style="background:#fff;">
	<!-- 容器，开始 -->
