<?php
/**
 * TcpServer.php
 * TcpServer
 * User: lixin
 * Date: 17-8-4
 */

namespace core\socket;


use core\LInstance;
use lib\CmdOutput;

class TcpServer implements ISocket
{
    /**
     * 链接id
     * @var array
     */
    public static $fds = [];


    /**
     * @var \swoole_server
     */
    private $_server;

    /**
     * TcpServer constructor.
     * @param string $host
     * @param int $port
     * @author lixin
     */
    public function __construct(string $host, int $port)
    {
        // TODO Socket的类型，支持TCP、UDP、TCP6、UDP6、UnixSocket Stream/Dgram 6种，暂时只支持TCP
        $this->_server = new \swoole_server($host, $port, SWOOLE_PROCESS, SWOOLE_SOCK_TCP);

        $this->_config();

        $this->_server->on('connect', function ($server, $fd) {
            // 保存链接id
            self::$fds[] = $fd;
        });

        $this->_server->on('receive', function ($server, $fd, $fromId, $data) {
            // client发送的数据
            LInstance::setStringInstance('request', $data);
            LInstance::getObjectInstance('router')->dispatchSocketAction();

        });

        $this->_server->on('close', function ($server, $fd) {
            CmdOutput::outputString("client {$fd} closed");
        });
        CmdOutput::outputString("Type: " . LInstance::getStringInstance('t') . "\t Listen: " . $host . ':' . $port);
    }

    /**
     * 发送消息
     * @param int $fd
     * @param string $msg
     * @author lixin
     */
    public function send(int $fd, string $msg)
    {
        $this->_server->send($fd, $msg);
    }

    /**
     * 关闭链接
     * @param int $fd
     * @author lixin
     */
    public function close(int $fd)
    {
        $this->_server->close($fd);
    }

    /**
     * 开始监听
     * @author lixin
     */
    public function start()
    {
        $this->_server->start();
    }

    private function _config()
    {
        $config = [
            // 此参数表示worker进程在处理完n次请求后结束运行。manager会重新创建一个worker进程。此选项用来防止worker进程内存溢出。
            'max_request' => 5000,
            // 设置启动的worker进程数量。swoole采用固定worker进程的模式。PHP代码中是全异步非阻塞，worker_num配置为CPU核数的1-4倍即可。
            // 如果是同步阻塞，worker_num配置为100或者更高，具体要看每次请求处理的耗时和操作系统负载状况。
            'worker_num' => 4,
            // 通过此参数来调节poll线程的数量，以充分利用多核 默认设置为CPU核数
            'reactor_num' => 2,
            // 加入此参数后，执行php server.php将转入后台作为守护进程运行
            'daemonize' => env('daemonize') ? true : false,
            // 此参数将决定最多同时有多少个待accept的连接
            'backlog' => 128,
            // 每隔多少秒检测一次，单位秒，Swoole会轮询所有TCP连接，将超过心跳时间的连接关闭掉
            'heartbeat_check_interval' => 30,
            // TCP连接的最大闲置时间，单位s , 如果某fd最后一次发包距离现在的时间超过
            'heartbeat_idle_time' => 60,
//            'task_worker_num' => 8, //异步任务进程
//            "task_max_request" => 10,
        ];
        $this->_server->set($config);
    }
}