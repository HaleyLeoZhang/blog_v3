<!-- 登录方式：谷歌验证码 -->
@extends('login.admin.layout')
<!-- 表单部分--->
@section('content')
<!-- 登录类型谷歌验证码，初始化时，不为空即可 -->
<input type="number" class="form-control" name='google_captchar' placeholder="谷歌验证码" />
<button class="btn btn-lg btn-warning btn-block" type="button" id="get_checkcode">登录</button>
@endsection
<!-- js 部分--->
@section('js')
<script>
// 本次的登录模块
var admin_login = (function ($) {
    var form_id = 'form_check';
    function _ini() {
        listen_submit();
    }
    // 验证数据
    function check_empty() {
        var _form = document.forms[form_id];
        if('' == _form.account.value) {
            layer.alert('请输入帐号');
            return false;
        }
        if('' == _form.password.value) {
            layer.alert('请输入密码');
            return false;
        }
        if('' == _form.google_captchar.value) {
            layer.alert('请输入谷歌验证码');
            return false;
        }
        return true;
    }
    // 加密数据
    function crypt_data(_data) {
        var temp = {};
        for(var i in _data) {
            temp[i] =
                encodeURIComponent(
                    rsa_encode(_data[i])
                );
        }
        return temp;
    }
    // 获取表单数据并加密
    function get_form_data() {
        var _form = document.forms[form_id];
        var _data = {
            'account': _form.account.value,
            'password': _form.password.value,
            'google_captchar': _form.google_captchar.value,
        };
        return crypt_data(_data);
    }
    // 监听登录按钮
    function listen_submit() {
        $("#get_checkcode").on("click", function (event) {
            if(!check_empty()) {
                return;
            }
            var layer_index = layer.load(0);
            var submit_data = get_form_data();
            $.ajax({
                'url': '/admin/login_google',
                'type': 'post',
                'dataType': 'json',
                'data': submit_data,
                'success': function (d) {
                    layer.close(layer_index);
                    console.log(d);
                    if(200 == d.code) {
                        var _data = d.data;
                        location.href = '/admin/set_cookie?' + _data.quert_string;
                    } else if(10006 == d.code) {
                        var form = document.forms[form_id];
                        var _email = encodeURIComponent(form.account.value);
                        location.href = '/admin/google_captchar?email=' + _email;
                    } else {
                        layer.alert(d.message);
                    }
                },
                'xhrFields': {
                    'withCredentials': true,
                },
                'errors': function () {
                    layer.alert('网络错误，请检查网络');
                    layer.close(layer_index);
                }
            });
        });
    }
    _ini();
    return {};
})(jQuery);
</script>
@endsection