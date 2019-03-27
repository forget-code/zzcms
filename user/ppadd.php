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
<?php
if (check_usergr_power("pp")=="no" && $usersf=='个人'){
showmsg('个人用户没有此权限');
}
?>
<title></title>
<script language = "JavaScript">
function CheckForm()
{
 if (document.myform.name.value=="")
  {
	document.myform.name.focus();
    document.myform.name.value='此处不能为空';
    document.myform.name.select();
	document.myform.name.style.backgroundColor="FFFF00";
	return false;
  }
	ischecked=false;
 	for(var i=0;i<document.myform.bigclassid.length;i++)
	{ 
		if(document.myform.bigclassid[i].checked==true)  
   		{
		 ischecked=true ;
   		} 
	}
   if(document.myform.bigclassid.checked==true)  
   		{
		 ischecked=true ;
   		} 
 	if (ischecked==false)
  	{
	alert("请选择大类别！");	
    return false;
	}
	
 
	
   if(document.myform.smallclassid.checked==true)  
   		{
		 ischecked=true ;
   		} 
 	if (ischecked==false)
  	{
	alert("请选择小类别！");	
    return false;
	}
	
 } 

function doClick_E(o){
	 var id;
	 var e;
	id=0
	 for(var i=1;i<=document.myform.bigclassid.length;i++){
	   id ="E"+i;
	   e = document.getElementById("E_con"+i);
	   if(id != o.id){
	   	 e.style.display = "none";		
	   }else{
		e.style.display = "block";
	   }
	 }
	   if(id==0){
		document.getElementById("E_con1").style.display = "block";
	   }
	 //document.write(classnum)
	 }

</script>
</head>
<link href="style.css" rel="stylesheet" type="text/css">
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
<div class="admintitle">发布品牌信息</div>
<?php
$tablename="zzcms_main";
include("checkaddinfo.php");
?>
<form  action="ppsave.php" method="post" name="myform" id="myform" onSubmit="return CheckForm();">
        <table width="100%" border="0" cellpadding="3" cellspacing="1">
          <tr> 
            <td width="20%" align="right" class="border2" > 名称 <font color="#FF0000">*</font></td>
            <td class="border2" > <input name="name" type="text" id="name" onclick="javascript:if (this.value=='此处不能为空') {this.value=''};this.style.backgroundColor='';" onblur="javascript:if (this.value=='此处不能为空') {this.value=''};this.style.backgroundColor='';" size="60" maxlength="45" /></td>
          </tr>
          <tr> 
            <td align="right" valign="top" class="border">类别<font color="#FF0000"> 
              *</font></td>
            <td valign="middle" class="border" > <table width="100%" border="0" cellpadding="5" cellspacing="1">
                <tr> 
                  <td> <fieldset>
                    <legend>请选择所属大类</legend>
                    <?php
        $sql = "select * from zzcms_zsclass where parentid='A' order by xuhao asc";
		$rs = mysql_query($sql,$conn); 
		$n=0;
		while($row= mysql_fetch_array($rs)){
		
		$n ++;
		if (@$_SESSION['bigclassid']==$row['classzm']){
		echo "<input name='bigclassid' type='radio' id='E$n'  onclick='javascript:doClick_E(this)' value='$row[classzm]' checked/><label for='E$n'>$row[classname]</label>";
		}else{
		echo "<input name='bigclassid' type='radio' id='E$n'  onclick='javascript:doClick_E(this)' value='$row[classzm]'/><label for='E$n'>$row[classname]</label>";
		}
		
	}
			?>
                    </fieldset></td>
                </tr>
                <tr> 
                  <td> 
                    <?php
$sql="select * from zzcms_zsclass where parentid='A' order by xuhao asc";
$rs = mysql_query($sql,$conn); 
$n=0;
while($row= mysql_fetch_array($rs)){
$n ++;
if (@$_SESSION['bigclassid']==$row["classzm"]) {  
echo "<div id='E_con$n' style='display:block;'>";
}else{
echo "<div id='E_con$n' style='display:none;'>";
}
echo "<fieldset><legend>请选择所属小类</legend>";

$sqln="select * from zzcms_zsclass where parentid='$row[classzm]' order by xuhao asc";
$rsn = mysql_query($sqln,$conn); 
$nn=0;
while($rown= mysql_fetch_array($rsn)){
$nn ++;
echo "<input name='smallclassid' id='radio$nn$n' type='radio' value='$rown[classzm]' />";
echo "<label for='radio$nn$n'>$rown[classname]</label>";
	if ($nn % 6==0) {
	echo "<br/>";
	}
}
echo "</fieldset>";
echo "</div>";
}
?>                  </td>
                </tr>
              </table></td>
          </tr>
		  
          <tr> 
            <td align="right" class="border" >介绍 <font color="#FF0000">*</font></td>
            <td class="border" > <textarea name="sm" cols="100%" rows="10" id="sm" onclick="javascript:if (this.value=='此处不能为空') {this.value=''};this.style.backgroundColor='';" onblur="javascript:if (this.value=='此处不能为空') {this.value=''};this.style.backgroundColor='';"></textarea></td>
          </tr>
          <tr> 
            <td align="right" class="border" >LOGO（小于<?php echo  maximgsize?>K）<br /> 
            <script src="/js/swfobject.js" type="text/javascript"></script> <script type="text/javascript">
function showtxt(num)
{
var sd =window.showModalDialog('/uploadimg_form.php?noshuiyin=1','','dialogWidth=400px;dialogHeight=300px');
//for chrome 
if(sd ==undefined) {  
sd =window.returnValue; 
}
if(sd!=null) { 
document.getElementById("img"+num).value=sd;//从子页面得到值写入母页面
document.getElementById("showimg"+num).innerHTML="<img src='"+sd+"' width=120>";
}
}

</script> <input name="img1" type="hidden" id="img1" value="/image/nopic.gif"/></td>
            <td class="border" > <table height="120" border="0" cellpadding="5" cellspacing="5">
                <tr align="center" bgcolor="#FFFFFF"> 
                  <td width="120" id="showimg1" onClick="showtxt(1)"> <input name="Submit2" type="button"  value="上传图片" /></td>
                </tr>
              </table></td>
          </tr>
        
          <tr> 
            <td align="center" class="border2" >&nbsp;</td>
            <td class="border2" > <input name="action" type="hidden" id="action2" value="add" /> 
              <input name="Submit" type="submit" class="buttons" value="填好了，发布信息" /></td>
          </tr>
        </table>
</form>
<?php
session_write_close();
?>
</div>	  
</div>
</div>
</body>
</html>