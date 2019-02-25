<?php
namespace tests\Once;

use LogService;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

/**
 * RabbitMQ 的相关使用
 * 官方包 https://packagist.org/packages/php-amqplib/php-amqplib
 * - 啥时候用MQ  https://blog.csdn.net/xybelieve1990/article/details/70313216
 * - Linux安装RabbitMQ  https://blog.csdn.net/nextyu/article/details/79250174
 * - 各种MQ选型对比  https://www.sojson.com/blog/48.html
 * - RabbitMQ的普通队列与镜像队列-底层原理 https://blog.csdn.net/wangming520liwei/article/details/79893763
 */

class AMQPTest extends \TestCase
{
    protected $exchange_name = 'yth.match'; // 交换机名
    protected $queue_name    = 'yth.queue.test'; // 队列名称
    protected $routing_key    = '*.*.test'; // 路由关键字(也可以省略)

    /**
     * 获取配置
     * @return 二维数组
     */
    protected function get_configs()
    {
        $host      = '192.168.199.170';
        $port      = 5672;
        $user      = 'yth';
        $password  = 'ythyth';
        $vhost     = '/';
        $config    = compact('host', 'port', 'user', 'password', 'vhost');
        $configs   = [];
        $configs[] = $config;
        return $configs;
    }

    /**
     * 推送到 RabbitMQ
     */
    public function test_amqp_productor()
    {
        LogService::info(__CLASS__ . '@' . __FUNCTION__ . '.start');
        $conn    = AMQPStreamConnection::create_connection($this->get_configs()); // 建立生产者与mq之间的连接
        $channel = $conn->channel(); // 在已连接基础上建立生产者与mq之间的通道
        // 将队列与某个交换机进行绑定，并使用路由关键字
        $channel->queue_bind($this->queue_name, $this->exchange_name, $this->routing_key);

        $body = json_encode(["name" => "HaleyLeoZhang", "birth_year" => 1996]);
        $msg  = new AMQPMessage($body, ['content_type' => 'text/plain', 'delivery_mode' => 2]); // 生成消息
        $channel->basic_publish($msg, $this->exchange_name, $this->routing_key); // 推送消息到某个交换机
        $channel->close();
        $conn->close();

        LogService::info(__CLASS__ . '@' . __FUNCTION__ . '.end');
    }

    /**
     * 从 RabbitMQ 消费数据
     */
    public function test_amqp_consumer()
    {

        LogService::info(__CLASS__ . '@' . __FUNCTION__ . '.start');
        $connection = AMQPStreamConnection::create_connection($this->get_configs()); // 建立生产者与mq之间的连接
        $channel    = $connection->channel();

        // 在接收消息的时候调用$callback函数
        $channel->basic_consume($this->queue_name, '', false, true, false, false, function ($msg) {
            LogService::info(__CLASS__ . '@' . __FUNCTION__ . '.消费数据.' . $msg->body);
            // 回调函数执行成功后，则自动返回 ACK
        });

        while (count($channel->callbacks)) {
            $channel->wait();
        }
    }

}
