<?php
/**
 * Created by PhpStorm.
 * User: Yanlongli
 * Date: 2018/4/4 0004
 * Time: 下午 12:52
 * APPLICATION:信达付接口配置文件-本地
 */

//富友支付接口配置文件

return array(

    //支付接口地址（富友分配）
    'interfaceAddress' => '',//详询FUIOU

    //支付回调地址
    'callback'=>'',//详询FUIOU

    //提交方式：post
    'method' => 'get',

    //字符编码：统一采用UTF-8字符编码
    'character' => 'UTF-8',//未启用

    //数据格式 json xml
    'dataType'=>'xml',

    'apiVersion'=>'1.0',

    //签名算法：RSA，兼容SHA1、SHA256、HMAC-SHA1  HMAC-SHA256 HMAC-MD5等
    'signature' => 'RSA',

    //提交信息签名或加密密钥
    'signatureKey' => '',//详询FUIOU
    //此处为服务提供方 提供返回信息签名验证或解密字段
    'signaturePublicKey'=>'',//详询FUIOU
//    'signaturePublicKey'=>'',//详询FUIOU

    //签名要求：请求和接收数据均需要校验签

    //机构号（富友分配）
    'organizationNumber' => '',//详询FUIOU

    //商户号
    'merchantNumber' => '',//详询FUIOU

    //语言包
    'language' => 'zh-cn',

    //时区  亚洲/上海
    'timezone'=>'Asia/Shanghai',

    //日志
    'log' => array(
        'class' => 'Jsdsx\FuYou\Support\Logger',
        'name' => 'jsdsx.fu_you',
        'level' => Monolog\Logger::DEBUG,//日志显示级别
        'file' => './fuyou.log',
    ),

);