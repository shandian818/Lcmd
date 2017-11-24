<?php
/**
 * Index.php
 * 默认控制器
 * User: lixin
 * Date: 17-8-7
 */

namespace app\controller;


use core\BaseController;

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
}