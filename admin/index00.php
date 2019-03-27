<?php
define('checkadminlogin',1);
include("admin.php");

if (opensite=='No' ){
echo "<script>location.href='siteconfig.php#SiteOpen'</script>";
}	
?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>管理员后台</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<style>
html,body{overflow: hidden;margin: 0px;height:100%}/*使不显示双滚动条，必须设height值，否则最外层DIV设值无效*/
</style>
<script>
var status = 1;
function switchSysBar(){
     if (1 == window.status){
		  window.status = 0;
          switchPoint.innerHTML = '<img src="image/manage_left.gif">';
          document.all("frmTitle").style.display="none"
     }
     else{
		  window.status = 1;
          switchPoint.innerHTML = '<img src="image/manage_right.gif">';
          document.all("frmTitle").style.display=""
     }
}
</script>
<body>
<div style="height:45px;overflow:hidden">
<iframe frameborder="0" id="top" name="top" scrolling="no" marginheight="0" src="top.php"  style="height:45px;width: 100%;"></iframe>
</div>

<div class="userbar">
 <?php $rs=query("select groupname from zzcms_admingroup where id=(select groupid from zzcms_admin where admin='".@$_COOKIE["admin"]."')");
	  $row= fetch_array($rs);
	  echo "您好<b>".@$_COOKIE["admin"]."</b>(" .$row["groupname"].")";
	  ?>
        [ <a href="/index.php" target="_top">返回首页</a> | <a href="loginout.php" target="_top">安全退出</a> 
        ] [ <a href="http://www.zzcms.net/help.asp" target="_blank">操作说明</a> ]
</div>

<div style="background:#C3DAF9;height:100%">
<table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
  <tr>
    <td align="middle" valign="top" width="185" id="FrmTitle" height="100%">
	<iframe frameborder="0" id="frmleft" name="frmleft" src="left.php" style="height:100%; visibility: inherit;width: 185px;" allowtransparency="true"></iframe>
	</td>
	  <td width="18"  valign="middle" height="100%"> 
        <div onClick="switchSysBar()"> <span class="navpoint" id="switchPoint" title="关闭/打开左栏"><img src="image/manage_right.gif" alt="" /></span> 
        </div>
	</td>
	<td valign="top" height="95%">
<iframe frameborder="0" id="frmright" name="frmright" scrolling="yes" src="right.php" style="height:95%; visibility: inherit; width:100%; z-index:1;"></iframe>
	</td>
  </tr>
</table>
</div>	
</body>
</html>