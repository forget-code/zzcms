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
checkadminisdo("helps");
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
if (isset($_REQUEST["keyword"])){
$keyword=$_REQUEST["keyword"];
}else{
$keyword="";
}
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td class="admintitle"><?php if ($b==1 ){echo"帮助"; }else{ echo"公告";}?>信息管理</td>
  </tr>
</table>
<table width="100%" border="0" cellpadding="5" cellspacing="0">
  <tr> 
    <td class="border"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td>
		  <?php if ($b==1) { ?>
		  <input name="submit3" type="submit" class="buttons" onClick="javascript:location.href='help_add.php?b=1'" value="发布帮助信息">
		  <?php }elseif ($b==2) { ?>
		  <input name="submit3" type="submit" class="buttons" onClick="javascript:location.href='help_add.php?b=2'" value="发布公告信息">
		  <?php
		  }
		  ?>
		  </td>
          <td align="right"> <form name="form1" method="post" action="?b=<?php echo $b?>">
              <input name="keyword" type="text" id="keyword" value="<?php echo $keyword?>">
              <input type="submit" name="Submit" value="查寻">
            </form></td>
        </tr>
      </table></td>
  </tr>
</table>
<?php
$page_size=pagesize_ht;  //每页多少条数据
$offset=($page-1)*$page_size;
$sql="select * from zzcms_help where classid=".$b." ";
if ($keyword<>"") {  		
$sql=$sql." and  title like '%".$keyword."%' ";
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
<form name="myform" method="post" action="?action=del&b=<?php echo $b?>">
<table width="100%" border="0" cellpadding="5" cellspacing="0" class="border">
    <tr> 
      <td> 
		<input type="submit" onClick="myform.action='del.php';myform.target='_self';return ConfirmDel()" value="删除选中的信息">
        <input name="pagename" type="hidden"  value="help_manage.php?b=<?php echo $b?>&page=<?php echo $page ?>"> 
        <input name="tablename" type="hidden"  value="zzcms_help"> </td>
    </tr>
  </table>
  <table width="100%" border="0" cellspacing="1" cellpadding="5">
    <tr> 
      <td width="5%" align="center" class="border">选择</td>
      <td width="10%" class="border">标题</td>
      <td width="5%" align="center" class="border">首页显示</td>
      <td width="10%" align="center" class="border">发布时间</td>
      <td width="5%" align="center" class="border">操作</td>
    </tr>
<?php
while($row = mysql_fetch_array($rs)){
?>
    <tr class="bgcolor1" onMouseOver="fSetBg(this)" onMouseOut="fReBg(this)"> 
      <td align="center" > <input name="id[]" type="checkbox" id="id" value="<?php echo $row["id"]?>"></td>
      <td ><a href="/one/announce_show.php?id=<?php echo $row["id"]?>" target="_blank"><?php echo $row["title"]?></a></td>
      <td align="center" > <?php if ($row["elite"]==1) { echo"是";} else{ echo"<font color=red>否</font>";}?></td>
      <td align="center"><?php echo $row["sendtime"]?></td>
      <td align="center" class="docolor"><a href="help_modify.php?id=<?php echo $row["id"]?>&b=<?php echo $b?>&page=<?php echo $page ?>">修改</a></td>
    </tr>
<?php
}
?>
  </table>
  <table width="100%" border="0" cellpadding="5" cellspacing="0" class="border">
    <tr> 
      <td> <input name="chkAll" type="checkbox" id="chkAll" onClick="CheckAll(this.form)" value="checkbox">
        全选 
        <input name="submit" type="submit" onClick="myform.action='del.php';myform.target='_self';return ConfirmDel()" value="删除选中的信息"></td>
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
			echo "【<a href='?keyword=".$keyword."&b=".$b."&page=1'>首页</a>】 ";
			echo "【<a href='?keyword=".$keyword."&b=".$b."&page=".($page-1)."'>上一页</a>】 ";
		}else{
			echo "【首页】【上一页】";
		}
		if ($page<>$totlepage) {
			echo "【<a href='?keyword=".$keyword."&b=".$b."&page=".($page+1)."'>下一页</a>】 ";
			echo "【<a href='?keyword=".$keyword."&b=".$b."&page=".$totlepage."'>尾页</a>】 ";
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