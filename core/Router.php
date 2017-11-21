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
use lib\Log;
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
     * 分发Socket动作请求
     * @author lixin
     */
    public function dispatchSocketAction()
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
            CmdOutput::outputString("Request fail, miss controller or action. Param: " . $request);
        }
    }

    /**
     * 分发Http动作请求
     * @param \swoole_http_request $request
     * @param \swoole_http_response $response
     * @author lixin
     */
    public function dispatchHttpAction(\swoole_http_request $request, \swoole_http_response $response)
    {
        // TODO 检验参数 防止注入
        
        $config = Config::getInstance(BASEDIR);
        if (array_key_exists($request->server['request_uri'], $config['httpRouter'][$request->server['request_method']])) {
            $params = explode('@', $config['httpRouter'][$request->server['request_method']][$request->server['request_uri']]);
            $controller = "\\app\\controller\\" . $params[0];
            $action = $params[1];
            LInstance::setStringInstance('controller', $params[0]);
            LInstance::setStringInstance('action', $action);
            (new $controller)->$action($request, $response);
        } else {
            $log = Log::getLogHandler('Router');
            $log->warning('Request fail, miss controller or action. ',[
                'uri'=>$request->server['request_uri'],
                'request_method'=>$request->server['request_method'],
            ]);
         
            CmdOutput::outputString("Request fail, miss controller or action. Param: " . $request->server['request_uri']
                . "\t" . $request->server['request_method']);
            $response->end("<h1>404, Not Found</h1>");
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
        foreach ($requestData as $k => $v) {
            $requestData[$k] = htmlspecialchars($v);
        }
        return $requestData;
    }
}