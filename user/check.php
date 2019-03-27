<?php
if (!isset($_COOKIE["UserName"]) || !isset($_COOKIE["PassWord"])){
echo "<script>location.href='/user/login.php';</script>";
}else{
	$rs=mysql_query("select id,usersf,lastlogintime from zzcms_user where lockuser=0 and username='".$_COOKIE["UserName"]."' and password='".$_COOKIE["PassWord"]."'");
	$row=mysql_num_rows($rs);
		if (!$row){
		//if ($_COOKIE["UserName"]!=$_SESSION["UserName"] || $_COOKIE["PassWord"]!=$_SESSION["PassWord"]){//当记登录状态时，只有COOKIE，没有SESSION
		echo "<script>location.href='/user/login.php';</script>";
		}else{
		$row=mysql_fetch_array($rs);
		$usersf=$row['usersf'];//left.php中用
		$userid=$row['id'];//top中用
		$lastlogintime=$row['lastlogintime'];
		$username=$_COOKIE["UserName"];
		$password=$_COOKIE["PassWord"];
		mysql_query("UPDATE zzcms_user SET loginip = '".getip()."' WHERE username='".$_COOKIE["UserName"]."'");//更新最后登录IP
		if (strtotime(date("Y-m-d H:i:s"))-strtotime($lastlogintime)>3600*24){
		mysql_query("UPDATE zzcms_user SET totleRMB = totleRMB+".jf_login." WHERE username='".$_COOKIE["UserName"]."'");//登录时加积分
		mysql_query("insert into zzcms_pay (username,dowhat,RMB,mark,sendtime) values('".$_COOKIE["UserName"]."','每天登录用户中心送积分','+".jf_login."','','".date('Y-m-d H:i:s')."')");
		}
		mysql_query("UPDATE zzcms_user SET lastlogintime = '".date('Y-m-d H:i:s')."' WHERE username='".$_COOKIE["UserName"]."'");//更新最后登录时间
		}
}
?>