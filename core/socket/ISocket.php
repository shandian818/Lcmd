<?php

/**
 * ISocket.php
 * socket接口
 * User: lixin
 * Date: 17-8-4
 */
namespace core\socket;

interface  ISocket
{
    // 发送消息
    public function send(int $fd,string $msg);

    // 关闭
    public function close(int $fd);

    // 开始
    public function start();
}