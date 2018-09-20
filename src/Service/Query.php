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

class Query extends BaseService
{
    /**
     * @return array
     */
    public static function queryWithdrawAmt()
    {
        $postData = [];
        $postData['ins_cd'] = Kernel::getApi()->organizationNumber;
        $postData['mchnt_cd'] = Kernel::getApi()->merchantNumber;
        $postData['random_str'] = md5(uniqid(mt_rand(), true));
        return self::request(__FUNCTION__, $postData);
    }

    /**
     * @param $amt
     * @return array
     */
    public static function queryFeeAmt($amt)
    {
        $postData = [];
        $postData['ins_cd'] = Kernel::getApi()->organizationNumber;
        $postData['mchnt_cd'] = Kernel::getApi()->merchantNumber;
        $postData['random_str'] = md5(uniqid(mt_rand(), true));
        $postData['amt'] = $amt;
        return self::request(__FUNCTION__, $postData);
    }
    public static function withdraw($amt,$feeAmt)
    {
        $postData = [];
        $postData['ins_cd'] = Kernel::getApi()->organizationNumber;
        $postData['mchnt_cd'] = Kernel::getApi()->merchantNumber;
        $postData['random_str'] = md5(uniqid(mt_rand(), true));
        $postData['amt'] = $amt;
        $postData['fee_amt'] = $feeAmt;
        $postData['txn_type'] = 2;
        return self::request(__FUNCTION__, $postData);
    }

    public static function queryChnlPayAmt($start_date,$end_date,$start_index,$end_index)
    {
        $postData = [];
        $postData['ins_cd'] = Kernel::getApi()->organizationNumber;
        $postData['mchnt_cd'] = Kernel::getApi()->merchantNumber;
        $postData['random_str'] = md5(uniqid(mt_rand(), true));
        $postData['start_date'] = $start_date;
        $postData['end_date'] = $end_date;
        $postData['start_index'] = $start_index;
        $postData['end_index'] = $end_index;
        return self::request(__FUNCTION__, $postData);
    }
}