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
if (check_usergr_power("zh")=="no" && $usersf=='个人'){
showmsg('个人用户没有此权限');
}

if (isset($_POST["page"])){//返回列表页用
$page=$_POST["page"];
}else{
$page=1;
}
$bigclassid=trim($_POST["bigclassid"]);
$title=trim($_POST["title"]);
$address=trim($_POST["address"]);
$timestart=trim($_POST["timestart"]);
$timeend=trim($_POST["timeend"]);
$content=str_replace("'","",stripfxg(trim($_POST["content"])));
$editor=trim($_POST["editor"]);
if ($_POST["action"]=="add" && $editor<>''){//$editor<>''防垃圾信息
mysql_query("Insert into zzcms_zh(bigclassid,title,address,timestart,timeend,content,editor,sendtime) values('$bigclassid','$title','$address','$timestart','$timeend','$content','$editor','".date('Y-m-d H:i:s')."')") ;  
$id=mysql_insert_id();
		
}elseif ($_POST["action"]=="modify"){
$id=$_POST["id"];
mysql_query("update zzcms_zh set bigclassid='$bigclassid',title='$title',address='$address',timestart='$timestart',timeend='$timeend',content='$content',
editor='$editor',sendtime='".date('Y-m-d H:i:s')."' where id='$id'");
}		
passed("zzcms_zh");
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
          <td><table width="100%" border="0" cellspacing="0" cellpadding="5">
              <tr bgcolor="#FFFFFF"> 
                <td width="25%" align="right" bgcolor="#FFFFFF">标题：</td>
                <td width="75%"><?php echo $title?></td>
              </tr>
              <tr bgcolor="#FFFFFF"> 
                <td align="right" bgcolor="#FFFFFF">地点：</td>
                <td><?php echo  $address?></td>
              </tr>
              <tr bgcolor="#FFFFFF"> 
                <td align="right" bgcolor="#FFFFFF">时间：</td>
                <td><?php echo $timestart?>至<?php echo $timeend?></td>
              </tr>
            </table></td>
  </tr>
  <tr> 
    <td><table width="100%" border="0" cellpadding="5" cellspacing="1">
        <tr> 
          <td width="120" align="center" class="border"><a href="zhadd.php">继续添加</a></td>
                <td width="120" align="center" class="border"><a href="zhmodify.php?id=<?php echo $id?>">修改</a></td>
                <td width="120" align="center" class="border"><a href="zhmanage.php?page=<?php echo $page?>">返回</a></td>
                <td width="120" align="center" class="border"><a href="<?php echo getpageurl("zh",$id)?>" target="_blank">预览</a></td>
        </tr>
      </table></td>
  </tr>
</table>
<?php
mysql_close($conn);
?>
</div>
</div>
</div>
</body>
</html>