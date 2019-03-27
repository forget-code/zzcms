<?php 
include("admin.php");
?>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td class="admintitle">QQ登陆设置</td>
  </tr>
</table>
<?php
if (isset($_POST["action"])){
$action=$_POST["action"];
}else{
$action="";
}
$fcontent=file_get_contents("../3/qq_connect2.0/API/comm/inc.php");
$json=json_decode($fcontent,true);//转换成数组
$appid=$json['appid'];//读取数组中的值
$appkey=$json['appkey'];
$callback=$json['callback'];

if ($action=="saveconfig") {
checkadminisdo("siteconfig");
	$fpath="../3/qq_connect2.0/API/comm/inc.php";
	$fp=fopen($fpath,"w+");//fopen()的其它开关请参看相关函数
	$fcontent=str_replace($appid,trim($_POST['appid']),$fcontent);
	$fcontent=str_replace($appkey,trim($_POST['appkey']),$fcontent);
	$fcontent=str_replace($callback,trim($_POST['callback']),$fcontent);
	$isok=fputs($fp,$fcontent);//把替换后的内容写入文件
	fclose($fp);
	if ($isok){
	$msg="ok";
	}else{
	$msg="失败";
	}
	echo  "<script>alert('".$msg."');location.href='?'</script>";
}
?>
<form method="POST" action="?" id="form1" name="form1">
  <table width="100%" border="0" cellpadding="5" cellspacing="0">
  
    <tr> 
      <td colspan="2" class="border2" style="text-align:center"><a href="http://connect.opensns.qq.com/apply" target="_blank" >审请接入</a></td>
    </tr>
    <tr> 
      <td width="30%" align="right" class="border">APP ID</td>
      <td width="70%" class="border"><input name="appid" type="text"  value="<?php echo $appid?>" size="40" maxlength="255"></td>
    </tr>
    <tr> 
      <td align="right" class="border">APP KEY</td>
      <td class="border"><input name="appkey" type="text"  value="<?php echo $appkey?>" size="40" maxlength="255"></td>
    </tr>
    <tr> 
      <td align="right" class="border">返回页地址</td>
      <td class="border"><input name="callback" type="text" id="qq_callback_url" value="<?php echo $callback?>" size="40" maxlength="255"></td>
    </tr>
    <tr> 
      <td align="right" class="border">&nbsp;</td>
      <td class="border"><input name="cmdSave422" type="submit" class="buttons" id="cmdSave422" value="保存设置" > 
        <input name="action" type="hidden" id="action" value="saveconfig"> </td>
    </tr>
  </table>
</form>
</body>
</html>