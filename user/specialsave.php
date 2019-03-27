<?php
if(!isset($_SESSION)){session_start();} 
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
if (check_usergr_power("special")=="no" && $usersf=='个人'){
showmsg('个人用户没有此权限');
}
if (isset($_POST["page"])){//返回列表页用
$page=$_POST["page"];
}else{
$page=1;
}
if (isset($_POST["bigclassid"])){
$bigclassid=trim($_POST["bigclassid"]);
}else{
$bigclassid=0;
}
$bigclassname="";
if ($bigclassid!=0){
$bigclassid=trim($_POST["bigclassid"]);
$rs = mysql_query("select * from zzcms_specialclass where classid='$bigclassid'"); 
$row= mysql_fetch_array($rs);
$bigclassname=$row["classname"];
}

if (isset($_POST["smallclassid"])){
$smallclassid=trim($_POST["smallclassid"]);
}else{
$smallclassid=0;
}
$smallclassname="";
if ($smallclassid!=0){
$rs = mysql_query("select * from zzcms_specialclass where classid='$smallclassid'"); 
$row= mysql_fetch_array($rs);
$smallclassname=$row["classname"];
}

$title=trim($_POST["title"]);
$link=trim($_POST["link"]);
$laiyuan=trim($_POST["laiyuan"]);
$content=str_replace("'","",stripfxg(trim($_POST["content"])));
$img=getimgincontent($content);
$editor=trim($_POST["editor"]);
$keywords=trim($_POST["keywords"]);
if ($keywords=="" ){
$keywords=$title;
}
$description=trim($_POST["description"]);
$groupid=trim($_POST["groupid"]);
$jifen=trim($_POST["jifen"]);
if ($_POST["action"]=="add"){
//判断是不是重复信息,为了修改信息时不提示这段代码要放到添加信息的地方
$sql="select title,editor from zzcms_special where title='".$title."'";
$rs = mysql_query($sql); 
$row= mysql_num_rows($rs); 
if ($row){
mysql_close($conn);
echo "<script lanage='javascript'>alert('此信息已存在，请不要发布重复的信息！');</script>";
echo "<script lanage='javascript'>location.replace('specialadd.php')</script>";
}

mysql_query("Insert into zzcms_special(bigclassid,bigclassname,smallclassid,smallclassname,title,link,laiyuan,keywords,description,groupid,jifen,content,img,editor,sendtime) values('$bigclassid','$bigclassname','$smallclassid','$smallclassname','$title','$link','$laiyuan','$keywords','$description','$groupid','$jifen','$content','$img','$editor','".date('Y-m-d H:i:s')."')");  
$id=mysql_insert_id();		
}elseif ($_POST["action"]=="modify"){
$id=$_POST["id"];
mysql_query("update zzcms_special set bigclassid='$bigclassid',bigclassname='$bigclassname',smallclassid='$smallclassid',smallclassname='$smallclassname',title='$title',link='$link',laiyuan='$laiyuan',
keywords='$keywords',description='$description',groupid='$groupid',jifen='$jifen',content='$content',img='$img',editor='$editor',
sendtime='".date('Y-m-d H:i:s')."',passed=0 where id='$id'");	
}
$_SESSION['bigclassid']=$bigclassid;
$_SESSION['smallclassid']=$smallclassid;
passed("zzcms_special");	
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
    <td class="tstitle"> 
	 <?php
	if ($_REQUEST["action"]=="add") {
      echo "添加成功 ";
	  }elseif ($_REQUEST["action"]=="modify"){
	  echo"修改成功";
	  }else{
	  echo"没有处理任何信息";
	  }
     ?>

      </td>
  </tr>
  <tr> 
    <td><table width="100%" border="0" cellspacing="0" cellpadding="3">
              <tr bgcolor="#FFFFFF"> 
                <td width="25%" align="right" bgcolor="#FFFFFF"><strong>标题：</strong></td>
                <td width="75%"><?php echo $title?></td>
              </tr>
            </table></td>
  </tr>
  <tr> 
    <td><table width="100%" border="0" cellpadding="5" cellspacing="1">
        <tr> 
          <td width="120" align="center" class="border"><a href="specialadd.php">继续添加</a></td>
		 
                <td width="120" align="center" class="border"><a href="specialmodify.php?id=<?php echo $id?>">修改</a></td>
				
                <td width="120" align="center" class="border"><a href="specialmanage.php?bigclassid=<?php echo $bigclassid?>&page=<?php echo $page?>">返回</a></td>
                <td width="120" align="center" class="border"><a href="<?php echo getpageurl("special",$id)?>" target="_blank">预览</a></td>
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