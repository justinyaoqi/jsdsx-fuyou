<?php
/**
 * Created by PhpStorm.
 * User: Yanlongli
 * Date: 2018年6月25日12:42:49
 * Time: 下午 1:21
 * APPLICATION:
 */

namespace Jsdsx\FuYou;

use Jsdsx\FuYou\Support\Signature;

/**
 * Class Api
 */
class Api
{
    //加密类型
    const SIGNATURE_TYPE_SHA256 = 'SHA256';
    const SIGNATURE_TYPE_HMAC = 'HMAC';
    const SIGNATURE_TYPE_MD5 = 'MD5';
    const SIGNATURE_TYPE_RSA = 'RSA';

    const PAYMENT_WECHAT = 'WECHAT';//微信
    const PAYMENT_ALIPAY = 'ALIPAY';//支付宝
    const PAYMENT_QQ = 'QQ';//QQ钱包
    const PAYMENT_UNIONPAY = 'UNIONPAY';//银联支付
    const PAYMENT_BESTPAY = 'BESTPAY';//中国电信（翼支付）

    public $organizationNumber;//机构号
    public $signature;//签名方式 当次请求的签名方式，对应SIGNATURE_TYPE_XX常量
    public $signatureKey;//签名密钥
    public $method;//请求方式
    public $interfaceAddress;//请求地址
    public $merchantNumber;//商户号
    public $apiVersion;//api接口版本号
    /**
     * @var array
     */
    public $transactionCode;//交易处理码集合

    public $domainCode;

    /**
     * Api constructor.
     * @param $config
     * @param string|null $interfaceAddress
     * @param string|null $method
     * @param string|null $signatureKey
     * @param string|null $signature
     * @param string|null $organizationNumber
     * @param string|null $merchantNumber
     * @param string|null $apiVersion
     */
    public function __construct($config, $interfaceAddress = null, $method = null, $signatureKey = null, $signature = null, $organizationNumber = null, $merchantNumber = null,$apiVersion = null)
    {
        if (is_array($config)) {
            extract($config, EXTR_OVERWRITE);
            $this->interfaceAddress = $interfaceAddress;
            $this->method = $method;
            $this->signatureKey = $signatureKey;
            $this->signature = $signature;
            $this->organizationNumber = $organizationNumber;
            $this->merchantNumber = $merchantNumber;
            $this->apiVersion = $apiVersion;
        }

        $this->transactionCode = require __DIR__ . '/config/transactionCode.php';
        $this->domainCode = require __DIR__ . '/config/domainCode.php';
    }

    /**
     * @param $data string|array
     * @return bool|string
     */
    function sign($data)
    {

        $dataStr = '';

        if (is_array($data)) {
            ksort($data);
            foreach ($data as $key=>$val){
                if($key=='sign' || substr($key,0,strlen('reserved')==='reserved')){
                    continue;
                }
                $dataStr .= '&'.$key.'='.$val;
            }
        }elseif(is_string($data)){
            $dataStr = $data;
        }else{
            return false;
        }
        $dataStr = ltrim($dataStr,'&');
        if (strtoupper($this->signature) == self::SIGNATURE_TYPE_RSA) {
            return Signature::RsaEncode($dataStr, $this->signatureKey, false);
        }

        if (strtoupper($this->signature) == self::SIGNATURE_TYPE_MD5) {
            return md5($dataStr);
        }

        return false;
    }


}