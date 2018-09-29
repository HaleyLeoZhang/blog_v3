<!-- 登录方式：滑动验证码 -->
@extends('login.admin.layout') 


<!-- 表单部分--->
@section('content')
        <div id="yth_captchar"></div>
@endsection 


@section('js')
<!-- js 部分--->
    <script type="text/javascript">
    /**
     * 获取随机字符串
     * @return string
     */
    function mess() {
        var words = "zxcvbnmasdfghjklqwertyuiop1234567890";
        var _shuff = '';
        var arr = words.split('');
        var _floor = Math.floor,
            _random = Math.random,
            len = arr.length,
            i, j, arri,
            n = _floor(len / 2) + 1;
        while(n--) {
            i = _floor(_random() * len);
            j = _floor(_random() * len);
            if(i !== j) {
                arri = arr[i];
                arr[i] = arr[j];
                arr[j] = arri;
            }
        }
        _shuff = arr.join('');
        return _shuff;
    }
    // - 滑动唯一凭证
    if(!localStorage.yth_drag_passsport) {
        localStorage.setItem('yth_drag_passsport', mess() ); // 用户滑动验证码 唯一凭证
    }


    // 加载验证码
    loadjs(["{{ link_plugins('verify', 'yth_drag.js')}}"], {
        success: function() {
            $.ajax({
                "url": api("slide_verify", "init"), // 获取初始的验证码 `css + 验证码图片` 的地址
                "dataType": "html",
                "type": "get",
                "beforeSend": function (xhr) {
                    xhr.setRequestHeader("Passport", localStorage.yth_drag_passsport);
                },
                "success": function(html) {
                    $("#yth_captchar").html(html);
                    $(this).yth_drag({
                        "verify_url": api("slide_verify", "check"),
                        "source_url": api("slide_verify", "captchar"),
                        "auto_submit": true,
                        "submit_url": '/admin/login_slide_verify',
                        "form_id": "form_check",
                        "crypt_func": "rsa_encode",
                        "call_back":function(res, reload_verify_function){
                            if(200 == res.code){
                                location.href = '/admin/set_cookie?' + res.data.quert_string;
                            }else{
                                layer.msg(res.message);
                                reload_verify_function();
                            }
                        },
                    });
                },
            });
            // 适应当前样式
            $("#yth_captchar").css({
                "margin-left": "10px",
                "width": "280px",
                "margin-top": "20px"
            });
        }
    });
    // 是否以前登陆过
    if (window.localStorage) {
        var pic = localStorage.getItem("staff_pic");
        if (pic) {
            $("#now_staff_pic").attr({
                "src": pic
            });
        }
    }
    </script>
@endsection 