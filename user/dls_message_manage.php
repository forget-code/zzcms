<?php
include("../inc/conn.php");
include("check.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<link href="style.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="/js/gg.js"></script>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
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
if (isset($_POST["lxr"])){ 
$lxr=trim($_POST["lxr"]);
}else{
$lxr="";
}
?>

<div class="admintitle">
<span>
<form name="form1" method="post" action="?">
        联系人姓名： 
              <input name="lxr" type="text" id="lxr2" value="<?php echo $lxr?>"> 
              <input type="submit" name="Submit" value="查找">
      </form>
</span>
<?php echo channeldl?>商留言</div>
<?php
if( isset($_GET["page"]) && $_GET["page"]!="") 
{
    $page=$_GET['page'];
}else{
    $page=1;
}
if (isset($_GET['page_size'])){
$page_size=$_GET['page_size'];
}else{
$page_size=pagesize_ht;  //每页多少条数据
}
$offset=($page-1)*$page_size;
$sql="select count(*) as total from zzcms_dl where passed=1 and del=0 and saver='".$username."' ";
$sql2='';
if ($lxr<>"") {
$sql2=$sql2."and name like '%".$lxr."%' ";
}

$rs = mysql_query($sql.$sql2); 
$row = mysql_fetch_array($rs);
$totlenum = $row['total'];
$totlepage=ceil($totlenum/$page_size);

$sql="select * from zzcms_dl where passed=1 and del=0 and saver='".$username."' ";
$sql=$sql.$sql2;
$sql=$sql." order by id desc limit $offset,$page_size";
$rs = mysql_query($sql); 
if(!$totlenum){
echo "暂无信息";
}else{
?>
<form action="" method="post" name="myform" id="myform">
  <table width="100%" border="0" cellpadding="5" cellspacing="1">
    <tr> 
      <td width="153" class="border">联系人</td>
      <td width="149" class="border"><?php echo channeldl?>区域</td>
      <td width="141" class="border"><?php echo channeldl?>品种</td>
      <td width="140" class="border">申请时间</td>
      <td width="113" align="center" class="border">操作</td>
      <td width="69" align="center" class="border">删除</td>
    </tr>
          <?php
while($row = mysql_fetch_array($rs)){
?>
    <tr class="bgcolor1" onMouseOver="fSetBg(this)" onMouseOut="fReBg(this)"> 
      <td width="153"><?php echo $row["dlsname"]?><?php if($row["looked"]==0) { echo "(<font color=red>新</font>)";}?> </td>
      <td width="149"><?php echo $row["province"].$row["city"]?></td>
      <td width="141"><?php echo $row["cp"]?></td>
      <td width="140"><?php echo $row["sendtime"]?></td>
      <td width="113" align="center"><a href="dls_show.php?id=<?php echo $row["id"]?>" target="_blank">查看联系方式</a></td>
      <td width="69" align="center"><input name="id[]" type="checkbox" id="id[]" value="<?php echo $row["id"]?>" /></td>
    </tr>
    <?php
}
?>
  </table>

<div class="fenyei"  >
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
          <select name="FileExt" id="FileExt">
          <option selected="selected" value="xls">下载类型</option>
          <option value="xls">excel表格</option>
          <option value="doc">word文件</option>
        </select> <select name="page_size" id="page_size" onChange="MM_jumpMenu('self',this,0)">
          <option value="?page_size=10" <?php if ($page_size==10) { echo "selected";}?>>10条/页</option>
          <option value="?page_size=20" <?php if ($page_size==20) { echo "selected";}?>>20条/页</option>
          <option value="?page_size=50" <?php if ($page_size==30) { echo "selected";}?>>50条/页</option>
          <option value="?page_size=100" <?php if ($page_size==100) { echo "selected";}?>>100条/页</option>
          <option value="?page_size=200" <?php if ($page_size==200) { echo "selected";}?>>200条/页</option>
        </select>
        <label for="chkAll">
        <input name="submit2"  type="submit" class="buttons"  value="打印" onclick="myform.action='dls_print.php';myform.target='_blank'" />
          </label>
          <input name="submit22"  type="submit" class="buttons"  value="下载" onclick="myform.action='dls_download.php';myform.target='_blank'" />
		<input name="submit"  type="submit" class="buttons" value="删除" onClick="myform.action='del.php';myform.target='_self';return ConfirmDel()"  > 
              <input name="pagename" type="hidden" id="page2" value="dls_message_manage.php?page=<?php echo $page ?>" /> 
              <input name="tablename" type="hidden" id="tablename" value="zzcms_dlly" />
              <input name="chkAll" type="checkbox" id="chkAll" onclick="CheckAll(this.form)" value="checkbox" />
              <label for="chkAll">全选</label> 
</div>
  </form>
<?php
}
mysql_close($conn)
?>
</div>
</div>
</div>
</body>
</html>