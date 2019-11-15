<style>
    .input_text{
        outline-style: none ;
        border: 1px solid #ccc; 
        border-radius: 3px;
        padding: 14px 14px;
        font-size: 14px;
        font-family: "Microsoft soft";
    }
    .input_button {
        background-color: #8a95ce;
        border: none;
        color: white;
        padding: 10px 21px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 12px;
    }
    .selector{
        padding: 9px 5px;
        padding-right: 50px;
        font-size: 12px;
        background: #353132;
        color: #ccb8bd;
    }
</style>
<form>
    <h3 class="title_header">请输入你要变短的网址</h3>
    <br>
    <input class="input_text" type="text" id="long_url" placeholder="长地址" size='80'>
    <br>
    <br>
    <select class="selector" name="channel" id="channel"></select>
    <input class="input_button" type="button" id="btn" value='生成短链接'>
    <br>
</form>
<h5>生成的短地址，如下</h5>
<input class="input_text" type="text" id="short_url" placeholder="生成后的短地址" size='80'>
<script src="{{ config('static_source_cdn.jquery') }}"></script>
<script src="{{ config('static_source_cdn.layer') }}"></script>
<script>
(function ($, window, undefined) {
    'use strict';

    var SWITCH_OFF = false;
    var SWITCH_ON = true;

    function ShortUrl() {
        this.long_url = ''; // 用户输入的长地址
        this.channel = ''; // 用户选择的渠道
        this.result_container_id = '#short_url';
        this.channel_list = [
            {
                "value": "sina",
                "content": "新浪 t.cn"
            },
            {
                "value": "bitly",
                "content": "国外 j.mp"
            },
            {
                "value": "tencent",
                "content": "腾讯 url.cn"
            },
        ];
    }
    // 获取短地址
    ShortUrl.prototype.request_api = function () {
        var _this = this;

        _this.loading(SWITCH_ON)
        $.ajax({
            "url": "/api/general/short_url",
            "type": "post",
            "data": {
                "long_url": _this.long_url,
                "channel": _this.channel,
            },
            "dataType": "json",
            "success": function (d) {
                _this.loading(SWITCH_OFF);
                if(d.code != 200) {
                    layer.alert(d.message);
                } else {
                    $(_this.result_container_id).val(d.data.short_url);
                    layer.msg('短地址已生成');
                }
            },
            "error": function () {
                _this.loading(SWITCH_OFF);
                layer.message('网络错误');
            }
        });
    };
    // 检测数据格式
    ShortUrl.prototype.check_input = function () {
        var _this = this;
        if(null === _this.long_url.match(/^http/)) {
            layer.alert("请输入以 http 开头的地址");
            return false;
        }
        return true;
    };

    ShortUrl.prototype.loading = function (_switch) {
        var _this = this;
        if(SWITCH_ON === _switch) {
            _this.loading_index = layer.load(0, { shade: [0.5, '#fff'] }); // 加载层 开启
        } else {
            layer.close(_this.loading_index)
        }
    };

    ShortUrl.prototype.render_channel_list = function () {
        var str = '';
        for(var i = 0, len = this.channel_list.length; i < len; i++) {
            var one = this.channel_list[i];
            str += '<option value="' + one.value + '">' + one.content + '</option>';
            console.log('one');
        }
        console.log(str);
        var dom = document.getElementById("channel")
        dom.innerHTML = str;
    };

    // 监听按钮
    ShortUrl.prototype.listener_btn = function () {
        var _this = this;
        $("#btn").on("click", function () {
            _this.long_url = $("#long_url").val();
            _this.channel = $("#channel").val();
            if(_this.check_input()) {
                _this.request_api();
            }
        });
    };
    ShortUrl.prototype.run = function () {
        var _this = this;
        _this.render_channel_list();
        _this.listener_btn();
    };

    var short_url = new ShortUrl();
    short_url.run();

})(jQuery, window);
</script>