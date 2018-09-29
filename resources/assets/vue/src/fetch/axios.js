import axios from 'axios'
import qs from 'qs' // 类似 php 中的 http_build_query

//+++++++++++++++++++++++++++++++++++++++++++++++++++++
// axios 配置
//+++++++++++++++++++++++++++++++++++++++++++++++++++++
axios.defaults.timeout = 5000;
axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=UTF-8';
// axios.defaults.baseURL = 'http://web.test.com/'; // 本地测试环境 - 正式环境需要去掉
// axios.defaults.baseURL = 'http://www.hlzblog.top/';


/**
* 统一数据返回格式

    {
        "detail": "",
        "code": 200,
        "data": {...}
    }

*/


//+++++++++++++++++++++++++++++++++++++++++++++++++++++
// POST传参序列化
//+++++++++++++++++++++++++++++++++++++++++++++++++++++
axios.interceptors.request.use(config => {
  if(config.method === 'post') {
    config.data = qs.stringify(config.data);
  }
  return config;
}, error => {
  console.log('错误的传参');
  return Promise.reject(error);
});

//+++++++++++++++++++++++++++++++++++++++++++++++++++++
// 返回状态判断
//+++++++++++++++++++++++++++++++++++++++++++++++++++++
axios.interceptors.response.use(res => {
  // HTTP 状态码
  if(200 !== res.status) {
    return Promise.reject(res);
  }
  return res;
}, error => {
  console.log('返回状态判断');
  Promise.reject(error);
});

//+++++++++++++++++++++++++++++++++++++++++++++++++++++
// 封装 POST 、 GET 请求
//+++++++++++++++++++++++++++++++++++++++++++++++++++++
// POST
const fetch = (url, params) => {
  return new Promise((resolve, reject) => {
    axios.post(url, params)
      .then(response => {
        resolve(response.data);
      }, err => {
        console.error(err);
      })
  })
}
// GET
const get = url => {
  return new Promise((resolve, reject) => {
    axios.get(url)
      .then(response => {
        resolve(response.data);
      }, err => {
        throw err;
      })
      .catch(error => {
        console.error(error);
      })
  })
}

// --------------------- 输出 -------------------------
export {
  get,
  fetch
}
