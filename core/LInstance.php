<?php
/**
 * LInstance.php
 * 单例类
 * @ex :
 * $cmdOutput = Load::getLib('\\lib\\CmdOutput');
 * $helpString = "Usage: php start.php -h HOST -p PORT -t TYPE";
 * echo $cmdOutput->getColoredString($helpString);
 * User: lixin
 * Date: 17-8-3
 */

namespace core;


class LInstance
{
    /**
     * @var array Load实例
     */
    protected static $_instance;


    /**
     * 获取lib里的类实例
     * @param string $libClassName 带命名空间的类名
     * @return mixed
     * @author lixin
     */
    public static function getLib(string $libClassName)
    {
        if (!isset(self::$_instance[$libClassName])) {
            self::$_instance[$libClassName] = new $libClassName();
        }
        return self::$_instance[$libClassName];
    }
}