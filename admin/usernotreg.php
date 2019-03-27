<?php
include("admin.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<link href="style.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="/js/gg.js"></script>
</head>
<body>
<?php

checkadminisdo("userreg");

if (isset($_REQUEST["action"])){
$action=$_REQUEST["action"];
}else{
$action="";
}

if( isset($_GET["page"]) && $_GET["page"]!="") 
{
    $page=$_GET['page'];
}else{
    $page=1;
}
if (isset($_REQUEST["keyword"])){
$keyword=$_REQUEST["keyword"];
}else{
$keyword="";
}
if ($action=="del"){
$id="";
if(!empty($_POST['id'])){
    for($i=0; $i<count($_POST['id']);$i++){
    $id=$id.($_POST['id'][$i].',');
    }
	$id=substr($id,0,strlen($id)-1);//去除最后面的","
}

if ($id==""){
echo "script lanage='javascript'>alert('操作失败！至少要选中一条信息。');history.back();";
}else{
	 if (strpos($id,",")>0){
		$sql="delete from zzcms_usernoreg where id in (". $id .")";
	}else{
		$sql="delete from zzcms_usernoreg where id='$id'";
	}

mysql_query($sql);
echo "<script>location.href='?page=".$page."'</script>";
}
}
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td class="admintitle">未进行邮件验证的临时注册用户管理（应是注册机注册较多）</td>
  </tr>
</table>
<form name="form1" method="post" action="?">
<table width="100%" border="0" cellpadding="5" cellspacing="0" class="border">
  <tr> 
      <td> 用户名： 
        <input name="keyword" type="text" id="keyword" value="<?php echo $keyword?>"> 
        <input type="submit" name="Submit" value="查找"> 
      </td>
  </tr>
</table>
</form>
<?php
$page_size=pagesize_ht;  //每页多少条数据
$offset=($page-1)*$page_size;
$sql="select * from zzcms_usernoreg where id<>0 ";

if ($keyword<>"") {
	$sql=$sql. " and username like '%".$keyword."%' ";
}
$rs = mysql_query($sql,$conn); 
$totlenum= mysql_num_rows($rs);  
$totlepage=ceil($totlenum/$page_size);

$sql=$sql . " order by id desc limit $offset,$page_size";
$rs = mysql_query($sql,$conn); 
if(!$totlenum){
echo "暂无信息";
}else{

?>
<form name="myform" method="post" action="?action=del">
  <table width="100%" border="0" cellspacing="1" cellpadding="5">
    <tr> 
      <td width="64" align="center" class="border">选取</td>
      <td width="162" class="border">用户名</td>
      <td width="113" align="center" class="border">用户身份</td>
      <td width="220" align="center" class="border">公司名</td>
      <td width="81" align="center" class="border">联系人</td>
      <td width="84" align="center" class="border">电话</td>
      <td width="120" align="center" class="border">email</td>
      <td width="86" align="center" class="border">审请时间</td>
    </tr>
<?php
while($row = mysql_fetch_array($rs)){
?>
     <tr class="bgcolor1" onMouseOver="fSetBg(this)" onMouseOut="fReBg(this)">  
      <td width="64" align="center" class="docolor"> <input name="id[]" type="checkbox" id="id" value="<?php echo $row["id"]?>"></td>
      <td width="162" ><?php echo $row["username"]?></td>
      <td width="113" align="center" ><?php echo $row["usersf"]?> </td>
      <td width="220" align="center"><?php echo $row["comane"]?> </td>
      <td width="81" align="center"><?php echo $row["somane"]?></td>
      <td width="84" align="center"><?php echo $row["phone"]?></td>
      <td width="120" align="center"><?php echo $row["email"]?></td>
      <td width="86" align="center"><?php echo $row["regdate"]?></td>
    </tr>
<?php
}
?>
  </table>
  <table width="100%" border="0" cellpadding="5" cellspacing="0" class="border">
    <tr> 
      <td> <input name="chkAll" type="checkbox" id="chkAll" onClick="CheckAll(this.form)" value="checkbox">
        全选 
        <input name="submit"  type="submit" value="删除选中的信息" onClick="return ConfirmDel()"> 
        <input name="page" type="hidden" id="page" value="<%=CurrentPage%>"></td>
    </tr>
  </table>
</form>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="border">
  <tr> 
    <td width="55%" height="30" align="center"> 
	页次：<strong><font color="#CC0033"><?php echo $page?></font>/<?php echo $totlepage?>　</strong> 
      <strong><?php echo $page_size?></strong>条/页　共<strong><?php echo $totlenum ?></strong>条
<?php
		
		if ($page<>1) {
			echo "【<a href='?keyword=".$keyword."&page=1'>首页</a>】 ";
			echo "【<a href='?keyword=".$keyword."&page=".($page-1)."'>上一页</a>】 ";
		}else{
			echo "【首页】【上一页】";
		}
		if ($page<>$totlepage) {
			echo "【<a href='?keyword=".$keyword."&page=".($page+1)."'>下一页</a>】 ";
			echo "【<a href='?keyword=".$keyword."&page=".$totlepage."'>尾页</a>】 ";
		}else{
			echo "【下一页】【尾页】";
		}       
	?>
    </td>
  </tr>
</table>
<?php
}
mysql_close($conn);
?>
</body>
</html>