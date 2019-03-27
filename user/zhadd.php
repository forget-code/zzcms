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
?>
<script language="javascript" src="/js/timer.js"></script>
<script type="text/javascript" src="/3/ckeditor/ckeditor.js"></script>
<script language = "JavaScript">
function CheckForm()
{
if (document.myform.bigclassid.value=="")
  {
    alert("请选择展会类型！");
	document.myform.bigclassid.focus();
	return false;
  }	  
if (document.myform.title.value=="")
  {
    alert("展会名称不能为空！");
	document.myform.title.focus();
	return false;
  }
  if (document.myform.address.value=="")
  {
    alert("展会地址不能为空！");
	document.myform.address.focus();
	return false;
  }
  if (document.myform.TimeStart.value=="")
  {
    alert("展会开始时间不能为空！");
	document.myform.TimeStart.focus();
	return false;
  }
  if (document.myform.TimeEnd.value=="")
  {
    alert("展会截止时间不能为空！");
	document.myform.TimeEnd.focus();
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
<div class="admintitle">发布展会信息</div>
<?php
$tablename="zzcms_zh";//checkaddinfo中用
include("checkaddinfo.php");
?>
<form action="zhsave.php" method="post" name="myform" id="myform" onSubmit="return CheckForm();">
              
        <table width="100%" border="0" cellpadding="3" cellspacing="1">
          <tr> 
            <td align="right" class="border2">所属类别 <font color="#FF0000">*</font></td>
            <td width="726" class="border2"> <select name="bigclassid" id="bigclassid">
                <option value="" selected="selected">请选择类别</option>
                <?php
		  
		$sql="select * from zzcms_zhclass";
		$rs=mysql_query($sql);
		while($row= mysql_fetch_array($rs)){
			?>
                <option value="<?php echo $row["bigclassid"]?>" ><?php echo $row["bigclassname"]?></option>
                <?php
		  }
		  ?>
              </select> </td>
          </tr>
          <tr> 
            <td width="91" align="right" class="border">展会名称 <font color="#FF0000">*</font></td>
            <td class="border"> <input name="title" type="text" id="title" size="50" maxlength="255"> 
            </td>
          </tr>
          <tr> 
            <td align="right" class="border2" >会议地址：</td>
            <td class="border2" > <input name="address" type="text" id="address" size="50" maxlength="255" /></td>
          </tr>
          <tr> 
            <td align="right" class="border" >会议时间：</td>
            <td class="border" > <input name="timestart" type="text" id="timestart" value="<?php echo date('Y-m-d')?>" onfocus="JTC.setday(this)" />
              至 
              <input name="timeend" type="text" id="timeend" value="<?php echo date('Y-m-d')?>" onfocus="JTC.setday(this)" /> 
            </td>
          </tr>
          <tr> 
            <td align="right" class="border2" >展会内容：</td>
            <td class="border2" > <textarea    name="content" id="content"></textarea> 
              <script type="text/javascript">
				CKEDITOR.replace('content');	
			</script> <input name="editor" type="hidden" id="editor" value="<?php echo $username?>" /> 
            </td>
          </tr>
          <tr> 
            <td align="right" class="border">&nbsp;</td>
            <td class="border"> <input name="Submit" type="submit" class="buttons" value="发 布"> 
              <input name="action" type="hidden" id="action3" value="add"></td>
          </tr>
        </table>
</form>
</div>
</div>
</div>
<?php
mysql_close($conn);
?>
</body>
</html>