import qs from 'qs' // 类似 php 中的 http_build_query
import { get, fetch } from './axios'

export default {
  // 分类列表
  CategoryList() {
    return get('/api/spa/category_list')
  },
  // 文章列表
  ArticleList(payload = null) {
    let params = '';
    if(payload) {
      params = qs.stringify(payload);
    }
    return get('/api/spa/article_list?' + params)
  },
  // 获取文章详情
  ArticleDetail(payload = null) {
    let params = '';
    if(payload) {
      params = qs.stringify(payload);
    }
    return get('/api/spa/article_detail?' + params)
  },
  // 用户足迹 记录
  FootMarkrAdd() {
    let params = {
      "url": location.href,
    };
    return fetch('/api/behaviour/foot_mark', params)
  },
}
