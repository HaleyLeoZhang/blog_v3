[官方站点](http://www.hlzblog.top/) | [法律声明](http://www.hlzblog.top/Info/law.html) | [留言给我](http://www.hlzblog.top/board)  

本次项目是基于 `Laravel 5` 系列框架开发的  
遵循 `PSR` 标准  
采用了多种设计模式  
重构了后端代码  

------

经过一段时间的线上使用  
目前功能已达到 `V1.0.0` 
因其含有部分不稳定的第三方API调用  
此次不保证 `/test` 路由组下的所有功能的稳定  

> 前台功能-PC-概览

![前台功能-PC-概览](https://i.loli.net/2019/09/19/rL8qK7meHFvEukS.png)    

> 前台功能-H5-概览

![前台功能-H5-概览](https://i.loli.net/2019/09/19/Ap61RcbLOT4kNDC.png)  

> 后台功能-概览

![后台功能-概览](https://i.loli.net/2019/09/19/VEsOKb254PxZgiD.png)  


> 下一版本迭代计划

- 将数据层与逻辑层分开
- 增加HTTP入参边缘数据限制

> 其他

[TODO](./readme_to_do.md)部分的内容  
根据这几年网站运营采集结果来看  
不会迭代太多功能进来了  
后续若有其他项目  
我将会写入一个CMS系统集中操作  
后台部分依旧会以`PHP`作为首选  
若你对我做所做的感兴趣  
请继续关注我的github主页  

![](https://i.loli.net/2019/11/26/zWPNA3CsvxhBTZe.png)  

------

## 目录结构

[查看详情](./readme_struct.md)  

## 初始帐号

 * 初始SQL : storage/backups 目录下 yth_blog.template.sql 与 yth_blog.template.sql
 * 登录入口: /admin/login
 * 初始帐号: test@hlzblog.top
 * 初始密码: 123123
 * 权限系统：[查看更多](public/static_pc/img/auth_readme/readme.md)  

## 关于博客的开发

 * [设计模式篇](http://www.hlzblog.top/article/64.html)
 * [前端自动化开发](http://www.hlzblog.top/article/45.html)

## 接口说明
本博客文档，基于[apidoc](http://apidocjs.com/)标准与生成  

    apidoc -i app/Http/Controllers/ -o public/doc

[点此查看接口文档](http://blog.doc.hlzblog.top)  

## 依赖相关
初始化项目  

~~~bash
#### 2022年5月1日
#### 因为该项目已存档，时间久远，有些第三方包仓库可能失效  
#### 当前 `vendor` 包已上传，不需要再通过`composer`下载
# 安装第三方扩展包
# - 请使用 1.9.3 的 composer 版本安装，具体下载方式，可参见 Makefile
#composer install --no-scripts
# 生成非对称密钥对
php artisan rsa_file
~~~

或者使用 `Makefile` 初始化项目  

~~~bash
make php
~~~


当你想在 VirtualBox 下开发时  

~~~bash
npm install --no-bin-links
gulp start
~~~

此外你可能还需要一些服务

 * redis --- 缓存、队列服务
 * nginx --- Web服务
 * mysql --- 目前在 5.7 版本 通过测试
 * php   --- 目前语法 在版本 7.4.3 通过测试
 * node  --- 如果你需要使用 Gulp 实现前端自动化
 * supervisor [详见](./storage/supervisor/readme.md)

## 单元测试

~~~bash
./phpunit
~~~
