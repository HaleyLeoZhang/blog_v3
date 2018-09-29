<template>
  <transition name="slide-left">
    <div v-show="sidebar" class="sidebar">
      <div class="left">
        <div class="left_box">
          <!-- 开头 -->
          <div class="_empty"></div>
          <!-- ---- -->
          <h5 class="title"><i class="el-icon-goods _icon"></i></h5>
          <ul class="cate_ul">
            <li v-for="item in category_list" @click="chooseCategory">
              <router-link :to="'/category/'+item.id">
                <span class="_left">{{item.title}}</span>
                <span class="_right">（{{item.total}}）</span>
              </router-link>
            </li>
            <!-- 批量测试域 -->
          </ul>
          <!-- 结尾 -->
          <div class="_empty"></div>
          <!-- ---- -->
        </div>
      </div>
      <div class="right" @click="changeAction"></div>
    </div>
  </transition>
</template>
<script>
import { mapGetters } from 'vuex'
import api from '../fetch/index'

export default {
  data() {
    return {
      category_list: []
    }
  },
  created() {
    // 文章分类信息
    if(0 === this.category_list.length) {
      api.CategoryList()
        .then(d => {
          this.category_list = d.data.categories;
        });
    }
  },
  methods: {
    changeAction() {
      this.$store.dispatch('setSidebarState', this.sidebar);
    },
    // 选中后，收起侧边栏
    chooseCategory() {
      this.$store.dispatch('setSidebarState', true);
    }
  },
  computed: {
    ...mapGetters([
      'sidebar'
    ])
  }
}

</script>
<style lang="scss" scoped>
@import '../assets/css/function';

.sidebar {
  position: fixed;
  height: 100%;
  width: 100%;
  top: 0;
  left: 0;
  z-index: 4;
  color: #f5f5f5;
  display: flex;
  .left {
    // background: url("http://img.cdn.hlzblog.top/17-6-16/28882506.jpg");
    background-image: url("../assets/img/sidebar_bg.jpg");
    background-repeat: repeat-y;
    width: 60%;
    height: 100%;
    overflow-y: scroll;
    overflow-x: hidden; // background: #262826;
    .left_box {
      padding-left: px2rem(40px);
      ._empty {
        width: 100%;
        height: px2rem(300px);
      }
      .title {
        width: 100%;
        font-size: px2rem(75px);
        &:after {
          padding-left: px2rem(40px);
          content: '文章分类';
        }
        ._icon {
          color: #8AB0DA;
          margin-right: px2rem(20px);
        }
      }
      .cate_ul {
        line-height: px2rem(120px);
        li a {
          text-decoration: none;
        }
        ._left {
          color: #D6D672;
        }
        ._right {
          color: #fdfdfa;
        }
      }
    }
  }
  .right {
    width: 40%;
    height: 100%;
    background: #fff;
    opacity: 0;
  }
}

// 过渡效果
// 动画 -- 左边进入
@keyframes slideInLeft {
  0% {
    opacity: 0;
    transform: translateX(-2000px)
  }
  100% {
    transform: translateX(0)
  }
}

// 动画 -- 左边回来
@keyframes slideOutLeft {
  0% {
    transform: translateX(0)
  }
  100% {
    opacity: 0;
    transform: translateX(-2000px)
  }
}

.slide-left-enter-active {
  animation: slideInLeft .3s
}

.slide-left-leave-active {
  animation: slideOutLeft .3s
}

</style>
