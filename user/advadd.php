<?php
include("../inc/conn.php");
include("check.php");
$fpath="text/advadd.txt";
$fcontent=file_get_contents($fpath);
$f_array=explode("|||",$fcontent) ;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title></title>
<link href="style/<?php echo siteskin_usercenter?>/style.css" rel="stylesheet" type="text/css">
<script language = "JavaScript">
<?php echo $f_array[0];?>
</script>
</head>
<body>
<div class="main">
<?php
include("top.php");
?>
<div class="pagebody">
<div class="right">
<div class="content">
<div class="admintitle"><?php echo $f_array[1];?></div>	  
<form action="advsave.php" method="post" name="myform" id="myform" onSubmit="return CheckForm();">
        <table width="100%" border="0" cellpadding="3" cellspacing="1">
          <tr>
            <td align="right" class="border"><?php echo $f_array[2];?></td>
            <td class="border">
	<select name="classname" id="classname" class="biaodan">
     <option value="<?php echo $f_array[3];?>"><?php echo $f_array[3];?></option>
     </select>
            </td></tr>
          <tr> 
            <td align="right" class="border"><?php echo $f_array[4];?></td>
			
            <td class="border">
			 <input name="title" type="text" id="title" size="50" maxlength="255" class="biaodan"></td>
          </tr>
          <tr>
            <td align="right" class="border"><?php echo $f_array[5];?></td>
            <td class="border"><input name="link" type="text" id="link2" size="50" class="biaodan"/></td>
          </tr>
          <tr>
            <td align="right" class="border"><?php echo $f_array[6];?>
              <input name="img" type="hidden" id="img"></td>
            <td class="border"><script type="text/javascript">
function showtxt(){
var sd =window.showModalDialog('/uploadimg_form.php?noshuiyin=1','','dialogWidth=400px;dialogHeight=300px');
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
                <table width="120" height="120" border="0" cellpadding="5" cellspacing="1" bgcolor="#cccccc">
                  <tr align="center" bgcolor="#FFFFFF">
                    <td id="showimg" onclick="showtxt()"><input name="Submit2" type="button"  value="<?php echo $f_array[7];?>" /></td>
                  </tr>
              </table></td>
          </tr>
          <tr> 
            <td align="right" class="border">&nbsp;</td>
            <td class="border"> <input name="Submit" type="submit" class="buttons" value="<?php echo $f_array[8];?>">
              <input name="editor" type="hidden" id="editor2" value="<?php echo $username?>" />
              <input name="action" type="hidden" id="action3" value="add"></td>
          </tr>
        </table>
</form>
</div>
</div>
<div class="left">
<?php
include("left.php");
unset ($f_array);
?>
</div>
</div>
</div>
</body>
</html>