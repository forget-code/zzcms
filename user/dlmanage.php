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

<div class="admintitle">
<span>
<form name="form1" method="post" action="?">
        产品名称： 
        <input name="cpmc" type="text" id="cpmc2"> <input type="submit" name="Submit" value="查找">
      </form>
</span>
<?php echo channeldl?>信息管理
</div>
<?php
if( isset($_GET["page"]) && $_GET["page"]!="") 
{
    $page=$_GET['page'];
}else{
    $page=1;
}

$cpmc = isset($_POST['cpmc'])?trim($_POST['cpmc']):"";
$page_size=pagesize_ht;  //每页多少条数据
$offset=($page-1)*$page_size;
$sql="select count(*) as total from zzcms_dl where editor='".$username."' ";
$sql2='';
if ($cpmc<>''){
$sql2=$sql2 . " and cp like '%".$cpmc."%' ";
}
$rs = mysql_query($sql.$sql2); 
$row = mysql_fetch_array($rs);
$totlenum = $row['total'];
$totlepage=ceil($totlenum/$page_size);

$sql="select id,cp,dlsname,province,city,xiancheng,saver,passed,sendtime,looked from zzcms_dl where editor='".$username."' ";
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
            <td width="10%" height="25" class="border"><?php echo channeldl?>产品名称或标题</td>
            <td width="10%" align="center" class="border">接收人用户名</td>
            <td width="5%" align="center" class="border"><?php echo channeldl?>区域</td>
            <td width="5%" align="center" class="border">更新时间</td>
            <td width="5%" align="center" class="border">信息状态</td>
            <td width="5%" align="center" class="border">操作</td>
            <td width="5%" align="center" class="border">删除</td>
          </tr>
          <?php
while($row = mysql_fetch_array($rs)){
?>
          <tr class="bgcolor1" onMouseOver="fSetBg(this)" onMouseOut="fReBg(this)"> 
            <td><a href="<?php echo getpageurl("dl",$row["id"])?>" target="_blank"><?php echo $row["cp"]?></a>            </td>
            <td align="center"><?php
			if ($row["saver"]<>''){
			echo '发送给：'.$row["saver"].'<br/>';
			if ($row["looked"]==1 ){ echo"已查看"; }else { echo"<font color=red>未查看</font>";}
			}else
			{echo '无接收人';}
			 ?></td>
            <td align="center" title='<?php echo $row["city"]?>'> <?php echo $row["province"].$row["city"].$row["xiancheng"]?>            </td>
            <td align="center"><?php echo $row["sendtime"]?></td>
            <td align="center"> 
              <?php 
	if ($row["passed"]==1 ){ echo "已审核";}else{ echo "<font color=red>待审</font>";}
	
	  ?>            </td>
            <td align="center" > 
              <a href="dlmodify.php?id=<?php echo $row["id"]?>&page=<?php echo $page?>">修改</a></td>
            <td align="center" ><input name="id[]" type="checkbox" id="id" value="<?php echo $row["id"]?>" /></td>
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
        <input name="pagename" type="hidden" id="page2" value="dlmanage.php?page=<?php echo $page ?>"> 
		<input name="tablename" type="hidden" id="tablename" value="zzcms_dl"> 
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