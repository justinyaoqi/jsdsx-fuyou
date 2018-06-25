# [XDF SDK](http://pfinal.cn)

一个简单易用的信达付支付SDK。

>更多信息请访问 https://www.x-d-f.com

开发者交流 QQ 群：`000000`

##使用教程  
```shel
	composer require xdf/pay
```
#### 如果你的项目没有使用composer

    请下载phpqrcode.php并引入
    引入demo/autoload.php并修正其内部路径


## 特点

 - 官方SDK简单封装，避免过度封装带来的额外学习成本以及影响扩展性;
 - 核心API类单文件，简单易用，隐藏开发者不需要关注的细节;
 - 抽象了消息事件，让你的控制器代码更优雅，扩展和维护更容易;
 - 详细的调试日志，让开发更轻松;
 - 支持PHP 5.3+、7.x版本;
 - 符合 [PSR](https://github.com/php-fig/fig-standards) 标准，非常方便与各主流PHP框架集成;

## 视频教程

> 无
>
## 在线文档
>[点击查看](http://pay.x-d-f.com/doc/xdf-posp-proxy/)

## 安装

环境要求：PHP >= 5.3


## 示例

查看demo中的示例  demo/demo.php 是演示demo

    //配置项 
    $config = new  array(
    
        //支付接口地址（信达付分配）
        'interfaceAddress'=>'http://lala.x-d-f.com/xdf-interface/request.jhtml',
    
        //提交方式：post
        'method'=>'post',
    
        //字符编码：统一采用UTF-8字符编码
        'character'=> 'UTF-8',
    
        //签名算法：MD5，后续会兼容SHA1、SHA256、HMAC-SHA1  HMAC-SHA256 HMAC-MD5等
        'signature'=>'MD5',
    
        //签名密钥
        'signatureKey'=>'123456',
    
        //签名要求：请求和接收数据均需要校验签
    
        //机构号（信达付分配）
        'organizationNumber'=>'',
    
        //商户号
        'merchantNumber'=>'',
    
        //语言包
        'language'=>'zh-cn',
    );
    //初始化
    Kernel::init($config);
    
    try {
        //获取扫码通道类型列表
        $list = ScanCodeService::getListScavengingChannelTypes();
        var_dump($list);
        //支付宝正扫 member scan seller
        $c = ScanCodeService::alipayM2S("123456789", "A10100050392342", "1");
        /**
         * 这里的Qrcode是来自于https://sourceforge.net/projects/phpqrcode/ 的开源项目  源文件名为phpqrcode.php
         */
        QRcode::png($c[62], false, 'L', 5, 2);
    
    } catch (\Xdf\Pay\XdfException $e) {
        //todo 预错处理
    
    }
    //获取通道列表
    
    ScanCodeService::getListScavengingChannelTypes();

##常见问题

·当使用Qrcode生成二维码图片无法显示时，尝试使用ob_clean();清除缓存区
·回调地址 异步请求时，当结果集处理完毕后逆向请求地址
·跳转地址 同步请求第三方网站时，结果处理完毕跳转回本站地址
    
## 修正问题
	2018年4月28日
	修正网关下单时3域交易参数错误问题
	修复提交方式被重写问题
	
	修正值为0时 empty导致不参与加密问题
	修正在linux服务器严格区分路径问题
	修正退款时请求行为参数错误问题

    
