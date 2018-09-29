<?php
namespace App\Services\Tool;

// ----------------------------------------------------------------------
// 带颜色的日志输出
// ----------------------------------------------------------------------
// Link  : http://www.hlzblog.top/
// GITHUB: https://github.com/HaleyLeoZhang
// ----------------------------------------------------------------------

class LogService
{

    // 初始信息配置
    protected static $_ini = [
        'switch'    => true, // Boolean  关 => false 开 => true
        'level'     => 1, // 该日志等级及以上，可以写入日志中
        'time_zone' => 'Asia/Chongqing', // 时区
        'path'      => 'logs', // 日志存放路径
        'log_name'  => 'laravel', // 日志文件名
        'overdue'   => 30, // 日志过期时间，单位天
        'suffix'    => '.log', // 日志文件名后缀
    ];

    /**
     * 日志名称与日志等级对照表
     * @param array $log_info
     */
    protected static $log_info = [
        'debug' => [ // 日志名称
            'level' => 1, // 日志等级
            'name'  => ' Debug  ', // 日记输出名 --- 所有同类型配置，字符串长度应该保持一致，不够长，使用空格补齐长度
            'color' => 'light_cyan', // 日志颜色
        ],
        'info'  => [
            'level' => 2,
            'name'  => ' Info   ',
            'color' => 'white',
        ],
        'warn'  => [
            'level' => 3,
            'name'  => ' Warn   ',
            'color' => 'yellow',
        ],
        'error' => [
            'level' => 4,
            'name'  => ' Error  ',
            'color' => 'light_red',
        ],
    ];

    /**
     * 日志类型名称，此项不同，日志信息会写入不同文件中
     */
    static $log_type = '';

    /**
     * 依据 $log_info 变量，对外开放的写入日志方法
     */
    public static function debug($info, $data = [])
    {
        self::run(__FUNCTION__, $info, $data);
    }

    /**
     * 依据 $log_info 变量，对外开放的写入日志方法
     */
    public static function info($info, $data = [])
    {
        self::run(__FUNCTION__, $info, $data);
    }

    /**
     * 依据 $log_info 变量，对外开放的写入日志方法
     */
    public static function warn($info, $data = [])
    {
        self::run(__FUNCTION__, $info, $data);
    }

    /**
     * 依据 $log_info 变量，对外开放的写入日志方法
     */
    public static function error($info, $data = [])
    {
        self::run(__FUNCTION__, $info, $data);
    }

    //------------------------------------------------------
    //      日志核心逻辑
    //------------------------------------------------------

    /**
     * 输出日志
     * @param string        $log_function_name  调用的函数名称
     * @param string        $info 日志信息
     * @param string|array  $data 日志信息附带日志
     */
    protected static function run($log_function_name, $info, $data)
    {
        // 覆盖配置
        $get_ini    = config('log_colored') ?? [];
        self::$_ini = array_merge(self::$_ini, $get_ini);
        // 日志开关
        if (self::$_ini['switch'] == false) {
            return;
        }
        // 日志写入资格
        if (self::$log_info[$log_function_name]['level'] < self::$_ini['level']) {
            return;
        }
        // 时区设置
        date_default_timezone_set(self::$_ini['time_zone']);

        $str   = date('Y-m-d H:i:s'); // 输出时间
        $name  = self::$log_info[$log_function_name]['name'];
        $color = self::$log_info[$log_function_name]['color'];
        // 获取 输出信息内容
        $data_str = '';
        if (count($data)) {
            $data_str = ' '.json_encode($data, JSON_UNESCAPED_UNICODE);
        }
        $info = $str . $name . $info . $data_str. "\n";
        $str  = self::getColoredString($info, $color);
        self::write($str);
    }

    /**
     * 追加写入日志
     * @param string $str  格式化后的日志信息
     */
    private static function write($str)
    {
        // 写入目录存在？
        $dir_path = self::$_ini['path'];
        if (!is_dir($dir_path)) {
            mkdir($dir_path, 0777, true);
        }
        // 追加写入文件
        $date      = date('Y-m-d');
        $file_path = self::get_log_file_name($date);
        $fp        = fopen($file_path, 'a+');
        fwrite($fp, $str);
        fclose($fp);
        self::del_overdue_log();
    }

    /**
     * 删除过期日志
     */
    private static function del_overdue_log()
    {
        $dir_path        = self::$_ini['path'];
        $overdue_time    = strtotime('-' . self::$_ini['overdue'] . ' day');
        $last_month_date = date('Y-m-d', $overdue_time);
        $file_path       = self::get_log_file_name($last_month_date);
        if (file_exists($file_path)) {
            @unlink($file_path);
        }
    }

    /**
     * 获取日志文件名
     * @param string $date 格式：date('Y-m-d')
     */
    private static function get_log_file_name($date)
    {
        $dir_path = self::$_ini['path'];
        if ('' == self::$_ini['log_name']) {
            $file_path = $dir_path . '/' . $date . self::$_ini['suffix'];
        } else {
            $file_path = $dir_path . '/' . self::$_ini['log_name'] . '-' . $date . self::$_ini['suffix'];
        }
        return $file_path;
    }

    //+++++++++++++++++++++++++++++++++++
    //      配色方案
    //+++++++++++++++++++++++++++++++++++

    private static $foreground_colors = [
        'black'        => '0;30',
        'dark_gray'    => '1;30',
        'blue'         => '0;34',
        'light_blue'   => '1;34',
        'green'        => '0;32',
        'light_green'  => '1;32',
        'cyan'         => '0;36',
        'light_cyan'   => '1;36',
        'red'          => '0;31',
        'light_red'    => '1;31',
        'purple'       => '0;35',
        'light_purple' => '1;35',
        'brown'        => '0;33',
        'yellow'       => '1;33',
        'light_gray'   => '0;37',
        'white'        => '1;37',
    ];
    private static $background_colors = [
        'black'      => '40',
        'red'        => '41',
        'green'      => '42',
        'yellow'     => '43',
        'blue'       => '44',
        'magenta'    => '45',
        'cyan'       => '46',
        'light_gray' => '47',
    ];

    /**
     * 返回可带背景色的有色字符串
     * @param string $str  格式化后的日志信息
     * @param string $foreground_color  字体色
     * @param string $background_color  背景色
     * @return string
     */
    private static function getColoredString($string, $foreground_color = null, $background_color = null)
    {
        $colored_string = "";
        // Check if given foreground color found
        if (isset(self::$foreground_colors[$foreground_color])) {
            $colored_string .= "\033[" . self::$foreground_colors[$foreground_color] . "m";
        }
        // Check if given background color found
        if (isset(self::$background_colors[$background_color])) {
            $colored_string .= "\033[" . self::$background_colors[$background_color] . "m";
        }
        // Add string and end coloring
        $colored_string .= $string . "\033[0m";
        return $colored_string;
    }

}

/*
示例：命令行下 发送邮箱后的
use Mine\Log;

LogService::$log_type = 'cli-email';
LogService::info('Send sql_bak file to the email success');

 */
