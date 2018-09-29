<template>
  <div class="bottom_nav">
    <div class="bot">
      <!-- 分割 -->
      <router-link v-for="item in button_info_arr" :to="item.router">
        <div class="bot_li" @click="chooseButton(item.icon_name)">
          <div class="bot_li_icon">
            <i :class="' fa fa-'+item.icon_name + ' '+ bottomBarButtonAnimateStatus(item.icon_name)"></i>
          </div>
          <div :class="'bot_li_title '+bottomBarButtonStatus(item.icon_name)">
            {{item.title}}
          </div>
        </div>
      </router-link>
      <!-- -->
    </div>
  </div>
</template>
<script>
import { mapGetters } from 'vuex'
export default {
  data() {
    return {
      "button_info_arr": [
        { "icon_name": "home", "title": "首页", "router": "/" },
        { "icon_name": "search", "title": "搜索", "router": "/search" },
        { "icon_name": "fire", "title": "热评", "router": "/fire" },
        { "icon_name": "user-o", "title": "我的", "router": "/mine" },
      ]
    }
  },
  methods: {
    // 显示/隐藏 侧边栏
    changeAction() {
      this.$store.dispatch('setSidebarState', this.sidebar)
    },
    // 选中底部按钮
    chooseButton(name) {
      this.$store.dispatch('setBottombarState', name)
      // 隐藏侧边栏
      this.$store.dispatch('setSidebarState', true)
    },
    // 底部按钮 --- 文字变化
    bottomBarButtonStatus(bar_name) {
      if(bar_name === this.bottombarName) {
        return "bot_choosen";
      } else {
        return "_icon";
      }
    },
    // 底部按钮 --- icon 动画
    bottomBarButtonAnimateStatus(bar_name) {
      if(bar_name === this.bottombarName) {
        return " _icon_animate bot_choosen";
      } else {
        return "_icon";
      }
    },
  },
  computed: {
    ...mapGetters([
      'sidebar',
      'bottombarName'
    ])
  }
}

</script>
<style scoped lang="scss">
@import '../assets/css/function';
$bottom_nav_h: px2rem(300px);

$bottom_button_count: 4; // 设置按钮数量
.bottom_nav {
  opacity: 0.7;
  height: $bottom_nav_h;
  position: fixed;
  transform: translateZ(0);
  bottom: 0;
  left: 0;
  z-index: 5;
  width: 100%;
  a {
    text-decoration: none;
  }
  .bot {
    position: absolute;
    display: flex;
    flex-direction: row;
    justify-content: space-around;
    box-shadow: 0 0 7px 0px #F1E7E7;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    .bot_li {
      display: block;
      flex: 1 1 0;
      text-align: center;
      .bot_li_icon {
        font-size: px2rem(300px) * 0.4;
        line-height: $bottom_nav_h * 0.7; // 图标选中状态
      }
      .bot_li_title {
        font-size: px2rem(300px) * 0.25;
        font-family: Helvetica Neue, Helvetica, PingFang SC, \5FAE\8F6F\96C5\9ED1, Tahoma, Arial, sans-serif;
        line-height: $bottom_nav_h * 0.3;
        font-weight: 400;
      }
      .bot_choosen {
        color: #0cc3ff;
      }
      ._icon_animate {
        animation: fadeIn 0.5s;
      }
      ._icon {
        color: #c7d3dc;
      }
    }
  }
}


// 点击图标特效
@keyframes fadeIn {
  0% {
    opacity: 0;
    font-size: px2rem(300px) * 0.5;
  }
  100% {
    opacity: 1;
    font-size: px2rem(300px) * 0.4;
  }
}

</style>
