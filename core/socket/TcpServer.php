<?php
/**
 * TcpServer.php
 * TcpServer
 * User: lixin
 * Date: 17-8-4
 */

namespace core\socket;


use core\Config;
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
            // TODO 分发
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

    /**
     * 配置TcpSocket
     * @author lixin
     */
    private function _config()
    {
        $config = Config::getInstance(BASEDIR);
        if (!empty($config['swoole']['tcp'])) {
            $this->_server->set($config['swoole']['tcp']);
        }
    }
}