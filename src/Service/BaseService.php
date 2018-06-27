<?php
/**
 * Created by PhpStorm.
 * User: Yanlongli
 * Date: 2018/4/4 0004
 * Time: 下午 2:32
 * APPLICATION:
 */

namespace Jsdsx\FuYou\Service;


use Jsdsx\FuYou\JsdsxException;
use Jsdsx\FuYou\Kernel;
use Jsdsx\FuYou\Support\Curl;
use Jsdsx\FuYou\Support\Json;
use Jsdsx\FuYou\Support\Log;
use Jsdsx\FuYou\Support\Xml;

class BaseService
{
    /**
     * @param null $data
     * @param bool $Encode
     * @param string $method
     * @param string $extendUrl
     * @return array
     */
    protected static function request($extendUrl = '',$data = null, $Encode = true, $method = '')
    {
        if (!empty($data)) {
            $data['sign'] = Kernel::getApi()->sign($data);
            ksort($data);//对数组按照key重新排序，兼容不按顺序写入数据
        }
        if ($Encode) {
            if(strtoupper(Kernel::getConfig('dataType'))=='XML')
            $data = Xml::arrayToXml($data);
        }
        //如传递了请求方式，怎使用，否则用配置方式
        $method = $method ? $method : Kernel::getApi()->method;
        //如配置请求方式无效，则根据data是否有数据选定请求方式，无get，有post
        if (!$method) {
            $method = is_null($data) ? 'get' : 'post';
        }
        //url解码，gbk转utf-8
//        $result = urldecode(Curl::execute(Kernel::getApi()->interfaceAddress, $method, ['req'=>urlencode(($data))]));
//        $result = iconv("GBK", "UTF-8//IGNORE", urldecode(Curl::execute(Kernel::getApi()->interfaceAddress.$extendUrl, $method, ['req'=>urlencode(urlencode($data))])));
        $result = urldecode(Curl::execute(Kernel::getApi()->interfaceAddress.$extendUrl, $method, ['req'=>urlencode(urlencode($data))]));
        Log::debug('url：' . Kernel::getApi()->interfaceAddress, ['result' => $result]);
//        $result = urldecode($result);
        //校验数据完整性和签名
        $result = simplexml_load_string(substr($result,strpos($result,'>')+1));
//        self::checkData($result);
        return json_decode(json_encode($result),true);
    }


    /**
     * 校验数据完整性和签名是否正确
     * @param $result
     * @return array
     */
    public static function checkData($result)
    {

    }
}