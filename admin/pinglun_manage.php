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

checkadminisdo("zxpinglun");
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
if (isset($_REQUEST["kind"])){
$kind=$_REQUEST["kind"];
}else{
$kind="";
}

if (isset($_REQUEST["shenhe"])){
$shenhe=$_REQUEST["shenhe"];
}else{
$shenhe="";
}
if (isset($_REQUEST["keyword"])){
$keyword=$_REQUEST["keyword"];
}else{
$keyword="";
}
if ($action<>""){
$id="";
if(!empty($_POST['id'])){
    for($i=0; $i<count($_POST['id']);$i++){
    $id=$id.($_POST['id'][$i].',');
    }
	$id=substr($id,0,strlen($id)-1);//去除最后面的","
}
if ($id==""){
echo "<script lanage='javascript'>alert('操作失败！至少要选中一条信息。');history.back()</script>";
}
}

if ($action=="pass"){
	 if (strpos($id,",")>0){
		$sql="update zzcms_pinglun set passed=1 where id in (". $id .")";
	}else{
		$sql="update zzcms_pinglun set passed=1 where id='$id'";
	}

mysql_query($sql);
echo "<script>location.href='?shenhe=no&keyword=".$keyword."&page=".$page."'</script>";
}

if ($action=="del"){
	 if (strpos($id,",")>0){
		$sql="delete from zzcms_pinglun where id in (". $id .")";
	}else{
		$sql="delete from zzcms_pinglun where id='$id'";
	}
mysql_query($sql);
echo "<script>location.href='?keyword=".$keyword."&page=".$page."'</script>";
}
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td class="admintitle">评论管理</td>
  </tr>
</table>
<form name="form1" method="post" action="?">
<table width="100%" border="0" cellpadding="5" cellspacing="0">
  <tr> 
      <td class="border"> 内容： 
        <input name="keyword" type="text" id="keyword" value="<?php echo $keyword?>"> <input type="submit" name="Submit" value="查寻"> 
      </td>
  </tr>
</table>
</form>
<?php
$page_size=pagesize_ht;  //每页多少条数据
$offset=($page-1)*$page_size;
$sql="select * from zzcms_pinglun where id<>0 ";
if ($shenhe=="no") {  		
$sql=$sql." and passed=0 ";
}

if ($keyword<>"") {
	$sql=$sql. " and content like '%".$keyword."%' ";
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
<form name="myform" method="post" action="">
<table width="100%" border="0" cellpadding="5" cellspacing="0" class="border">
    <tr> 
      <td> 
        <input type="submit" onClick="pass(this.form)" value="审核选中的信息"> 
        <input type="submit" onClick="del(this.form)" value="删除选中的信息">
      </td>
    </tr>
  </table>
  <table width="100%" border="0" cellspacing="1" cellpadding="5">
    <tr> 
      <td width="5%" align="center" class="border">选择</td>
      <td width="10%" class="border">评论内容</td>
      <td width="5%" class="border">被评文章ID</td>
      <td width="5%" align="center" class="border">是否审核</td>
      <td width="10%" align="center" class="border">发布时间</td>
      <td width="10%" align="center" class="border">评论人</td>
      <td width="10%" align="center" class="border">评论人IP</td>
    </tr>
<?php
while($row = mysql_fetch_array($rs)){
?>
    <tr class="bgcolor1" onMouseOver="fSetBg(this)" onMouseOut="fReBg(this)"> 
      <td align="center" class="docolor"> <input name="id[]" type="checkbox" id="id" value="<?php echo $row["id"]?>"></td>
      <td ><?php echo $row["content"]?></td>
      <td ><a href="<?php echo getpageurl("zx",$row["about"])?>" target="_blank"><?php echo $row["about"]?></a></td>
      <td align="center" > <?php if ($row["passed"]==1) { echo"已审核";} else{ echo"<font color=red>未审核</font>";}?></td>
      <td align="center"><?php echo $row["sendtime"]?></td>
      <td align="center"><a href="usermanage.php?keyword=<?php echo $row["username"]?>"><?php echo $row["username"]?></a></td>
      <td align="center"><?php echo $row["ip"]?></td>
    </tr>
<?php
}
?>
  </table>
  <table width="100%" border="0" cellpadding="5" cellspacing="0" class="border">
    <tr> 
      <td> <input name="chkAll" type="checkbox" id="chkAll" onClick="CheckAll(this.form)" value="checkbox">
        全选 
        <input type="submit" onClick="pass(this.form)" value="审核选中的信息"> 
        <input type="submit" onClick="del(this.form)" value="删除选中的信息"> 
        <input name="page" type="hidden" id="page" value="<%=CurrentPage%>"></td>
    </tr>
  </table>
</form>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="border">
  <tr> 
    <td height="30" align="center">页次：<strong><font color="#CC0033"><?php echo $page?></font>/<?php echo $totlepage?>　</strong> 
      <strong><?php echo $page_size?></strong>条/页　共<strong><?php echo $totlenum ?></strong>条
<?php
		
		if ($page<>1) {
			echo "【<a href='?keyword=".$keyword."&shenhe=".$shenhe."&page=1'>首页</a>】 ";
			echo "【<a href='?keyword=".$keyword."&shenhe=".$shenhe."&page=".($page-1)."'>上一页</a>】 ";
		}else{
			echo "【首页】【上一页】";
		}
		if ($page<>$totlepage) {
			echo "【<a href='?keyword=".$keyword."&shenhe=".$shenhe."&page=".($page+1)."'>下一页</a>】 ";
			echo "【<a href='?keyword=".$keyword."&shenhe=".$shenhe."&page=".$totlepage."'>尾页</a>】 ";
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
