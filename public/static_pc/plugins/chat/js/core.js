(function ($, window, undefined) {
    var lib = new Lib();
    // 配置信息
    function Config() {
        this.protocol = 'ws';
        this.domain = document.domain;
        this.port = 9502;
    }
    var config = new Config();
    var ws_server = config.protocol + '://' + config.domain + ':' + config.port;
    //　- Websocket
    function Chat() {
        this.ws = new WebSocket(ws_server);
        this.user_list = [];
    }
    var chat = new Chat();
    // --- 连接开始
    chat.ws.onopen = function (event) {
        console.log('WebSocket: 连接成功');
    };
    // --- 连接失败
    chat.ws.onerror = function (event, e) {
        console.log('WebSocket: 连接失败');
    };
    // --- 连接关闭
    chat.ws.onclose = function (event) {
        console.log('WebSocket: 断开连接');
        hlz_alert.open('WebSocket: 断开连接');
    };
    // --- 服务器端传过来的数据
    chat.ws.onmessage = function (event) {
        var ws_data = JSON.parse(event.data);
        var message = new Message();
        message.dispatch(ws_data);
    };
    // 分发数据
    function Message() {}
    Message.prototype.dispatch = function (_data) {
        console.log('时间：' + lib.format_time("Y-m-d h:i:s"));

        var handle = new Handle();
        switch(_data.event) {
        case 'init': // 客户端，获取在线用户列表
            console.log('客户端，获取在线用户列表');
            break;
        case 'private': // 私聊
            handle.event_private(_data.data);
            break;
        case 'public': // 群聊
            console.log('群聊');
            console.log(_data.data);
            break;
        case 'customer_service': // 客服
            console.log('客服');
            console.log(_data.data);
            break;
        case 'online': // 在线时，同步用户信息
            console.log('在线时，同步用户信息');
            console.log(_data.data);
            break;
        case 'offline': // 用户离线
            console.log('用户离线');
            console.log(_data.data);
            break;
        case 'news': // 图灵机器人，输出列表数据
            console.log('图灵机器人，输出列表数据');
            console.log(_data.data);
            break;
        case "error":
            console.log('error');
            console.log(_data.data);
            break;
        default:
            console.log('default');
            console.log(_data.data);
            break;
        }
    };
    // - 处理数据
    function Handle() {}
    Handle.prototype.event_private = function(_data){
        console.log('--私聊回复--');
        console.log(_data.content);
    };
    // - 工具类
    function Lib() {}
    // var lib = new Lib();
    // --- 两位数补零
    Lib.prototype.add_zero = function (number) {
        if(number < 9) {
            return "0" + number;
        } else {
            return "" + number + "";
        }
    };
    /**
     * 获取格式化后的时间
     * - 如： format_time("Y-m-d h:i:s") 输出 2018-08-08 20:08:08
     * @param string str 待格式化的时间
     * @param int timestamp 时间戳， 0为不处理
     * @return string 
     */
    Lib.prototype.format_time = function (str, timestamp) {
        if(undefined === timestamp) {
            timestamp = 0;
        } else {
            timestamp = parseInt(timestamp * 1000);
        }
        var date = timestamp === 0 ? 　new Date() : new Date(timestamp);
        var Y = date.getFullYear(),
            m = this.add_zero(date.getMonth() + 1),
            d = this.add_zero(date.getDate()),
            h = this.add_zero(date.getHours()),
            i = this.add_zero(date.getMinutes()),
            s = this.add_zero(date.getSeconds());
        str = str.replace("Y", Y);
        str = str.replace("m", m);
        str = str.replace("d", d);
        str = str.replace("h", h);
        str = str.replace("i", i);
        str = str.replace("s", s);
        return str;
    };

    // - 供测试时，全局使用
    window.websocket_send = function (content) {
        var _data = {
            "event": "private",
            "data": {
                "type": "text",
                "user_id": -1, // 改字段，目前 -1 为私人培养的机器人 -2 为图灵机器人
                "content": content,
            }
        };
        chat.ws.send(JSON.stringify(_data));
    };


})(jQuery, window);



// function chat_instance() {
//     /* Initial your config */
//     // var websocket_server = "ws://www.hlzblog.top:9502",
//     var domain = document.domain;
//     var port = 9502;
//     var websocket_server = "ws://" + domain + ":" + port,
//         ws_obj = new WebSocket(websocket_server);
//     /* Connect Succsess */
//     ws_obj.onopen = function(event) {
//         console.log("WebSocket: Connected");
//         // list info
//         get_staff_list();
//     };
//     /* Connect Failed */
//     ws_obj.onerror = function(event, e) {
//         console.log("WebSocket: Failed");
//     };
//     /* Disconnection */
//     ws_obj.onclose = function(event) {
//         hlz_alert.open("您已与服务器断开连接，请刷新页面");
//     };
//     /* Receive Data From Server */
//     ws_obj.onmessage = function(event) {
//         var d = JSON.parse(event.data); /* Decode josn data */
//         // Callback ...
//         switch (d.event) {
//             case "init":
//                 $("#fd").val(d.fd);
//                 chat_initial(); // Event handler 
//                 break;
//             case "receive":
//                 chat_receive_data(d); // Event handler
//                 // Save Data 
//                 chat_save_data(d);
//                 break;
//             case "error":
//                 $("#yth_chat_container > .box > .container > ul").append('<li class="error">对方已离线，当前未接收到您的消息，请稍候重试</li>');
//                 $("#yth_chat_container > .box > .container").animate({"scrollTop":"9999"},0);
//                 break;
//             default:
//                 break;
//         }
//     };

//     /* Send Data */
//     $("#hlz_chat_send").on("click", function() {
//         var send_data = chat_send_data();
//         // If it is a robot
//         if(  parseInt($("#chating-s_id").val()) < 0 ){
//             chat_robot( JSON.parse(send_data) );
//         }else{
//             ws_obj.send(send_data);
//         }

//     });
//     $("#yth_editor").on("keydown", function(event) {
//         if (event.ctrlKey && event.keyCode == 13) {
//             $("#hlz_chat_send").click();
//         }
//     });
//     /* Save Draft */
//     $("#yth_editor").on("keyup",function(){
//         localStorage.setItem("chat_draft", $("#yth_editor").html() );
//     });
// }


// +----------------------------------------------------------------------------
// |  Role: Customer
// |  Following functions are using in the function which named "chat_instance"
// +----------------------------------------------------------------------------

// +-----------------------------------------------------------------------
// |  Chat Dialog btn
// +-----------------------------------------------------------------------
// function chat_dialog_btn() {
//     // Btn: Dialog Close 
//     $("#yth_chat_container > .box > .header > .top_right > .name > .close").on("click", function () {
//         $("#chating-s_id").val('');
//         $("#yth_chat_box").hide();
//     });
//     // Btn: Dialog Show
//     dialog_show();
//     // Btn: Show SideBar
//     $("#yth_chat_sidebar .logo_btn").on("click", function () {
//         var it = $(this);
//         $(".bar").show();
//         it.hide();
//     });
//     // Btn: Hide SideBar
//     $("#yth_chat_sidebar .bar .ngv_top .name .back_button").on("click", function () {
//         $(".bar").hide();
//         $(".logo_btn").show();
//     });
//     // Btn: Select Function
//     $(".select").unbind("click");
//     $(".select").on("click", function () {
//         var it = $(this),
//             selected = it.attr("yth-data");
//         $(".selected").removeClass("selected");
//         it.addClass("selected");
//         $(".list").hide();
//         $(".list").eq(selected).show();
//     });
// }

// function dialog_show() {
//     $("#yth_chat_sidebar .bar .list .warp .list_content").unbind("click");
//     $("#yth_chat_sidebar .bar .list .warp .list_content").on("click", function () {
//         var it = $(this);
//         pic = it.find(".pic img").attr("src"),
//             s_id = it.attr("yth-s_id");
//         name = it.find(".info .name").html().trim(),
//             icons = it.find(".icons").html(),
//             descript = it.find(".info .name").attr("yth-descript");
//         // Reset Config
//         $("#yth_chat_container > .box > .header > .top_left > img").attr({ "src": pic });
//         $("#chating-s_id").val(s_id);
//         $("#dialog_with_whose_name").html(name);
//         $("#yth_chat_container > .box > .header > .top_right > .name > .icon").remove();
//         $("#yth_chat_container > .box > .header > .top_right > .name").append(icons);
//         $("#yth_chat_container > .box > .container > ul").html('');
//         $("#dialog_with_whose_descript").html(descript);
//         $("#yth_chat_box").show();
//         // Get info about whom  he is takling with
//         var item_name = 'chat_with_' + s_id;
//         // Set chat_id
//         $("#chating-s_id").val(s_id);
//         // Data exists?
//         if(sessionStorage.getItem(item_name)) {
//             var data = JSON.parse(sessionStorage.getItem(item_name)),
//                 arr = data.info;
//             for(var i = 0; i < arr.length; i++) {
//                 // Render Data and append it at end of the chat container
//                 chat_append_data(JSON.parse(arr[i]));
//             }
//         }
//         it.attr({ "style": "" });
//         // Save Chat List
//         var html = $("#chat_logs_list").html();
//         sessionStorage.setItem("chat_logs_list", encodeURIComponent(html));
//     });
// }


// +-----------------------------------------------------------------------
// |  Chat Event
// +-----------------------------------------------------------------------

// // WebSocket Event: onopen()
// function get_staff_list() {
//     $.ajax({
//         "url": api("Chat", "get_chat_staff_list"),
//         "dataType": "json",
//         "success": function (msg) {
//             // Get Staff List
//             async_render("yth_chat_staff_list_tpl", "yth_chat_staff_list", msg.info, function () {
//                 chat_dialog_btn();
//             });
//         }
//     });
// }

// // Event: Init 
// function chat_initial() {
//     set_modal_align();
//     $.ajax({
//         "url": api("Chat", "init_customer"),
//         "type": "post",
//         "data": {
//             "c_id": get_ssid(),
//             "fd": $("#fd").val()
//         },
//         "success": function () {
//             run_editor();
//             // If there is any draft
//             if(localStorage.getItem("chat_draft")) {
//                 $("#yth_editor").html(localStorage.getItem("chat_draft"));
//             }
//             $("#yth_chat_container").show();
//         }
//     });
//     // Render Chat History
//     if(sessionStorage.getItem("chat_logs_list")) {
//         var html = decodeURIComponent(sessionStorage.getItem("chat_logs_list"));
//         // Get Chat List
//         $("#chat_logs_list").html(html);
//         dialog_show();
//     }
// }
// // You can save history data  by sessionStorage 
// // like, {$cookie_id}_{$s_id} = '[{"time":{$time},{"content",{$content} } },...]'

// // Event: Send 
// function chat_send_data() {
//     // event, role, c_id, s_id, text, token
//     var text = $("#yth_editor").html(),
//         data = {
//             event: 'send',
//             role: 'customer',
//             c_id: get_ssid(),
//             s_id: $("#chating-s_id").val(),
//             text: encodeURIComponent(text)
//         };
//     send_data = JSON.stringify(data);
//     // Save Data
//     chat_save_data(data);
//     // Add own message to the tab
//     chat_append_data(data);
//     localStorage.setItem("chat_draft", '<p><br></p>');
//     $("#yth_editor").html('<p><br></p>');
//     return send_data;
// }
// // Event: Receive
// function chat_receive_data(d) {
//     var item_s_id = "receive_s_id_" + d.s_id;
//     // Exists this id ?
//     if(document.getElementById(item_s_id)) {
//         // If he is the one whom the customer is chating with?
//         if(d.s_id == $("#chating-s_id").val()) {
//             chat_append_data(d);
//         } else {
//             $("#" + item_s_id).attr({ "style": "background:#FFE7BA;" });
//         }
//     } else {
//         // Get Data 
//         var info_id = "#yth-s_id_" + d.s_id,
//             tpl_data = {
//                 "s_id": d.s_id,
//                 "pic": $(info_id).find(".pic img").attr("src"),
//                 "name": $(info_id).find(".info .name").html(),
//                 "icons": $(info_id).find(".info .icons").html(),
//                 "descript": $(info_id).find(".info .name").attr("yth-descript")
//             };
//         // Render
//         var logs_id = '#chat_logs_list',
//             tpl = $("#yth_chat_logs_list_tpl").html(),
//             result = laytpl(tpl).render(tpl_data);
//         $(logs_id).prepend(result);
//         // Btn Event -> show dialog
//         $("#" + item_s_id).attr({ "style": "background:#FFE7BA;" });
//         $("#yth_chat_sidebar .bar .list .warp .list_content").unbind("click");
//         dialog_show();
//     }
//     var ring = document.getElementById("yth_bg_music");
//     ring.pause();
//     ring.play();
//     dialog_show();
// }
// // Action : append data
// function chat_append_data(d) {
//     // Float right while this object has property named 'role'
//     if(!d.time) {
//         d.time = new Date().Format("yyyy-MM-dd hh:mm:ss");
//     }
//     d.text = decodeURIComponent(d.text);
//     // Write Data
//     if(d.role) {
//         d.name = '我：';
//         d.actor = 'send';
//         d.float = 'right';
//     } else {
//         d.name = $("#dialog_with_whose_name").html() + '：';
//         d.actor = 'receiver';
//         d.float = 'left';
//     }
//     // Render
//     var tpl = $("#yth_chat_customer_text_tpl").html(),
//         result = laytpl(tpl).render(d);
//     $("#yth_chat_container > .box > .container > ul").append(result);
//     $("#yth_chat_container > .box > .container").animate({ "scrollTop": "9999" }, 0);
// }
// // Save Data 
// // Require: `d.s_id`  And `data.text` should be encodeURIComponent()
// function chat_save_data(d) {
//     d.time = new Date().Format("yyyy-MM-dd hh:mm:ss");
//     var item_name = 'chat_with_' + d.s_id;
//     // Decode String to Json
//     if(sessionStorage.getItem(item_name)) {
//         var arr_obj = sessionStorage.getItem(item_name),
//             obj = JSON.parse(arr_obj);
//         obj.info.push(JSON.stringify(d));
//     } else {
//         var obj = { "info": [] };
//         obj.info.push(JSON.stringify(d));
//     }
//     // Save Data   &&  Encode Json to String
//     sessionStorage.setItem(item_name, JSON.stringify(obj));
//     // Save Chat List
//     var html = $("#chat_logs_list").html();
//     sessionStorage.setItem("chat_logs_list", encodeURIComponent(html));
// }

// // +-----------------------------------------------------------------------
// // |  Robot Api
// // +-----------------------------------------------------------------------

// function chat_robot(d) {
//     var option;
//     switch(d.s_id) {
//     case "-1":
//         option = 0;
//         break;
//     case "-2":
//         option = 1;
//         break;
//     default:
//         hlz_alert.open("该机器人不存在");
//     }
//     $.ajax({
//         "url": api("Turning_robot", "index"),
//         "type": "post",
//         "data": {
//             "text": d.text, // This data has been treated  with function `encodeURIComponent`
//             "option": option
//         },
//         "dataType": "json",
//         "success": function (msg) {

//             var tpl_data = {
//                 "text": msg.info,
//                 "s_id": d.s_id,
//                 "event": 'receive'
//             };
//             chat_receive_data(tpl_data);
//             chat_save_data(tpl_data);
//         }
//     });
// }

// // +-----------------------------------------------------------------------
// // |  Library
// // +-----------------------------------------------------------------------

// // Editor Tool's option
// function run_editor() {
//     var set_menu = [
//         'bold',
//         'underline',
//         'emotion'
//     ];
//     editor(false, false, set_menu);
// }

// function editor(if_get_content = false, set_container_id = false, set_menu = false) {
//     var container_id = false == set_container_id ? 'yth_editor' : set_container_id;
//     if(false == if_get_content) {
//         var editor = new wangEditor(container_id);
//         // 阻止输出 log
//         wangEditor.config.printLog = false;
//         editor.config.emotions = {
//             'default': {
//                 title: '默认',
//                 data: '/static_pc/plugins/editor/emotions.data'
//             }
//         };
//         if(set_menu) {
//             editor.config.menus = set_menu;
//         }
//         editor.create();
//     } else {
//         return $('#' + container_id).html();
//     }
// }
// // GET SSID
// function get_ssid() {
//     var result = document.cookie.match(/PHPSESSID\=([^;]+)/);
//     return result[1];
// }
// // Positon - fixed align
// function set_modal_align() {
//     var a = document,
//         b = a.getElementById("yth_chat_box"),
//         its_h = 540,
//         client_h = parseInt(a.documentElement.clientHeight),
//         set_top = (client_h - its_h) / 2,
//         content = "top:" + set_top + "px";
//     b.setAttribute("style", content);
// }