<?php
/**
 * Init.php
 * 初始化
 * User: lixin
 * Date: 17-8-3
 */

namespace core;


use exception\FrameException;
use lib\CmdOutput;

class Init
{
    /**
     * @var Init init实例
     */
    protected static $_instance;

    /**
     * Init constructor.
     */
    protected function __construct()
    {
        //注册自动加载函数
        spl_autoload_register('\\core\\Init::autoload');
    }

    /**
     * 类的自动加载
     * @param string $class 带命名空间的类名
     * @author lixin
     */
    public static function autoload(string $class)
    {
        if (file_exists(BASEDIR . '/' . str_replace('\\', '/', $class) . '.php')) {
            include BASEDIR . '/' . str_replace('\\', '/', $class) . '.php';
        }
    }

    /**
     * 单例获得一个init实例
     * @return Init
     * @author lixin
     */
    public static function getInstance() : Init
    {
        if (empty(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function run()
    {
        // 获取命令行参数
        $option = getopt("h:p:t", ["help"]);
        if (!$option) {
            throw new FrameException('Plz check you input param, you can use --help to read menu', 101);
        }

        // 检查输入参数是否符合规范
        if (!$this->checkCmdParam($option)) {
            throw new FrameException('Plz check you input param, you can use --help to read menu', 101);
        }

        // 分发命令行参数
        $router = new Router();
        $router->dispatchOption();
    }

    /**
     * 检查输入参数
     * @param array $option getopt("h:p:t", ["help"]); 的返回值
     * @return bool
     * @throws FrameException
     * @author lixin
     */
    private function checkCmdParam(array $option) : bool
    {
        $helpString = "Usage:   php start.php -h HOST -p PORT -t TYPE \n\n";
        $helpString .= "-h \t HOST \t Server hostname (ex: 127.0.0.1).\n";
        $helpString .= "-p \t PORT \t Server port (ex: 9501).\n";
        $helpString .= "-t \t TYPE \t Socket type (ex: websocket), support[websocket, tcp, http].\n";

        if (isset($option['help'])) {
            echo $helpString;
            return true;
        }

        if (isset($option['h']) && isset($option['p']) && isset($option['t'])) {
            if (LInstance::setStringInstance('h', $option['h'])
                && LInstance::setStringInstance('p', $option['p'])
                && LInstance::setStringInstance('t', $option['t'])
            ) {
                return true;
            } else {
                throw new FrameException('Plz check you input param, you can use --help to read menu', 101);
            }
        }
    }
}