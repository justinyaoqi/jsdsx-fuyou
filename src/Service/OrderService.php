<?php
/**
 * Created by PhpStorm.
 * User: Yanlongli
 * Date: 2018/6/25/0025
 * Time: 下午 5:04
 * APPLICATION:
 */

namespace Jsdsx\FuYou\Service;


use Jsdsx\FuYou\Kernel;

class OrderService extends BaseService
{
    /**
     * @param $order_sn string
     * @param $paymentType integer
     * @return array
     */
    static public function OrderQuery($order_sn, $paymentType)
    {
        $postData = [];
        $postData['version'] = Kernel::getApi()->apiVersion;
        $postData['ins_cd'] = Kernel::getApi()->organizationNumber;
        $postData['mchnt_cd'] = Kernel::getApi()->merchantNumber;
        $postData['term_id'] = '88888888';
        $postData['order_type'] = $paymentType;
        $postData['mchnt_order_no'] = $order_sn;
        $postData['random_str'] = md5(uniqid(mt_rand(), true));
//        $postData['sign'] = 'sign';
        return self::request('commonQuery', $postData);

    }

    /**
     * @param $order_sn
     * @param $paymentType
     * @param $refund_sn
     * @param $totalAmount
     * @param $refundAmount
     * @param $operatorId
     * @return array
     */
    static public function refund($order_sn,$paymentType,$refund_sn,$totalAmount,$refundAmount,$operatorId)
    {
        $postData = [];
        $postData['version'] = Kernel::getApi()->apiVersion;
        $postData['ins_cd'] = Kernel::getApi()->organizationNumber;
        $postData['mchnt_cd'] = Kernel::getApi()->merchantNumber;
        $postData['term_id'] = '88888888';
        $postData['mchnt_order_no'] = $order_sn;
        $postData['random_str'] = md5(uniqid(mt_rand(),true));
//        $postData['sign'] = 'sign';
        $postData['order_type'] = $paymentType;
        $postData['refund_order_no'] = $refund_sn;
        $postData['total_amt'] = $totalAmount;
        $postData['refund_amt'] = $refundAmount;
        $postData['operator_id'] = $operatorId;
//        $postData['reserved_fy_term_id'] = 'reserved_fy_term_id';

        return self::request('commonRefund', $postData);
    }
}