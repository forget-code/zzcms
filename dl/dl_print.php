<?php
if(!isset($_SESSION)){session_start();} 
include("../inc/conn.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<link href="/template/<?php echo siteskin?>/style.css" rel="stylesheet" type="text/css">
<title></title>
<script src="/js/msgbox.js" type="text/javascript" language="JavaScript"></script>
</head>
<body>
<?php
$founderr=0;
$ErrMsg="";
if (isset($_REQUEST['action'])){
$action=$_REQUEST['action'];
}else{
$action="";
}

if (!isset($_COOKIE["UserName"]) || $_COOKIE["UserName"]==""){
?>
<script>
MsgBox('用户登录','../user/login2.php?fromurl=<?php echo "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']?>',500,196,1);
</script>
<?php
exit;
}
$username="";
if (isset($_COOKIE["UserName"])){
$username=$_COOKIE["UserName"];
}
session_write_close();
$id="";
if(!empty($_POST['id'])){
    for($i=0; $i<count($_POST['id']);$i++){
    $id=$id.($_POST['id'][$i].',');
    }
	
}else{//如果为空直接取前几条
	$sql="select * from zzcms_dl where passed<>0 ";
	if (liuyanysnum!=0){
	$liuyanysnum=liuyanysnum*3600*24;
	$sql=$sql. " and id not in (select id from zzcms_dl where savergroupid>1 and unix_timestamp()-unix_timestamp(sendtime)<$liuyanysnum) order by id desc limit 0,10";
	}
	$rs = mysql_query($sql);
	while($row= mysql_fetch_array($rs)){
	$id=$id. $row["id"].',';
	}
}
$id=substr($id,0,strlen($id)-1);//去除最后面的","
if (!isset($id) || $id==""){
echo "<script>alert('操作失败！至少要选中一条信息。');history.back()</script>";
}else{
    if (strpos($id,",")>0){
	$sql="select * from zzcms_dl where passed=1 and id in (". $id .") ";
	}else{
	$sql="select * from zzcms_dl where passed=1  and id=".$id." order by id desc";
	}
}
?>
<div class="main">
<?php
if (check_user_power("dls_print")=="no"){
$founderr=1;
$ErrMsg=$ErrMsg."<li>您所在的用户组没有打印".channeldl."信息的权限！<br><input  type=button value=升级成VIP会员 onclick=\"location.href='/one/vipuser.php'\"/></li>";
}

//判断查看代理条数
$rslookedlsnumber=mysql_query( "select looked_dls_number_oneday from zzcms_usergroup where groupid=(select groupid from zzcms_user where username='".$username."')");
$rown=mysql_fetch_array($rslookedlsnumber);
$lookedlsnumber=$rown["looked_dls_number_oneday"];

$rslookedlsnumbers=mysql_query("select looked_dls_number_oneday from zzcms_looked_dls_number_oneday where username='".$username."' and  timestampdiff(day,sendtime,now()) < 3600*24 ");
$rown=mysql_num_rows($rslookedlsnumbers);
if ($rown){
	if ($rown["looked_dls_number_oneday"]+$i>$lookedlsnumber){
	$founderr=1;
	$ErrMsg="<li>您所在的用户组每天只能查看 ".$lookedlsnumber." 条".channeldl."信息<br><input type=button value=升级为高级会员 onClick=\"location.href='/one/vipuser.php'\"/></li>";
	}
}

if ($founderr==1){
WriteErrMsg($ErrMsg);
}else{
	$rslooked=mysql_query("select * from zzcms_looked_dls_number_oneday where username='".$username."'");
	$rown=mysql_num_rows($rslooked);
	if (!$rown){
	mysql_query("insert into zzcms_looked_dls_number_oneday (looked_dls_number_oneday,username,sendtime)values(1,'".$username."','".date('Y-m-d H:i:s')."') ");
	}else{
		if (time()-strtotime($rown["sendtime"])<3600*24){
		mysql_query("update zzcms_looked_dls_number_oneday set looked_dls_number_oneday=looked_dls_number_oneday+".$i." where username='".$username."'");
		}else{
		mysql_query("update zzcms_looked_dls_number_oneday set looked_dls_number_oneday=".$i.",sendtime='".date('Y-m-d H:i:s')."' where username='".$username."'");
		}
	}
	
$rs=mysql_query($sql,$conn);
echo "<div style=text-align:center><a href='javascript:window.print()'><img src='/image/ico-dy.gif' width='18' height='17' border='0'>打印</a></div>";
$table="<table width=100% cellspacing=0 cellpadding=0 border=0>";
$table=$table."<tr>";
$table=$table."<td width=8% height=30 align=center class=x><strong>序号</strong></td>";
$table=$table."<td width=12%  class=x><b>".channeldl."人</b></td>";
$table=$table."<td width=15%  class=x><b>电话</b></td>";
$table=$table."<td width=22%  class=x><b>".channeldl."产品</b></td>";
$table=$table."<td width=19%   class=x><b>".channeldl."区域</b></td>";
$table=$table."<td width=24%  class=x><b>发布时间</b></td>";
$table=$table."</tr>";
$i=1;
while ($row=mysql_fetch_array($rs)){
$table=$table."<tr>\n";
$table=$table."<td width=8% height=30 align=center>".$i."</td>\n";
$table=$table."<td width=12%>".$row['dlsname']."</td>\n";
$table=$table."<td width=15%>".$row['tel']."</td>\n";
$table=$table."<td width=22%>".$row['cp']."</td>\n";
$table=$table."<td width=19%>".$row['province'].$row['city']."</td>\n";
$table=$table."<td width=24% >".$row['sendtime']."</td>\n";
$table=$table."</tr>\n";
$table=$table."<tr><td colspan=6 class=x height=1>&nbsp;</td></tr>\n";
$i=$i+1;
}
$table=$table."</table>";
echo $table;
}
?>