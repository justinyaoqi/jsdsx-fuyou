# [FuYou SDK](http://blog.yanlongli.com)

一个简单易用的富友支付SDK。

>更多信息请访问 http://blog.yanlongli.com

开发者交流 QQ 群：`000000`

> 如果你认为功能不足，请自行下载源码进行扩展。

>请同意并遵循MIT开源协议，保留许可声明。

##使用教程  
```shel
	composer require jsdsx/fuyou
```
#### 如果你的项目没有使用composer

    请自行下载composer并进行update操作
    
    然后引入composer的自动加载类


## 特点

 - 官方方法简单封装，避免过度封装带来的额外学习成本以及影响扩展性;
 - 核心API类单文件，简单易用，隐藏开发者不需要关注的细节;
 - 抽象了消息事件，让你的控制器代码更优雅，扩展和维护更容易;
 - 详细的调试日志，让开发更轻松;
 - 支持PHP 5.3+、7.x版本;
 - 符合 [PSR](https://github.com/php-fig/fig-standards) 标准，非常方便与各主流PHP框架集成;

## 视频教程

> 无
>
## 在线文档
>[无]()

## 安装

环境要求：PHP >= 5.3


## 示例

查看demo中的示例  demo/demo.php 是演示demo

    请查看demo中的config-local.php

##常见问题

·当使用Qrcode生成二维码图片无法显示时，尝试使用ob_clean();清除缓存区
·回调地址 异步请求时，当结果集处理完毕后逆向请求地址
·跳转地址 同步请求第三方网站时，结果处理完毕跳转回本站地址
    
## 修正问题
	修正签名验证失败问题
	修正统一下单传递不参与签名字段

    
