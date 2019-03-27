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
if (isset($_REQUEST["keyword"])){
$keyword=$_REQUEST["keyword"];
}else{
$keyword="";
}
if (isset($_REQUEST["b"])){
$b=$_REQUEST["b"];
}else{
$b="";
}
if (isset($_REQUEST["shenhe"])){
$shenhe=$_REQUEST["shenhe"];
}else{
$shenhe="";
}
if (isset($_REQUEST["action"])){
$action=$_REQUEST["action"];
}else{
$action="";
}
if( isset($_GET["page"]) && $_GET["page"]!="") {
    $page=$_GET['page'];
}else{
    $page=1;
}

if ($action<>""){
checkadminisdo("friendlink");
if(!empty($_POST['id'])){
    for($i=0; $i<count($_POST['id']);$i++){
    $id=$_POST['id'][$i];
	switch ($action){
	case "pass";
	$sql="select passed from zzcms_link where id ='$id'";
	$rs = mysql_query($sql); 
	$row = mysql_fetch_array($rs);
		if ($row['passed']=='0'){
		mysql_query("update zzcms_link set passed=1 where id ='$id'");
		}else{
		mysql_query("update zzcms_link set passed=0 where id ='$id'");
		}
	break;	
	case "elite";
	$sql="select elite from zzcms_link where id ='$id'";
	$rs = mysql_query($sql); 
	$row = mysql_fetch_array($rs);
		if ($row['elite']=='0'){
		mysql_query("update zzcms_link set elite=1 where id ='$id'");
		}else{
		mysql_query("update zzcms_link set elite=0 where id ='$id'");
		}
	break;
	case "del";
	mysql_query("delete from zzcms_link where id ='$id'");
	break;	
	}	
	}
}else{
echo "<script>alert('操作失败！至少要选中一条信息。');history.back()</script>";
}
echo "<script>location.href='?keyword=".$keyword."&page=".$page."'</script>";	
}
?>
<div class="admintitle">友情链接管理</div>
      <div class="border"> 
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td>
              <input name="submit3" type="submit" class="buttons" onClick="javascript:location.href='link_add.php'" value="添加友情链接">
             </td>
            <td align="right">
			<form name="form1" method="post" action="?">
			网站名称： 
              <input name="keyword" type="text" id="keyword" value="<?php echo $keyword?>"> 
              <input type="submit" name="Submit" value="查找">
			  </form>
            </td>
          </tr>
        </table> </div>
   
<?php
$page_size=pagesize_ht;  //每页多少条数据
$offset=($page-1)*$page_size;
$sql="select count(*) as total from zzcms_link where id<>0 ";
$sql2='';
if ($shenhe=="no") {  		
$sql2=$sql2." and passed=0 ";
}
if ($b<>"") {
$sql2=$sql2. " and bigclassid =".$b." ";
}
if ($keyword<>"") {
$sql2=$sql2. " and sitename like '%".$keyword."%' ";
}
$rs = mysql_query($sql.$sql2); 
$row = mysql_fetch_array($rs);
$totlenum = $row['total'];    
$totlepage=ceil($totlenum/$page_size);

$sql="select * from zzcms_link where id<>0 ";
$sql=$sql.$sql2;
$sql=$sql . " order by id desc limit $offset,$page_size";
$rs = mysql_query($sql); 
if(!$totlenum){
echo "暂无信息";
}else{
?>
<form name="myform" id="myform" method="post" action="">
  <table width="100%" border="0" cellpadding="5" cellspacing="0" class="border">
    <tr>
      <td><input name="submit2" type="submit" onClick="myform.action='?action=pass'" value="【取消/审核】选中的信息">
          <input name="submit22" type="submit" onClick="myform.action='?action=elite'" value="【取消/推荐】选中的信息">
          <input name="submit" type="submit" onClick="myform.action='?action=del'" value="删除选中的信息">
      <input name="page" type="hidden" id="page" value="<?php echo $page?>"> <input name="shenhe" type="hidden" id="shenhe" value="<?php echo $shenhe?>">      </td></tr>
</table>

  <table width="100%" border="0" cellpadding="5" cellspacing="1">
    <tr> 
      <td width="5%" align="center" class="border"><label for="chkAll" style="text-decoration: underline;cursor: hand;">全选</label> </td>
      <td width="5%" class="border">类型</td>
      <td width="10%" class="border">网站名称</td>
      <td width="10%" class="border">网站描述</td>
      <td width="10%" class="border">申请时间</td>
      <td width="5%" align="center" class="border">信息状态</td>
      <td width="5%" align="center" class="border">操作</td>
    </tr>
<?php
while($row = mysql_fetch_array($rs)){
?>
    <tr bgcolor="#FFFFFF" onMouseOver="this.bgColor='#E6E6E6'" onMouseOut="this.bgColor='#FFFFFF'"> 
      <td align="center" > <input name="id[]" type="checkbox" id="id" value="<?php echo $row["id"]?>"></td>
      <td ><a href="?b=<?php echo $row["bigclassid"]?>">
	  <?php
	  $rsn=mysql_query("select bigclassname from zzcms_linkclass where bigclassid=".$row["bigclassid"]." ");
	  $rown=mysql_fetch_array($rsn);
	  echo $rown["bigclassname"]?></a></td>
      <td><b><?php echo $row["sitename"]?></b><br> 
        <a href="<?php echo $row["url"]?>" target="_blank"><?php echo $row["url"]?></a><br> 
        <?php if ($row["logo"]<>""){?>
        <img src="<?php echo $row["logo"]?>" width="150" height="50"> 
        <?php }else{
		  echo "未填写LOGO地址";
		  }
		 ?>      </td>
      <td><?php echo $row["content"]?></td>
      <td><?php echo $row["sendtime"]?></td>
      <td align="center" > 
        <?php if ($row["passed"]==1) { echo"已审核";} else{ echo"<font color=red>未审核</font>";}?>  <br>
		<?php if ($row["elite"]==1) { echo"已推荐";} else{ echo"未推荐";}?>		    </td>
      <td align="center" class="docolor"><a href="link_modify.php?id=<?php echo $row["id"]?>&page=<?php echo $page ?>">修改</a>      </td>
    </tr>
<?php
}
?>
  </table>
  <table width="100%" border="0" cellpadding="5" cellspacing="0" class="border">
    <tr>
      <td><input name="chkAll" type="checkbox" id="chkAll" onClick="CheckAll(this.form)" value="checkbox">
        <label for="chkAll" style="text-decoration: underline;cursor: hand;">全选</label>
        <input name="submit23" type="submit" onClick="myform.action='?action=pass'" value="【取消/审核】选中的信息">
        <input name="submit222" type="submit" onClick="myform.action='?action=elite'" value="【取消/推荐】选中的信息">
      <input name="submit4" type="submit" onClick="myform.action='?action=del'" value="删除选中的信息"></td>
    </tr>
  </table>
  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="border">
  <tr> 
    <td height="30" align="center">页次：<strong><font color="#CC0033"><?php echo $page?></font>/<?php echo $totlepage?>　</strong> 
      <strong><?php echo $page_size?></strong>条/页　共<strong><?php echo $totlenum ?></strong>条
<?php
		if ($page<>1) {
			echo "【<a href='?b=".$b."&keyword=".$keyword."&shenhe=".$shenhe."&page=1'>首页</a>】 ";
			echo "【<a href='?b=".$b."&keyword=".$keyword."&shenhe=".$shenhe."&page=".($page-1)."'>上一页</a>】 ";
		}else{
			echo "【首页】【上一页】";
		}
		if ($page<>$totlepage) {
			echo "【<a href='?b=".$b."&keyword=".$keyword."&shenhe=".$shenhe."&page=".($page+1)."'>下一页</a>】 ";
			echo "【<a href='?b=".$b."&keyword=".$keyword."&shenhe=".$shenhe."&page=".$totlepage."'>尾页</a>】 ";
		}else{
			echo "【下一页】【尾页】";
		}       
	?> 
    </td>
  </tr>
</table>
</form>
<?php
}
mysql_close($conn);
?>
</body>
</html>