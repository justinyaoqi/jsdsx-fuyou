<?php

class A2Xml
{
    private $xml = null;

    function __construct()
    {
        $this->xml = new XmlWriter();
    }

    //数组转xml
    function toXml($data, $eIsArray = FALSE)
    {
        if (!$eIsArray) {
            $this->xml->openMemory();
        }
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $this->xml->startElement($key);
                $this->toXml($value, TRUE);
                $this->xml->endElement();
                continue;
            }
            $this->xml->writeElement($key, $value);
        }
        if (!$eIsArray) {
            $this->xml->endElement();
            return $this->xml->outputMemory(true);
        }
    }

    //签名加密流程
    function sign($data)
    {
        //读取密钥文件
        $pem = file_get_contents(dirname(__FILE__) . '/keypem.pem');
        //获取私钥
        $pkeyid = openssl_pkey_get_private($pem);
        //MD5WithRSA私钥加密
        openssl_sign($data, $sign, $pkeyid, OPENSSL_ALGO_MD5);
        //返回base64加密之后的数据
        $t = base64_encode($sign);
        //解密-1:error验证错误 1:correct验证成功 0:incorrect验证失败
        // $pubkey = openssl_pkey_get_public($pem);
        // $ok = openssl_verify($data,base64_decode($t),$pubkey,OPENSSL_ALGO_MD5);
        // var_dump($ok);
        return $t;
    }

    //通过curl模拟post的请求；
    function SendDataByCurl($url, $data)
    {
        //对空格进行转义
        $url = str_replace(' ', '+', $url);
        $ch = curl_init();
        //设置选项，包括URL
        curl_setopt($ch, CURLOPT_URL, "$url");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 3); //定义超时3秒钟
        // POST数据
        curl_setopt($ch, CURLOPT_POST, 1);
        // 把post的变量加上
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);  //所需传的数组用http_bulid_query()函数处理一下，就ok了
        //执行并获取url地址的内容
        $output = curl_exec($ch);
        $errorCode = curl_errno($ch);
        //释放curl句柄
        curl_close($ch);
        if (0 !== $errorCode) {
            return false;
        }
        return $output;
    }

}

$xml = new A2Xml();
$data = array();
$data['ins_cd'] = "08A9999999";
$data['mchnt_cd'] = "0002900F0370542";
$data['goods_des'] = "描述";
$data['order_type'] = "WECHAT";
$data['order_amt'] = "2000";
$data['notify_url'] = "http://test.modernmasters.com/index.php/Supplier/User/myResources.html";


$data['addn_inf'] = "";
$data['curr_type'] = "CNY";
$data['term_id'] = "";
$data['goods_detail'] = "";
$data['goods_tag'] = "";
$data['version'] = "1";
$data['random_str'] = time();
$data['mchnt_order_no'] = time();
$data['term_ip'] = "117.29.110.187";
$data['txn_begin_ts'] = date('YmdHis', time());

//拼装过的需要签名的字符串串
$sign = "addn_inf=" . $data['addn_inf'] . "&curr_type=" . $data['curr_type'] . "&goods_des=" . $data['goods_des'] . "&goods_detail=" . $data['goods_detail'] . "&goods_tag=" . $data['goods_tag'] . "&ins_cd=" . $data['ins_cd'] . "&mchnt_cd=" . $data['mchnt_cd'] . "&mchnt_order_no=" . $data['mchnt_order_no'] . "&notify_url=" . $data['notify_url'] . "&order_amt=" . $data['order_amt'] . "&order_type=" . $data['order_type'] . "&random_str=" . $data['random_str'] . "&term_id=" . $data['term_id'] . "&term_ip=" . $data['term_ip'] . "&txn_begin_ts=" . $data['txn_begin_ts'] . "&version=" . $data['version'];


//RSAwithMD5+base64加密后得到的sign
$data['sign'] = $xml->sign($sign);

//完整的xml格式
$a = "<?xml version=\"1.0\" encoding=\"GBK\" standalone=\"yes\"?><xml>" . $xml->toXml($data) . "</xml>";

//经过两次urlencode()之后的字符串
$b = "req=" . urlencode(urlencode($a));

//通过curl的post方式发送接口请求 
$url = "http://116.239.4.195:28164/preCreate";

//返回的xml字符串        
$resultXml = URLdecode($xml->SendDataByCurl($url, $b));

//将xml转化成对象
$ob = simplexml_load_string($resultXml);

//输出结果
var_dump($ob);


?>