<?php
include("../inc/conn.php");
include("check.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<link href="style.css" rel="stylesheet" type="text/css">
<?php
if (check_usergr_power("pp")=="no" && $usersf=='个人'){
showmsg('个人用户没有此权限');
}
?>
<title></title>
<script language = "JavaScript">
function CheckForm()
{
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
	alert("请选择类别！");	
    return false;
	}
		

		
  if (document.myform.name.value=="")
  {
	document.myform.name.focus();
    document.myform.name.value='此处不能为空';
    document.myform.name.select();
	document.myform.name.style.backgroundColor="FFCC00";
	return false;
  }
}

function doClick_E(o){
	 var id;
	 var e;
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

$sql="select * from zzcms_pp where id='$id'";
$rs = mysql_query($sql); 
$row = mysql_fetch_array($rs);
if ($row["editor"]<>$username) {
markit();
showmsg('非法操作！警告：你的操作已被记录！小心封你的用户及IP！');
}
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="admintitle">修改品牌信息</td>
  </tr>
</table>

<form action="ppsave.php" method="post" name="myform" id="myform" onSubmit="return CheckForm();">
        <table width="100%" border="0" cellpadding="3" cellspacing="1">
          <tr> 
            <td align="right" class="border" >名称<font color="#FF0000"> *</font></td>
            <td class="border" > <input name="name" type="text" id="name" value="<?php echo $row["ppname"]?>" size="60" maxlength="45" ></td>
          </tr>
          <tr> 
            <td width="18%" align="right" valign="top" class="border2" ><br>
              所属类别 <font color="#FF0000">*</font></td>
            <td width="82%" class="border2" > <table width="100%" border="0" cellpadding="0" cellspacing="1">
                <tr> 
                  <td> <fieldset>
                    <legend>请选择所属大类</legend>
                    <?php
        $sqlB = "select * from zzcms_zsclass where parentid='A' order by xuhao asc";
		$rsB = mysql_query($sqlB,$conn); 
		$n=0;
		while($rowB= mysql_fetch_array($rsB)){
		$n ++;
		if ($row['bigclasszm']==$rowB['classzm']){
		echo "<input name='bigclassid' type='radio' id='E$n'  onclick='javascript:doClick_E(this)' value='$rowB[classzm]' checked/><label for='E$n'>$rowB[classname]</label>";
		}else{
		echo "<input name='bigclassid' type='radio' id='E$n'  onclick='javascript:doClick_E(this)' value='$rowB[classzm]' /><label for='E$n'>$rowB[classname]</label>";
		}
		}
			?>
                    </fieldset></td>
                </tr>
                <tr> 
                  <td> 
                    <?php
$sqlB="select * from zzcms_zsclass where parentid='A' order by xuhao asc";
$rsB = mysql_query($sqlB,$conn); 
$n=0;
while($rowB= mysql_fetch_array($rsB)){
$n ++;
if ($row["bigclasszm"]==$rowB["classzm"]) {  
echo "<div id='E_con$n' style='display:block;'>";
}else{
echo "<div id='E_con$n' style='display:none;'>";
}
echo "<fieldset><legend>请选择所属小类</legend>";
$sqlS="select * from zzcms_zsclass where parentid='$rowB[classzm]' order by xuhao asc";
$rsS = mysql_query($sqlS,$conn); 
$nn=0;
while($rowS= mysql_fetch_array($rsS)){
$nn ++;
if ($row['smallclasszm']==$rowS['classzm']){
echo "<input name='smallclassid' id='radio$nn$n' type='radio' value='$rowS[classzm]' checked/>";
}else{
echo "<input name='smallclassid' id='radio$nn$n' type='radio' value='$rowS[classzm]' />";
}
echo "<label for='radio$nn$n'>$rowS[classname]</label>";
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
            <td align="right" class="border" >说明 <font color="#FF0000">*</font></td>
            <td class="border" > <textarea name="sm" cols="100%" rows="10" id="sm"><?php echo $row["sm"] ?></textarea></td>
          </tr>
          <tr> 
            <td align="right" class="border" >图片 
              <script type="text/javascript">
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

</script> <input name="oldimg1" type="hidden" id="oldimg1" value="<?php echo $row["img"] ?>"> 
              <input name="img1"type="hidden" id="img1" value="<?php echo $row["img"] ?>"></td>
            <td class="border" > <table height="120" border="0" cellpadding="5" cellspacing="1" bgcolor="#999999">
                <tr> 
                  <td width="120" align="center" bgcolor="#FFFFFF" id="showimg1" onclick='showtxt(1)'> 
                    <?php
				  if($row["img"]<>""){
				  echo "<img src='".$row["img"]."' border=0 width=120 /><br>点击可更换图片";
				  }else{
				  echo "<input name='Submit2' type='button'  value='上传图片'/>";
				  }
				  ?>                  </td>
                </tr>
              </table></td>
          </tr>
         
		   
          <tr> 
            <td align="center" class="border2" >&nbsp;</td>
            <td class="border2" > <input name="ypid" type="hidden" id="ypid2" value="<?php echo $row["id"] ?>"> 
              <input name="action" type="hidden" id="action2" value="modify"> 
              <input name="page" type="hidden" id="action" value="<?php echo $page ?>"> 
              <input name="Submit" type="submit" class="buttons" value="保存修改结果"></td>
          </tr>
        </table>
	  </form>
</div>
</div>
</div>
</body>
</html>
