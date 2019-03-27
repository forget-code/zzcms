<?php
//echo $_SERVER['REQUEST_URI'];
if (@$_POST["action"]=="search"){
echo "<script>location.href='".@$_POST["lb"]."/search.php?keyword=".@$_POST["keyword"]."'</script>";
}
if (isset($_REQUEST["skin"])){
$siteskin=$_REQUEST["skin"];
}else{
$siteskin=siteskin;

//php判断客户端是否为手机  
if (isset($_COOKIE['agent'])){//获取js里的agent信息,使通一，
//echo $_COOKIE['agent'];
	if ($_COOKIE['agent']=='iPad'){//如果是IPAD还用管理员设定的模板
	$siteskin=siteskin;
	}else{
	$siteskin="mobile/".siteskin_mobile;//如果获取的值是其它的："Android","iPhone","SymbianOS","Windows Phone","iPod"，则启用手机模板
	}
}

}
function sitetop(){
global $siteskin,$b,$sx;//$sx zs_list.php页获取值，导航条中显示当前属性页样式
$channel=strtolower($_SERVER['REQUEST_URI']);
$channel=substr($channel,1,strpos($channel,'/',1)-1);
//echo $channel;
$fp=zzcmsroot."template/".$siteskin."/top.htm";

if (file_exists($fp)==false){
echo $fp.' no this template';
exit;
}

$f = fopen($fp,'r');
$strout = fread($f,filesize($fp));
fclose($f);
$strout=str_replace("{#siteskin}",$siteskin,$strout) ;
$strout=str_replace("{#sitename}",sitename,$strout) ;
$strout=str_replace("{#kftel}",kftel,$strout) ;
$strout=str_replace("{#kfqq}",kfqq,$strout) ;
$strout=str_replace("{#siteurl}",siteurl,$strout) ;
$strout=str_replace("{#logourl}",logourl,$strout);
$strout=str_replace("{#sitekeyword}",sitekeyword,$strout);
$strout=str_replace("{#channel}",$channel,$strout);
$strout=str_replace("{#channelname}",getchannelname($channel),$strout);
if ($channel=='zx'){
$strout=str_replace("{#bigclass}",zxbigclass($b),$strout);//招商显示页有调用subzx.php同用bigclass会出错，所以这里把资讯区分为zxbigclass
}else{
$strout=str_replace("{#bigclass}",bigclass($b),$strout);
}
if ($channel=='zs'||$channel=='zsclass'){
$strout=str_replace("{#shuxing}",showsx($sx),$strout);
}else{
$strout=str_replace("{#shuxing}","",$strout);
}
if (strpos("zs,dl,zh,company,zx,special,pp,job",$channel)!==false) {
$strout=str_replace("{#".$channel."_style}","class='current_search'",$strout);
$strout=str_replace("{#".$channel."_style2} style='display:none'","",$strout);
$strout=str_replace("{#nav".$channel."}","class='current'",$strout);//导航条换为当前样式
}else{	
$strout=str_replace("{#zs_style}","class='current_search'",$strout);
$strout=str_replace("{#zs_style2} style='display:none'","",$strout);
$strout=str_replace("{#navindex".$channel."}","class='current'",$strout);//导航条换为当前样式
}
return $strout;
}
?>