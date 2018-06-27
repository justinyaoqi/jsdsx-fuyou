<?php
/**
 * Created by PhpStorm.
 * User: Yanlongli
 * Date: 2018/6/25/0025
 * Time: 下午 12:27
 * APPLICATION:
 */

namespace Jsdsx\FuYou\Support;


class Signature
{
    /**
     * RSA签名并base64
     * @param $data
     * @param $pem
     * @param bool $private
     * @return string
     */
    static public function signature($data, $pem, $private = true)
    {

        //MD5WithRSA私钥加密 签名一般为私钥
        openssl_sign($data, $sign, self::pem($pem, !$private), OPENSSL_ALGO_MD5);
        //返回base64加密之后的数据
        return base64_encode($sign);
    }

    /**
     * 签名验证
     * 过滤签名中的\n换行及进行base64解码
     * @param $data string
     * @param $sign string
     * @param $pem string
     * @param bool $public
     * @return int
     */
    static public function verify($data, $sign, $pem, $public = true)
    {
        //验证签名有效性，验证一般为公钥
        return openssl_verify($data, base64_decode(str_replace("\n", "", $sign)), self::pem($pem, $public), OPENSSL_ALGO_MD5);
    }

    /**
     * RSA公钥私钥pkey获取
     * @param $pem
     * @param bool $public
     * @return bool|resource
     */
    protected static function pem($pem, $public = true)
    {
        if ($public == false) {
            //拼装私钥
            $pem = wordwrap($pem, 64, "\n", true);
            $pem = "-----BEGIN RSA PRIVATE KEY-----\n$pem\n-----END RSA PRIVATE KEY-----\n";
            //获取私钥
            return openssl_pkey_get_private($pem);
        } else {
            //拼装公钥
            $pem = wordwrap($pem, 64, "\n", true);
            $pem = "-----BEGIN PUBLIC KEY-----\n$pem\n-----END PUBLIC KEY-----\n";
            //获取公钥
            return openssl_pkey_get_public($pem);
        }
    }
}