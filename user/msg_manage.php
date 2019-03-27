<?php
include("../inc/conn.php");
include("../inc/fy.php");
include("check.php");
$fpath="text/msg_manage.txt";
$fcontent=file_get_contents($fpath);
$f_array=explode("\n",$fcontent) ;
?>
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

if ($action=="del"){
	if ($id<>"" ){
	mysql_query("delete from zzcms_msg where id='$id'") ;
	}
	echo "<script>location.href='msg_manage.php'</script>";
}
?>
<script language="JavaScript" src="/js/gg.js"></script>
<div class="admintitle"><?php echo $f_array[0]?></div>
<div class="box center"><a href="msg.php?action=add"><?php echo $f_array[1]?></a></div>
<?php
$sql="select * from zzcms_msg";
$rs=mysql_query($sql);
$row=mysql_num_rows($rs);
if (!$row){
echo $f_array[2];
}else{
?>
<table width="100%" border="0" cellpadding="3" cellspacing="1">
  <tr class="title"> 
    <?php echo $f_array[3]?>
  </tr>
  <?php
while($row = mysql_fetch_array($rs)){
?>
 <tr class="bgcolor1" onMouseOver="fSetBg(this)" onMouseOut="fReBg(this)">  
    <td height="22" align="center" ><?php echo $row["id"]?></td>
    <td height="22" align="center" ><?php echo $row["content"]?></td>
    <td height="22" align="center" ><?php
	if ($row["elite"]==1 ){ echo  $f_array[4];}
	?>
	
	</td>
    <td align="center"> 
	<a href="?action=elite&id=<?php echo $row["id"]?>"><?php echo $f_array[5]?></a> 
	| <a href="msg.php?action=modify&id=<?php echo $row["id"]?>"><?php echo $f_array[6]?></a> 
    | <a href="?action=del&id=<?php echo $row["id"]?>" onClick="return ConfirmDel();"><?php echo $f_array[7]?></a></td>
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