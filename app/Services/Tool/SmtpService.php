<?php
namespace App\Services\Tool;

// ----------------------------------------------------------------------
// 发送邮件
// ----------------------------------------------------------------------
// Link  : http://www.hlzblog.top/
// GITHUB: https://github.com/HaleyLeoZhang
// ----------------------------------------------------------------------
// composer require phpmailer/phpmailer
// ----------------------------------------------------------------------

// 引入自动加载函数
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class SmtpService
{
    const SEND_RESULT_FAILED  = false; // 发送成功
    const SEND_RESULT_SUCCESS = true; // 发送失败

    /**
     * 发送邮件方法
     * @param Array  : receivers  接收者信息
     * - 示例数据
     * [
     *     [
     *         'addr' => 'haleyleozhang@sohu.com', // 收件人名
     *         'name' => '报警机器人', // 收件人名称(可不填)
     *     ]
     * ];
     * @param String : title  标题
     * @param html   : content  邮件内容
     * @param Array  : files  附件
     * - 示例数据
     * [
     *     [
     *         'path' => '/data/logs/blog/bakups/blog_database_20191129_1125.tar.gz', // 附件地址(相对目录、或绝对目录均可)
     *         'name' => '11-25数据库备份文件', // 附件名
     *     ]
     * ];
     * @return Boolean: true发送成功 | false发送失败
     */
    public static function run($receivers, $title, $content, $files = [])
    {
        // 实例化PHPMailer核心类
        $mail = self::get_mail_obj();
        try {

            // 设置收件人邮箱地址 该方法有两个参数 第一个参数为收件人邮箱地址 第二参数为给该地址设置的昵称 不同的邮箱系统会自动进行处理变动 这里第二个参数的意义不大
            // 添加多个收件人 则多次调用方法即可
            // $mail->addAddress('xxx@163.com','lsgo在线通知');
            foreach ($receivers as $one) {
                $receiver_email = $one['addr'];
                $receiver_name  = $one['name'];
                $mail->addAddress($receiver_email, $receiver_name);
            }
            // 邮件名
            $mail->Subject = $title;
            // 邮件HTML内容
            $mail->Body = $content;
            // 为该邮件添加附件 该方法也有两个参数 第一个参数为附件存放的目录（相对目录、或绝对目录均可） 第二参数为在邮件附件中该附件的名称
            foreach ($files as $one) {
                $file_path = $one['path'];
                $file_name = $one['name'];
                $mail->addAttachment($file_path, $file_name);
            }
            $status = $mail->send(); // 错误日志的输出在 supervisor 对应日志中
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
        return $status;
    }

    private function __contruct()
    {}

    /**
     * 读取并返回配置信息（从数据库中，可扩展）
     * @return array
     */
    protected static function get_conf()
    {
        $tpl = [
            // 必填
            'Host'        => env('MAIL_HOST'), // 链接qq域名邮箱的服务器地址，    示例 smtp.163.com
            'FromName'    => env('MAIL_FORM_NAME'), // 你的昵称
            'From'        => env('MAIL_FROM_ADDRESS'), // smtp邮箱全称
            'Username'    => env('MAIL_USERNAME'), // smtp邮箱帐号，如果是qq邮箱则是qq号，如果是163邮箱：除去@163.com的部分
            'Password'    => env('MAIL_PASSWORD'), // smtp邮箱 授权码 cddbstebcoxgbhjc
            // 选填
            'Hostname'    => env('MAIL_HOSTNAME', 'localhost'), // 发出请求的域名
            'Port'        => env('MAIL_PORT', 465), // 通信端口
            'MailEncrypt' => env('MAIL_ENCRYPTION', 'ssl'), // 通信加密方式，默认 ssl
        ];
        return $tpl;
    }

    /**
     * 返回实例化对象
     * @return PHPMailer\PHPMailer\PHPMailer
     */
    protected static function get_mail_obj()
    {
        static $ins = null;
        if (null === $ins) {
            $config = self::get_conf();

            $ins = new PHPMailer();
            // 是否启用smtp的debug进行调试 开发环境建议开启 生产环境注释掉即可 默认关闭debug调试模式
            $ins->SMTPDebug = SMTP::DEBUG_OFF;; // 0-> 关闭  1-> errors and messages  2-> messages only
            // 使用smtp鉴权方式发送邮件
            $ins->isSMTP();
            // smtp需要鉴权 这个必须是true
            $ins->SMTPAuth = true;
            // 链接qq域名邮箱的服务器地址
            $ins->Host = $config['Host'];
            // 设置使用ssl加密方式登录鉴权
            $ins->SMTPSecure = $config['MailEncrypt'];
            // 设置ssl连接smtp服务器的远程服务器端口号，以前的默认是25，但是现在新的好像已经不可用了 可选465或587
            $ins->Port = $config['Port'];
            // 设置发件人的主机域 可有可无 默认为localhost 内容任意，建议使用你的域名
            $ins->Hostname = $config['Hostname'] ?? 'localhost';
            // 设置发送的邮件的编码
            $ins->CharSet = PHPMailer::CHARSET_UTF8;
            // 设置发件人a.邮箱 b.昵称
            $ins->setFrom($config['From'], $config['FromName']);
            // smtp登录的账号 这里填入字符串格式的qq号即可
            $ins->Username = $config['Username'];
            // smtp登录的密码 使用生成的授权码（就刚才叫你保存的最新的授权码）
            $ins->Password = $config['Password'];
            // 设置发件人邮箱地址 这里填入上述提到的“发件人邮箱”
            // 邮件正文是否为html编码 注意此处是一个方法 不再是属性 true或false
            $ins->isHTML(true);
        }
        return $ins;
    }

}
