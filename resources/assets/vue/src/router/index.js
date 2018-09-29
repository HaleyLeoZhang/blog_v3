import Vue from 'vue'
import Router from 'vue-router'
// 导入页面渲染的各个组件
import Home from '@/pages/Home'
import Category from '@/pages/Category'
import Article from '@/pages/Article'
import NotFound from '@/pages/NotFound'

Vue.use(Router)
// 书写页面信息
const rout_list = [{
    path: '/',
    name: 'Home',
    component: Home,
    meta: {
      "title": "首页 | 云天河博客",
    },
  },{
    path: '/category/:id',
    name: 'Category',
    component: Category,
    meta: {
      "title": "分类信息 | 云天河博客",
    },
  },{
    path: '/article/:id',
    name: 'Article',
    component: Article,
    meta: {
      "title": "文章详情",
    },
  },
  {
    path: '*',
    name: 'NotFound',
    component: NotFound,
    meta: {
      "title": "页面不存在 | 云天河博客",
    },
  },
];

const router = new Router({
  // 导入路由信息
  routes: rout_list
})

// 每个都执行
router.beforeEach((to, from, next) => {
  // 先设置标题
  window.document.title = to.meta.title;
  // 最后进入路由
  next()
})


export default router
