/**
* 这里是为了配置 Mutation 的，给事件 批量取名，  
* 然后在 module 中通过 `ES6`的变量的解构赋值
* 实现使用常量替代 Mutation 事件类型 
*/

// -----------------------------------------------------------:
//     公共
// -----------------------------------------------------------:
export const COMMON_TOKEN = 'COMMON_TOKEN'; // 用于权限鉴别的token值，多端使用的时候，这项有用
export const COMMON_SIDEBAR = 'COMMON_SIDEBAR'; // 收起/显示
export const COMMON_BOTTOMBAR_NAME = 'COMMON_BOTTOMBAR_NAME'; // 底部选中的导航名称
export const ARTICLE_ID = 'ARTICLE_ID'; // 当前文章id
