<?php
namespace App\Helpers;

// ----------------------------------------------------------------------
// laypage 分页类
// ----------------------------------------------------------------------
// Link  : http://www.hlzblog.top/
// GITHUB: https://github.com/HaleyLeoZhang
// ----------------------------------------------------------------------

// 用法，见文末
use DB;

class Page
{
    /**
     * @param Int     : page_size 单次数据最大个数
     * @param Boolean: is_render 是否直接获取渲染页条的代码，默认开启
     * @param Int     : page_count页数统计
     * @param Int     : total     页面总计
     * @param String : sql_tpl     sql语句， DB:select方法的传参方式，但是不传 limit的两个参数
     * @param Array     : data         sql 对应的参数
     * @param String : to_page     输出相应页码，默认to_page
     */
    public $page_size = 15;
    public $is_render = true;
    public $page_count;
    public $total;
    protected $sql_tpl;
    protected $data;
    protected $to_page;

    const IS_RENDER_YES = true;
    const IS_RENDER_NO  = false;

    /**
     * 构造函数
     * @param String : sql_tpl     Sql语句， DB:select方法的传参方式
     * @param Array     : data         Sql 对应的参数
     * @param String : page_name     跳转页码名称，默认to_page
     */
    public function __construct($sql_tpl, $data, $page_name = 'to_page')
    {
        $this->to_page   = $_REQUEST[$page_name] ?? 1;
        $this->sql_tpl   = $sql_tpl;
        $this->data      = $data;
        $this->is_render = self::IS_RENDER_YES;
    }
    /**
     * 依据 is_render ，传出结果
     */
    public function get_result()
    {
        if ($this->is_render) {
            return [
                "info"   => $this->select(),
                "render" => $this->js(),
            ];
        } else {
            return [
                "info"       => $this->select(),
                "page_count" => $this->page_count,
                "total"      => $this->total,
            ];
        }

    }

    /**
     * 传入 sql ,等待解析
     */
    private function count()
    {
        if (preg_match('/Select(.*?)(From.*?)Limit/is', $this->sql_tpl, $matches)) {
            $count_sql        = 'Select count(*) as total ' . $matches[2];
            $result           = DB::select($count_sql, $this->data);
            $this->total      = $result[0]->total;
            $this->page_count = ceil($this->total / $this->page_size);
        } else {
            $error_msg = 'SQL语句不匹配。请以：Select(.*?)(From.*?)Limit的形式去书写，当前SQL ' . $this->sql_tpl;
            exit($error_msg);
        }
    }

    /**
     * 传入 sql ,直接运行
     * @return Array  数量列表
     */
    private function select()
    {
        $this->count();
        // 是否为空集
        if (!$this->page_count) {
            return [];
        }
        // 计算页码
        $this->to_page = intval($this->to_page);
        if ('' == $this->to_page || $this->to_page <= 1) {
            $this->to_page = 1;
        } elseif ($this->page_count <= $this->to_page) {
            $this->to_page = $this->page_count;
        }
        // 计算偏移量
        $start_len = ($this->to_page - 1) * $this->page_size;
        // limit参数 压入数组
        array_push($this->data, $start_len, $this->page_size);
        return DB::select($this->sql_tpl, $this->data);
    }

    /**
     * layPage HTml + Js + Css库资源
     */
    private function js()
    {
        if ($this->page_count == 1) {
            // 如果只有一页，返回空
            return '';
        }
        $source = <<<js_source

		!function(){"use strict";function a(d){var e="laypagecss";a.dir="dir"in a?a.dir:f.getpath+"/skin/laypage.css",new f(d),a.dir&&!b[c](e)&&f.use(a.dir,e)}a.v="1.3";var b=document,c="getElementById",d="getElementsByTagName",e=0,f=function(a){var b=this,c=b.config=a||{};c.item=e++,b.render(!0)};f.on=function(a,b,c){return a.attachEvent?a.attachEvent("on"+b,function(){c.call(a,window.even)}):a.addEventListener(b,c,!1),f},f.getpath=function(){var a=document.scripts,b=a[a.length-1].src;return b.substring(0,b.lastIndexOf("/")+1)}(),f.use=function(c,e){var f=b.createElement("style");f.innerHTML='.laypage_main a,.laypage_main input,.laypage_main span{height:26px;line-height:26px}.laypage_main button,.laypage_main input,.laypageskin_default a{border:1px solid #ccc;background-color:#fff}.laypage_main{font-size:0;clear:both;color:#666}.laypage_main *{display:inline-block;vertical-align:top;font-size:12px}.laypage_main a{text-decoration:none;color:#666}.laypage_main a,.laypage_main span{margin:0 3px 6px;padding:0 10px}.laypage_main input{width:40px;margin:0 5px;padding:0 5px}.laypage_main button{height:28px;line-height:28px;margin-left:5px;padding:0 10px;color:#666}.laypageskin_default span{height:28px;line-height:28px;color:#999}.laypageskin_default .laypage_curr{font-weight:700;color:#666}.laypageskin_molv a,.laypageskin_molv span{padding:0 12px;border-radius:2px}.laypageskin_molv a{background-color:#f1eff0}.laypageskin_molv .laypage_curr{background-color:#00AA91;color:#fff}.laypageskin_molv input{height:24px;line-height:24px}.laypageskin_molv button{height:26px;line-height:26px}.laypageskin_yahei{color:#333}.laypageskin_yahei a,.laypageskin_yahei span{padding:0 13px;border-radius:2px;color:#333}.laypageskin_yahei .laypage_curr{background-color:#333;color:#fff}.laypageskin_flow{text-align:center}.laypageskin_flow .page_nomore{color:#999}',e&&(f.id=e),b[d]("head")[0].appendChild(f),f=null},f.prototype.type=function(){var a=this.config;return"object"==typeof a.cont?void 0===a.cont.length?2:3:void 0},f.prototype.view=function(){var b=this,c=b.config,d=[],e={};if(c.pages=0|c.pages,c.curr=0|c.curr||1,c.groups="groups"in c?0|c.groups:5,c.first="first"in c?c.first:"首页",c.last="last"in c?c.last:"尾页",c.prev="prev"in c?c.prev:"上一页",c.next="next"in c?c.next:"下一页",c.pages<=1)return"";for(c.groups>c.pages&&(c.groups=c.pages),e.index=Math.ceil((c.curr+(c.groups>1&&c.groups!==c.pages?1:0))/ (0 === c.groups ? 1 : c.groups)), c.curr > 1 && c.prev && d.push('<a href="javascript:;" class="laypage_prev" data-page="' + (c.curr - 1) + '">' + c.prev + "</a>"), e.index > 1 && c.first && 0 !== c.groups && d.push('<a href="javascript:;" class="laypage_first" data-page="1"  title="首页">' + c.first + "</a><span>…</span>"),e.poor=Math.floor((c.groups-1)/2),e.start=e.index>1?c.curr-e.poor:1,e.end=e.index>1?function(){var a=c.curr+(c.groups-e.poor-1);return a>c.pages?c.pages:a}():c.groups,e.end-e.start<c.groups-1&&(e.start=e.end-c.groups+1);e.start<=e.end;e.start++)e.start===c.curr?d.push('<span class="laypage_curr" '+(/^#/.test(c.skin)?'style="background-color:'+c.skin+'"':"")+">"+e.start+"</span>"):d.push('<a href="javascript:;" data-page="'+e.start+'">'+e.start+"</a>");return c.pages>c.groups&&e.end<c.pages&&c.last&&0!==c.groups&&d.push('<span>…</span><a href="javascript:;" class="laypage_last" title="尾页"  data-page="'+c.pages+'">'+c.last+"</a>"),e.flow=!c.prev&&0===c.groups,(c.curr!==c.pages&&c.next||e.flow)&&d.push(function(){return e.flow&&c.curr===c.pages?'<span class="page_nomore" title="已没有更多">'+c.next+"</span>":'<a href="javascript:;" class="laypage_next" data-page="'+(c.curr+1)+'">'+c.next+"</a>"}()),'<div name="laypage'+a.v+'" class="laypage_main laypageskin_'+(c.skin?function(a){return/^#/.test(a)?"molv":a}(c.skin):"default")+'" id="laypage_'+b.config.item+'">'+d.join("")+function(){return c.skip?'<span class="laypage_total"><label>到第</label><input type="number" min="1" onkeyup="this.value=this.value.replace(/\\D/, \'\');" class="laypage_skip"><label>页</label><button type="button" class="laypage_btn">确定</button></span>':""}()+"</div>"},f.prototype.jump=function(a){if(a){for(var b=this,c=b.config,e=a.children,g=a[d]("button")[0],h=a[d]("input")[0],i=0,j=e.length;j>i;i++)"a"===e[i].nodeName.toLowerCase()&&f.on(e[i],"click",function(){var a=0|this.getAttribute("data-page");c.curr=a,b.render()});g&&f.on(g,"click",function(){var a=0|h.value.replace(/\s|\D/g,"");a&&a<=c.pages&&(c.curr=a,b.render())})}},f.prototype.render=function(a){var d=this,e=d.config,f=d.type(),g=d.view();2===f?e.cont.innerHTML=g:3===f?e.cont.html(g):b[c](e.cont).innerHTML=g,e.jump&&e.jump(e,a),d.jump(b[c]("laypage_"+e.item)),e.hash&&!a&&(location.hash="!"+e.hash+"="+e.curr)},"function"==typeof define?define(function(){return a}):"undefined"!=typeof exports?module.exports=a:window.laypage=a}();

js_source;

        $execute = "
			laypage({
			    cont: 'yth_pageination',  // 分页条的ID
			    pages: $this->page_count,      // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~【后端】传入总页数~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
			    skin: 'yahei',  // 加载内置皮肤，也可以直接赋值16进制颜色值，如:#c00
			    // 下面几个就是 都是 false=>不显示，设为字符串=>设置为对应按钮的名称
			    prev:  false,   // 上一页
			    next:  false,   // 下一页
			    skip:  true,    // 开启跳页
			    first: false,   // 数字1,
			    last:  false,   // 总页数。
			    curr: function() { // 通过url获取当前页,页码get参数，默认为 to_page
			        var page = location.search.match(/to_page=(\d+)/);
			        return page ? page[1] : 1;
			    }(),
			    jump: function(e, first) {
			        var total = $this->total,// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~【后端】传入总记录数~~~~~~~~~~~~~~~~~~~~~~~~~~~~
			            page_info  = document.createElement('span');
			            page_info.style='font-size:12px;';
			            page_info.innerHTML =  '总计 <b>'+total+'</b> 条记录，共<b> '+this.pages+' </b> 页';
			            if(this.pages>1){
			            	document.getElementsByClassName('laypage_total')[0].appendChild( page_info );
			            }
			        if (!first) { // 因为一开始就响应该函数，所以用该参数判断是否第一次刷新。
			            var url_params = location.search.match(/(.*?)&?(to_page=\d+)(&?.*)/);
			            var first_page_params = location.search.match(/(.*?\?)(.*)/);
			            if( url_params ){
			                location.href = url_params[1] + url_params[3]+'&to_page='+e.curr;
			            }
			            else if( first_page_params ){
			            	location.href = first_page_params[1] + first_page_params[2]+'&to_page='+e.curr;
			            }
			            else{
			                location.href = '?to_page='+e.curr;
			            }
			        }
			    },
			    groups: 5 // 每次显示的码数数
			});
			";
        $div    = '<div id="yth_pageination"></div>';
        $script = '<script>' . $source . $execute . '</script>';
        return $div . $script;
    }

}

/*
 * 请注意：如果页数为1，则render为空字符串
 *            使用时，请先加载jquery库
 */
// 当 is_render = true     输出 样式    Array["info"=>Array,"page_count"=>Int,"total"=>Int]
// 当 is_render = false    输出 样式    Array["info"=>Array,"render"=>String]

/* 后台示例：   limit部分，不用写对应的数据，如下

        $paginate = new Page('
            Select `ip`, `location`, `time`
            From `hlz_staff_login_logs`
            Where `staff_id`=?
            Order By `time` Desc
            Limit ?,?
        ', []);
        $paginate->page_size = 2; // 每页显示的数据条数，默认 15
        $page_data    = $paginate->get_result();
        return view('example', ["render" => $page_data["render"], "info" => $page_data["info"]]);

 */

/* 前台示例，模板输出数据与分页条 ， 如果只有一页则不显示分页条

    @foreach ($info as $item)
        <p>This is user {{ $item->ip }}</p>
    @endforeach
    
    {{  $article_list['render'] }}

{{$render}}

 */
