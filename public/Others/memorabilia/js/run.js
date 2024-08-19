//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//++  "云天河Blog"官网 http://www.hlzblog.top/ 请尊重作者成果，请保留此项
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
/**
* 云天河大事记，初始配置如下
* 请注意：考虑浏览器下载的多线程特性，请不要让第一个事件的背景图片的与其他事件的资源来自同一域名
*/
var yth_memorabilia_init = {
	// 背景音乐配置，云天河采集自酷狗音乐接口
	"bg_music_url" : "/api/general/memorabilia_bg",
	// 默认初始季节编号 [冬 春  夏  秋]  分别对应 0 ~ 3
	"season_now_code": 2,
	// 季节相关配置
	"season_init":[
		/**
		* bg 			背景图片
		* header_bg 	logo所在横栏背景色
		* title_color 	标题颜色 
		* content_color 文字颜色
		*/
		{
			// [冬] 源：http://img.cdn.hlzblog.top/17-6-2/4658560.jpg
			"bg": "http://img.cdn.hlzblog.top/17-6-2/4658560.jpg",
			"header_bg":"rgba(255,255,255,0.2)",
			"title_color":"#0D0D0D",
			"content_color":"#213e44"
		},
		{
			// [春] 源：http://img.cdn.hlzblog.top/17-6-2/69738894.jpg
			"bg":"http://img.cdn.hlzblog.top/17-6-2/69738894.jpg",
			"header_bg":"rgba(255,106,106, 0.2)",
			"title_color":"#CAC7C7",
			"content_color":"#fff"
		},
		{
			// [夏] 源：  https://i.loli.net/2018/09/28/5bad085aa74a5.jpg
			"bg": "https://i.loli.net/2018/09/28/5bad085aa74a5.jpg",
			"header_bg":"rgba(17,178,255,0.2)",
			"title_color":"#11b2e2",
			"content_color":""
		},
		{
			// [秋] 源：http://img.cdn.hlzblog.top/17-6-2/31164195.jpg
			"bg": "http://img.cdn.hlzblog.top/17-6-2/31164195.jpg",
			"header_bg":"rgba(239, 104, 104, 0.2)",
			"title_color":"#efd264",
			"content_color":""
		},
	],
	// 每个大事记的停留时间
	"durative_time": 4000
};
/**
* 全局变量设置
* Array   event_cache 	事件缓存
* Boolean loop 			对大事记循环的控制
* Int 	  timer_index  		循环用的定时器的索引号
* Obecjt  impress 		特效引用，非IE环境下
*/
var event_cache = null,
	loop = true,
	timer_index = null,
	impress = $.browser.msie ? undefined : impress();
;(function() {
	if (!
		/*@cc_on!@*/
		0) return;
	var e = "abbr, article, aside, audio, canvas, datalist, details, dialog, eventsource, figure, footer, header, hgroup, mark, menu, meter, nav, output, progress, section, time, video".split(', ');
	var i = e.length;
	while (i--) {
		document.createElement(e[i])
	}
})()

var replay = function() {
	if (impress) {
		impress.goto($("#0")[0]);
	} else {
		location.reload();
	}
};

$(function() {
	$(window).bind('scroll resize', function() {
		if ($(window).scrollTop() >= 1)
			$('.gotop').css('display', 'block');
		else
			$('.gotop').css('display', 'none');
	});

	var cache_event_top = function() {
		if (event_cache != null)
			return;
		event_cache = new Array(24);
		var i = 0;
		var length = event_cache.length;
		for (; i < length; i++) {
			var id = i + 1;
			event_cache[i] = $("#" + id).position().top;
		}
	}

	var resize = function() {
		var width = $(window).width();
		var height = $(window).height();
		$(".bg img").css("width", width);
		$(".bg img").css("height", height);

	};

	var cur_month = 2;

	var getMonthByTop = function(top) {
		for (var i = 0, event = event_cache[i]; i < event_cache.length; i++) {
			if (i == event_cache.length - 1 && top >= event || top >= event && top < event_cache[i + 1]) {
				var date = $("#" + (i + 1)).find(".circle").html();
				if (date) {
					var month = +date.split("/")[0];
					return month;
				}
			}
		}
		return cur_month;
	};

	var scroll = function() {
		if ($.browser.msie) {
			cache_event_top();
			var st = $(window).scrollTop();
			var month = getMonthByTop(st);
			if (month != cur_month) {
				changeBackground(month);
				cur_month = month;
			}
		}
	};

	resize();

	$(window).resize(function() {
		resize();
	});

	$(window).scroll(function() {
		scroll();
	});

	// 某个选项 或者 点击图片  就停下来

	$(".circle").click(function() {
		loop = false;
		if (timer_index)
			clearInterval(timer_index);
	});
	$(".refresh img").click(function() {
		loop = true;
		$(".refresh img").addClass("rotate45");
		setTimeout(function() {
			$(".refresh img").removeClass("rotate45");
		}, 2000);
	});
	if (!$.browser.msie) {
		// 配置背景音乐
		$.ajax({
			"url": yth_memorabilia_init.bg_music_url,
			"dataType":"json",
			"success":function(d){
				bgMusic = new Audio(d.data.url);
				console.log(d.data.url)
				bgMusic.loop = true;
				bgMusic.volume = 0.7;
				$('#bgMusicSwitch').click(function() {
					if (bgMusic.paused) {
						bgMusic.play();
						$(".triangle").css("display", "none");
						$(".pause").css("display", "block");
						$("#bgMusicSwitch").attr("title", "暂停背景音乐");
					} else {
						bgMusic.pause();
						$(".pause").css("display", "none");
						$(".triangle").css("display", "block");
						$("#bgMusicSwitch").attr("title", "播放背景音乐");
					}
				});
				let hasUserInteract = false // 是否用户有动
				// 1. 等待用户交互：才有权限播放
				document.addEventListener('mouseover mousein touchstart', function() {
					if (!hasUserInteract){
						$('#bgMusicSwitch').click()
						hasUserInteract = true
					}
				});
			}
		});
		
	} else {
		$(".music").hide();
	}
});


// 预加载背景
var preload_bg = function (){
	$(".bg img").eq(0).ready(function() {
		var img_obj ;
		for (var i=0; i < 4;i++) {
			img_obj = new Image();
			img_obj.src = yth_memorabilia_init.season_init[i%4].bg;
		}
	});
}
preload_bg();
// 切换背景
var changeBackground = function(month) {
	var now_season ;	// 当前所处季节
	if (month == 12 || month == 1 || month == 2) {
		now_season = 4;
	} else if (month >= 3 && month <= 5) {
		now_season = 1;
	} else if (month >= 6 && month <= 8) {
		now_season = 2;
	} else {
		now_season = 3;
	}
	// 重新设定主题？
	if(  yth_memorabilia_init.season_now_code != now_season  ){
		var d =  yth_memorabilia_init.season_init[now_season % 4] ; // 该季节的数据
		$(".list_show h2").attr("style", "color:"+d.title_color);
		$(".list_show p").css("style", "color:"+d.content_color);
		$(".bg img").attr("src", d.bg);
		$("header").css("background-color", d.header_bg);
	}else{
		return;
	}
};

// 确认非IE环境
if (!$.browser.msie) {
	// 初始化 特效
	if (impress) impress.init();
	// 监听事件
	document.addEventListener('impress:stepenter', function(e) {
		var cur = arguments[0].target;
		var date = $(cur).find(".circle").html();
		if (date) {
			var month = +date.split("/")[0];
			changeBackground(month);
		}
		if (!loop)
			return;
		if (typeof timer_index !== 'undefined') clearInterval(timer_index);
		// 循环效果
		timer_index = setInterval(function() {
			var dom = impress.next();
			$(dom).attr("yth-end_tag");
			if ( $(dom).attr("yth-end_tag") == "true") {
				clearInterval(timer_index);
				loop = false;
			}
		}, yth_memorabilia_init.durative_time);
	});
}