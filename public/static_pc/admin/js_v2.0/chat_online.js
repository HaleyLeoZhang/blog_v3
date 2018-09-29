function chat_instance() {
    /* Initial your config */
    var websocket_server = "ws://123.206.211.133:9502",
        ws_obj = new WebSocket(websocket_server);
    /* Connect Succsess */
    ws_obj.onopen = function(event) {
        console.log("WebSocket: Connected");
    };
    /* Connect Failed */
    ws_obj.onerror = function(event, e) {
        console.log("WebSocket: Failed");
    };
    /* Disconnection */
    ws_obj.onclose = function(event) {
        layer.alert("您已与服务器断开连接",
            function() {
                window.location.reload();
            });
    };
    /* Receive Data From Server */
    ws_obj.onmessage = function(event) {
        var d = JSON.parse(event.data); /* Decode josn data */
        // Callback ...
        switch (d.event) {
            case "init":
                $("#fd").val(d.fd);
                chat_initial(); // Event handler 
                break;
            case "receive":
                chat_receive_data(d); // Event handler
                // Save Data 
                chat_save_data(d);
                break;
            case "error":
                $("#yth_chat_container > .box > .container > ul").append('<li class="error">对方已离线，当前未接收到您的消息，请稍候重试</li>');
                $("#yth_chat_container > .box > .container").animate({"scrollTop":"9999"},0);
                break;
            default:
                break;
        }
    };

    /* Send Data */
    $("#hlz_chat_send").on("click", function() {
        var send_data = chat_send_data();
        ws_obj.send(send_data);
    });
    $("#yth_editor").on("keydown", function(event) {
        if (event.ctrlKey && event.keyCode == 13) {
            $("#hlz_chat_send").click();
        }
    });
    /* Save Draft */
    $("#yth_editor").on("keyup",function(){
        localStorage.setItem("chat_draft", $("#yth_editor").html() );
    });

    /* Reload to make sure you are online */
    setTimeout(function(){
        window.location.reload();
    },1300*1000);
}
 

//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// Role: Staff
// Following functions are using in the function which nameed "chat_instance"

// Event: Init 
function chat_initial(){
	var page_load_index = layer.load(0, {shade: false}); // Loading layer open
	$.ajax({
		"url":api("Chat","init_staff"),
		"type":"post",
		"data":$("#form_1").serialize(),
		"success":function(){
			layer.close(page_load_index); // Loading layer close
            run_editor();
            // If there is any draft
            if(  localStorage.getItem("chat_draft")  ){
                $("#yth_editor").html(  localStorage.getItem("chat_draft")  );
            }
            $("#yth_chat_container").fadeIn();
		}
	});
    if( sessionStorage.getItem("chat_session_people_list") ){
        var html = decodeURIComponent(  sessionStorage.getItem("chat_session_people_list")  ) ;
        // Get Chat List
        $("#chat_session_people_list").html( html );
        chat_with_whom_button();
    }
}

// Click On One's Dialog Button
function chat_with_whom_button(){
    $(".chat_with_whom_button").unbind("click");
    $(".chat_with_whom_button").on("click",function(){
        var page_load_index = layer.load(0, {shade: false}); // Loading layer open
        // Get info about whom  he is takling with
        var it   = $(this),
            c_id = it.html(),
            item_name = 'chat_with_' + c_id;
        // Reset Config 
        $("#yth_chat_container > .box > .container > ul").html('');
        $("#dialog_with_whose_name").html( c_id );
        $("#dialog_with_whose_descript").html( '我是一个游客...' );
        it.removeClass("layui-btn-warm");
        $("#yth_chat_container > .box > .header >  .top_right > .name .icon").remove();
        var new_icon = '<span class="icon icon_gendar_gentleman"></span>';
        $("#yth_chat_container > .box > .header >  .top_right > .name ").append(new_icon);
        // Set chat_id
        $("#chating-c_id").val( it.html() );
        // Data exists?
        if( sessionStorage.getItem(item_name) ){
            var data = JSON.parse( sessionStorage.getItem(item_name) ),
                arr = data.info;
                for(var i=0; i< arr.length ;i++){
                    // Render Data and append it at end of the chat container
                    chat_append_data( JSON.parse( arr[i] ) );

                }
        }
        // Save Chat List
        var html = $("#chat_session_people_list").html();
        sessionStorage.setItem( "chat_session_people_list", encodeURIComponent(html) );
        layer.close(page_load_index); // Loading layer close
    });   
}

// You can save history data  by sessionStorage 
	// like, {$cookie_id}_{$s_id} = '[{"time":{$time},{"content",{$content} } },...]'

// Event: Send 
function chat_send_data(){
    // event, role, c_id, s_id, text, token
    var text = $("#yth_editor").html(),
        data = {};
        data.event = 'send';
        data.role  = 'staff';
        data.c_id  = $("#chating-c_id").val();
        data.s_id  = $("#s_id").val();
        data.text  = encodeURIComponent( text );
        data.token = $("#token").val(),
        send_data  = JSON.stringify(data);
        // Save Data
        chat_save_data( data );
        // Add own message to the tab
        chat_append_data(data);
        localStorage.setItem("chat_draft", '<p><br></p>');
        $("#yth_editor").html('<p><br></p>');
    return send_data;
}

// Event: Receive
function chat_receive_data(d) {
    var item_c_id = "c_id_" + d.c_id;
    // Exists this id ?
    if ( document.getElementById(item_c_id) ) {
        // If he is the one whom the staff is chating with?
        if( d.c_id == $("#chating-c_id").val() ){
            chat_append_data(d);
        }else{
            $("#"+item_c_id).addClass("layui-btn-warm");
            // Add msg ring
            var ring = $("#yth_bg_music")[0];
            ring.pause();
            ring.play();
            chat_with_whom_button();
        }
    } else {
        $("#chat_session_people_list").prepend('<button class="layui-btn chat_with_whom_button" id="' +item_c_id+ '">' + d.c_id + '</button>');
        $("#"+item_c_id).addClass("layui-btn-warm");
        chat_with_whom_button();
    }
}

// Action : append data
function chat_append_data(d){
    // Float right while this object has property named 'role'
    if( !d.time  ){
        d.time = format_time("Y-m-d h:i:s");
    }
    d.text = decodeURIComponent(d.text);
    // Filter of XSS
    d.text = filterXSS(d.text );
    // Write Data
    if(d.role){
        d.name  = '我：';
        d.actor = 'send';
        d.float = 'right';
    }else{
        d.name  = '游客：';
        d.actor = 'receiver';
        d.float = 'left';
    }
    // Render
    var tpl = $("#yth_chat_tpl").html(),
        result = laytpl( tpl ).render(d);
    $("#yth_chat_container > .box > .container > ul").append( result );
    $("#yth_chat_container > .box > .container").animate({"scrollTop":"9999"},0);
}


// Save Data 
    // Require: `d.c_id`  And `data.text` should be encodeURIComponent()
function chat_save_data(d){
    d.time = format_time("Y-m-d h:i:s");
    var item_name = 'chat_with_' + d.c_id;
    // Decode String to Json
    if( sessionStorage.getItem( item_name ) ){
        var arr_obj = sessionStorage.getItem( item_name),
            obj = JSON.parse(arr_obj); 
        obj.info.push( JSON.stringify(d) );
    }else{
        var obj = {"info":[]};
            obj.info.push( JSON.stringify(d) );
    }
    // Save Data   &&  Encode Json to String
    sessionStorage.setItem( item_name, JSON.stringify(obj) );
    // Save Chat List
    var html = $("#chat_session_people_list").html();
    sessionStorage.setItem( "chat_session_people_list", encodeURIComponent(html) );
}


// Editor Tool's option
function run_editor() {
    var set_menu = [
        'bold',
        'underline',
        'italic',
        'emotion',
        'fontsize',
        'forecolor',
        'quote',
        'link',
        'img',
        'location'
    ];
    editor(false, false, set_menu);
}