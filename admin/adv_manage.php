<?php 
include("admin.php"); 
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<link href="style.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="/js/gg.js"></script>
<?php
checkadminisdo("advtext");
if (isset($_REQUEST["action"])){
$action=$_REQUEST["action"];
}else{
$action="";
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
if( isset($_GET["page"]) && $_GET["page"]!="") 
{
    $page=$_GET['page'];
}else{
    $page=1;
}
if (isset($_REQUEST["id"])){
$id=$_REQUEST["id"];
}else{
$id="";
}

if ($action=="del") {
$sql="select * from zzcms_textadv where id='$id'";
$rs=mysql_query($sql);
$row=mysql_fetch_array($rs);
$newsid=$row["newsid"];
$username=$row["username"];
	if ($newsid<>0) {//当用户抢占了广告位时执行下面的操作
	$sql="select * from zzcms_ad where id='$newsid'";
	$rs=mysql_query($sql);
	$row=mysql_num_rows($rs);
		if ($row){
		$row=mysql_fetch_array($rs);	
		mysql_query("update zzcms_ad set nextuser='' where id='$newsid' ");//如果此处有值，此用户将不能参与下一次的抢占
    		if ($row["username"]==$username){//当用户抢得了广告位后并被审核通过后，这时username的值(即广告主)就是此用户
    		mysql_query("update zzcms_ad set username='',title='此位空出>>>点击抢占此位置',link='user/index.php?gotopage=adv2.php',sendtime='".date('Y-m-d H:i:s',time()-60*60*24*showadvdate)."' where id='$newsid' ");	//被审核通过后的用户修改了广告词,又要被审，这时若删时要清除username的值	
			}
		}
	}
//mysql_query("update zzcms_textadv set adv='' where id='$id'");
mysql_query("delete from zzcms_textadv where id='$id'");
echo "<script>location.href='adv_manage.php?page=".$page."'</script>";
}
if ($action=="pass") {
$sql="select * from zzcms_textadv where id='$id'";
$rs=mysql_query($sql);
$row=mysql_fetch_array($rs);
mysql_query("update zzcms_textadv set passed=1 where id='$id'");
$newsid=$row["newsid"];
$title=$row["adv"];
$company=$row["company"];
$link=$row["advlink"];
$img=$row["img"];
$username=$row["username"];
$sendtime=$row["gxsj"];
if ($newsid<>0) {//当用户设置了广告词并抢占了广告位时执行下面的复制操作
$sql="select * from zzcms_ad where id='$newsid'";
$rs=mysql_query($sql);
$row=mysql_fetch_array($rs);
if ($row["bigclassname"]=="B") {//如是B区的广告标题上加公司名称
mysql_query("update zzcms_ad set title='<b>".cutstr($company,10)."</b><br>".$title."' where id='$newsid'");
}else{
mysql_query("update zzcms_ad set title='".$title."' where id='$newsid'");
}
mysql_query("update zzcms_ad set link='".$link."',img='".$img."',imgwidth=0,username='".$username."',sendtime='".$sendtime."',nextuser='' where id='$newsid'");
//写入用户抢占时的时间sendtime，为了防止一个用户通过修改广告词功能长期霸占一个位置。设nextuser为空,如果此处有值，此用户不将能参与下一次的抢占
}
echo "<script>location.href='adv_manage.php?shenhe=no&page=".$page."'</script>";
}
?>
</head>
<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td class="admintitle">用户审请的文字广告管理</td>
  </tr>
</table>
  <form name="form1" method="post" action="?">
<table width="100%" border="0" cellpadding="5" cellspacing="0">

    <tr> 
      <td class="border"> 
        <input name="kind" type="radio" value="username" <?php if ($kind=="username") { echo "checked";}?>>
        按发布人 
        <input type="radio" name="kind" value="title" <?php if ($kind=="title") { echo "checked";}?>>
        按广告词 
        <input name="keyword" type="text" id="keyword" value="<?php echo $keyword?>"> 
        <input type="submit" name="Submit" value="查找">
        　 </td>
    </tr>
</table>
  </form>
  <?php
$page_size=pagesize_ht;  //每页多少条数据
$offset=($page-1)*$page_size;
$sql="select * from zzcms_textadv where id<>0 ";
if ($shenhe=="no") {  		
$sql=$sql." and passed=0 ";
}
if ($keyword<>"") {
	switch ($kind){
	case "username";
	$sql=$sql. " and username like '%".$keyword."%' ";
	break;
	case "title";
	$sql=$sql. " and adv like '%".$keyword."%'";
	break;
	default:
	$sql=$sql. " and adv like '%".$keyword."%'";
	}
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
<table width="100%" border="0" cellspacing="1" cellpadding="5">
  <tr> 
    <td width="56" align="center" class="border">ID</td>
    <td width="176" class="border">广告词</td>
    <td width="177" class="border">图片</td>
    <td width="92" class="border">是否审核</td>
    <td width="112" align="center" class="border">发布时间</td>
    <td width="106" align="center" class="border">发布人</td>
    <td width="232" align="center" class="border">操作</td>
  </tr>
  <?php
while($row = mysql_fetch_array($rs)){
?>
  <tr class="bgcolor1" onMouseOver="fSetBg(this)" onMouseOut="fReBg(this)"> 
    <td width="56" align="center">
      <input name="id[]" type="checkbox"  value="<?php echo $row["id"]?>"></td>
    <td width="176"><a href='<?php echo $row["advlink"]?>' target="_blank"><?php echo $row["adv"]?></a></td>
    <td width="177">
	<?php
if ($row["img"]<>""){
	if (strpos("gif|jpg|png|bmp",substr($row["img"],-3))>=0) {
	$str="<img src='".$row["img"]."' width=100'  border='0'/>";
	}elseif (substr($row["img"],-3)=="swf"){
	$str="<object classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0'  width='".$row["imgwidth"]."' height='".$row["imgheight"]."'>";
	$str=$str."<param name='movie' value='".$row["img"]."'>";
	$str=$str."<param name='quality' value='high'>";
	$str=$str."<embed src='".$row["img"]."' width='".$row["imgwidth"]."' height='".$row["imgheight"]."' quality='high' pluginspage='http://www.macromedia.com/go/getflashplayer' type='application/x-shockwave-flash'></embed></object>";
	}
	echo $str;
}else{
	echo "文字广告-无图片";
}	
	?>
	</td>
    <td width="92"> 
      <?php if ($row["passed"]==1) { echo"已审核";} else{ echo"<font color=red>未审核</font>";}?>
    </td>
    <td width="112" align="center"><?php echo $row["gxsj"]?></td>
    <td width="106" align="center"><a href="usermanage.php?keyword=<?php echo $row["username"]?>"><?php echo $row["username"]?></a></td>
    <td width="232" align="center" class="docolor"><a href="adv_manage.php?action=pass&page=<?php echo $page?>&id=<?php echo $row["id"]?>">审核</a> 
      | <a href="adv_modify.php?page=<?php echo $page?>&id=<?php echo $row["id"]?>">修改</a> 
      | <a href="adv_manage.php?action=del&id=<?php echo $row["id"]?>" onClick="return ConfirmDel();">删除</a> 
    </td>
  </tr>
  <?php
}
?>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="border">
  <tr> 
    <td height="30" align="center">页次：<strong><font color="#CC0033"><?php echo $page?></font>/<?php echo $totlepage?>　</strong> 
      <strong><?php echo $page_size?></strong>条/页　共<strong><?php echo $totlenum ?></strong>条
<?php
		
		if ($page<>1) {
			echo "【<a href='?kind=".$kind."&keyword=".$keyword."&shenhe=".$shenhe."&page=1'>首页</a>】 ";
			echo "【<a href='?kind=".$kind."&keyword=".$keyword."&shenhe=".$shenhe."&page=".($page-1)."'>上一页</a>】 ";
		}else{
			echo "【首页】【上一页】";
		}
		if ($page<>$totlepage) {
			echo "【<a href='?kind=".$kind."&keyword=".$keyword."&shenhe=".$shenhe."&page=".($page+1)."'>下一页</a>】 ";
			echo "【<a href='?kind=".$kind."&keyword=".$keyword."&shenhe=".$shenhe."&page=".$totlepage."'>尾页</a>】 ";
		}else{
			echo "【下一页】【尾页】";
		}       
	?> 
    </td>
  </tr>
</table>
<?php
}
?>
</body>
</html>