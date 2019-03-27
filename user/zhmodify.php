<?php
include("../inc/conn.php");
include("check.php");
$fpath="text/zhmodify.txt";
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
<script language="javascript" src="/js/timer.js"></script>
<script type="text/javascript" src="/3/ckeditor/ckeditor.js"></script>
<script language = "JavaScript">
function CheckForm(){
<?php echo $f_array[0]?> 
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
<div class="admintitle"><?php echo $f_array[1]?> </div>
<?php
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
$sqlzh="select * from zzcms_zh where id='$id'";
$rszh = mysql_query($sqlzh); 
$rowzh = mysql_fetch_array($rszh);
if ($rowzh["editor"]<>$username) {
markit();
showmsg('非法操作！警告：你的操作已被记录！小心封你的用户及IP！');
}
?>
<form action="zhsave.php" method="post" name="myform" id="myform" onSubmit="return CheckForm();">
              
        <table width="100%" border="0" cellpadding="3" cellspacing="1">
          <tr> 
            <td align="right" class="border2"><?php echo $f_array[2]?> <font color="#FF0000">*</font></td>
            <td width="726" class="border2"> <select name="bigclassid" id="bigclassid">
                <option value="" selected="selected"><?php echo $f_array[3]?></option>
                <?php
		  
		$sql="select * from zzcms_zhclass";
		$rs=mysql_query($sql);
		while($row= mysql_fetch_array($rs)){
			?>
                <option value="<?php echo $row["bigclassid"]?>"  <?php if ($row["bigclassid"]==$rowzh["bigclassid"]) { echo "selected";}?> ><?php echo $row["bigclassname"]?></option>
                <?php
		  }
		  ?>
              </select> </td>
          </tr>
          <tr> 
            <td width="91" align="right" class="border"><?php echo $f_array[4]?> <font color="#FF0000">*</font></td>
            <td class="border"> <input name="title" type="text" id="title" size="50" maxlength="255" value="<?php echo $rowzh["title"]?>" /> 
            </td>
          </tr>
          <tr> 
            <td align="right" class="border2" ><?php echo $f_array[5]?></td>
            <td class="border2" > <input name="address" type="text" id="address" size="50" maxlength="255" value="<?php echo $rowzh["address"]?>"/></td>
          </tr>
          <tr> 
            <td align="right" class="border" ><?php echo $f_array[6]?></td>
            <td class="border" > <input name="timestart" type="text" id="timestart" value="<?php echo $rowzh["timestart"]?>" onfocus="JTC.setday(this)" />
              -
              <input name="timeend" type="text" id="timeend" value="<?php echo $rowzh["timeend"]?>" onfocus="JTC.setday(this)" /> 
            </td>
          </tr>
          <tr> 
            <td align="right" class="border2" ><?php echo $f_array[7]?></td>
            <td class="border2" > <textarea    name="content" id="content"><?php echo $rowzh["content"]?></textarea> 
              <script type="text/javascript">
				CKEDITOR.replace('content');	
			</script>
            </td>
          </tr>
          <tr> 
            <td align="right" class="border">&nbsp;</td>
            <td class="border"> <input name="Submit" type="submit" class="buttons" value="<?php echo $f_array[8]?>"> 
              <input name="action" type="hidden" id="action3" value="modify">
              <input name="editor" type="hidden" id="editor" value="<?php echo $username?>" />
              <input name="page" type="hidden" id="page" value="<?php echo $page?>" />
              <input name="id" type="hidden" id="id" value="<?php echo $rowzh["id"] ?>" /></td>
          </tr>
        </table>
</form>
</div>
</div>
</div>
<?php
mysql_close($conn)
?>
</body>
</html>