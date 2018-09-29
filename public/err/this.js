var Timer = 0;
function dom_id(get_id){
    return document.getElementById( get_id );
}
/**
* Ajax instance is in the following:
*/
function out_info( url, err_code ) {
    var xhr = new XMLHttpRequest(),
        cache_time = 60 * 60,
        cache_flag = false,
        data;
    var p = new Promise(function (resolve, reject) {
        xhr.open("GET", url, true);
        xhr.onload = function () {
            if (this.status === 200) {
                data = JSON.parse(this.responseText);
                var code_name= data.Prefix + err_code;
                eval( "var err_msg = data.Err." + code_name );
                resolve( err_msg );
            }
        };
        xhr.onerror = function (e) {
            reject( e );
        };
        if( false == cache_flag ){
            xhr.setRequestHeader( "Cache-Control", "private,max-age=" + cache_time );
            cache_flag = true ;
        }
        xhr.send( null );
    });
    return p;
}
function detail( data ){
    var now = new Date().getTime() - Timer;
    dom_id("msg").innerText  = data || "---" ;
    dom_id("time").innerText = now +" msec";
}

// API test
function yth_console(){
    var con = dom_id("con").value,
        act = dom_id("act").value,
        param = dom_id("param").value;
    var url = api( con, act ),
        xhr = new XMLHttpRequest(),
        data;
        // Reveal the debuging website!
        dom_id("now_url").innerText = url;
        dom_id("now_url").href = url;
    var p = new Promise(function (resolve, reject) {
        xhr.open("post", url, true);
        xhr.onload = function () {
            if (this.status === 200) {
                data = this.responseText;
                var out_data = JSON.parse(data);
                out( out_data );
                resolve( data );
            }
        };
        xhr.onerror = function (e) {
            reject( e );
        };
        xhr.setRequestHeader("Cache-Control", "no-cache");
        xhr.setRequestHeader("Content-type" ,"application/x-www-form-urlencoded");
        xhr.send( param );
    });
    return p;
}
function back_handle( data ){
    var dom = dom_id("back_data");
    dom.setAttribute("class","");
    dom.innerHTML = data;
    var sc=document.createElement("script");
    sc.src="/err/hlz_markdown.js";
    document.head.appendChild(sc);
    // Timer result
    var use_time = new Date().getTime() - Timer;
    dom_id("use_time").innerHTML =  use_time +" msec";
}

// Click Event
dom_id("bt_1").addEventListener("click",function(){
    click_button();
});
dom_id("bt_2").addEventListener("click",function(){
    api_click_button();
});
dom_id("get_code").addEventListener("keyup",function(){
    click_button();
});
dom_id("get_code").addEventListener("focus",function(){
    dom_id("msg").innerHTML  = "Welcome to use yth_console";
    dom_id("time").innerHTML = "Timer is ready...";
});
 
function click_button(){
    var url = "/err/error.json",
        code= dom_id("get_code").value;
    Timer = new Date().getTime();
    out_info( url, code ).then( detail, detail );
}

function api_click_button(){
    // Timer commence
    dom_id("use_time").innerHTML = "Counting time...";
    Timer = new Date().getTime();
    // Handle process
    yth_console().then( back_handle );
}