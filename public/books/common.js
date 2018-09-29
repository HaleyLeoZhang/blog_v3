/**
* Commin JS for pictures  Link: http://www.hlzblog.top/
*/

// 初始页面
$("body").html('  <h5 id="just_look"></h5>  <div id="skip">    <input type="text" placeholder="请输入页码" id="get_page">    <input type="button" id="show" value="跳转">  </div>  <div id="container"></div>    <button class="next">下一页</button>  <span id="top">    顶部  </span>');
// $("body").html(`
//   <h5 id="just_look"></h5>
//   <div id="skip">
//     <input type="text" placeholder="请输入页码" id="get_page">
//     <input type="button" id="show" value="跳转">
//   </div>
//   <div id="container"></div>  
//   <button class="next">下一页</button>
//   <span id="top">
//     顶部
//   </span>
// `);



var page = localStorage.getItem(title_en_us) || $("#get_page").val(),
    page_not_preload = 5, // 前多少张，不需要等待，直接加载 
    pictures_fetch_counter = 0 , // 图片抓取失败数量，注：懒加载模式无效
    page_count = 50; // 默认，图片的最大尝试呈现数量;





//++++++++++++++++++++++++++++++++++++++
//     公共函数  - 监听
//++++++++++++++++++++++++++++++++++++++

$(document).ready(function(){

    // 显示图片
    $("#show").on("click", function() {
      page = parseInt($("#get_page").val());
      to_page();
    });

    // 下一页
    $(".next").on("click", function() {
      document.getElementById("top").click();
      page = parseInt($("#get_page").val()) + 1;
      to_page();
    });

    // 返回顶部
    $("#top").on("click", function() {
      $("body,html").animate({
        "scrollTop": "0px"
      });
    });

    // 初始拉取数据
    to_page(); 


});

//++++++++++++++++++++++++++++++++++++++
//     公共函数  - 工具
//++++++++++++++++++++++++++++++++++++++

// 分页 - 公共功能
function page_common(pic_src_prefix, pic_src_suffix){
    // 配置项
    var pic_href,
        pic_div;
    // 输出图片
    $("#container").html(''); // 加载前，初始化

    // // 前5张，直接加载资源
    // for (var i = 1; i < page_not_preload; i++) {
    //     pic_href = pic_src_prefix + i + pic_src_suffix;
    //     pic_div = '<img class="lazy"  src="' + pic_href + '" />';
    //     $("#container").append(pic_div);
    // }
    // // 后面的需要等待加载
    // for (var i = page_not_preload; i < page_count + 1; i++) {
    //     pic_href = pic_src_prefix + i + pic_src_suffix;
    //     pic_div = '<img class="lazy"  originalSrc="' + pic_href + '" />';
    //     $("#container").append(pic_div);
    // }

    // 最多连续加载五张
    for (var i = 1; i < page_count + 1; i++) {
        pic_href = pic_src_prefix + i + pic_src_suffix;
        pic_div = '<img class="lazy"  src="' + pic_href + '" />';
        $("#container").append(pic_div);
    }

  // 依据配置 运行
  document.title = title_zh_cn +"/第" + page + "话";
  pic_status_handle();
  footer_log();
  // 如果可以本地存储
  $("#get_page").val(page);
}


// 页码判断
function set_page_num(){
  page = parseInt( page );
  if( isNaN(page) ){
    page = 1;
  }
  else if (page == 0){
    page = 1;
  }

} 


// 记录用户上次访看过的页面
function footer_log() {
  if (window.localStorage) {
    if (localStorage.getItem(title_en_us)) {
      $("#just_look").html('你上次看到第' + localStorage.getItem(title_en_us) + '话');
    }
    localStorage.setItem(title_en_us, page);
  }
}



// 判断图片资源相关
function pic_status_handle() {

    //　延迟渲染，不能监听资源是否加载成功，而且目前图片资源来源于同一站，应该不会让浏览器并发下载
    
    // // 延迟渲染图片
    // $("img.lazy").lazyload({
    //     effect: "fadeIn",
    //     threshold: 500,
    //     failurelimit: page_not_preload,
    //     // placeholder: "../common_loading.gif",
    //     placeholder: "https://i.loli.net/2017/10/29/59f5ec6c5e015.gif", // 暂用 cdn
    // });
    // console.log(  $(".lazy") );
    // $("img.lazy").on('error',function(e){
    //   console.log('错了');
    // });
    // 重置计数器
    pictures_fetch_counter = 0;

    // 不存在就移除DOM
    $(".lazy").on("error", function() {
        $(this).remove();
        pictures_fetch_counter++;
        // 如果一张都没拉取成功
        if( pictures_fetch_counter == page_count ){
          $('#container').html('<h5 class="no_pic">页面解析失败!</h5>');
        }
    });

}
// 小于10自动补零
function give_zero(now_page){
  if( now_page<10 ) {
    return "0"+now_page +"";
  }
  return now_page;
}








