<?php
/**
 * SocketFactory.php
 * SocketFactory
 * User: lixin
 * Date: 17-8-3
 */

namespace core\socket;


use exception\FrameException;

class SocketFactory
{
    /**
     * @param string $host
     * @param int $port
     * @param string $type
     * @return ISocket
     * @throws FrameException
     * @author lixin
     */
    public static function createSocket(string $host, int $port, string $type) : ISocket
    {
        switch ($type) {
            case 'websocket':
                return new WebSocket($host, $port);
                break;
            case 'http':
                echo "Plz wait for us, we will update soon \n";
                return new HttpServer($host, $port);
                break;
            case 'tcp':
                echo "Plz wait for us, we will update soon \n";
                return new TcpServer($host, $port);
                break;
            default:
                throw new FrameException('Plz check you input param, you can use --help to read menu', 101);
                break;
        }
    }
}