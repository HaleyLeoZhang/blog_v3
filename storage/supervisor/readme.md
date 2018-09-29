# 安装 supervisor

示例 Ubuntu 14 安装

    apt-get install -y supervisor

# 简述

一般用于管理监听进程  
进程挂掉的时候使得 对应监听进程 自动重启  
后文是配置示例，linux 通用  

## 移动文件

移动当前目录里以　`.conf` 结尾的文件到 `supervisor` 的配置目录下

    /etc/supervisor/conf.d

## 创建配置文件
示例：创建 `swoole` 监听脚本 的配置文件

在 `/etc/supervisor/conf.d` 下，创建

    swoole_websocket.conf

示例配置，以 www-data 用户 启动  
（注：涉及php交互的，最好与 nginx 保持相同的用户去运行，因为写入日志的文件可能需要一致的权限）

    [program:swoole_websocket]
    
    command     = /usr/local/bin/php /data/www/www.hlzblog.top/artisan swoole websocket 
    autorestart = true
    user        = www-data
    
    redirect_stderr         = true
    stdout_logfile_maxbytes = 10MB
    stdout_logfile_backups  = 1
    stdout_logfile          = /data/logs/supervisor/swoole_websocket.log

#### 参数说明

[program:子进程名] 这个就是咱们要管理的子进程了":"后面的是名字，最好与你编写的 `.conf` 文件保持一致  
`command` 这个就是我们的要启动进程的命令路径了  
`autorestart` 是否自动重启  
`user` 设置普通用户，可以用来管理该 listener 进程  
`redirect_stderr` 如果为true，则stderr的日志会被写入stdout日志文件中，默认为false，非必须设置  
`stdout_logfile_maxbytes` 日志文件最大大小  
`stdout_logfile_backups` 日志文件备份数量  
`stdout_logfile` 日志文件存放路径  

[更多参数说明](https://www.cnblogs.com/xuezhigu/p/7660203.html)  

## 配置结束

重启生效 

    supervisorctl reload  
