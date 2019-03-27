<?php
include("admin.php");
?>
<html>
<head>
<title></title>
<link href="style.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script language="JavaScript" src="/js/gg.js"></script>
<?php
checkadminisdo("licence");
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

if ($action=="pass"){
$id="";
if(!empty($_POST['id'])){
    for($i=0; $i<count($_POST['id']);$i++){
    $id=$id.($_POST['id'][$i].',');
    }
	$id=substr($id,0,strlen($id)-1);//去除最后面的","
}
if ($id==""){
$founderr=1;
$ErrMsg="<li>操作失败！至少要选中一条信息。</li>";
WriteErrMsg($ErrMsg);
}else{
	if (strpos($id,",")>0){
		$sql="update zzcms_licence set passed=1 where id in (". $id .")";
	}else{
		$sql="update zzcms_licence set passed=1 where id='$id'";
	}
mysql_query($sql);
echo "<script>location.href='?shenhe=no&keyword=".$keyword."&page=".$page."'</script>";
}
}
?>
</head>
<body>
<div class="admintitle">资质证书管理</div>
<div>
<form action="?" name="form1" method="post"> 
标题： <input name="keyword" type="text" id="keyword" value="<?php echo $keyword?>"> <input type="submit" name="Submit" value="查找">
</form> 
</div>
<?php
$page_size=pagesize_ht;  //每页多少条数据
$offset=($page-1)*$page_size;
$sql="select count(*) as total from zzcms_licence where id<>0 ";
$sql2='';
if ($shenhe=="no") {  		
$sql2=$sql2." and passed=0 ";
}
if ($keyword<>"") {
	$sql2=$sql2. " and editor '%".$keyword."%'";
}
$rs = mysql_query($sql.$sql2,$conn); 
$row = mysql_fetch_array($rs);
$totlenum = $row['total']; 
$totlepage=ceil($totlenum/$page_size);

$sql="select * from zzcms_licence where id<>0 ";
$sql=$sql.$sql2;
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
<input name="submit"  type="submit" onClick="pass(this.form)" value="审核选中的信息">
        <input name="submit4" type="submit" onClick="myform.action='del.php';myform.target='_self';return ConfirmDel()" value="删除选中的信息"> 
        <input name="pagename" type="hidden"  value="licence.php?shenhe=<?php echo $shenhe?>&page=<?php echo $page ?>"> 
        <input name="tablename" type="hidden"  value="zzcms_licence"> </td>
    </tr>
  </table>
  <table width="100%" border="0" cellpadding="5" cellspacing="1">
    <tr> 
      <td width="5%" align="center" class="border">选取</td>
      <td width="20%" class="border">证件</td>
      <td width="20%" class="border">资质证书名称</td>
      <td width="5%" class="border">用户</td>
      <td width="5%" class="border">状态</td>
    </tr>
<?php
while($row = mysql_fetch_array($rs)){
?>
   <tr class="bgcolor1" onMouseOver="fSetBg(this)" onMouseOut="fReBg(this)"> 
      <td align="center" class="docolor"> <input name="id[]" type="checkbox" id="id" value="<?php echo $row["id"]?>"></td>
      <td><a href="<?php echo $row["img"]?>" target="_blank"><img src="<?php echo $row["img"]?>" border="0" width="100"></a>      </td>
      <td><?php echo $row["title"]?></td>
      <td><a href="usermanage.php?keyword=<?php echo $row["editor"]?>"><?php echo $row["editor"]?></a></td>
      <td><?php if ($row["passed"]==0) { echo "<font color=red>未审核</font>"; }else{ echo "已审核"; }?></td>
    </tr>
<?php
}
?>
  </table>
<table width="100%" border="0" cellpadding="5" cellspacing="0" class="border">
  <tr> 
    <td> <input name="chkAll" type="checkbox" id="chkAll" onClick="CheckAll(this.form)" value="checkbox">
      全选 
      <input name="submit2"  type="submit" onClick="pass(this.form)" value="审核选中的信息">
        <input name="submit42" type="submit" onClick="myform.action='del.php';myform.target='_self';return ConfirmDel()" value="删除选中的信息"> 
      </td>
  </tr>
</table>
</form>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="border">
  <tr> 
    <td width="55%" height="30" align="center">页次：<strong><font color="#CC0033"><?php echo $page?></font>/<?php echo $totlepage?>　</strong> 
      <strong><?php echo $page_size?></strong>条/页　共<strong><?php echo $totlenum ?></strong>条
<?php
		if ($page<>1) {
			echo  "【<a href='?shenhe=".$shenhe."&page=1'>首页</a>】";
			echo  "【<a href='?shenhe=".$shenhe."&page=".($page-1)."'>上一页</a>】";
		}else{
			echo  "【首页】【上一页】";
		}
		if ($page<>$totlepage) {
			echo  "【<a href='?shenhe=".$shenhe."&page=".($page+1)."'>下一页</a>】";
			echo  "【<a href='?shenhe=".$shenhe."&page=".$totlepage."'>尾页</a>】";
		}else{
			echo  "【下一页】【尾页】";
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