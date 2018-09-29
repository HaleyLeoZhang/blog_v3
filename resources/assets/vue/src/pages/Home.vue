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
      is_loading: false,
      // 下拉相关
      timerIndex: 0,
      pageNow: 0,
    }
  },
  created() {
    let _this = this;
    _this.is_loading = false;
    // 文章分类信息 --- 每秒检测屏幕滚动到的高度
    _this.timerIndex = setInterval(() => {
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
        };
        _this.is_loading = true; // 开启加载层
        api.ArticleList(params)
          .then(d => {
            let list = d.data.articles;
            if(list.page_count <= _this.pageNow) {
              clearInterval(_this.timerIndex);
            }
            _this.articleList = [].concat.call(
              _this.articleList,
              list.info
            );
            _this.is_loading = false; // 关闭加载层
          });
      }
    }, 1000);

  },
  beforeDestroy() {
    // 销毁定时器
    clearInterval(this.timerIndex);
  },
  computed: {},
  methods: {

  }
}

</script>
<style scoped lang="scss">
@import '../assets/css/function';
.home {}

</style>
