<!DOCTYPE html>
<html>

    <head>
        <title>后台管理系统 | 云天河Blog</title>
        <meta charset="UTF-8" />
        <meta name="keywords" content="云天河,后台管理系统" />
        <meta name="description" content="云天河博客，后台登录系统" />
        <meta name="author" content="业务QQ1290336562" />
        <link href="//lib.sinaapp.com/js/bootstrap/v3.0.0/css/bootstrap.min.css" rel="stylesheet">
        <style>
        body {
            min-width: 500px;
            background: url("http://img.cdn.hlzblog.top/17-12-15/28859555.jpg");
            background-attachment: fixed;
            background-size: 100% 100%;
            background-repeat: no-repeat;
        }

        .signin {
            width: 477px;
            height: 479px;
            margin: 0 auto;
            position: absolute;
            top: 50%;
            left: 50%;
            margin-top: -239px;
            margin-left: -238px;
            z-index: 2;
        }

        .signin-head {
            margin: 0 auto;
            padding-top: 30px;
            width: 120px;
            margin-top: -50px;
        }

        .form-signin {
            max-width: 330px;
            padding: 43px 15px 15px 15px;
            margin: 0 auto;
        }

        .form-signin .checkbox {
            margin-bottom: 10px;
        }

        .form-signin .checkbox {
            font-weight: normal;
        }

        .form-signin .form-control {
            position: relative;
            font-size: 16px;
            height: auto;
            padding: 10px;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }

        .form-signin .form-control:focus {
            z-index: 2;
        }

        .form-signin input[type="text"] {
            margin-bottom: 14px;
            border-radius: 0;
            background: url(/static_pc/admin/login_user.png) 0 0 #bdbdbd no-repeat;
            padding-left: 60px;
            color: #FFFFFF;
        }

        .form-signin input[type="password"] {
            margin-bottom: 10px;
            border-radius: 0;
            background: url(/static_pc/admin/login_pas.png) 0 0 #bdbdbd no-repeat;
            padding-left: 60px;
            color: #FFFFFF;
        }

        .form-signin input[type="number"] {
            margin-bottom: 10px;
            border-radius: 0;
            background: url(/static_pc/admin/login_google.png) 0 0 #bdbdbd no-repeat;
            padding-left: 60px;
            color: #FFFFFF;
        }

        .form-signin button {
            border-radius: 0;
        }

        .footer {
            font-family: Microsoft Yahei;
            font-weight: 400;
            color: #fff;
            font-size: 13px;
            text-align: center
        }
        .footer .copyright_link{
            color: #fff;
        }
        </style>
    </head>

    <body>
        <div class="signin">
            <div class="signin-head">
                <img src="/static_pc/admin/author.jpg" alt="头像" width="120px" height="120px" id="now_staff_pic" class="img-circle">
            </div>
            <form class="form-signin" id="form_check" role="form">
                <input type="text" class="form-control" name='account' placeholder="用户名" />
                <input type="password" class="form-control" name='password' placeholder="密码" /> @yield('content')
            </form>
            <div class="footer">
                @include('admin.public.copyright')
            </div>
        </div>
        <!-- Sentry -->
        <script src="{{ config('static_source_cdn.sentry') }}" crossorigin="anonymous"></script>
        <!-- JS -->
        <script type="text/javascript" src="{{ config('static_source_cdn.jquery') }}"></script>
        <script type="text/javascript" src="{{ config('static_source_cdn.layer') }}"></script>
        <script type="text/javascript" src="{{ config('static_source_cdn.load_js') }}"></script>
        <script type="text/javascript" src="/static_pc/js/global.js"></script>
        <script type="text/javascript" src="/static_pc/js/hlz_rsa.js"></script>
        @yield('js')
    </body>

</html>