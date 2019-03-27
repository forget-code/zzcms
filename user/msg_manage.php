<?php
include("../inc/conn.php");
include("check.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="main">
<?php
include("top.php");
?>
<div class="pagebody">
<div class="left">
<?php
include("left.php");
?>
</div>
<div class="right">
<?php
if (isset($_REQUEST["action"])){
$action=$_REQUEST["action"];
}else{
$action="";
}
if (isset($_REQUEST["id"])){
$id=$_REQUEST["id"];
}else{
$id="";
}

if ($action=="elite"){
	if ($id<>"" ){
	mysql_query("Update zzcms_msg set elite=0 ");//只有一条为1的
	mysql_query("update zzcms_msg set elite=1 where id='$id'");
}
echo "<script>location.href='msg_manage.php'</script>";	
}

if ($action=="del")
 {
	if ($id<>"" ){
	mysql_query("delete from zzcms_msg where id='$id'") ;
	}
	echo "<script>location.href='msg_manage.php'</script>";
}
?>
<script language="JavaScript" src="/js/gg.js"></script>
<script language="JavaScript" type="text/JavaScript">
function ConfirmDelBig()
{
   if(confirm("确定要删除吗？"))
     return true;
   else
     return false;	 
}
</script>

    <div class="admintitle">邮件/短信内容设置</div>
    <table width="100%" border="0" cellpadding="5" cellspacing="1">
  <tr> 
    <td align="center" class="border"><a href="msg.php?action=add">添加邮件/短信内容</a></td>
  </tr>
</table>
<?php
$sql="select * from zzcms_msg";
$rs=mysql_query($sql);
$row=mysql_num_rows($rs);
if (!$row){
echo "暂无信息";
}else{
?>
<table width="100%" border="0" cellpadding="3" cellspacing="1">
  <tr class="title"> 
    <td width="10%" height="25" align="center" class="border">ID</td>
    <td width="50%" align="center" class="border">内容</td>
    <td width="10%" align="center" class="border">默认短信模板</td>
    <td width="20%" height="20" align="center" class="border">操作选项</td>
  </tr>
  <?php
while($row = mysql_fetch_array($rs)){
?>
 <tr class="bgcolor1" onMouseOver="fSetBg(this)" onMouseOut="fReBg(this)">  
    <td height="22" align="center" ><?php echo $row["id"]?></td>
    <td height="22" align="center" ><?php echo $row["content"]?></td>
    <td height="22" align="center" ><?php
	if ($row["elite"]==1 ){ echo "默认模板";}
	?>
	
	</td>
    <td align="center"> 
	<a href="?action=elite&id=<?php echo $row["id"]?>">设为默认</a> 
	| <a href="msg.php?action=modify&id=<?php echo $row["id"]?>">修改</a> 
    | <a href="?action=del&id=<?php echo $row["id"]?>" onClick="return ConfirmDelBig();">删除</a></td>
  </tr>
<?php
}
?>
</table>
<?php
}
?>
</div>
</div>
</div>
</body>
</html>