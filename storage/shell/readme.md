## 说明

每分钟跑一次框架自带的定时任务管理器  

~~~bash
* * * * * /usr/local/bin/php /data/www/site/www.hlzblog.top/artisan schedule:run 1>> /dev/null 2>&1
~~~