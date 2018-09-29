import * as types from '../types';
import api from '@/fetch/api'; // 之前封装好的 接口对象
// 通用配置


// -----------------------------------------------------------:
//     设置初始状态
// -----------------------------------------------------------:
const state = {
    res: null , // 首页，json 数据
};

// -----------------------------------------------------------:
//     可进行异步操作，一般数据交互常用。完成后提交新的状态信息到 Mutation
// -----------------------------------------------------------:
const actions = {
    setLoadingState({ commit }, status) {
        api.SportsList()
            .then(res => {
                console.log(res)
                commit(types.COM_LOADING_STATUS, res)
            })
    },
    setNavState({ commit }, status) {
        commit(types.COM_NAV_STATUS, status)
    }

}

// -----------------------------------------------------------:
//     通过 getters 实现 向外暴露状态参数
// -----------------------------------------------------------:
const getters = {
    loading: state => state.loading,
    showToast: state => state.showToast,
    showAlert: state => state.showAlert
}

// -----------------------------------------------------------:
//     同步执行 --- 负责变更状态
// -----------------------------------------------------------:
const mutations = {
    [types.GET_TRAVELS_SEARCH_KEY](state, params) {
        state.searchKey = params
    },
}

export default {
    state,
    actions,
    getters,
    mutations
}