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
if (isset($_POST["page"])){//返回列表页用
$page=$_POST["page"];
}else{
$page=1;
}

$title=trim($_POST["title"]);
$content=str_replace("'","",stripfxg(trim($_POST["content"])));
$editor=trim($_POST["editor"]);

if ($_POST["action"]=="add"){
$isok=mysql_query("Insert into zzcms_ztad(title,content,editor) values('$title','$content','$editor')");  
$id=mysql_insert_id();		
}elseif ($_POST["action"]=="modify"){
$id=$_POST["id"];
$isok=mysql_query("update zzcms_ztad set title='$title',content='$content',editor='$editor',passed=0 where id='$id'");	
}
passed("zzcms_ztad");	
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
	if ($isok) {
      echo "发布成功 ";
	  }else{
	  echo"发布失败";}
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
          <td width="33%" align="center" class="border"><a href="advadd.php">继续添加</a></td>
		 
                <td width="33%" align="center" class="border"><a href="advmodify.php?id=<?php echo $id?>">修改</a></td>
				
                <td width="33%" align="center" class="border"><a href="advmanage.php?bigclassid=<?php echo $bigclassid?>&page=<?php echo $page?>">返回</a></td>
              </tr>
      </table></td>
  </tr>
</table>
</div>
</div>
</div>
</body>
</html>