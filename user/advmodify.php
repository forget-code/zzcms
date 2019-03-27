<?php
include("../inc/conn.php");
include("check.php");
$fpath="text/advmodify.txt";
$fcontent=file_get_contents($fpath);
$f_array=explode("\n",$fcontent) ;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title></title>
<link href="style.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="/3/ckeditor/ckeditor.js"></script>
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
$sqlzx="select * from zzcms_ztad where id='$id'";
$rszx = mysql_query($sqlzx); 
$rowzx = mysql_fetch_array($rszx);
if ($rowzx["editor"]<>$username) {
markit();
echo $f_array[2];
exit;
}
?>	  
<form action="advsave.php" method="post" name="myform" id="myform" onSubmit="return CheckForm();">
        <table width="100%" border="0" cellpadding="3" cellspacing="1">
          <tr>
            <td align="right" class="border"><?php echo $f_array[3]?></td>
            <td class="border"><select name="classname" id="classname">
                <option value="<?php echo $f_array[4]?>"><?php echo $f_array[4]?></option>
              </select>
            </td>
          </tr>
          <tr> 
            <td width="109" align="right" class="border"><?php echo $f_array[5]?> <font color="#FF0000">*</font></td>
			
            <td width="708" class="border">
			 <input name="title" type="text" id="title2" size="50" maxlength="255" value="<?php echo $rowzx["title"]?>" ></td>
          </tr>
          <tr>
            <td align="right" class="border"><?php echo $f_array[6]?><font color="#FF0000">*</font></td>
            <td class="border"><input name="link" type="text" id="link" size="50" maxlength="255" value="<?php echo $rowzx["link"]?>"></td>
          </tr>
          <tr>
            <td align="right" class="border"><?php echo $f_array[7]?>
              <input name="oldimg" type="hidden" id="oldimg" value="<?php echo $rowzx["img"]?>" />
                <input name="img" type="hidden" id="img" value="<?php echo $rowzx["img"]?>" /></td>
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
                <table width="120" height="120" border="0" cellpadding="5" cellspacing="1" bgcolor="#999999">
                  <tr>
                    <td align="center" bgcolor="#FFFFFF" id="showimg" onclick='showtxt()'><?php
				 if ($rowzx["img"]<>""){
						if (substr($rowzx["img"],-3)=="swf"){
						$str=$str."<object classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0' width='120' height='120'>";
						$str=$str."<param name='wmode' value='transparent'>";
						$str=$str."<param name='movie' value='".$rowzx["img"]."' />";
						$str=$str."<param name='quality' value='high' />";
						$str=$str."<embed src='".$rowzx["img"]."' quality='high' pluginspage='http://www.macromedia.com/go/getflashplayer' type='application/x-shockwave-flash' width='120'  height='120' wmode='transparent'></embed>";
						$str=$str."</object>";
						echo $str;
						}elseif (strpos("gif|jpg|png|bmp",substr($rowzx["img"],-3))!==false ){
                    	echo "<img src='".$rowzx["img"]."' width='120'  border='0'> ";
                    	}
					echo $f_array[8];	
					}else{
                     echo "<input name='Submit2' type='button'  value='".$f_array[9]."'/>";
                    }	
				  ?>                    </td>
                  </tr>
                </table>              </td>
          </tr>
            <td align="right" class="border2">&nbsp;</td>
            <td class="border2"> <input name="Submit" type="submit" class="buttons" value="<?php echo $f_array[10]?>">
              <input name="id" type="hidden" id="ypid2" value="<?php echo $rowzx["id"] ?>" /> 
              <input name="editor" type="hidden" id="editor2" value="<?php echo $username?>" />
              <input name="page" type="hidden" id="action" value="<?php echo $page?>" />
              <input name="action" type="hidden" id="action2" value="modify" /></td>
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