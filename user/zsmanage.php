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
if (check_usergr_power("zs")=="no" && $usersf=='个人'){
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
<?php
if (isset($_POST["cpmc"])){ 
$cpmc=$_POST["cpmc"];
}else{
$cpmc="";
}

if (isset($_REQUEST["bigclass"])){
$bigclass=$_REQUEST["bigclass"];
}else{
$bigclass="";
}
?>
<div class="admintitle">
<span>
 <form name="form1" method="post" action="?">
  <input name="cpmc" type="text" id="cpmc" value="<?php if($cpmc){ echo $cpmc;}else{ echo '输入产品名称';}?>"  onfocus="javascript:if (this.value=='输入产品名称') {this.value=''}" > 
        <input name="Submit" type="submit" value="查找"> <input name="Submit2" type="button" class="buttons"  onClick="javascript:location.href='zsmanage.php?action=refresh'" value="一键刷新" title='一键刷新功能可使您的信息排名靠前，以提高被查看的机率。'>
</form>
</span>
<?php echo channelzs?>信息管理</div>
<?php
$sql="select refresh_number,groupid from zzcms_usergroup where groupid=(select groupid from zzcms_user where username='".$username."')";
$rs = mysql_query($sql); 
if(empty($rs)){
$refresh_number=3;
}else{
$row = mysql_fetch_array($rs);
$refresh_number=$row["refresh_number"];
}

if (isset($_REQUEST["action"])){
$action=$_REQUEST["action"];
}else{
$action="";
}

$sql="select refresh,sendtime from zzcms_main where editor='".$username."' ";
$rs = mysql_query($sql);
$row = mysql_fetch_array($rs);
if ($action=="refresh") {
    if ($row["refresh"]< $refresh_number){
	mysql_query("update zzcms_main set sendtime='".date('Y-m-d H:i:s')."',refresh=refresh+1 where editor='".$username."'");
	showmsg('操作成功！',"?");
    }else{
	showmsg("操作失败！一天内只允许刷新 ".$refresh_number." 次！");
    }
}else{
	if (strtotime(date("Y-m-d H:i:s"))-strtotime($row['sendtime'])>12*3600){
	mysql_query("update zzcms_main set refresh=0 where editor='".$username."'");
  	}
}	

if( isset($_GET["page"]) && $_GET["page"]!="") 
{
    $page=$_GET['page'];
}else{
    $page=1;
}

$page_size=pagesize_ht;  //每页多少条数据
$offset=($page-1)*$page_size;
$sql="select count(*) as total from zzcms_main where editor='".$username."' ";
$sql2='';
if (isset($cpmc)){
$sql2=$sql2 . " and proname like '%".$cpmc."%' ";
}
if ($bigclass<>""){
$sql2=$sql2 . " and bigclasszm ='".$bigclass."'";
}
if (isset($_GET["id"])){
$sql2=$sql2 . " and id ='".$_GET["id"]."'"; 
}
$rs = mysql_query($sql.$sql2); 
$row = mysql_fetch_array($rs);
$totlenum = $row['total'];
$totlepage=ceil($totlenum/$page_size);

$sql="select id,bigclasszm,smallclasszm,proname,refresh,img,province,city,xiancheng,sendtime,elite,passed,elitestarttime,eliteendtime,tag from zzcms_main where editor='".$username."' ";
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
      <td width="107" class="border">产品名称</td>
      <td width="108" align="center" class="border">所属类别</td>
      <td width="93" height="25" align="center" class="border">产品图片</td>
      <td width="86" align="center" class="border">招商区域</td>
      <td width="97" align="center" class="border">更新时间</td>
      <td width="50" align="center" class="border">已刷新</td>
      <td width="57" align="center" class="border">信息状态</td>
      <td width="92" align="center" class="border">修改</td>
      <td width="42" align="center" class="border">删除</td>
    </tr>
<?php
while($row = mysql_fetch_array($rs)){
?>
    <tr class="bgcolor1" onMouseOver="fSetBg(this)" onMouseOut="fReBg(this)"> 
      <td width="107"><a href="<?php echo getpageurl("zs",$row["id"])?>" target="_blank"><?php echo $row["proname"]?></a> </td>
      <td width="108" align="center">
	  <?php
	$sqln="select classname from zzcms_zsclass where classzm='".$row["bigclasszm"]."' ";
	$rsn = mysql_query($sqln); 
	$rown = mysql_fetch_array($rsn);
	echo $rown["classname"];
	
	if (strpos($row["smallclasszm"],",")>0){
	$sqln="select classname from zzcms_zsclass where parentid='".$row["bigclasszm"]."' and classzm in (".$row["smallclasszm"].") ";
	$rsn = mysql_query($sqln);
	echo "<br/> ";
	while($rown = mysql_fetch_array($rsn)){
	echo " [".$rown["classname"]."]";
	}
	}else{
	$sqln="select classname from zzcms_zsclass where classzm='".$row["smallclasszm"]."' ";
	$rsn = mysql_query($sqln); 
	$rown = mysql_fetch_array($rsn);
	echo "<br/>".$rown["classname"];
	}
	  ?>	  </td>
      <td width="93" align="center"><a href="<?php echo $row["img"] ?>" target='_blank'><img src="<?php echo $row["img"] ?>" width="60" height="60" border="0"></a></td>
      <td width="86" align="center" title='<?php echo $row["city"]?>'> 
	  <?php echo $row["province"].$row["city"]?>        </td>
      <td width="97" align="center"><?php echo $row["sendtime"]?></td>
      <td width="50" align="center"><?php echo $row["refresh"]?>次</td>
      <td width="57" align="center"> 
	  <?php 
	if ($row["passed"]==1 ){ echo "已审";}else{ echo "<font color=red>待审</font>";}
	if ($row["elite"]<>0) { echo "<br><font color=green title='中标关键词:".$row["tag"]."&#10;中标时间:".$row["elitestarttime"]."至".$row["eliteendtime"]."'>中标</font>";}
	  ?> </td>
            <td width="92" align="center" class="docolor"> 
              <a href="zsmodify.php?id=<?php echo $row["id"]?>&page=<?php echo $page?>">修改</a> 
              | <a href="zspx.php" target="_self">排序</a>| <a href="zs_elite.php?id=<?php echo $row["id"]?>&page=<?php echo $page?>">投标</a></td>
            <td width="42" align="center" class="docolor"><input name="id[]" type="checkbox" id="id" value="<?php echo $row["id"]?>" /></td>
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
          <input name="submit"  type="submit" class="buttons"  value="删除" onclick="return ConfirmDel()" />
          <input name="pagename" type="hidden" id="pagename" value="zsmanage.php?page=<?php echo $page ?>" />
          <input name="tablename" type="hidden" id="tablename" value="zzcms_main" />
          </div>
</form>
<?php
}
?>
</div>
</div>
</div>
</body>
</html>