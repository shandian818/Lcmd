<?php
/**
 * WebSocketController.php
 * WebSocket服务控制器
 * User: lixin
 * Date: 17-11-24
 */

namespace core;


use core\socket\ISocket;

class WebSocketController extends BaseController
{
    /**
     * @var ISocket
     */
    protected $_socket;

    /**
     * @var \swoole_websocket_frame
     */
    protected $_frame;
    
    /**
     * WebSocketController constructor.
     * @param ISocket $socket
     * @param \swoole_websocket_frame $frame
     * @author lixin
     */
    public function __construct(ISocket $socket, \swoole_websocket_frame $frame)
    {
        // 可以封装一些WebSocket通用逻辑
        $this->_socket = $socket;
        $this->_frame = $frame;
    }
}