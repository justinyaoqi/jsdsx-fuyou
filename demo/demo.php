<?php

use Jsdsx\FuYou\Kernel;
use Jsdsx\FuYou\Service\ScanCodeService;

//header("Content-type:text/html;charset=GBK");
require "../vendor/autoload.php";
date_default_timezone_set('Asia/Shanghai');
//初始化核心类
$service = new Kernel();
$service->init();
if (!isset($_GET['type'])) {
    $_GET['type'] = '2';
}
//测试订单号：3ac85f48313c509bf185fe62330f4a
if ($_GET['type'] == '1') {
    $c = ScanCodeService::M2S(substr(md5(uniqid()), 1, 30), \Jsdsx\FuYou\Api::PAYMENT_ALIPAY, 1, '28256好商品', "28257商品描述");
    if($_GET['c']==2){
        echo '<a href="'.$c['qr_code'].'">去支付</a>';
        return;
    }
    if (isset($c['result_code']) && $c['result_code'] == '000000') {
        \PHPQRCode\QRcode::png($c['qr_code'], false, 'L', 4, 2);
    }
}
//var_dump($c);
if ($_GET['type'] == '2') {
    if (!isset($_GET['order_sn'])) {
        $a = <<<html

<form action="demo.php?type=2">
<input name="order_sn" placeholder="请输入订单号" />
<input type="hidden" name="type"value="2" />
<input type="submit" value="查订单">
</form>
<br/>
<form action="demo.php">
<input name="order_sn" placeholder="请输入订单号" />
<input type="hidden" name="type"value="3" />
<input type="submit" value="退款">
</form>
<br/>
<a href="demo.php?type=1">支付宝支付二维码</a> 
<br/>
<a href="demo.php?type=1&c=2">跳转支付</a> 
html;
        echo $a;
    } else {

        //查寻结果为支付成功
        $c = \Jsdsx\FuYou\Service\OrderService::OrderQuery($_GET['order_sn'], \Jsdsx\FuYou\Api::PAYMENT_ALIPAY);
        var_dump($c);
    }

}

if ($_GET['type'] == '3') {
    //申请退款  返回结果为成功
    $c = \Jsdsx\FuYou\Service\OrderService::refund($_GET['order_sn'], \Jsdsx\FuYou\Api::PAYMENT_ALIPAY, substr(md5(uniqid()),0,30), 1, 1, 1);
    var_dump($c);
}