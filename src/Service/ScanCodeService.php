<?php
/**
 * Created by PhpStorm.
 * User: Yanlongli
 * Date: 2018/4/4 0004
 * Time: 下午 2:43
 * APPLICATION:扫码API
 */

namespace Jsdsx\FuYou\Service;


use Jsdsx\FuYou\Kernel;

class ScanCodeService extends BaseService
{
    /**
     * 消费者扫描商户提供二维码
     * memberscanseller 统一下单接口
     * @param $order_sn string 商户订单号
     * @param $paymentType
     * @param $price int|string 价格（分）
     * @param $goods_description
     * @param string $goods_detail
     * @return array
     */
    public static function M2S($order_sn, $paymentType, $price, $goods_description, $goods_detail = '')
    {
        $postData = [];
        $postData['version'] = Kernel::getApi()->apiVersion;
        $postData['ins_cd'] = Kernel::getApi()->organizationNumber;
        $postData['mchnt_cd'] = Kernel::getApi()->merchantNumber;
        $postData['term_id'] = '88888888';//没有实体终端填写88888888
        $postData['random_str'] = md5(uniqid(mt_rand(), true));//随机字符串
        $postData['order_type'] = $paymentType; //支付方式
        $postData['goods_des'] = iconv('UTF-8', 'GBK//IGNORE', $goods_description);//商品描述
        $postData['goods_detail'] = iconv('UTF-8', 'GBK//IGNORE', $goods_detail);;//商品详情
//        $postData['addn_inf'] = '';//附加数据
        $postData['mchnt_order_no'] = $order_sn;//商户订单号5-30
        $postData['curr_type'] = 'CNY';//货币类型
        $postData['order_amt'] = sprintf('%012s', $price);//补足12位
        $postData['term_ip'] = '127.0.0.1';//客户端ip
        $postData['txn_begin_ts'] = date('YmdHis', time());
//        $postData['goods_tag'] = '';//商品标签
        $postData['notify_url'] = Kernel::getConfig('callback');//异步回调地址
//        $postData['reserved_sub_appid'] = '';//无
//        $postData['reserved_limit_pay'] = '';//限制支付方式（）no_credit不能使用信用卡
//        $postData['reserved_expire_minute'] = '30';//交易关闭时间
//        $postData['reserved_fy_term_id'] = '';
//        $postData['reserved_fy_term_type'] = '4';
//        $postData['reserved_fy_term_sn'] = '';

        return self::request('preCreate', $postData);

    }

}