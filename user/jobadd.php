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
if (check_usergr_power("job")=="no" && $usersf=='个人'){
showmsg('个人用户没有此权限');
}
?>
<title></title>
<script language = "JavaScript">
function CheckForm(){
	ischecked=false;
 	for(var i=0;i<document.myform.bigclassid.length;i++){ 
		if(document.myform.bigclassid[i].checked==true)  {
		 ischecked=true ;
   		} 
	}
   if(document.myform.bigclassid.checked==true)  {
		 ischecked=true ;
   		} 
 	if (ischecked==false){
	alert("请选择大类别！");	
    return false;
	}

  if (document.myform.province.value=="请选择省份"){
	document.myform.province.focus();
    alert("请选择省份！");
	return false;
  }  
  
  if (document.myform.city.value==0){
	document.myform.city.focus();
    alert("请选择城市！");
	return false;
  }   
ischecked=false;
 	for(var i=0;i<document.myform.smallclassid.length;i++){ 
		if(document.myform.smallclassid[i].checked==true)  
   		{
		 ischecked=true ;
   		} 
	}
	
   if(document.myform.smallclassid.checked==true)  {
		 ischecked=true ;
   		} 
 	if (ischecked==false){
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
function addSrcToDestList() {
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
<div class="admintitle">发布招聘信息</div>
<?php
$tablename="zzcms_main";
include("checkaddinfo.php");
?>
<form  action="jobsave.php" method="post" name="myform" id="myform" onSubmit="return CheckForm();">
        <table width="100%" border="0" cellpadding="3" cellspacing="1">
          <tr> 
            <td width="20%" align="right" valign="top" class="border">职位类别<font color="#FF0000"> 
              *</font></td>
            <td valign="middle" class="border" > <table width="100%" border="0" cellpadding="5" cellspacing="1">
                <tr> 
                  <td> <fieldset>
                    <legend>请选择所属大类</legend>
                    <?php
        $sql = "select * from zzcms_jobclass where parentid='0' order by xuhao asc";
		$rs = mysql_query($sql,$conn); 
		$n=0;
		while($row= mysql_fetch_array($rs)){
		
		$n ++;
		if (@$_SESSION['bigclassid']==$row['classid']){
		echo "<input name='bigclassid' type='radio' id='E$n'  onclick='javascript:doClick_E(this)' value='$row[classid]' checked/><label for='E$n'>$row[classname]</label>";
		}else{
		echo "<input name='bigclassid' type='radio' id='E$n'  onclick='javascript:doClick_E(this)' value='$row[classid]'/><label for='E$n'>$row[classname]</label>";
		}
		
	}
			?>
                    </fieldset></td>
                </tr>
                <tr> 
                  <td> 
                    <?php
$sql="select * from zzcms_jobclass where parentid=0 order by xuhao asc";
$rs = mysql_query($sql,$conn); 
$n=0;
while($row= mysql_fetch_array($rs)){
$n ++;
if (@$_SESSION['bigclassid']==$row["classid"]) {  
echo "<div id='E_con$n' style='display:block;'>";
}else{
echo "<div id='E_con$n' style='display:none;'>";
}
echo "<fieldset><legend>请选择所属小类</legend>";

$sqln="select * from zzcms_jobclass where parentid='$row[classid]' order by xuhao asc";
$rsn = mysql_query($sqln,$conn); 
$nn=0;
while($rown= mysql_fetch_array($rsn)){
$nn ++;
echo "<input name='smallclassid' id='radio$nn$n' type='radio' value='$rown[classid]' />";
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
            <td align="right" class="border" >职位<font color="#FF0000">*</font></td>
            <td class="border" ><input name="jobname" type="text" id="jobname" size="50" maxlength="255" /></td>
          </tr>
		
          <tr> 
            <td align="right" class="border" >内容 <font color="#FF0000">*</font></td>
            <td class="border" > <textarea name="sm" cols="80%" rows="10"></textarea></td>
          </tr>
          <tr> 
            <td align="right" class="border2">工作地点 <font color="#FF0000">*</font></td>
            <td class="border2">       
<select name="province" id="province"></select>
<select name="city" id="city"></select>
<select name="xiancheng" id="xiancheng"></select>
<script src="/js/area.js"></script>
<script type="text/javascript">
new PCAS('province', 'city', 'xiancheng', '<?php echo @$_SESSION['province']?>', '<?php echo @$_SESSION['city']?>', '<?php echo @$_SESSION['xiancheng']?>');
</script>
</td>
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