<template>
  <div>
    <div class="cell" v-if="getCollapse">
      <ul class="detail-cell">
        <li><i class="icon">&#xe615;</i><span>活动时间：</span>{{beginTime}} ~ {{endTime}}</li>
        <li><i class="icon">&#xe615;</i><span>报名截止：</span>{{cantJoinTime}}</li>
        <li><i class="icon">&#xe600;</i><span>活动地址：</span>{{destination}}</li>
        <li><i class="icon">&#xe694;</i><span>是否收费：</span>否</li>
        <li><i class="icon">&#xe601;</i><span>发布人：</span>{{releaseUsername | minize}}</li>
      </ul>
      <el-input v-focus placeholder="请输入内容"></el-input>
      <router-link to="/404">去看 `Hello World`</router-link>
    </div>
    <div>
      <el-button v-on:click="toggleButton" type="info">{{ getToggleButton }}</el-button>
    </div>
  </div>
</template>
<script>
import tools from '@/tools';
import { mapGetters } from 'vuex';
export default {
  // 基础类型检测 String Number Boolean Function Object Array
  props: {
    beginTime: String, // 也可以设置为多种类型  [String, Number]
    endTime: String,
    cantJoinTime: String,
    destination: String,
    releaseUsername: String,
    // // 自定义验证函数 
    // propF: {
    //   validator: function (value) {
    //     return value > 10
    //   }
    // }
  },
  data() {
    return {}
  },
  computed: {
    getToggleButton() {
      return !this.collapse ? '点击展开' : '点击收起';
    },
    getCollapse() {
      return this.$store.state.common.collapse;
    }
  },
  methods: {
    // 切换
    toggleButton() {
      let status = this.$store.state.common.collapse;
      this.$store.dispatch('setCollapseState', status);
    }
  },
  filters: {
    minize: function (value) {
      return value.toLowerCase()
    }
  },
  // 局部指令相关
  directives: {
    // 注册一个局部的自定义指令 v-focus
    focus: {
      // 使用钩子函数
      // 被绑定元素插入父节点时调用 --- 定义指令
      inserted(el) { // el 可以直接进行dom操作
        el.focus();
      },
    },
  },
}

</script>
<style lang="scss" scoped>
@import '../assets/css/function';
.cell {
  background: #fff;
  .detail-cell {
    color: #999;
    border-bottom: 1px solid #EAEAEA;
    border-top: 10px solid #f1f1f1;
    font-size: 15px;
    li {
      border-top: 1px solid #f1f1f1;
      padding: px2rem(25px) px2rem(20px);
      &:nth-of-type(4) {
        color: red;
      }
    }
    .icon {
      color: #999;
      font-size: 17px; // margin-right: px2rem(15px);
    }
  }
}

</style>
