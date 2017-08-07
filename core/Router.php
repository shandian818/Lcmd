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
use lib\CmdOutput;
use lib\ParseParam;

class Router implements ILInstance
{
    /**
     * Router constructor.
     * @author lixin
     */
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

        $socket = SocketFactory::createSocket($host, $port, $type);

        $socket->start();
    }

    /**
     * 分发动作请求
     * @author lixin
     */
    public function dispatchAction()
    {
        $request = $this->_checkParam(json_decode(LInstance::getStringInstance('request'), true));
        
        // 请求中必须有controller和action字段
        if (isset($request['controller']) && !empty($request['controller'])
            && isset($request['action']) && !empty($request['action'])
        ) {
            $controller = "\\app\\controller\\" . $request['controller'];
            $action = $request['action'];
            (new $controller)->$action();
        } else {
            CmdOutput::outputString("Request fail, miss controller or action. Param: ". $request);
        }
    }

    /**
     * 过滤请求参数
     * @param array $requestData
     * @return bool
     * @author lixin
     */
    private function _checkParam(array $requestData) : bool
    {
        foreach ($requestData as $k => $v){
            $requestData[$k] = htmlspecialchars($v);
        }
        return $requestData;
    }
}