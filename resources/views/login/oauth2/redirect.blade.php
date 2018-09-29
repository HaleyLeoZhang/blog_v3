<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>
    <script>
        localStorage.oauth_redirect = '{!! $redirect_after_login !!}'; // 客户端存储登录成功前的地址，同时也为移动端使用SPA类框架考虑
        location.href = '{!! $redirect !!}';
    </script>
</body>
