<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title>用户中心</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<?php
include("../inc/conn.php");
include("check.php");

if (check_usergr_power("zt")=="no" && $usersf=='个人'){
showmsg('个人用户没有此权限');
}

if (isset($_REQUEST["action"])){
$action=$_REQUEST["action"];
}else{
$action="";
}
if($action=="modify"){
$skin=$_POST["skin"];

mysql_query("update zzcms_usersetting set skin='$skin' where username='".$username."'");			
echo "<script>alert('成功更新设置');location.href='ztconfig_skin.php'</script>";	
}
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
<div class="admintitle">展厅设置</div>

<form name="myform" method="post" action="?action=modify"> 
<div style="padding:5px;text-align:center"><input name="Submit" type="submit" class="buttons" value="更新设置" /></div>
<table width="95%" border="0" cellpadding="5" cellspacing="0">
                  <tr>        
                    <?php 
$rs=mysql_query("select skin from zzcms_usersetting where username='".$username."'");
$row=mysql_fetch_array($rs);					
$dir = opendir("../skin");
$i=0;
while(($file = readdir($dir))!=false){
  if ($file!="." && $file!=".." && strpos($file,".zip")==false && strpos($file,".rar")==false && strpos($file,".txt")==false && $file!='mobile') { //不读取. ..
    //$f = explode('.', $file);//用$f[0]可只取文件名不取后缀。 
?>
                    <td><table width="120" border="0" cellpadding="5" cellspacing="1">
                        <tr> 
                          <td height="100" align="center" bgcolor="#FFFFFF"><img src='../skin/<?php echo $file?>/image/mb.gif' width="120"  border='0'/></td>
                        </tr>
                        <tr> 
                          <td align="center" bgcolor="#FFFFFF"> <input name="skin" type="radio" id='<?php echo $file?>' value="<?php echo $file?>" <?php if($row["skin"]==$file){ echo"checked";}?>/> 
                            <label for='<?php echo $file.$row["skin"]?>'><?php echo $file?></label></td>
                        </tr>
                      </table></td>
                    <?php 
				  $i=$i+1;
				  if($i % 5==0 ){
				  echo"<tr>";
				  }
				}
				}	
closedir($dir)
				?>
           </table>  
<div style="padding:5px;text-align:center"><input name="Submit" type="submit" class="buttons" value="更新设置" /></div>
</form>
</div>
</div>
</div>
</body>
</html>