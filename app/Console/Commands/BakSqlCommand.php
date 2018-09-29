<?php

namespace App\Console\Commands;

use App\Jobs\EmailJob;
use Illuminate\Console\Command;
use LogService;

class BakSqlCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bak_sql';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '每日SQL备份到邮箱';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        LogService::info(__CLASS__ . '.start');
        $this->backups();
        LogService::info(__CLASS__ . '.end');
    }

    const FILE_SUFFIX = '.tar.gz'; // 备份文件的文件后缀名
    const FILE_EXPIRE = 30; // 每次删除，指定天数前的备份文件
    const LOGO_SRC    = 'http://img.cdn.hlzblog.top/17-11-1/90327252.jpg'; // 站点 LOGO 图片： 650px * 144px

    public function backups()
    {
        // 发送附件前，配置
        $last_day      = date("Ymd", strtotime("-1 day"));
        $set_file_name = $last_day . self::FILE_SUFFIX;
        $to            = env('BAKUPS_SQL_TO_EMAIL', '');
        $title         = 'blog v2.1 - 数据备份';
        $view_data     = [
            'logo'      => self::LOGO_SRC,
            'file_name' => $set_file_name,
            'hostname'  => config('app.hostname'),
        ];
        $html_content = view('module.email.bak_sql', $view_data);
        $content      = htmlspecialchars($html_content); // HTML转义为字符串

        // - 获取附件，并投递邮件任务
        $path = $this->get_file_real_path($set_file_name);
        if (is_file($path)) {
            // - 发送文件
            $data    = compact('to', 'title', 'content', 'path', 'set_file_name');
            $job_obj = new EmailJob(EmailJob::TYPE_SEND_HTML, json_encode($data));
            $job     = $job_obj->onQueue(EmailJob::QUEUE_NAME);
            dispatch($job);
            // - 清除指定天数前的备份
            $old_day       = date("Ymd", strtotime("-" . self::FILE_EXPIRE . " day"));
            $old_file_name = $old_day . self::FILE_SUFFIX;
            $old_file_path = $this->get_file_real_path($old_file_name);
            @unlink($old_file_path);
            LogService::debug(__CLASS__ . '.info.success');
        } else {
            LogService::debug(__CLASS__ . '.info.fail  No such a sql_bak file');
        }

    }

    /**
     * 获取备份文件在服务器内的绝对路径
     */
    public function get_file_real_path($file_name)
    {
        $file_path = storage_path('backups/' . $file_name);
        LogService::debug('real_path.' . $file_path);
        return $file_path;
    }

}
