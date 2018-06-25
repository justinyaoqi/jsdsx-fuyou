<?php
/**
 * Created by PhpStorm.
 * User: Yanlongli
 * Date: 2018/4/4 0004
 * Time: 下午 12:52
 * APPLICATION:
 */

use Xdf\Pay\Kernel;
use Xdf\Pay\Support\Log;
use Xdf\Pay\XdfException;

require "../vendor/autoload.php";

$config = array();
//引入配置文件
if (file_exists( realpath('.').'/config-local.php')) {
    $config = require  realpath('.').'/config-local.php';
} else if (file_exists( realpath('.').'/config.php')) {
    $config = require  realpath('.').'/config.php';
} else {
    exit("中文：无法加载配置文件，请重试,ENGLISH：Configuration file does not exist,");
}

//实例化核心类
$xdf = new Kernel();
//初始化核心类
$xdf::init($config);

var_dump($http_response_header);
echo 'success';
try {
    //将收到的信息打印到日志
    Log::info("收到回调信息",['get'=>$_GET,'post'=>$_POST]);
    $postStr = $GLOBALS['HTTP_RAW_POST_DATA'];
    if (empty($postStr)){
        $postStr = file_get_contents('php://input');
    }
    Log::info("收到回调信息2",['ss'=>$postStr]);
} catch (XdfException $e) {
    //todo 预错处理

}
