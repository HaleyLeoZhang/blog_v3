import * as types from '../types';
// 通用配置


// -----------------------------------------------------------:
//     设置初始状态
// -----------------------------------------------------------:
const state = {
  sidebar: false, // false -> 隐藏 true -> 显示
  token: '', // 空字符 -> 未登录  非空字符串 -> 有登录信息
  bottombarName: '', // 底部选中的bar名称
};

// -----------------------------------------------------------:
//     处理逻辑[可以异步]，数据交互常用。 它提交的是 Mutation 
// -----------------------------------------------------------:
/**
    外部通过类似
    this.$store.dispatch('setLoadingState', false)
    来实现访问 actions 方法 
*/
const actions = {
  // loading 层  显示状态
  setToken({ commit }, payload) {
    commit(types.COMMON_TOKEN, payload);
  },
  setSidebarState({ commit }, payload) {
    commit(types.COMMON_SIDEBAR, payload);
  },
  setBottombarState({ commit }, payload) {
    commit(types.COMMON_BOTTOMBAR_NAME, payload);
  },
}

// -----------------------------------------------------------:
//     通过 getters 实现 向外暴露状态参数
// -----------------------------------------------------------:
/**
    外部通过类似
    this.$store.state.模块名.collapse
    来实现访问 getters 参数 
*/
const getters = {
  loading: state => state.loading,
  sidebar: state => state.sidebar,
  bottombarName: state => state.bottombarName,
}

// -----------------------------------------------------------:
//     状态变更[同步执行] - 可接收 actions 中调用，来实现更新状态
// -----------------------------------------------------------:
const mutations = {
  // 修改token
  [types.COMMON_TOKEN](state, val) {
    state.token = val;
  },
  // 侧边栏
  [types.COMMON_SIDEBAR](state, status) {
    state.sidebar = !status;
  },
  // 底部选中
  [types.COMMON_BOTTOMBAR_NAME](state, barName) {
    state.bottombarName = barName;
  },
}

export default {
  state,
  actions,
  getters,
  mutations
}
