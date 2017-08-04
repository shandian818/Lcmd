<?php

/**
 * HttpServer.php
 * HttpServer
 * User: lixin
 * Date: 17-8-4
 */
namespace core\socket;

class HttpServer implements ISocket
{
    // TODO 
    public function __construct(string $host, int $port)
    {

    }

    public function send(int $fd, string $msg)
    {
        // TODO: Implement send() method.
    }

    public function close(int $fd)
    {
        // TODO: Implement close() method.
    }

    public function start()
    {
        // TODO: Implement start() method.
    }
}