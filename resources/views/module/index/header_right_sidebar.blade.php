<!-- Right Sidebar -->
<style>
    /*这里是首页的右侧jquery浮动属性*/
    #right_bar_block { width: 131px; height: 143px; position: fixed; top: 258px; right: 0px; }
    *html #right_bar_block { margin-top: 258px; position: absolute; top: expression(eval(document.documentElement.scrollTop)); }
    #right_bar_block li { width: 131px; height: 60px; }
    #right_bar_block li img { float: right; }
    #right_bar_block li a { height: 49px; float: right; display: block; min-width: 47px; max-width: 131px; }
    #right_bar_block li a .mouseover { display: block; width: 47px; height: 49px; }
    #right_bar_block li a .mouseout { margin-right: -143px; cursor: pointer; cursor: hand; width: 131px; height: 49px; }
    #right_bar_block li a.favourable .mouseout { position: absolute; right: 190px; top: 150px; }
</style>

<div id="right_bar_block">
        <ul>
            <!-- <li>
                <a href="http://hlzblog.top/type/4.html" target="_blank"><img src="{{ static_host() }}/static_pc/img/default/side_bar/ll01.png" width="131" height="49" class="mouseout"><img src="{{ static_host() }}/static_pc/img/default/side_bar/l01.png" width="47" height="49" class="mouseover"></a>
            </li> -->
            <li>
                <a href="http://shang.qq.com/wpa/qunwpa?idkey=e56d51c39f21e0a38b686d70fd44943fb68027d2d4b2eb6606166801f93bade1" target="_blank">
                    <img src="{{ static_host() }}/static_pc/img/default/side_bar/ll03.png" class="mouseout">
                    <img src="{{ static_host() }}/static_pc/img/default/side_bar/l03.png" class="mouseover">
                </a>
            </li>
            <li>
                <a href="http://wpa.qq.com/msgrd?v=3&amp;uin=1290336562&amp;site=qq&amp;menu=yes" target="_blank">
                    <img src="{{ static_host() }}/static_pc/img/default/side_bar/ll04.png" class="mouseout">
                    <img src="{{ static_host() }}/static_pc/img/default/side_bar/l04.png" class="mouseover">
                </a>
            </li>
            <li>
                <a id="to_top" >
                    <img src="{{ static_host() }}/static_pc/img/default/side_bar/ll06.png" class="mouseout">
                    <img src="{{ static_host() }}/static_pc/img/default/side_bar/l06.png" class="mouseover">
                </a>
            </li>
        </ul>
</div>
<div class='clr'></div>

<script>
    // 右侧侧边栏
    $(document).ready(function() {
        var selector = "#right_bar_block a";
        $(selector).on("mouseenter",function() {
            $(this).find("img.mouseout").show();
            $(this).find("img.mouseout").animate({
                'margin-right': '0px'
            }, 'slow');
            $(this).find("img.mouseover").animate({
                width: '0px'
            }, 200);
        });

        $(selector).on("mouseleave",function() {
            $(this).find("img.mouseout").animate({
                'margin-right': '-131px'
            }, 'slow', function() {
                $(this).hide();
                $(this).next("img.mouseover").animate({
                    width: '47px'
                }, 200);
            });
        });

        $("#to_top").click(function() {
            $("html,body").animate({scrollTop: 0 });
        });
    });
    
</script>