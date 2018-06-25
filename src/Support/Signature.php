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
    static public function RsaEncode($data, $pem, $public = true)
    {
        if ($public == false) {
            //拼装私钥
            $pem = "-----BEGIN RSA PRIVATE KEY-----\n$pem\n-----END RSA PRIVATE KEY-----\n";
            //获取私钥
            $pkeyid = openssl_pkey_get_private($pem);
        } else {
            //拼装公钥
            $pem = "-----BEGIN PUBLIC KEY-----\n$pem\n-----END PUBLIC KEY-----\n";
            //获取公钥
            $pkeyid = openssl_pkey_get_public($pem);
        }

        //MD5WithRSA私钥加密
        openssl_sign($data, $sign, $pkeyid, OPENSSL_ALGO_MD5);
        //返回base64加密之后的数据
        return base64_encode($sign);
    }
}