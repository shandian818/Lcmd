<?php
/**
 * Index.php
 * 默认控制器
 * User: lixin
 * Date: 17-8-7
 */

namespace app\controller;


use core\BaseController;
use core\socket\ISocket;

class Index extends BaseController
{
    /**
     * @param \swoole_http_request $request
     * @param \swoole_http_response $response
     * @author lixin
     */
    public function index(\swoole_http_request $request, \swoole_http_response $response)
    {
        $response->end('Hello world');
        echo "Hello world";
    }

    /**
     * @param ISocket $socket
     * @param \swoole_websocket_frame $frame
     * @param array $request
     * @author lixin
     */
    public function testWebSocket(ISocket $socket, \swoole_websocket_frame $frame, array $request)
    {
        $socket->send($frame->fd, 'hello world');
    }
}