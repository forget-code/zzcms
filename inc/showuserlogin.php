<?php
include("config.php");
include("function.php");
$style=$_REQUEST["style"];
switch ($style){
case "H";
	if (isset($_COOKIE["UserName"]) && isset($_COOKIE["PassWord"])){
		$str= "您好！<b>". $_COOKIE["UserName"]."</b>";			
		$str=$str . "&nbsp;[ <a href='".siteurl."/user/index.php'>进入用户中心</a>&nbsp;|&nbsp;<a href='".siteurl."/user/logout.php'>安全退出</a> ]&nbsp;";	
	}else{		
		$str="<img src='".siteurl."/image/user.gif'> ";
		$str=$str ."您好！客人 [<a href='".siteurl."/user/".getpageurl3("login")."' target='_blank'>请登陆</a>]&nbsp;[<a href='".siteurl."/reg/".getpageurl3("userreg")."' target='_blank'>免费注册</a>]&nbsp;";
		if (qqlogin=="Yes") {
		$str=$str ."<a href='".siteurl."/3/qq_connect2.0/index.php'><img src='".siteurl."/image/Connect_logo_2.png' border='0'></a>";
		}
	}
echo 'document.write ("'.$str.'");';//注意单双引号的写法
break;
	case "S";
	if (!isset($_COOKIE["UserName"]) || !isset($_COOKIE["PassWord"])){
	 $str="<form action='CheckLogin.php' method='post' name='UserLogin' onSubmit='return CheckUserForm();' target='_parent'>";
        $str=$str . "<div class='boxnoborder'><ul>";
		$str=$str . "<li>用&nbsp;户&nbsp;名：<input name='username' type='text' id='username' size='12' maxlength='14' class='biaodan' style='width:160px'></li>";
        $str=$str . "<li>密&nbsp;&nbsp;&nbsp;&nbsp;码：<input name='password' type='password' id='password' size='12' maxlength='14' class='biaodan' style='width:160px'></li>";
		$str=$str . "<li><input name='Login' type='submit' value='登 陆'> <input name='CookieDate' type='checkbox' id='CookieDate' value='1'>记住我的登录状态 </li>";
		//$str=$str . "&nbsp;<input name='reg' type='button' value='免费注册' class='buttonlogin' onClick='javascrpt:window.open(""/reg/userreg.php"")'>&nbsp;<input name='searchpass' type='button' value='找密码' class='buttonlogin' onClick='javascrpt:window.open(""/one/getpassword.php"")'>&nbsp;";
		$str=$str . "<input name='fromurl' type='hidden' value='".@$_SERVER['HTTP_REFERER']."' />";
		$str=$str . "</ul></div>";
		$str=$str . "</form>";
echo 'document.write ("'.$str.'");';//注意单双引号的写法
	}
break;
}
?>