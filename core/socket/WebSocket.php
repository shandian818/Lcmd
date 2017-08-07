<?php
/**
 * WebSocket.php
 * WebSocket
 * User: lixin
 * Date: 17-8-3
 */

namespace core\socket;

use core\LInstance;
use core\Router;
use lib\CmdOutput;

class WebSocket implements ISocket
{
    /**
     * @var \swoole_websocket_server
     */
    private $_server;

    /**
     * 链接id
     * @var array
     */
    public static $fds = [];

    /**
     * WebSocket constructor.
     * @param string $host
     * @param int $port
     * @author lixin
     */
    public function __construct(string $host, int $port)
    {
        $this->_server = new \swoole_websocket_server($host, $port);

        // 当WebSocket客户端与服务器建立连接并完成握手后会回调此函数
        $this->_server->on('open', function (\swoole_websocket_server $server, $request) {
            // 保存链接id
            self::$fds[] = $request->fd;
        });

        // 当服务器收到来自客户端的数据帧时会回调此函数
        $this->_server->on('message', function (\swoole_websocket_server $server, $frame) {
            // client发送的数据
            LInstance::setStringInstance('request', $frame->data);
            LInstance::getObjectInstance('router')->dispatchAction();
        });

        // 当服务器收到来自客户端的关闭链接请求时会回调此函数
        $this->_server->on('close', function (\swoole_websocket_server $server, $fd) {
            echo "client {$fd} closed\n";
        });

        CmdOutput::outputString("Type: " . LInstance::getStringInstance('t') . "\t Listen: " . $host . ':' . $port);
    }

    /**
     * 发送消息
     * @param int $fd client id
     * @param string $msg 消息
     * @author lixin
     */
    public function send(int $fd, string $msg)
    {
        $this->_server->push($fd, $msg);
    }

    /**
     * 关闭链接
     * @param int $fd client id
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
}