<?php

namespace Jsdsx\FuYou;

/**
 * Created by PhpStorm.
 * User: Yanlongli
 * Date: 2018年6月25日
 * Time: 上午 11:01
 * APPLICATION:江苏德司信支付接口核心文件
 */

use Jsdsx\FuYou\Support\Log;


/**
 * Class Kernel
 * @package Xdf\Pay
 */
class Kernel
{
    public static $lang;
    /**
     * @var Api
     */
    protected static $api = null;

    //配置文件路径
    protected $configPath = null;
    /**
     * @var array
     */
    private static $config = array();

    /**
     * 初始化配置信息
     * @param null $configPath
     */
    public function init($configPath=null)
    {
        if (!is_null($configPath)) {
            $this->configPath = $configPath;
        }
        //初始化语言包  默认为中文
        static::$lang = require __DIR__ . "/lang/" . self::getConfig('language', 'zh-cn') . '.php';
        //加载配置文件
        $this->loadConfig();
        //加载自定义语言包  默认为中文
        static::$lang = require __DIR__ . "/lang/" . self::getConfig('language', 'zh-cn') . '.php';
        //初始化时间为 特定区域
        date_default_timezone_set(static::$config['timezone']);
        Log::debug('kernel.init start');
    }

    /**
     * 加载配置文件
     */
    protected function loadConfig()
    {
        //加载指定配置文件
        if (!is_null($this->configPath)) {
            self::$config = require $this->configPath;
            Log::debug("loadConfig：" . $this->configPath . PHP_EOL);
            //加载本地化配置文件
        } else if (file_exists(realpath('.') . '/config-local.php')) {
            self::$config = require realpath('.') . '/config-local.php';
            Log::debug("loadConfig：" . realpath('.') . '/config-local.php' . PHP_EOL);
            //加载配置文件
        } else if (file_exists(realpath('.') . '/config.php')) {
            self::$config = require realpath('.') . '/config.php';
            Log::debug("loadConfig：" . realpath('.') . '/config.php' . PHP_EOL);
        } else {
            Log::error('无法加载配置文件，请放置config.php到特定目录' . PHP_EOL);
            exit(self::$lang['notFileConfig']);
        }
    }

    public static function getConfig($name, $defaultValue = null)
    {
        if (array_key_exists($name, static::$config)) {
            return static::$config[$name];
        }
        return $defaultValue;
    }

    public static function setConfig($name, $defaultValue = null)
    {
        if (array_key_exists($name, static::$config)) {
            return static::$config[$name] = $defaultValue;
        }
        return $defaultValue;
    }

    /**
     * @return Api
     */
    public static function getApi()
    {
        if (static::$api == null) {
            static::$api = new Api(self::$config);
            Log::debug('kernel.getApi');
        }
        return static::$api;
    }

}