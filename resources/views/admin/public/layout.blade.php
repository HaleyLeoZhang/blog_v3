<!DOCTYPE html>
<html>

    <head>
        <meta charset="UTF-8">
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <title>@yield('title') | 云天河博客管理系统</title>
        <!-- Bootstrap 3.3.2 -->
        <link href="{{ cdn_host() }}/static_pc/admin/theme/bootstrap/css/bootstrap.min.css?v=3.0.0" rel="stylesheet" type="text/css" />
        <link href="{{ cdn_host() }}/static_pc/admin/theme/icheck/all.css?v=3.0.0" rel="stylesheet" type="text/css" />
        <link href="{{ cdn_host() }}/static_pc/admin/theme/scojs/sco.message.css?v=3.0.0" rel="stylesheet" type="text/css" />
        <!-- Font Awesome Icons -->
        <!-- <link href="{{ cdn_host() }}/static_pc/admin/theme/font-awesome/css/font-awesome.min.css?v=3.0.0" rel="stylesheet" type="text/css" /> -->
        <link href="//cdn.staticfile.org/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet">
        <link href="//cdn.staticfile.org/font-awesome/4.6.3/fonts/fontawesome-webfont.svg" rel="image/svg+xml">
        <!-- Theme style -->
        <link href="{{ cdn_host() }}/static_pc/admin/theme/admin/admin.css?v=3.0.0" rel="stylesheet" type="text/css" />
        <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
        <link href="{{ cdn_host() }}/static_pc/admin/theme/admin/skins/_all-skins.min.css?v=3.0.0" rel="stylesheet" type="text/css" />
        <!-- logo -->
        <link rel="shortcut icon" href="{{ cdn_host() }}/favicon.ico" />
        <!-- v2.0博客后台，功能，被全部重写后，此区间资源可以删除掉 -->
        <link rel="stylesheet" href="/static_pc/plugins/layui/js/css/layui.css"> @yield('css')
    </head>

    <body class="skin-blue sidebar-mini">
        <div class="wrapper">
            <header class="main-header">
                <!-- Logo -->
                <div class="logo" style="background-color: #1B2125;">
                    <!-- mini logo for sidebar mini 50x50 pixels -->
                    <span class="logo-mini"><b>T</b></span>
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg text-center">
                <a class="navbar-brand admin_logo" href="/admin/hall"></a>
            </span>
                </div>
                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top" role="navigation" style="background-color: #23262E;">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" id="sliderbar_control" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <!--管理员基本信息展示 -->
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <span class="hidden-xs" style="color: silver;">
                                
                                亲爱的
                                  <b style="color:#EEE0E5" title="昵称">
                                    {{ \CommonService::$admin->truename }}</b>，
                                  <span id="hello_user">傍晚好！</span></a>
                            </span>
                        </a>
                                <ul class="dropdown-menu">
                                    <!-- User image -->
                                    <li class="user-header" style="background-color: #3D484E;">
                                        <img src="{{ \CommonService::$admin->user_pic }}" class="img-circle" alt="User Image" />
                                        <p>
                                            {{ \CommonService::$admin->truename }}
                                            <small>{{ \CommonService::$admin->email }}</small>
                                        </p>
                                    </li>
                                    <!-- 点击头像显示-->
                                    <li class="user-footer">
                                        <!-- <div class="pull-left">
                                            <a href="" class="btn btn-default btn-flat">头像左下角</a>
                                        </div> -->
                                        <div class="pull-right">
                                            <a href="/admin/logout" class="btn btn-default btn-flat">退出登录</a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <!-- 侧边栏，左侧 -->
            <aside class="main-sidebar">
                <section class="sidebar">
                    <ul class="sidebar-menu" id="root_menu">
                        <li class="header">管理菜单</li>
                        {!! \App\Repositories\Admin\MenuRepository::show_menu() !!}
                    </ul>
                </section>
            </aside>
            <!-- 内容 -->
            <div class="content-wrapper">
                <section class="content-header">
                    <h1>@yield('title')<small>@yield('mark')</small></h1>
                    
                </section>
                <section class="content">
                    @yield('content')
                </section>
            </div>
            <!-- 页足 -->
            @include('admin.public.footer')
        </div>
        <!-- 公共js库 -->
        @include('admin.public.script')
        <!-- 每个模块下引入的脚本 -->
        @yield('script')
    </body>

</html>