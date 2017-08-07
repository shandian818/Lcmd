<?php
/**
 * Log.php
 * 日志类
 * User: lixin
 * Date: 17-5-19
 * Monolog文档:https://github.com/Seldaek/monolog/blob/HEAD/doc/01-usage.md
 * example:
 * $log = new Log('name','warning',Log::FILE);
 * $log->warning('warning');
 */

namespace lib;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class Log
{
    /**
     * @var string 日志中显示的名字
     */
    private $_log_name = '';

    /**
     * @var Logger
     */
    public $_logger;

    /**
     * 日志写文件
     */
    const FILE = 1;

    /**
     * Log constructor.
     * @param string $logName 日志中显示的名字
     * @param int $type 处理日志类型 根据Log类的常量来做判断
     * @param string $logFileName 日志文件名
     * @author lixin
     */
    public function __construct($logName, $logFileName, $type= self::FILE)
    {
        $this->_log_name = $logName;
        $this->_logger = new Logger($logName);

        if ($type == self::FILE) {
            $this->logToFile(Logger::INFO, $logFileName);
        }
    }

    /**
     * 日志写文件
     * @param int $level 处理级别
     * @param string $logFileName 日志文件名
     * @author lixin
     * @example
     */
    public function logToFile($level, $logFileName)
    {
        $this->_logger->pushHandler(new StreamHandler(BASEDIR . '/log/'. $logFileName, $level));
    }

    /**
     * @param string $name Logger的方法名
     * @param mixed $arguments 参数
     * @author lixin
     */
    public function __call($name, $arguments)
    {
        $this->_logger->$name($arguments);
    }
}