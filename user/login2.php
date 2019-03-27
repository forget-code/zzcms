<?php
include("../inc/conn.php");
$fromurl="";
if (isset($_GET['fromurl'])){
$fromurl=$_GET['fromurl'];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title>用户登陆</title>
<style type="text/css">
<!--
body{margin:0;padding:0;font-size:12px}
.biaodan{height:18px;border:solid 1px #DDDDDD;width:150px;background-color:#FFFFFF}
-->
</style>
<script type="text/javascript" src="/js/jquery.js"></script>
<script>
$(function(){
$("#getcode_math").click(function(){
		$(this).attr("src",'/one/code_math.php?' + Math.random());
	});
});
</script>
<script language=javascript>
	function CheckUserForm()
	{
		if(document.UserLogin.username.value=="")
		{
			alert("请输入用户名！");
			document.UserLogin.username.focus();
			return false;
		}
		if(document.UserLogin.password.value == "")
		{
			alert("请输入密码！");
			document.UserLogin.password.focus();
			return false;
		}
			if(document.UserLogin.yzm.value == "")
		{
			alert("请输入验证问题的正确答案！");
			document.UserLogin.yzm.focus();
			return false;
		}
	}	
</script>
</head>
<body>

<form action='logincheck.php' method='post' name='UserLogin' onSubmit='return CheckUserForm();' target='_parent'>
<table width="100%" height="100" border="0" cellpadding="5" cellspacing="0">
      <tr>
        <td width="100" align="right"><label for="username">用户名</label></td>
        <td><input name="username" type="text" class="biaodan" id="username" tabindex="1" value="<?php  if (isset($_GET["username"])){ echo $_GET["username"];}?>" size="14" maxlength="255" />
        <a href="/reg/<?php echo getpageurl3("userreg")?>" target="_parent">注册用户</a></td>
      </tr>
      <tr>
        <td width="100" align="right"><label for="password">密码</label></td>
        <td><input name="password" type="password" class="biaodan" id="password" tabindex="2" size="14" maxlength="255" />
          <a href="/one/getpassword.php" target="_parent">找回密码</a></td>
      </tr>
      <tr>
        <td width="100" align="right"><label for="yzm">答案</label>        </td>
        <td><input name="yzm" type="text" id="yzm" value="" tabindex="3" size="10" maxlength="50" style="width:40px" class="biaodan"/>
        <img src="/one/code_math.php" align="absmiddle" id="getcode_math" title="看不清，点击换一张" /></td>
      </tr>
      <tr>
        <td width="100" align="right">&nbsp;</td>
        <td><input name="CookieDate[]" type="checkbox" id="CookieDate2" value="1">
          记住我的登陆状态
          <input name="fromurl" type="hidden" value="<?php echo $fromurl//这里是由上页JS跳转来的，无法用$_SERVER['HTTP_REFERER']?>" /></td>
      </tr>
      <tr>
        <td width="100" align="right">&nbsp;</td>
        <td><input type="submit" name="Submit" value="登 陆" tabindex="4" /></td>
      </tr>
    </table>
</form>
 <?php
mysql_close($conn);
?>			  
</body>
</html>
