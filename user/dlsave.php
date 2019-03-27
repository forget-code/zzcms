<?php
if(!isset($_SESSION)){session_start();} 
include("../inc/conn.php");
include("check.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<link href="style.css" rel="stylesheet" type="text/css">
</head>
<?php
if (isset($_POST["page"])){
$page=$_POST["page"];
}else{
$page=1;
}
if (isset($_POST["dlid"])){
$id=$_POST["dlid"];
}else{
$id=0;
}
$classid=$_POST["classid"];
$cp=$_POST["cp"];
$province=$_POST["province"];
$city=$_POST["city"];
$xiancheng=$_POST["cityforadd"];
$content=$_POST["content"];
$dlsf=$_POST["dlsf"];
if (isset($_POST["companyname"])){
$companyname=$_POST["companyname"];
}else{
$companyname="";
}
if ($dlsf=="个人" ){
$companyname="";
}
$truename=$_POST["truename"];
$tel=$_POST["tel"];
$email=$_POST["email"];
$address=$_POST["address"];

checkyzm($_POST["yzm"]);

if ($_POST["action"]=="add"){
if ($cp<>'' && $truename<>'' && $tel<>''){
mysql_query("Insert into zzcms_dl(classzm,cpid,cp,province,city,content,company,companyname,dlsname,tel,address,email,sendtime,editor) values('$classid',0,'$cp','$province','$city','$content','$dlsf','$companyname','$truename','$tel','$address','$email','".date('Y-m-d H:i:s')."','$username')") ;  
$dlid=mysql_insert_id();	
mysql_query("Insert into `zzcms_dl_".$classid."`(dlid,cpid,cp,province,city,content,company,companyname,dlsname,tel,address,email,sendtime,editor) values('$dlid',0,'$cp','$province','$city','$content','$dlsf','$companyname','$truename','$tel','$address','$email','".date('Y-m-d H:i:s')."','$username')") ; 
}	
}elseif ($_POST["action"]=="modify"){
mysql_query("update zzcms_dl set classzm='$classid',cp='$cp',province='$province',city='$city',content='$content',company='$dlsf',companyname='$companyname',dlsname='$truename',tel='$tel',address='$address',email='$email',sendtime='".date('Y-m-d H:i:s')."' where id='$id'");

mysql_query("update `zzcms_dl_".$classid."` set cp='$cp',province='$province',city='$city',content='$content',company='$dlsf',companyname='$companyname',dlsname='$truename',tel='$tel',address='$address',email='$email',sendtime='".date('Y-m-d H:i:s')."' where dlid='$id'");

}
$_SESSION['content']=$content;
$_SESSION['bigclassid']=$classid;
$_SESSION['province']=$province;
$_SESSION['city']=$city;
$_SESSION['xiancheng']=$xiancheng;
passed("zzcms_dl");		
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
<br><br>
<table width="400" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td class="tstitle"> <?php
	if ($_REQUEST["action"]=="add") {
      echo "添加 ";
	  }else{
	  echo"修改";
	  }
	  echo"成功";
     ?>
      </td>
  </tr>
  <tr> 
    <td><table width="100%" border="0" cellspacing="0" cellpadding="3">
              <tr bgcolor="#FFFFFF"> 
                <td width="25%" align="right" bgcolor="#FFFFFF"><strong>名称：</strong></td>
                <td width="75%"><?php echo $cp?></td>
              </tr>
              <tr bgcolor="#FFFFFF"> 
                <td align="right" bgcolor="#FFFFFF"><strong><?php echo channeldl?>区域：</strong></td>
                <td><?php echo $province.$city?></td>
              </tr>
            </table></td>
  </tr>
  <tr> 
    <td><table width="100%" border="0" cellpadding="5" cellspacing="1">
        <tr> 
          <td width="120" align="center" class="border"><a href="dladd.php">继续添加</a></td>
                <td width="120" align="center" class="border"><a href="dlmodify.php?id=<?php echo $dlid?>">修改</a></td>
                <td width="120" align="center" class="border"><a href="dlmanage.php?page=<?php echo $page?>">返回</a></td>
                <td width="120" align="center" class="border"><a href="<?php echo getpageurl("dl",$dlid)?>" target="_blank">预览</a></td>
        </tr>
      </table></td>
  </tr>
</table>
<?php
mysql_close($conn);
session_write_close();
?>
</div>
</div>
</div>
</body>
</html>