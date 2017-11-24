<?php
/**
 * WebSocketChatDemo.php
 * websocket聊天demo
 * User: lixin
 * Date: 17-11-24
 */

namespace app\controller;


use core\WebSocketController;

class WebSocketChatDemo extends WebSocketController
{
    /**
     * @param array $request
     * @author lixin
     */
    public function testWebSocket(array $request)
    {
        $this->_socket->send($this->_frame->fd, 'hello world');
    }
}