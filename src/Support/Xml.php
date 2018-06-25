<?php

namespace Jsdsx\FuYou\Support;

/**
 * 构建请求xml
 */
class Xml
{
    static function arrayToXml($arr){
        $xml = "<?xml version=\"1.0\" encoding=\"GBK\" standalone=\"yes\"?><xml>";
        foreach ($arr as $key=>$val){
            if(is_array($val)){
                $xml.="<".$key.">".self::arrayToXml($val)."</".$key.">";
            }else{
                $xml.="<".$key.">".$val."</".$key.">";
            }
        }
        $xml.="</xml>";
        return $xml;
    }
}
