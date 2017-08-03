<?php
/**
 * WebSocket.php
 * WebSocket
 * User: lixin
 * Date: 17-8-3
 */

namespace core\socket;


use exception\FrameException;

class WebSocket extends Socket
{
    public function __construct()
    {
        if (!extension_loaded('swoole')) {
            throw new FrameException('Plz install swoole first', 102);
        }
    }
}