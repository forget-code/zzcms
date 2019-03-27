<?php
include("../inc/conn.php");
include("check.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title></title>
<link href="style.css" rel="stylesheet" type="text/css">
<?php
if (check_usergr_power("special")=="no" && $usersf=='个人'){
showmsg('个人用户没有此权限');
}
?>
<script language="JavaScript" src="/js/gg.js"></script>
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

<div class="admintitle">
<span>
<form name="form1" method="post" action="?">
        标题： 
          <input name="keyword" type="text" id="keyword"> <input type="submit" name="Submit" value="查找">
      </form>
</span>
专题信息管理</div>
<?php
if (isset($_GET["bigclassid"])){
$bigclassid=$_GET["bigclassid"];
}else{
$bigclassid="";
}

if (isset($_POST["keyword"])){ 
$keyword=trim($_POST["keyword"]);
}else{
$keyword="";
}	

if( isset($_GET["page"]) && $_GET["page"]!="") 
{
    $page=$_GET['page'];
}else{
    $page=1;
}

$page_size=pagesize_ht;  //每页多少条数据
$offset=($page-1)*$page_size;
$sql="select count(*) as total from zzcms_special where editor='".$username."' ";
$sql2='';
if ($bigclassid!=""){
$sql2=$sql2." and bigclassid='".$bigclassid."'  ";
}
if ($keyword!=""){
$sql2=$sql2." and title like '%".$keyword."%' ";
}

$rs = mysql_query($sql.$sql2); 
$row = mysql_fetch_array($rs);
$totlenum = $row['total'];  
$totlepage=ceil($totlenum/$page_size);

$sql="select * from zzcms_special where editor='".$username."' ";	
$sql=$sql.$sql2;
$sql=$sql . " order by id desc limit $offset,$page_size";
$rs = mysql_query($sql); 
if(!$totlenum){
echo "暂无信息";
}else{
?>
<form name="myform" method="post" action="del.php">
        <table width="100%" border="0" cellpadding="5" cellspacing="1">
          <tr> 
            <td width="222" height="25" class="border">标题</td>
            <td width="116" align="center" class="border">所属类别</td>
            <td width="135" align="center" class="border">更新时间</td>
            <td width="87" align="center" class="border">审核状态</td>
            <td width="94" align="center" class="border">点击</td>
            <td width="55" align="center" class="border">操作</td>
            <td width="55" align="center" class="border">删除</td>
          </tr>
          <?php
while($row = mysql_fetch_array($rs)){
?>
          <tr class="bgcolor1" onMouseOver="fSetBg(this)" onMouseOut="fReBg(this)"> 
            <td width="222"><a href="<?php echo getpageurl("special",$row["id"])?>" target="_blank"><?php echo $row["title"]?></a>            </td>
            <td width="116" align="center"> 
			<a href="?bigclassid=<?php echo $row["bigclassid"]?>"><?php echo $row["bigclassname"]?></a> 
              - <?php echo $row["smallclassname"]?>            </td>
            <td width="135" align="center"><?php echo $row["sendtime"]?></td>
            <td width="87" align="center"> 
              <?php 
	if ($row["passed"]==1 ){ echo "<font color='green'>已审核</font>";}else{ echo "<font color=red>待审</font>";}
	  ?>            </td>
            <td width="94" align="center"><?php echo $row["hit"]?>次</td>
            <td width="55" align="center"> 
			
              <a href="specialmodify.php?id=<?php echo $row["id"]?>&page=<?php echo $page?>&bigclassid=<?php echo $bigclassid?>">修改</a></td>
            <td width="55" align="center"><input name="id[]" type="checkbox" id="id" value="<?php echo $row["id"]?>" /></td>
          </tr>
          <?php
}
?>
        </table>

<div class="fenyei">
页次：<strong><font color="#CC0033"><?php echo $page?></font>/<?php echo $totlepage?>　</strong> 
      <strong><?php echo $page_size?></strong>条/页　共<strong><?php echo $totlenum ?></strong>条		 
          <?php  
if ($page!=1){
echo "<a href=?page=1&bigclassid=".$bigclassid.">【首页】</a> ";
echo "<a href=?page=".($page-1)."&bigclassid=".$bigclassid.">【上一页】</a> ";
}else{
echo "【首页】【上一页】";
}
if ($page!=$totlepage){
echo "<a href=?page=".($page+1)."&bigclassid=".$bigclassid.">【下一页】</a> ";
echo "<a href=?page=".$totlepage."&bigclassid=".$bigclassid.">【尾页】</a>";
}else{
echo "【下一页】【尾页】";
}
?>
 <input name="chkAll" type="checkbox" id="chkAll" onclick="CheckAll(this.form)" value="checkbox" />
          <label for="chkAll">全选</label>
<input name="submit"  type="submit" class="buttons"  value="删除" onClick="return ConfirmDel()"> 
<input name="pagename" type="hidden" id="page2" value="specialmanage.php?page=<?php echo $page ?>"> 
<input name="tablename" type="hidden" id="tablename" value="zzcms_special"> 
</div>
  </form>
<?php
}
mysql_close($conn);
?>
</div>
</div>
</div>
</body>
</html>