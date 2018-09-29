<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>
    <script>
        var redirect;
        if( localStorage.oauth_redirect ){
            redirect = encodeURIComponent( localStorage.oauth_redirect ); // 客户端存储：登录前的地址
        }else{
            redirect = '/';
        }
        location.href = '/oauth2/set_cookie?{!! $token_info !!}&redirect=' + redirect;
    </script>
</body>
