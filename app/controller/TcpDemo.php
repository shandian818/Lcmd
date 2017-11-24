<?php
/**
 * TcpDemo.php
 * tcp服务测试
 * User: lixin
 * Date: 17-11-24
 */

namespace app\controller;


use core\TcpController;

class TcpDemo extends TcpController
{
    /**
     * @param array $request
     * @author lixin
     */
    public function test(array $request)
    {
        $this->_socket->send($this->_fd, 'hello world');
    }
}