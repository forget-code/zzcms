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
<div class="admintitle">展厅内留言</div>
<?php
if( isset($_GET["page"]) && $_GET["page"]!="") 
{
    $page=$_GET['page'];
}else{
    $page=1;
}
$page_size=pagesize_ht;  
if(isset($_GET["show"])) {
$show=$_GET['show'];
}else{
$show="";
}
$sql="select * from zzcms_guestbook where passed=1 and saver='".$username."' ";
if ($show=="new") {
$sql=$sql." and looked=0 ";
}

$offset=($page-1)*$page_size;
$rs = mysql_query($sql,$conn); 
$totlenum= mysql_num_rows($rs);  
$totlepage=ceil($totlenum/$page_size);

$sql=$sql." order by id desc limit $offset,$page_size";
$rs = mysql_query($sql,$conn); 
$row= mysql_num_rows($rs);//返回记录数
if(!$row){
echo "暂无信息";
}else{
?>
<form name="myform" method="post" action="del.php">
  <table width="100%" border="0" cellpadding="5" cellspacing="1">
    <tr> 
      <td width="373" class="border">部分内容</td>
      <td width="201" class="border">留言时间</td>
      <td width="190" class="border">是否查看</td>
      <td width="77" align="center" class="border">操作</td>
      <td width="77" align="center" class="border">删除</td>
    </tr>
          <?php
while($row = mysql_fetch_array($rs)){
?>
    <tr class="bgcolor1" onMouseOver="fSetBg(this)" onMouseOut="fReBg(this)"> 
      <td><a href="ztliuyan_show.php?id=<?php echo $row["id"]?>" target="_blank"><?php echo cutstr($row["content"],10)?></a></td>
      <td><?php echo $row["sendtime"]?></td>
      <td><?php if ($row["looked"]==0){ echo "<font color=red>未查看</font>";} else {echo "已查看";}?></td>
      <td align="center"><a href="ztliuyan_show.php?id=<?php echo $row["id"]?>" target="_blank">查看</a></td>
      <td align="center"><input name="id[]" type="checkbox" id="id" value="<?php echo $row["id"]?>" /></td>
    </tr>
<?php
}
?>
  </table>

<div class="fenyei" >
页次：<strong><font color="#CC0033"><?php echo $page?></font>/<?php echo $totlepage?>　</strong> 
      <strong><?php echo $page_size?></strong>条/页　共<strong><?php echo $totlenum ?></strong>条		 
          <?php  
if ($page!=1){
echo "<a href=?page=1>【首页】</a> ";
echo "<a href=?page=".($page-1).">【上一页】</a> ";
}else{
echo "【首页】【上一页】";
}
if ($page!=$totlepage){
echo "<a href=?page=".($page+1).">【下一页】</a> ";
echo "<a href=?page=".$totlepage.">【尾页】</a>";
}else{
echo "【下一页】【尾页】";
}
?>
 <input name="chkAll" type="checkbox" id="chkAll" onclick="CheckAll(this.form)" value="checkbox" />
          <label for="chkAll">全选</label>
<input name="submit"  type="submit" class="buttons"  value="删除" onClick="return ConfirmDel()">
<input name="pagename" type="hidden" id="page2" value="ztliuyan.php?page=<?php echo $page ?>" /> 
<input name="tablename" type="hidden" id="tablename" value="zzcms_guestbook" /> 
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
