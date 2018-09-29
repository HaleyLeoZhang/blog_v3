<template>
  <div class="top_nav">
    <!-- <img src="//tencent.cdn.hlzblog.top/static/img/default/logo_detail.png" class="logo" alt="logo"> -->
    <router-link to="/">
      <img src="../assets/img/logo_detail_hq.png" class="logo" alt="logo" @click="chooseCategory">
    </router-link>
    <div class="nav_logo">
      <i class="fa fa-windows" @click="changeAction"></i>
    </div>
  </div>
</template>
<script>
import { mapGetters } from 'vuex'
export default {
  data() {
    return {

    }
  },
  methods: {

    changeAction() {
      this.$store.dispatch('setSidebarState', this.sidebar)
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
<style scoped lang="scss">
@import '../assets/css/function';
$top_nav_h: px2rem(300px);

.top_nav {
  position: fixed;
  transform: translateZ(0);
  top: 0;
  left: 0;
  z-index: 5;
  height: $top_nav_h;
  line-height: $top_nav_h;
  width: 100%;
  background: #666;
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  .logo {
    margin-left: $top_nav_h*0.2;
    margin-top: $top_nav_h *0.1;
    height: $top_nav_h* 0.8;
  }
  .nav_logo {
    color: #f5f5f5;
    font-size: px2rem(120px);
    padding-right: $top_nav_h * 0.3;
  }
}

</style>
