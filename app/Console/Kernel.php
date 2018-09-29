<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\SitemapRefreshCommand::class,
        \App\Console\Commands\BakSqlCommand::class,
        \App\Console\Commands\RsaFileCommand::class,
        \App\Console\Commands\SwooleCommond::class,
    ];

    /**
     * 定时说明
     * ->everyTenMinutes() // 每10分钟
     * ->everyFiveMinutes() // 每5分钟
     * ->dailyAt('03:00') // 固定时间：  时：分钟
     * ->cron('* * * * *') // 分（0～59） 时（0～23） 日（1～31） 月（1～12） 星期（0～7，0与7表示星期天）
     *
     * 请记得加入 crontab 定时任务，每分钟执行，示例：
     * /usr/local/bin/php /data/www/www.hlzblog.top/artisan schedule:run 1>> /dev/null 2>&1
     */

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $daily_clock = '03:00'; // 闲时时间
        // - 生成 Sitemap
        $schedule->command('sitemap:refresh daily')
            ->dailyAt($daily_clock)
            ->withoutOverlapping();
        // - 发送备份邮件
        $schedule->command('bak_sql')
            ->dailyAt($daily_clock)
            ->withoutOverlapping();

    }
}
