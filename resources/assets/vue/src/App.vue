<template>
  <div id="app">
    <!-- 这里是全局视图 -->
    <!-- z-index: 5-->
    <v-topnav></v-topnav>
    <!-- z-index: 4-->
    <v-sidebar></v-sidebar>
    <!-- z-index: 5-->
    <v-bottombar></v-bottombar>
    <!-- 限制显示面试 -->
    <div class="app_box">
      <!-- 给予视图过渡效果 -->
      <transition name="slide-fade">
        <!-- 这里是 router 里面的视图 -->
        <router-view></router-view>
      </transition>
    </div>
  </div>
</template>
<script>
import TopNav from '@/components/TopNav'
import Sidebar from '@/components/Sidebar'
import BottomBar from '@/components/BottomBar'
export default {
  name: 'App',
  components: {
    'v-topnav': TopNav,
    'v-sidebar': Sidebar,
    'v-bottombar': BottomBar,
  },
}

</script>
<style lang="scss" scoped>
@import './assets/css/function';

// WebAPP式 布局
.app_box{
  margin-top: px2rem(400px);
  margin-bottom: px2rem(400px);
}

// 动画过渡配置
#app {
  // background: #f5f5f5;
  .slide-fade-enter-active {
    animation: fadeInDown .4s
  }
  .slide-fade-leave-active {
    animation: fadeOutDown .2s
  }
}
// 过渡动画
@keyframes fadeInDown {
  0% {
    opacity: 0;
    transform: translateY(-20px)
  }
  100% {
    opacity: 1;
    transform: translateY(0)
  }
}

@keyframes fadeOutDown {
  0% {
    opacity: 1;
    transform: translateY(0)
  }
  100% {
    opacity: 0;
    transform: translateY(20px)
  }
}

</style>
