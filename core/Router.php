<?php
/**
 * Router.php
 * 路由
 * User: lixin
 * Date: 17-8-3
 */

namespace core;


use core\socket\SocketFactory;
use exception\FrameException;
use lib\ParseParam;

class Router
{
    public function __construct()
    {

    }

    /**
     * 分发option 创建对应socket
     * @throws FrameException
     * @author lixin
     */
    public function dispatchOption()
    {
        $host = LInstance::getStringInstance('h');
        $port = LInstance::getStringInstance('p');
        $type = LInstance::getStringInstance('t');

        // 检查传参是否有空
        if (empty($host) || empty($port) || empty($type)) {
            throw new FrameException('Plz check you input param, you can use --help to read menu', 101);
        }

        // 检查ip
        if (!ParseParam::isIp($host)) {
            throw new FrameException('Plz check you input param, you can use --help to read menu', 101);
        }
        
        $socket = SocketFactory::createSocket($host,$port,$type);
       
        $socket->start();
    }
}