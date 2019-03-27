<?php
include("../inc/conn.php");
include("check.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title>自助广告</title>
<link href="style.css" rel="stylesheet" type="text/css">
<script language = "JavaScript">
function CheckForm()
{
  if (document.myform.adv.value=="")
  {
    alert("请填写广告词！");
	document.myform.adv.focus();
	return false;
  } 
}

function showtxt()
{
var sd =window.showModalDialog('/uploadimg_form.php?noshuiyin=1','','dialogWidth=400px;dialogHeight=300px');
//for chrome 
if(sd ==undefined) {  
sd =window.returnValue; 
}
if(sd!=null) {  
document.getElementById("img").value=sd;//从子页面得到值写入母页面
document.getElementById("showimg").innerHTML="<img src='../"+sd+"' width=120>";
}
}
		
</script>
</head>
<?php
if (isset($_REQUEST["action"])){
$action=$_REQUEST["action"];
}else{
$action="";
}
if (isset($_REQUEST["adv"])){
$adv=$_REQUEST["adv"];
}else{
$adv="";
}
if (isset($_REQUEST["advlink"])){
$advlink=$_REQUEST["advlink"];
}else{
$advlink="";
}
if (isset($_REQUEST["company"])){
$company=$_REQUEST["company"];
}else{
$company="";
}
if (isset($_REQUEST["img"])){
$img=$_REQUEST["img"];
}else{
$img="";
}
if (isset($_REQUEST["oldimg"])){
$oldimg=$_REQUEST["oldimg"];
}else{
$oldimg="";
}

$rs=mysql_query("select usersf from zzcms_user where username='".$_COOKIE["UserName"]."' ");
$row=mysql_fetch_array($rs);
if ($row["usersf"]=="个人"){
echo "个人用户不能抢占广告位";
mysql_close($conn);
exit;
}

if ($action=="modify"){
mysql_query("update zzcms_textadv set adv='$adv',company='$company',advlink='$advlink',img='$img',passed=0 where username='".$_COOKIE["UserName"]."'");
//为了防止一个用户通过修改广告词功能长期霸占一个位置当用户修改广告词时只更新其内容不更新时间。
//deloldimg
if ($oldimg<>$img){
		$f="../".$oldimg;
		if (file_exists($f)){
		unlink($f);		
		}
}
	//修改广告词后验查一下此用户是否已抢占了广告位
	//$rs=mysql_query("select * from zzcms_ad where username='".$_COOKIE["UserName"]."'");
    //$row=mysql_num_rows($rs);
	//if ($row){
	//mysql_query("update zzcms_ad set title='<b>新的广告内容正在审核中...</b>',link='###' where username='".$_COOKIE["UserName"]."'");
	//}
	echo "<script>alert('广告修改成功！提示：通过审核后新广告内容才显示');location.href='adv2.php'</script>";
}
		
if ($action=="add"){
mysql_query("insert into zzcms_textadv (adv,company,advlink,img,username,passed,gxsj)values('$adv','$company','$advlink','$img','".$_COOKIE["UserName"]."',0,'".date('Y-m-d H:i:s')."') ");
if ($oldimg<>$img && $oldimg!=''){
		$f="../".$oldimg;
		if (file_exists($f)){
		unlink($f);		
		}
}
		echo "<script>alert('广告词设置成功！现在可以抢占广告位置了');location.href='adv2.php'</script>";
}

?>
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
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td class="admintitle">自助广告</td>
  </tr>
</table>
<?php
$rs=mysql_query("select * from zzcms_textadv where username='".$_COOKIE["UserName"]."'");
$row=mysql_num_rows($rs);
if ($row){
$row=mysql_fetch_array($rs);
?> 
<form name="myform" method="post" action="?action=modify" onSubmit="return CheckForm();"> 
        <table width="100%" border="0" cellpadding="3" cellspacing="1">
          <tr> 
            <td width="27%" align="right" class="border"> <p><strong>广告内容<br>
                </strong>最多15个字符<br>
              </p></td>
            <td width="73%" class="border"> <input name="adv" type="text" id="adv" value="<?php echo $row["adv"]?>" size="40" maxlength="15"> 
              <?php
			
			$rsn=mysql_query("select id,comane from zzcms_user where username='".$_COOKIE["UserName"]."'");
           $rown=mysql_fetch_array($rsn);
			?>
              <input name="advlink" type="hidden" id="advlink4" value="<?php echo getpageurl("zt",$rown["id"])?>"> 
              <input name="company" type="hidden" id="company" value="<?php echo $rown["comane"]?>"> 
            </td>
          </tr>
          <tr> 
            <td align="right" class="border"><strong>广告图片 
              <input name="oldimg" type="hidden" id="oldimg" value="<?php echo $row["img"]?>" />
              <input name="img" type="hidden" id="img" value="<?php echo $row["img"]?>" size="50" />
              </strong></td>
            <td class="border"> <table width="120" height="120" border="0" cellpadding="5" cellspacing="0" class="borderforimg">
                <tr> 
                  <td align="center" id="showimg" onclick='showtxt()'> 
                    <?php
				 if ($row["img"]<>""){
						if (substr($row["img"],-3)=="swf"){
						$str=$str."<object classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0' width='120' height='120'>";
						$str=$str."<param name='wmode' value='transparent'>";
						$str=$str."<param name='movie' value='".$row["img"]."' />";
						$str=$str."<param name='quality' value='high' />";
						$str=$str."<embed src='".$row["img"]."' quality='high' pluginspage='http://www.macromedia.com/go/getflashplayer' type='application/x-shockwave-flash' width='120'  height='120' wmode='transparent'></embed>";
						$str=$str."</object>";
						echo $str;
						}elseif (strpos("gif|jpg|png|bmp",substr($row["img"],-3))!==false ){
                    	echo "<img src='".$row["img"]."' width='120'  border='0'> ";
                    	}
						echo "点击可更换图片";
					}else{
                     echo "<input name='Submit2' type='button'  value='上传图片'/>";
                    }	
				  ?>
                  </td>
                </tr>
              </table></td>
          </tr>
          <tr> 
            <td align="right" class="border2"><strong>显示效果</strong></td>
            <td class="border2"> 
              <?php if ($row["adv"]<>""){ echo "<a href='".$row["advlink"]."' target='_blank'>".$row["adv"]."</a>";}?>
            </td>
          </tr>
          <tr> 
            <td align="right" class="border"><strong>信息状态</strong></td>
            <td class="border">
              <?php if ($row["passed"]==1){ echo "广告词已通过审核"; }else{ echo "<font color=red>未审核</font>";}?>
            </td>
          </tr>
          <tr> 
            <td colspan="2" align="center" class="border2"> <input name="Submit2" type="submit" class="buttons" value="修 改"> 
            </td>
          </tr>
        </table>
  </form>
<?php 
}else{
?>
    <form name="myform" method="post" action="?action=add" onSubmit="return CheckForm();">    
        <table width="100%" border="0" cellpadding="3" cellspacing="1">
          <tr> 
            <td width="27%" align="right" class="border"> <p><strong>广告内容<br>
                </strong>最多15个字符<br>
              </p></td>
            <td width="73%" class="border"> <input name="adv" type="text" id="adv" size="40" maxlength="15"> 
              <?php
			
			$rsn=mysql_query("select id,comane from zzcms_user where username='".$_COOKIE["UserName"]."'");
            $rown=mysql_fetch_array($rsn)
			?>
              <input name="advlink" type="hidden" id="advlink" value="<?php echo getpageurl("zt",$rown["id"])?>"> 
              <input name="company" type="hidden"  value="<?php echo $rown["comane"]?>"> 
            </td>
          </tr>
          <tr> 
            <td align="right" class="border"><strong>广告图片 
              <input name="img" type="hidden" id="img3" size="50" />
              </strong></td>
            <td class="border"> <table width="120" height="120" border="0" cellpadding="5" cellspacing="1" bgcolor="#999999">
                <tr> 
                  <td align="center" bgcolor="#FFFFFF" id="showimg" onclick='showtxt()'> 
                    <input name='Submit2' type='button'  value='上传图片'/> </td>
                </tr>
              </table></td>
          </tr>
          <tr> 
            <td align="right" class="border2"><strong>显示效果</strong></td>
            <td class="border2"> 
              <?php if ($adv<>""){ echo"<a href='".$advlink."' target='_blank'>".$adv."</a>";}?>
            </td>
          </tr>
          <tr> 
            <td colspan="2" align="center" class="border"> <input name="Submit3" type="submit" class="buttons" value="发 布"> 
            </td>
          </tr>
        </table>
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