<template>
  <div class="home">
    <article-list :list-info="articleList"></article-list>
    <loading :flag="is_loading"></loading>
  </div>
</template>
<script>
import api from '@/fetch';

import ArticleList from '@/components/ArticleList';
import Loading from '@/components/Loading';

export default {
  components: {
    ArticleList,
    Loading,
  },
  data() {
    return {
      articleList: [],
      cate_id: this.$route.params.id,
      is_loading: false,
      // 下拉相关
      timerIndex: 0,
      pageNow: 0,
    }
  },
  created() {
    // 初始化数据
    this.yth_init();
  },
  beforeDestroy() {
    // 销毁定时器
    clearInterval(this.timerIndex);
  },
  computed: {},
  methods: {
    yth_init() {
      let _this = this;
      // 初始化数据
      _this.articleList = [];
      _this.is_loading = false;
      // 下拉相关
      _this.timerIndex = 0;
      _this.pageNow = 0;

      // 文章分类信息 --- 每秒检测屏幕滚动到的高度
      _this.timerIndex = setInterval(() => {
        console.log('Category.vue - timerIndex');
        let tolerant = 5; // 容差值
        let scroll = parseInt(document.documentElement.scrollTop || document.body.scrollTop);
        // - 计算当前页面高度
        let tag_position = document.body.scrollHeight;
        let now = scroll + document.documentElement.clientHeight + tolerant;
        let is_reach = false;
        if(now >= tag_position) {
          // 如果已经处于加载中了，则忽略
          if(_this.is_loading) {
            return false;
          }
          _this.is_loading = true; // 开启加载层

          _this.pageNow++;
          let params = {
            "to_page": _this.pageNow,
            "cate_id": _this.cate_id,
          };

          api.ArticleList(params)
            .then(d => {
              let list = d.data.articles;
              // 关闭底部按钮的选中
              _this.$store.dispatch('setBottombarState', '');
              // 如果数据为空，404
              if(0 === list.page_count) {
                _this.$router.go('/*');
              }
              // 分类名
              window.document.title = list.info[0].cate_name + ' | 文章分类 | 云天河博客';
              if(list.page_count >= _this.pageNow) {
                // 加载数据
                _this.articleList = [].concat.call(
                  _this.articleList,
                  list.info
                );
                // 最后一页，则取消循环
                console.error({
                  page: list.page_count,
                  now: _this.pageNow
                });
                if(list.page_count <= _this.pageNow) {
                  clearInterval(_this.timerIndex);
                }

              }
              _this.is_loading = false; // 关闭加载层
            });
        }
      }, 1000);
    },
  },
  beforeRouteUpdate(to, from, next) {
    // 路由更新的时候
    // console.log('beforeRouteUpdate')
    // 销毁定时器
    this.cate_id = to.params.id;
    this.yth_init();
    next();
  },
}

</script>
<style scoped lang="scss">
@import '../assets/css/function';
.home {}

</style>
