    </div>
</div>
<div class="clr"></div>
<!--  友情链接 -->
<div id="friend_link_html"></div>
<div class="clr"></div>
<!-- 容器，结束 -->
<!-- Footer -->
<div class="Footer">
    <!-- 页脚 -->
    <div class="container">
        <p>
            <a href="/board" target="_blank">联系天河</a><span>|</span>
            <a href="/Info/law.html" target="_blank">法律声明</a><span>|</span>
            <a href="/sitemap.xml" target="_blank">网站地图</a>
        </p>
        <p>
            如有急事，请联系邮箱 hlzblog@vip.qq.com
        </p>
        <p>
            Copyright&nbsp;&copy; 2015-{{ date('Y') }} HaleyLeoZhang All Rights Reserved
        </p>
        <p>
            版权所有&copy; 2015-{{ date('Y') }} HaleyLeoZhang <a style="color:#437373;" target="_blank" rel="nofollow" href="http://beian.miit.gov.cn/">鲁ICP备16014994号-1</a>
        </p>
    </div>
</div>
<!-- 页脚结束 -->
<!-- Run js-->
<script>
var arr_src = [
  "{{ link_plugins('referrer_killer','referrer-killer.js')}}",
  // Baidu Statistic
  "{{ config('static_source_cdn.baidu_statistic') }}",
  // jq lazy load
  "{{ config('static_source_cdn.jquery_lazyload') }}",
];
loadjs(arr_src, {
    success: function () {
        // It is to load images without http_referrer that by use this lib
        // In this way, you will preload all of those images from other sites in this page
        var arr = $(".lazy_pic"),
            arr_len = arr.length;
        temp_src = '';
        for(var i = 0; i < arr_len; i++) {
            temp_src = arr[i].getAttribute("data-original");

            // Filters --- Lastest : Unified CNAME
            // If this pic is not from my cdn
            if(!temp_src.match(/hlzblog\.top/i)) {
                arr[i].innerHTML = ReferrerKiller.imageHtml(temp_src);
            }
        }

        // Achieve lazy load
        $(".lazy_pic").lazyload({
            effect: "fadeIn",
            threshold: 200,
            failurelimit: 10,
            placeholder: "{{ static_host() }}/static_pc/img/default/loading_400x400.gif",
            data_attribute: "original", // data-original属性
        });

        // Get visiter footmark in this website
        footmark();
    }
});
</script>
@yield('script')
</body>

</html>
