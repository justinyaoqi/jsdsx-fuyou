<?php

use Jsdsx\FuYou\Kernel;
use Jsdsx\FuYou\Service\ScanCodeService;

//header("Content-type:text/html;charset=GBK");
require "../vendor/autoload.php";
date_default_timezone_set('Asia/Shanghai');
//初始化核心类
$service = new Kernel();
$service->init(require_once 'config.php');
if (!isset($_GET['type'])) {
    $_GET['type'] = '2';
}
//测试订单号：3ac85f48313c509bf185fe62330f4a
if ($_GET['type'] == '1') {
//    var_dump(Kernel::getApi()->sign("addn_inf=&buyer_id=2088702923096592&ins_cd=08A9999999&mchnt_cd=0002900F0370542&mchnt_order_no=3ac85f48313c509bf185fe62330f4a&order_amt=1&order_type=ALIPAY&random_str=B9KGGWDVL8BE54XZ70QNH566IFQAFUHF&result_code=000000&result_msg=SUCCESS&term_id=88888888&trans_stat=REFUND&transaction_id=2018062521001004590547992686",true));
//    exit();
//    $c = \Jsdsx\FuYou\Service\H5Service::M2S("201814145741285415428412987515", \Jsdsx\FuYou\Api::PAYMENT_H5_WECHAT, 1, '28256好商品', "28257商品描述282931");
    $c = \Jsdsx\FuYou\Service\ScanCodeService::M2S("201814145741285415428412987514", \Jsdsx\FuYou\Api::PAYMENT_WECHAT, 1, 'ddasdaadbn', "28257商品描述282931");
//    $c = ScanCodeService::M2S(substr(md5(uniqid()), 1, 30), \Jsdsx\FuYou\Api::PAYMENT_ALIPAY, 1, '28256好商品', "28257商品描述");
    if(isset($_GET['c']) && $_GET['c']==2){
        var_dump($c);
//        var_dump(Kernel::getApi()->sign($c));
        var_dump(Kernel::getApi()->sign($c,true));
//                echo '<a href="'.$c['qr_code'].'">去支付</a>';
        return;
    }

       var_dump($c);

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
<form action="demo.php">
<input type="hidden" name="type"value="4" />
<input type="submit" value="查询可提现余额">
</form>
<form action="demo.php">
<input name="order_sn" placeholder="请输入提现金额" />
<input type="hidden" name="type"value="5" />
<input type="submit" value="查询手续费">
</form>
<form action="demo.php">
<input name="amt" placeholder="请输入提现金额" />
<input name="fee_amt" placeholder="手续费" />
<input type="hidden" name="type"value="6" />
<input type="submit" value="发起提现">
</form>
<form action="demo.php">
<input name="start_date" placeholder="开始时间" />
<input name="end_date" placeholder="开始时间" />
<input name="start_index" placeholder="开始序号" />
<input name="end_index" placeholder="结束序号" />
<input type="hidden" name="type"value="7" />
<input type="submit" value="发起提现">
</form>
<br/>
<a href="demo.php?type=1">被扫</a> 
<br/>
<a href="demo.php?type=1&c=2">跳转支付</a> 
html;
        echo $a;
    } else {

        //查寻结果为支付成功
        $c = \Jsdsx\FuYou\Service\OrderService::OrderQuery($_GET['order_sn'], \Jsdsx\FuYou\Api::PAYMENT_ALIPAY);
        var_dump($c);
        var_dump(Kernel::getApi()->sign($c,true)==true?'经过验证，该返回信息未经篡改，信息有效':'经过验证，该信息未通过验证，信息无效');
    }

}

if ($_GET['type'] == '3') {
    //申请退款  返回结果为成功
    $c = \Jsdsx\FuYou\Service\OrderService::refund($_GET['order_sn'], \Jsdsx\FuYou\Api::PAYMENT_ALIPAY, substr(md5(uniqid()),0,30), 1, 1, 1);
    var_dump($c);
}
if ($_GET['type'] == '4') {
    //查询可提现余额
    $c = \Jsdsx\FuYou\Service\Query::queryWithdrawAmt();
    var_dump($c);
}
if ($_GET['type'] == '5') {
    //查询可提现余额
    $c = \Jsdsx\FuYou\Service\Query::queryFeeAmt($_GET['order_sn']);
    var_dump($c);
}
if ($_GET['type'] == '6') {
    //发起提现
    $c = \Jsdsx\FuYou\Service\Query::withdraw($_GET['amt'],$_GET['fee_amt']);
    var_dump($c);
}
if ($_GET['type'] == '7') {
    //发起提现
    $c = \Jsdsx\FuYou\Service\Query::queryChnlPayAmt($_GET['start_date'],$_GET['end_date'],$_GET['start_index'],$_GET['end_index']);
    var_dump($c);
}