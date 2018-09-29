<template>
  <div class="home">
    <loading :flag="is_loading"></loading>
    <div class="article_title">{{info.title}}</div>
    <div class="article_field">
      <!-- 文章基础信息 -->
      <div class="basic_info">
        <div class="others">
          <span title="发布时间">
            <i class="fa fa-clock-o" aria-hidden="true"></i>
            {{info.created_at}}           <font></font>
          </span>
          <span title="所属分类" class="own_category">
            <i class="fa fa-folder-open-o"></i>            
            <router-link :to="'/category/'+info.cate_id">
              {{info.cate_name}}
            </router-link>
          </span>
          <div class="clr"></div>
        </div>
        <div class="clr"></div>
      </div>
      <div class="clr"></div>
      <!-- 文章内容 -->
      <div class="real_html">
        <div class="article_content_type_markdown" 　id="markdown_container" v-html="content.markdown"></div>
        <div class="article_content_type_editor" 　v-html="content.editor"></div>
      </div>
    </div>
  </div>
</template>
<script>
import api from '@/fetch';
import Loading from '@/components/Loading';
import referrer_killer from '@/tools/referer_killer';
import markdown_lib from '@/tools/markdown';

export default {
  components: {
    Loading,
  },
  data() {
    return {
      info: {},
      content: {
        markdown: '',
        editor: '',
      },
      article_id: this.$route.params.id,
      is_loading: true,
      is_first_time: true, // 标示，是否为第一次更新节点
    }
  },
  created() {
    // 初始化数据
    console.log('created...');
    this.yth_init();
  },
  // 因为通过 v-hmtl 加载进来的，所有文章内容相关节点，加载好了
  updated() {
    if(this.is_first_time) {
      this.is_first_time = false;
      markdown_lib.__init(); // 渲染Markdown
      this.pic_init(); // 懒加载图片
    }
  },
  computed: {},
  methods: {
    yth_init() {
      let _this = this;
      let params = {
        "article_id": this.article_id,
      };

      _this.is_loading = true; // 开启加载层
      api.ArticleDetail(params)
        .then(d => {
          _this.is_loading = false; // 关闭加载层
          // 关闭底部按钮的选中
          _this.$store.dispatch('setBottombarState', '');
          // 如果数据返回不正确
          if(200 !== d.code) {
            console.log(d.message);
          } else {
            _this.info = d.data.article;
            // 重置数据
            _this.content.markdown = '';
            _this.content.editor = '';
            // 写入文章
            if(_this.info.type === 0) { // markdown
              _this.content.markdown = _this.info.content;
            } else { // editor
              _this.content.editor = _this.info.content;;
            }
            document.title = _this.info.title + ' | 文章详情';
          }
        });
      api.FootMarkrAdd()
        .then(d => {
          console.log(d);
        });
    },
    pic_init() {


      // It is to load images without http_referrer that by use this lib
      // In this way, you will preload all of those images from other sites in this page
      let arr = $(".lazy_pic"),
        arr_len = arr.length;
      let temp_src = '';
      for(var i = 0; i < arr_len; i++) {
        temp_src = arr[i].getAttribute("data-original");

        // Filters --- Lastest : Unified CNAME
        // If this pic is not from my cdn
        if(!temp_src.match(/hlzblog\.top/i)) {
          arr[i].innerHTML = referrer_killer.imageHtml(temp_src);
          console.log('这张图片正在重置');
        }
      }

      // Achieve lazy load
      $(".lazy_pic").lazyload({
        effect: "fadeIn",
        threshold: 200,
        failurelimit: 10,
        placeholder: "//tencent.cdn.hlzblog.top/static/img/default/pre_pic.png",
        data_attribute: "original", // data-original属性
      });

      // 新窗口打开图片
      $(".lazy_pic").on("click", function () {
        var src = $(this).attr("data-original");
        window.open(src);
      });

    }
  },
  beforeRouteUpdate(to, from, next) {
    // 路由更新的时候
    console.log('beforeRouteUpdate')
    // 销毁定时器
    this.article_id = to.params.id;
    this.yth_init();
    next();
  }

}

</script>
<style scoped lang="scss">
@import '../assets/css/function';

.clr {
  clear: both;
  width: 100%;
  height: 0;
}

.article_title {
  color: #ffa54f;
  font-size: 20px;
  line-height: 30px;
  font-weight: 700;
  margin-bottom: 10px;
}

.article_field {
  .basic_info {
    float: left;
    width: 100%;
    clear: both;
    padding-left: 0px;
    .others {
      color: #333;
      padding-bottom: 10px;
      span {
        float: left;
        i {
          margin-right: 5px;
        }
        font:after {
          content: '/';
          display: inline-block;
          margin: 0 10px 0 5px;
          opacity: 0.5;
        }
      }
      .own_category a{
        color: #333;
        text-decoration: none;
      }
    }
  }
  .real_html {
    .article_content_type_editor {
      width: 100%;
      img {
        max-width: 100%;
      }
    }
    word-wrap: break-word;
    img {
      cursor: pointer;
      max-width: 100%;
    }
  }
}

</style>
