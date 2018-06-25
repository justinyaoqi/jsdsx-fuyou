<?php
$privateKey = file_get_contents(__DIR__.'/private_key.pem');
$private_key = openssl_pkey_get_private($privateKey);
$ciphertext = $_POST['string'];
if(!empty($ciphertext)){
$bin_ciphertext = base64_decode($ciphertext);
openssl_private_decrypt($bin_ciphertext, $plaintext, $private_key, OPENSSL_PKCS1_PADDING);
echo "密文：<br/>".$ciphertext;
echo "解密：<br/>".$plaintext;
}
?>
<html>
<head>
<script src="BigInt.js" ></script>
<script src="Barrett.js" ></script>
<script src="RSA.js"></script>
<script language="JavaScript">
var key;
function bodyLoad()
{
	setMaxDigits(262);
	key = new RSAKeyPair(
		//这里是16进制数据
		"10001",
		"10001",
		//rsa public key 
		"EDA017EBA532CD23754813203F4026C78EB9089FB7DA16ABBC5220C87BEC3B3C9684E8181AE8AE56CBAEE40BA5B2778A9BA4B59FF6C4FFFEB086E4BC288CC00E970C4CE0BEFAD7ED23FFD6D86F5B2B400ED11F20CCFF67D9DF6DA8620EE5CA20741265A5AF51AE2EF0B1D3834F3E90D5545D12CA67B629332F349020C9A5789B01BA147870108FC436CEEB401DD0BEADA4E2F0DB6AB6D506E7D0AD1C947FCEF38346E82F6D6048D2683494DE8E515243FD1C750C6E6195436BB6FA1F0E4BF86471AB30B34C2FCEEB1DAE8937C0B8DB265AC1067FF6EC46402AA2853B8D69C157C3B08F165C1976E799801F29FBD18516AAAC3B94901284202DF1E941EB9FB86F",
	 	//
		2048
	);
}
function encryptString()
{
		//加密
	var ciphertext = encryptedString(key, document.subForm.string.value,
		RSAAPP.PKCS1Padding, RSAAPP.RawEncoding);
		//将转换后的HEX转换成ASIIC
	document.subForm.string.value = window.btoa(ciphertext);
		//控制台打印日志，调试使用
	console.log(document.subForm.string.value);
		//提交表单
	document.subForm.submit();
	
}

</script>
</head>
<body onload="bodyLoad()">
<div>这是一个RAS加密解密测试代码</div>
<form action="index.php" name="subForm" method="post">
<label>请输入字符串<input type="text" name="string" value="123456"/></label>
<input type="button" value="提交" onclick="encryptString()"/>
</form>
</body>
</html>