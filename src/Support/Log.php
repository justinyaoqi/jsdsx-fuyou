<?php

namespace Jsdsx\FuYou\Support;


use Jsdsx\FuYou\Kernel;

/**
 * Class Log
 * @package Jsdsx\FuYou\Support
 * @method void error(string $message,array $context = []) static 错误日志;
 * @method void debug(string $message,array $context = []) static 调试日志;
 * @method void info(string $message,array $context = []) static 普通日志;
 * @method void notice(string $message,array $context = []) static 普通日志;
 * @method void warning(string $message,array $context = []) static 普通日志;
 * @method void alert(string $message,array $context = []) static 普通日志;
 */
class Log
{
    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected static $logger = null;

    public static function __callStatic($name, $arguments)
    {
        self::init();
        return call_user_func_array(array(self::$logger, $name), $arguments);
    }

    private static function init()
    {
        if (static::$logger === null) {
            $config = Kernel::getConfig('log', array('class' => 'Jsdsx\FuYou\Support\Logger'));
            $class = $config['class'];
            unset($config['class']);
            static::$logger = new $class($config);
        }
    }
}
