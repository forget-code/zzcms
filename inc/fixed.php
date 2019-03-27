<?php
function fixed($str){
//checkver($str);
if (strpos($str,"{#showad:")!==false){
$n=count(explode("{#showad:",$str));//循环之前取值
	for ($i=1;$i<$n;$i++){ 
	$cs=strbetween($str,"{#showad:","}");
	if ($cs<>''){
	$css=explode(",",$cs); //分解成数组，得到每个参数的值 
	if(count($css)<11){
	WriteErrMsg( "当前页模板中 <span style='color:red;font-size:14px'>{#showad:".$cs."}</span> 广告调用标签少参数，请参考 <a href='http://www.zzcms.net/zx/show-93.htm' target='_blank'>【参数说明】</a> 添加缺少的参数");
	exit;
	}
	$str=str_replace("{#showad:".$cs."}",showad($css[0],$css[1],$css[2],$css[3],$css[4],$css[5],$css[6],$css[7],$css[8],$css[9],$css[10]),$str);	
	}
	}
}
if (strpos($str,"{#showzx:")!==false){
$n=count(explode("{#showzx:",$str));
	for ($i=1;$i<$n;$i++){ 
	$cs=strbetween($str,"{#showzx:","}");
	//echo $cs."<br>";
	if ($cs<>''){
	$css=explode(",",$cs);
	$str=str_replace("{#showzx:".$cs."}",showzx($css[0],$css[1],$css[2],$css[3]),$str);
	}
	}
}
if (strpos($str,"{#showzs:")!==false){
$n=count(explode("{#showzs:",$str));
	for ($i=1;$i<$n;$i++){ 
	$cs=strbetween($str,"{#showzs:","}");
	//echo $cs."<br>";
	if ($cs<>''){
	$css=explode(",",$cs); 
	$str=str_replace("{#showzs:".$cs."}",showzs($css[0],$css[1],$css[2],$css[3],$css[4],$css[5],$css[6],$css[7],$css[8],$css[9],$css[10]),$str);
	}
	}
}
if (strpos($str,"{#showpp:")!==false){
$n=count(explode("{#showpp:",$str));
	for ($i=1;$i<$n;$i++){ 
	$cs=strbetween($str,"{#showpp:","}");
	//echo $cs."<br>";
	if ($cs<>''){
	$css=explode(",",$cs);  
	$str=str_replace("{#showpp:".$cs."}",showpp($css[0],$css[1],$css[2],$css[3],$css[4],$css[5],$css[6],$css[7],$css[8],$css[9],$css[10]),$str);
	}
	}
}
if (strpos($str,"{#showjob:")!==false){
$n=count(explode("{#showjob:",$str));
	for ($i=1;$i<$n;$i++){ 
	$cs=strbetween($str,"{#showjob:","}");
	//echo $cs."<br>";
	if ($cs<>''){
	$css=explode(",",$cs);
	$str=str_replace("{#showjob:".$cs."}",showjob($css[0],$css[1],$css[2]),$str);
	}
	}
}
if (strpos($str,"{#showannounce:")!==false){
$n=count(explode("{#showannounce:",$str));
	for ($i=1;$i<$n;$i++){ 
	$cs=strbetween($str,"{#showannounce:","}");
	//echo $cs;
	if ($cs<>''){
	$css=explode(",",$cs);  
	$str=str_replace("{#showannounce:".$cs."}",showannounce($css[0],$css[1]),$str);
	}
	}
}

if (strpos($str,"{#showcookiezs:")!==false){
$n=count(explode("{#showcookiezs:",$str));
	for ($i=1;$i<$n;$i++){ 
	$cs=strbetween($str,"{#showcookiezs:","}");
	//echo $cs;
	if ($cs<>''){
	$css=explode(",",$cs); 
	$str=str_replace("{#showcookiezs:".$cs."}",showcookieszs($css[0],$css[1],$css[2]),$str);
	}
	}
}

if (strpos($str,"{#zsclass:")!==false){
$n=count(explode("{#zsclass:",$str));
	for ($i=1;$i<$n;$i++){ 
	$cs=strbetween($str,"{#zsclass:","}");
	//echo $cs;
	$css=explode(",",$cs); 
	if(count($css)<12){
	WriteErrMsg( "当前页模板中 <span style='color:red;font-size:14px'>{#zsclass:".$cs."}</span> ".channelzs."类别调用标签少参数，请参考 <a href='http://www.zzcms.net/zx/show-93.htm' target='_blank'>【参数说明】</a> 添加缺少的参数");
	exit;
	}
	$str=str_replace("{#zsclass:".$cs."}",showzsclass($css[0],$css[1],$css[2],$css[3],$css[4],$css[5],$css[6],$css[7],$css[8],$css[9],$css[10],$css[11]),$str);
	}
}
if (strpos($str,"{#keyword:")!==false){
$n=count(explode("{#keyword:",$str));
	for ($i=1;$i<$n;$i++){ 
	$cs=strbetween($str,"{#keyword:","}");
	//echo $cs;
	$css=explode(",",$cs); 
	$str=str_replace("{#keyword:".$cs."}",showkeyword($css[0],$css[1],$css[2]),$str);
	}
}
if (strpos($str,"{#province:")!==false){
$n=count(explode("{#province:",$str));
	for ($i=1;$i<$n;$i++){ 
	$cs=strbetween($str,"{#province:","}");
	$css=explode(",",$cs);  
	$str=str_replace("{#province:".$cs."}",showprovince($css[0],$css[1]),$str);
	}
}
if (strpos($str,"{#sitecount:")!==false){
$n=count(explode("{#sitecount:",$str));
	for ($i=1;$i<$n;$i++){ 
	$cs=strbetween($str,"{#sitecount:","}");
	$css=explode(",",$cs);  
		if(count($css)<8){
		WriteErrMsg( "当前页模板中 <span style='color:red;font-size:14px'>{#sitecount:".$cs."}</span> 标签少参数，请参考 <a href='http://www.zzcms.net/zx/show-93.htm' target='_blank'>【参数说明】</a> 添加缺少的参数");
		}
	$str=str_replace("{#sitecount:".$cs."}",sitecount($css[0],$css[1],$css[2],$css[3],$css[4],$css[5],$css[6],$css[7]),$str);
	}
}
return $str;
}
?>