<?php
if(!isset($_SESSION)){session_start();} 
include("../inc/conn.php");
include("check.php");
$fpath="text/ppsave.txt";
$fcontent=file_get_contents($fpath);
$f_array=explode("|||",$fcontent) ;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title></title>
<link href="style.css" rel="stylesheet" type="text/css">
<?php
if (check_usergr_power("pp")=="no" && $usersf=='个人'){
echo $f_array[0];
exit;
}

if (isset($_REQUEST["page"])){ 
$page=$_REQUEST["page"];
}else{
$page=1;
}
$bigclassid=trim($_POST["bigclassid"]);
$smallclassid=trim($_POST["smallclassid"]);
$cp_name=$_POST["name"];
$sm=$_POST["sm"];
$img=$_POST["img1"];

$rs=mysql_query("select comane,id from zzcms_user where username='".$username."'");
$row=mysql_fetch_array($rs);
$comane=$row["comane"];
$userid=$row["id"];


$cpid=isset($_POST["ypid"])?$_POST["ypid"]:'0';
//判断大小类是否一致，修改产品时有用
if ($smallclassid<>""){ 
$sql="select * from zzcms_zsclass where parentid='".$bigclassid."' and  classzm='".$smallclassid."'";
$rs=mysql_query($sql);
$row=mysql_fetch_array($rs);
if (!$row){
echo $f_array[1];
echo"<script>location.href='ppmodify.php?id=".$cpid."'</script>";
}
}

//判断是不是重复信息
if ($_REQUEST["action"]=="add" ){
$sql="select * from zzcms_pp where ppname='".$cp_name."' and editor='".$username."' ";
$rs=mysql_query($sql);
$row=mysql_num_rows($rs);
if ($row){
echo $f_array[2];
exit;
}
}elseif($_REQUEST["action"]=="modify"){
$sql="select * from zzcms_pp where ppname='".$cp_name."' and editor='".$username."' and id<>".$cpid." ";
$rs=mysql_query($sql);
$row=mysql_num_rows($rs);
if ($row){
echo $f_array[2];
exit;
}
}


if ($_POST["action"]=="add"){
$isok=mysql_query("Insert into zzcms_pp(ppname,bigclasszm,smallclasszm,sm,img,sendtime,editor,userid,comane) values('$cp_name','$bigclassid','$smallclassid','$sm','$img','".date('Y-m-d H:i:s')."','$username','$userid','$comane')") ;  
$cpid=mysql_insert_id();		
}elseif ($_POST["action"]=="modify"){
$oldimg=trim($_POST["oldimg1"]);

$isok=mysql_query("update zzcms_pp set ppname='$cp_name',bigclasszm='$bigclassid',smallclasszm='$smallclassid',sm='$sm',img='$img',sendtime='".date('Y-m-d H:i:s')."',editor='$username',userid='$userid',comane='$comane',passed=0 where id='$cpid'");

	if ($oldimg<>$img && $oldimg<>"image/nopic.gif") {
	//deloldimg
		$f=$oldimg;
		if (file_exists($f)){
		unlink($f);		
		}
		$fs=str_replace(".","_small.",$oldimg);
		if (file_exists($fs)){
		unlink($fs);		
		}
	}
}
			$_SESSION['bigclassid']=$bigclassid;
passed("zzcms_pp");		
?>
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
<br><br>
<table width="400" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td class="tstitle"> <?php
	if ($isok) {
      echo $f_array[3];
	  }else{
	  echo $f_array[4];}
     ?>
      </td>
  </tr>
  <tr> 
    <td><table width="100%" border="0" cellspacing="0" cellpadding="3">
        <tr bgcolor="#FFFFFF"> 
          <td width="25%" align="right" bgcolor="#FFFFFF"><strong><?php echo $f_array[5]?></strong></td>
          <td width="75%"><?php echo $cp_name?></td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td><table width="100%" border="0" cellpadding="5" cellspacing="1">
        <tr> 
          <td width="120" align="center" class="border"><a href="ppadd.php"><?php echo $f_array[5]?></a></td>
                <td width="120" align="center" class="border"><a href="ppmodify.php?id=<?php echo $cpid?>"><?php echo $f_array[6]?></a></td>
                <td width="120" align="center" class="border"><a href="ppmanage.php?page=<?php echo $page?>"><?php echo $f_array[7]?></a></td>
                <td width="120" align="center" class="border"><a href="<?php echo getpageurl("pp",$cpid)?>" target="_blank"><?php echo $f_array[8]?></a></td>
        </tr>
      </table></td>
  </tr>
</table>
<?php
session_write_close();
?>
</div>
</div>
</div>
</body>
</html>