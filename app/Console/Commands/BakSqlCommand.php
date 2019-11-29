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
    protected $description = '
        每日SQL备份到邮箱
        对应系统需要
        shell_exec 与 exec 函数权限
    ';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        LogService::info(__CLASS__ . '.start');
        try {
            $this->shell_create_db_tar();
            $this->backups();
            ///
        } catch (\Exception $exception) {
            $result = [
                'file'    => $exception->getFile(),
                'line'    => $exception->getLine(),
                'message' => $exception->getMessage(),
            ];
            echo json_encode($result);
        }
        LogService::info(__CLASS__ . '.end');
    }

    const FILE_SUFFIX = '.tar.gz'; // 备份文件的文件后缀名
    const FILE_EXPIRE = 30; // 每次删除，指定天数前的备份文件
    const LOGO_SRC    = 'https://i.loli.net/2018/10/12/5bc0020f34867.jpg'; // 站点 LOGO 图片： 650px * 144px，采用图床
    // const LOGO_SRC    = 'http://img.cdn.hlzblog.top/17-11-1/90327252.jpg'; // 站点 LOGO 图片： 650px * 144px，备份用
    const MY_CNF_NAME = '.my.cnf'; // mysql配置文件写入用户家目录的根路径,则可以不再输入密码

    private function backups()
    {
        // 发送附件前，配置
        $last_day  = $this->get_last_day();
        $file_name = $last_day . self::FILE_SUFFIX;
        $receivers = [
            [
                'addr' => env('BAKUPS_SQL_TO_EMAIL', ''),
                'name' => '',
            ],
        ];
        $title     = 'blog v3 - 数据备份';
        $view_data = [
            'logo'      => self::LOGO_SRC,
            'file_name' => $file_name,
            'hostname'  => config('app.hostname'),
        ];
        $html_content = view('module.email.bak_sql', $view_data);
        $content      = htmlspecialchars($html_content); // HTML转义为字符串

        // - 获取附件，并投递邮件任务
        $path  = $this->get_file_real_path($file_name);
        $files = [
            [
                'path' => $path,
                'name' => $file_name,
            ],
        ];
        if (is_file($path)) {
            // - 发送文件
            $data    = compact('receivers', 'title', 'content', 'files');
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

    private function get_last_day()
    {
        $last_day = date("Ymd", strtotime("-1 day"));
        return $last_day;
    }

    /**
     * 获取备份文件在服务器内的绝对路径
     */
    private function get_file_real_path($file_name)
    {
        $file_path = storage_path('backups/' . $file_name);
        return $file_path;
    }

    private function create_temp_my_cnf()
    {
        $mysql_user     = env('AVATAR_DB_READ_USERNAME', 'root');
        $mysql_password = env('AVATAR_DB_READ_PASSWORD', '');

        $cnf_conf   = [];
        $cnf_conf[] = "[mysqldump]";
        $cnf_conf[] = "user=${mysql_user}";
        $cnf_conf[] = "password=${mysql_password}";

        $my_cnf_content = implode("\n", $cnf_conf);

        file_put_contents($this->get_my_cnf_path(), $my_cnf_content);
    }

    private function remove_temp_my_cnf()
    {
        unlink($this->get_my_cnf_path());
    }

    private function get_my_cnf_path()
    {
        $home = exec('echo $HOME');
        $path = $home . '/' . self::MY_CNF_NAME;
        return $path;
    }

    private function shell_create_db_tar()
    {
        $this->create_temp_my_cnf();

        $mysql_database_avatar      = env('AVATAR_DB_READ_DATABASE', '');
        $mysql_database_avatar_file = $this->get_file_real_path($mysql_database_avatar . '.sql');

        $mysql_database_ext      = env('EXT_DB_READ_DATABASE', '');
        $mysql_database_ext_file = $this->get_file_real_path($mysql_database_ext . '.sql');

        $shell_bak_db_avatar = "mysqldump ${mysql_database_avatar} > ${mysql_database_avatar_file}";
        $shell_bak_db_ext    = "mysqldump ${mysql_database_ext} > ${mysql_database_ext_file}";

        $result_bak_avatar = shell_exec($shell_bak_db_avatar);
        $result_bak_ext    = shell_exec($shell_bak_db_ext);

        $this->remove_temp_my_cnf();

        $last_day                      = $this->get_last_day();
        $target_tar_file               = $this->get_file_real_path("${last_day}" . self::FILE_SUFFIX);
        $shell_set_last_day_db_tar_bak = "tar -zcvPf ${target_tar_file} ${mysql_database_avatar_file} ${mysql_database_ext_file}";

        $result_bak_tar = shell_exec($shell_set_last_day_db_tar_bak);
        LogService::info('shell_create_db_tar.shell', compact('result_bak_tar'));

        $shell_remove_temp_db_avatar_bak_file = "rm -rf ${mysql_database_avatar_file}";
        $shell_remove_temp_db__ext_bak_file   = "rm -rf ${mysql_database_ext_file}";

        $result_remove_temp_db_avatar_bak_file = shell_exec($shell_remove_temp_db_avatar_bak_file);
        $result_remove_temp_db_ext_bak_file    = shell_exec($shell_remove_temp_db__ext_bak_file);

    }
}
