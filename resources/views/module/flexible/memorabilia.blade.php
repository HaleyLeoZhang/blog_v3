<!DOCTYPE >
<html>
	<head>
		<meta charset="utf-8">
		<meta name="author" content="'云天河Blog'官网 http://www.hlzblog.top/ 请尊重作者成果，请保留此项">
		<meta name="keywords" content="云天河,云天河作品,云天河大事记"/>
		<meta name="description" content="一路走来 云天河所做过的努力">
		<title>作品 | 云天河Blog</title>
		<link rel="shortcut icon" href="{{ static_host() }}/favicon.ico"  />
		<link rel="stylesheet" type="text/css" href="/Others/memorabilia/css/reset_y.css">
		<link rel="stylesheet" type="text/css" href="/Others/memorabilia/css/run.css">
	</head>
<body class="impress-not-supported">
	<!-- 背景图，初始化，夏天开始，因为2016夏天我开始有的第一个线上博客，为了减小单服务器压力，初始图为七牛的-->
	<div class="bg">
		<img src="http://img.cdn.hlzblog.top/17-6-2/56649681.jpg" width="100%" />
	</div>

	<header class="top" id="top">
		<h1>
			<a href="/">
				<img src="{{ static_host() }}/static_pc/img/default/logo_detail.png" class="animated bounceInLeft" width="160px" height="47px" alt="logo"/>
			</a>
			<em><!--这里是文字--></em>
			<img src="{{ static_host() }}/static_pc/img/default/slogans.png" class="animated fadeInDown" style="border-right:none" alt="">
		</h1>
		<div class="music" id="bgMusicSwitch" title="停止背景音乐">
			<div class="triangle"></div>
			<div class="pause pause1"></div>
			<div class="pause pause2"></div>
		</div>
	</header>

	<section id="timeline" class="timeline">
		<div id="line" class="line_white"></div>
		<div id="impress">
			<div id="timeList">
			<!-- 事件列表  -->
								<!-- data-x     新年分年份与前一个事件的该值设为一样的，但是后面一个事件 改值增加400  -->
								<!-- data-scale 过渡效果设为0.5  -->
								<!-- id 设为0表示调转到初始页面  -->
				<div class="step year" data-x="-600" data-y="0" data-scale ="0.5" id="0">
					<!-- 屏幕下方时间，年份  -->
					<div class="year_start">2016</div>
					<div class="list_show"><!-- 年份不给予文字叙述 --></div>
				</div>

				<!-- 单个内容 -->
						<!-- data-x 从.0 开始，每多一个事件，值增加200  -->
						<!-- id     从 1 开始，每多一个事件，值增加1，用于事件缓存    -->
				<div class="timeList_item step" data-x="0" data-y="0" id="1">
						<!-- int(2)/int(2) -->
					<div class="circle">05/01</div>
						<!-- h2 String -->
					<h2 class="timeList_item_title">站点第一次上线</h2>
					<div class="list_show show1" >
							<!-- src  String -->
						<img src="http://img.cdn.hlzblog.top/17-6-3/3123029.jpg" width="500">
							<!-- href String -->
							<!-- p    String -->
						<h2><a href="javascript:;">MVC原生博客上线</a></h2>
						<p>
							四月初购买域名<br>
							服务器选择的腾讯云<br>
							经过漫长的备案<br>
							域名终于能用了<br>
							在五一前一天晚上，完成了全部部署<br>
							刚好五一可以给自己放放假
						</p>
					</div>
				</div>

				<!-- 其他两种排版，展示的大图 分别在  左 与 右 -->

				<!-- 

				<div class="timeList_item step" data-x="200" data-y="0" >
					<div class="circle">08/12</div>
					<h2 class="timeList_item_title">style3</h2>
					<div class="list_show show3">
						<img src="这里是图片，图片在左侧【大图】" width="500">
						<h2><a href="#">style3's title</a></h2>
						<p><img src="这里是图片" /></p>
					</div>
				</div>

				<div class="timeList_item step"  data-x="400" data-y="0" >
					<div class="circle">08/30</div>
					<h2 class="timeList_item_title">style4</h2>
					<div class="list_show show4">
						<img src="这里是图片，图片在右侧【大图】" width="500">
						<h2><a href="#">style4's title</a></h2>
						<p><img src="这里是图片" /></p>
					</div>
				</div> 

				-->

				<!-- 事件结尾，模板 -->
				<!-- 

				<div class="timeList_item step refresh" data-x="1000" data-y="0" >
					<div class="list_show">
						<a href='javascript:replay();'><img src="/Others/memorabilia/img/refress.png"/></a>
						<p class="end">为了更好的明天，我们一起加油！</p>
					</div>
				</div>

				-->

				<div class="timeList_item step" data-x="200" data-y="0" >
					<div class="circle">07/15</div>
					<h2 class="timeList_item_title">在线商城 -v1.0</h2>
					<div class="list_show show2">
						<img src="http://img.cdn.hlzblog.top/17-6-3/19038600.jpg" width="500">
						<h2><a href="http://mall-bak.hlzblog.top/" target="_blank" rel="nofollow">Mall - v1.0</a></h2>
						<p>
							网站上线那几天就有个想法<br>
							自己再做一个电商平台吧<br>
							我喜欢说走就的旅行<br>
							于是整个六月<br>
							我一个人在创业孵化基地默默的写啊写<br>
							在六月底，算是完成了<br>
							很遗憾，我当时备份做得不好<br>
							目前只有一个当时做了一半时，备份下来的作品了
						</p>
					</div>
				</div>
				
				<div class="timeList_item step" data-x="400" data-y="0" >
					<div class="circle">09/03</div>
					<h2 class="timeList_item_title">Redis微博上线</h2>
					<div class="list_show show4">
						<img src="http://img.cdn.hlzblog.top/17-6-3/65544929.jpg" width="500">
						<h2><a href="javascript:;">Redis微博上线</a></h2>
						<p><img src="http://img.cdn.hlzblog.top/17-6-3/39890711.jpg" /></p>
					</div>
				</div>

				<div class="timeList_item step" data-x="600" data-y="0" >
					<div class="circle">09/30</div>
					<h2 class="timeList_item_title">博客移动端上线</h2>
					<div class="list_show show1">
						<img src="http://img.cdn.hlzblog.top/17-6-3/82124843.jpg" width="500">
						<h2><a href="javascript:;">博客移动端上线</a></h2>
						<p>
							这次主要是为了实现响应式<br>
							让移动端界面更好看一点<br>
						</p>
					</div>
				</div>

				<div class="timeList_item step" data-x="800" data-y="0" >
					<div class="circle">10/28</div>
					<h2 class="timeList_item_title">第一笔私单</h2>
					<div class="list_show show1">
						<img src="http://img.cdn.hlzblog.top/17-6-3/17361783.jpg" width="500">
						<h2><a href="javascript:;">微信订阅号开发</a></h2>
						<p>
							全干(栈)工程师之第一次投入生产<br>
							仔细分析了她的客户的圈子与基本需求<br>
							我建议的她做成订阅号方便推广<br>
							整个开发周期交流沟通还算不错<br>
							毕竟聪明的我一开始就跟她说好<br>
							一旦定好需求，就不能再大改
						</p>
					</div>
				</div>

				<div class="step year" data-x="800" data-y="0" data-scale ="0.5" >
					<div class="year_start">2017</div>
					<div class="list_show"><!-- 年份不给予文字叙述 --></div>
				</div>

				<div class="timeList_item step" data-x="1200" data-y="0" >
					<div class="circle">05/20</div>
					<h2 class="timeList_item_title">在线商城 -v2.0</h2>
					<div class="list_show show1">
						<img src="http://img.cdn.hlzblog.top/17-6-3/78989901.jpg" width="500">
						<h2><a href="http://mall.hlzblog.top/" target="_blank" ><font color="#5fb878">Mall</font> <font color="#009688">~</font> <font color="#01aaed">Version</font> <font color="#ff572">2.0</font></a></h2>
						<p>
							简约大气设计<br>
							注重用户体验与安全<br>
							第一款Pjax应用
						</p>
					</div>
				</div>

				<div class="timeList_item step" data-x="1400" data-y="0" >
					<div class="circle">06/24</div>
					<h2 class="timeList_item_title">博客 v2.0</h2>
					<div class="list_show show1">
						<img src="http://img.cdn.hlzblog.top/17-6-3/66986340.jpg" width="500">
						<h2><a href="javascript:;" >新版博客</a></h2>
						<p>
							管理员后台全套API实现<br>
							注重用户体验与安全
						</p>
					</div>
				</div>


				<div class="timeList_item step" data-x="1600" data-y="0" >
					<div class="circle">07/29</div>
					<h2 class="timeList_item_title">品质生活-微信用户端</h2>
					<div class="list_show show1">
						<img src="http://img.cdn.hlzblog.top/17-7-29/47782114.jpg" width="500">
						<h2><a href="javascript:;">第一次产品公司工作</a></h2>
						<p>
							历时5个工作日开发<br>
							独立完成全站开发<br>
							因为是个刚成立的产品公司<br>
							急着要个第一版出去搞宣传<br>
							为了晚上不加班,我上班几乎不敢走神
						</p>
					</div>
				</div>


				<div class="step year" data-x="1600" data-y="0" data-scale ="0.5" >
					<div class="year_start">2018</div>
					<div class="list_show"><!-- 年份不给予文字叙述 --></div>
				</div>


				<div class="timeList_item step" data-x="2000" data-y="0" >
					<div class="circle">01/01</div>
					<h2 class="timeList_item_title">品质生活-用户端APP</h2>
					<div class="list_show show1">
						<img src="http://img.cdn.hlzblog.top/18-1-13/87487623.jpg" width="500">
						<h2><a href="javascript:void;">第一款上线APP</a></h2>
						<p>
							云天河负责了react-native的学习<br>
							对APP进行了两次架构<br>
							进行了部分微信前端页面的书写，如部分APP内webview页与部分微信页<br>
							实现了golang基于tcp与硬件完成对接、阿里物联网套件的应用、APP相关接口...<br>
							负责完成了，如，在线商城、活动页、物联控制等功能<br>
							IOS&Android应用v1.0.0正式上线
						</p>
					</div>
				</div>


				<div class="timeList_item step" data-x="2200" data-y="0" >
					<div class="circle">02/23</div>
					<h2 class="timeList_item_title">Vue全家桶上线</h2>
					<div class="list_show show1">
						<img src="http://img.cdn.hlzblog.top/18-5-19/94950714.jpg" width="500">
						<h2><a href="http://www.hlzblog.top/mobile/" target="_blank" >第一款SPA博客</a></h2>
						<p>
							云天河尝试将早前准备好的Vue零碎知识点<br>
							融合到v2版本的博客中去<br>
							只是为了让支持我博客的读者们能有更贴近APP的舒适体验
						</p>
					</div>
				</div>


				<div class="timeList_item step" data-x="2400" data-y="0" >
					<div class="circle">04/22</div>
					<h2 class="timeList_item_title">开源物联网之API</h2>
					<div class="list_show show1">
						<img src="http://img.cdn.hlzblog.top/18-5-19/74614871.jpg" width="500">
						<h2><a href="javascript:;">物联网API项目</a></h2>
						<p>
							这是打算送给我姐的新婚礼物<br>
							我打算在今年我姐结婚前，送他们一套物联网产品<br>
							如果最近半年没谈恋爱，应该不会水大家的<br>
							内容将包含 API、APP、H5 等，欢迎读者们持续关注<br>
						</p>
					</div>
				</div>

				<div class="timeList_item step" data-x="2600" data-y="0" >
					<div class="circle">09/29</div>
					<h2 class="timeList_item_title">博客 v3.0</h2>
					<div class="list_show show1">
						<img src="//img.cdn.hlzblog.top/blog/upload/img/2018_10_12_QQ9tRLXI.jpg" width="500">
						<h2><a href="https://github.com/HaleyLeoZhang/blog_v3" target="_blank" >博客 v3.0</a></h2>
						<p>
							基于第二版前端视图，后端重构<br>
							Laravel+Gulp+Vue<br>
							更多的设计模式<br>
							更优雅的代码<br>
						</p>
					</div>
				</div>

				<div class="step year" data-x="2600" data-y="0" data-scale ="0.5" >
					<div class="year_start">2019</div>
					<div class="list_show"><!-- 年份不给予文字叙述 --></div>
				</div>

				<div class="timeList_item step" data-x="3000" data-y="0" >
					<div class="circle">08/20</div>
					<h2 class="timeList_item_title">行为类爬虫框架</h2>
					<div class="list_show show1">
						<img src="//img.cdn.hlzblog.top/blog/upload/img/2019_09_22_xPzWod9Y.jpg" width="500">
						<h2><a href="https://github.com/HaleyLeoZhang/node_puppeteer_framework" target="_blank" >行为类爬虫框架</a></h2>
						<p>
							使用谷歌无头浏览器puppeteer<br>
							结合nodeJs+golang书写<br>
						</p>
					</div>
				</div>

                <div class="step year" data-x="3000" data-y="0" data-scale ="0.5" >
                    <div class="year_start">2020</div>
                    <div class="list_show"><!-- 年份不给予文字叙述 --></div>
                </div>

                <div class="timeList_item step" data-x="3400" data-y="0" >
                    <div class="circle">03/02</div>
                    <h2 class="timeList_item_title">邮件通知服务</h2>
                    <div class="list_show show1">
                        <img src="//img.cdn.hlzblog.top/blog/upload/img/2020_03_08_F3ttasb0.jpg" width="400">
                        <h2><a href="https://github.com/HaleyLeoZhang/email_server" target="_blank" >邮件通知服务</a></h2>
                        <p>
                            单独的邮件发送服务<br>
                            只因目前很多公司对此都是单机部署<br>
                            若带附件,目前只完成了单机实现方案<br>
                            RabbitMQ/Kafka 与 golang 实现<br>
                        </p>
                    </div>
                </div>

				<div class="timeList_item step refresh" data-x="3800" data-y="0"  yth-end_tag="true">
					<div class="list_show">
						<a href='javascript:replay();'><img src="/Others/memorabilia/img/refress.png"/></a>
						<p class="end">遇见更好的自己 ... </p>
					</div>
				</div>

			</div>
		</div>
	</section>
	<div class="gotop"> <a href="#top"><img src="/Others/memorabilia/img/top.png" title="回顶部"/></a></div>
	<!-- 当前环境 jQuery 1.8.3版本-->
	<!-- Sentry -->
	<script src="{{ config('static_source_cdn.sentry') }}" crossorigin="anonymous"></script>
{{--	<script src="//apps.bdimg.com/libs/jquery/1.8.3/jquery.min.js"></script>--}}
{{--	<script src="//apps.bdimg.com/libs/impress.js/0.5.3/impress.min.js"></script>--}}
	<script src="/Others/memorabilia/js/jquery1.8.3.js"></script>
	<script src="/Others/memorabilia/js/impress.min.js"></script>
	<script src="/Others/memorabilia/js/run.js"></script>
	<script src="{{ config('static_source_cdn.baidu_statistic') }}"></script>
	<script src="/static_pc/js/global.js"></script>
	<script>
	footmark();
	</script>
</body>
</html>