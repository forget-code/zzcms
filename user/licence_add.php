<?php
include("../inc/conn.php");
include("check.php");
$fpath="text/licence_add.txt";
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
<script language = "JavaScript">
function CheckForm(){
<?php echo $f_array[0]?>  
}
</SCRIPT>
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
$tablename="zzcms_licence";
include("checkaddinfo.php");
?>
<FORM name="myform" action="licence_save.php?action=add" method="post" onSubmit="return CheckForm();">
  <table width="100%" border="0" cellpadding="3" cellspacing="1">
    <tr> 
            <td width="17%" align="right" class="border"> <?php echo $f_array[2]?> <input name="img" type="hidden" id="img" value="">
       </td>
            <td width="83%" height="30" class="border"> 
            
<script type="text/javascript">
function showtxt()
{
var sd =window.showModalDialog('/uploadimg_form.php','','dialogWidth=400px;dialogHeight=300px');
//for chrome 
if(sd ==undefined) {  
sd =window.returnValue; 
}
if(sd!=null) {  
document.getElementById("img").value=sd;//从子页面得到值写入母页面
document.getElementById("showimg").innerHTML="<img src='"+sd+"' width=120>";
}
}
</script>
	  <table width="120" height="120" border="0" cellpadding="5" cellspacing="1" bgcolor="#999999">
          <tr align="center" bgcolor="#FFFFFF"> 
            <td id="showimg" onClick="showtxt()"> <input name="Submit2" type="button"  value="<?php echo $f_array[3]?> " /></td>
          </tr>
        </table>

	  </td>
    </tr>
    <tr> 
      <td align="right" class="border2"><?php echo $f_array[4]?> </td>
      <td height="30" class="border2">
<input name="title" type="text" id="title"> </td>
    </tr>
    <tr> 
      <td class="border">&nbsp;</td>
      <td height="30" class="border"><input name=Submit   type=submit class="buttons" id="Submit" value="<?php echo $f_array[5]?> "></td>
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