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
<title></title>
<script language="javascript" src="/js/timer.js"></script>
<script language = "JavaScript">
function CheckForm(){
if (document.myform.eliteendtime.value==""){
	document.myform.eliteendtime.focus();
    alert('请选择到期时间');
	return false;
}
if (document.myform.tag.value==""){
	document.myform.tag.focus();
    alert('关键词不能为空');
	return false;
  }
}    
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
$err=0;
if (isset($_REQUEST['action'])){
$action=$_REQUEST['action'];
}else{
$action="";
}
if (isset($_GET["page"])){
$page=$_GET["page"];
}else{
$page=1;
}

if (isset($_REQUEST["id"])){
$id=$_REQUEST["id"];
}else{
$id=0;
}

if ($action=='modify'){

if (isset($_POST["eliteendtime"])){
$eliteendtime=$_POST["eliteendtime"];
}

if (strtotime($eliteendtime)<=time()){
$err=1;
$errmsg='时间已过期';
}

if (isset($_POST["oldeliteendtime"])){
$oldeliteendtime=$_POST["oldeliteendtime"];
	if (strtotime($oldeliteendtime)<time()){//设过值，过期了
	$oldeliteendtime=date('Y-m-d');
	}
}else{
$oldeliteendtime=date('Y-m-d');//没有设过值的
}

if (isset($_POST["tag"])){
$tag=$_POST["tag"];
}

$sql="select id,proname,eliteendtime,tag from zzcms_main where tag='".$tag."' and id<>'$id'";
$rs = mysql_query($sql); 
$row=mysql_num_rows($rs);
if ($row){
$row = mysql_fetch_array($rs);
$err=1;
$errmsg="此关键词已有中标产品:<a href='/zs/search.php?keyword=".$row['tag']."'>".$row['proname']."</a><br>中标期限至：".$row['eliteendtime'];
}
if ($err==1){
WriteErrMsg($errmsg);
}else{
$day=floor((strtotime($eliteendtime)-strtotime($oldeliteendtime))/(24*3600));//按到期时间计费，这样改关键词可免费，续期只收续期的费用
$jfpay=$day*jf_set_elite;
if ($jfpay<0){ $jfpay=0; }
//echo $jfpay;
switch (check_user_power('set_elite')){
case 'yes':
if (jifen=="Yes"){
$sqln="select totleRMB from zzcms_user where username='".$username."'";
$rsn = mysql_query($sqln);
$rown = mysql_fetch_array($rsn);
	if ($rown["totleRMB"]>=$jfpay){
	mysql_query("update zzcms_user set totleRMB=totleRMB-$jfpay where username='".$username."'");
	mysql_query("update zzcms_main set elitestarttime='".date('Y-m-d')."',eliteendtime='$eliteendtime',tag='$tag',elite=1 where id='$id'");
	mysql_query("insert into zzcms_pay (username,dowhat,RMB,mark,sendtime) values('$username','投标".channelzs."信息','-$jfpay','产品ID：<a href=zsmanage.php?id=$id>$id</a>','".date('Y-m-d H:i:s')."')");
	echo "<script>alert('成功,计费时间".$oldeliteendtime."至".$eliteendtime.",共计".$day."天，".jf_set_elite."个金币/天，共付出".$jfpay."个金币');location.href='zsmanage.php?page=".$_REQUEST["page"]."'</script>";
	}else{
	echo "<script>alert('失败，你的金币不足".$jfpay."');history.back()</script>";
	}			
}elseif (jifen=="No") {
echo "<script>alert('积分功能关闭，无法使用此功能！');history.back(-1)</script>";
}
break;
case 'no':
echo "<script>alert('你所在的用户组没有此权限');history.back()'</script>";
}

}
}else{

$sql="select id,editor,proname,eliteendtime,tag from zzcms_main where id='$id'";
$rs = mysql_query($sql); 
$row = mysql_fetch_array($rs);
if ($row["editor"]<>$username) {
markit();
showmsg('非法操作！警告：你的操作已被记录！小心封你的用户及IP！');
}
?>
<div class="admintitle">投标</div>
<form action="?" method="post" name="myform" id="myform" onSubmit="return CheckForm();">
        <table width="100%" border="0" cellpadding="3" cellspacing="1">
          <tr> 
            <td width="18%" align="right" class="border" >产品名称</td>
            <td width="82%" class="border" > <?php echo $row["proname"]?></td>
          </tr>
          <tr> 
            <td align="right" class="border" >到期时间<font color="#FF0000">&nbsp; 
              </font></td>
            <td class="border" > <input name="eliteendtime" type="text" id="eliteendtime" value="<?php echo $row["eliteendtime"]?>" size="30" maxlength="45" onFocus="JTC.setday(this)">
              <input name="oldeliteendtime" type="hidden"  value="<?php echo $row["eliteendtime"]?>" size="30" maxlength="45" />
              <?php echo jf_set_elite?>积分/天</td>
          </tr>
          
          <tr> 
            <td align="right" class="border" >关键词（tag）</td>
            <td class="border" > <input name="tag" type="text" id="tag" value="<?php echo $row["tag"] ?>" size="10" maxlength="4">
              (多个关键词以“,”隔开)</td>
          </tr>
          <tr> 
            <td align="center" class="border" >&nbsp;</td>
            <td class="border" > <input name="id" type="hidden" id="ypid2" value="<?php echo $row["id"] ?>"> 
              <input name="action" type="hidden" id="action2" value="modify">
              <span class="border">
              <input name="page" type="hidden" id="page" value="<?php echo $_GET["page"]?>" />
              </span>
              <input name="Submit" type="submit" class="buttons" value="提交"></td>
          </tr>
        </table>
	  </form>
<?php
}
?>	  
</div>
</div>
</div>
</body>
</html>