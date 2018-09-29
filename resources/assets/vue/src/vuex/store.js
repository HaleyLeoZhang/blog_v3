import Vue from 'vue'
import Vuex from 'vuex'
// 导入模块
import common from './modules/common'
Vue.use(Vuex)

/**
* Vuex 出口，将配置好的状态关系 导入到 `main.js`
*/
export default new Vuex.Store({
    // 注入模块到状态树
    modules: {
        common,
    }
})