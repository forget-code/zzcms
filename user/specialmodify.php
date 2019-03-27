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
if (check_usergr_power("special")=="no" && $usersf=='个人'){
showmsg('个人用户没有此权限');
}
?>
<script type="text/javascript" src="/3/ckeditor/ckeditor.js"></script>
<script language = "JavaScript">
function CheckForm(){
if (document.myform.title.value==""){
    alert("标题不能为空！");
	document.myform.title.focus();
	return false;
}
return true;  
} 

function showlink(){
whichEl = eval("link");
if (whichEl.style.display == "none"){
eval("link.style.display=\"\";");
eval("trlaiyuan.style.display=\"none\";");
eval("trcontent.style.display=\"none\";");
eval("trseo.style.display=\"none\";");
eval("trkeywords.style.display=\"none\";");
eval("trdescription.style.display=\"none\";");
eval("trquanxian.style.display=\"none\";");
eval("trquanxian2.style.display=\"none\";");
}else{
eval("link.style.display=\"none\";");
eval("trlaiyuan.style.display=\"\";");
eval("trcontent.style.display=\"\";");
eval("trseo.style.display=\"\";");
eval("trkeywords.style.display=\"\";");
eval("trdescription.style.display=\"\";");
eval("trquanxian.style.display=\"\";");
eval("trquanxian2.style.display=\"\";");
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
<div class="admintitle">修改专题信息</div>
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
$sqlzx="select * from zzcms_special where id='$id'";
$rszx = mysql_query($sqlzx); 
$rowzx = mysql_fetch_array($rszx);
if ($rowzx["editor"]<>$username) {
markit();
showmsg('非法操作！警告：你的操作已被记录！小心封你的用户及IP！');
}
?>	  
<form action="specialsave.php" method="post" name="myform" id="myform" onSubmit="return CheckForm();">
        <table width="100%" border="0" cellpadding="3" cellspacing="1">
          <tr> 
            <td align="right" class="border2">类别 <font color="#FF0000">*</font></td>
            <td width="708" class="border2"> 
              <?php

$sql = "select * from zzcms_specialclass where parentid<>0 order by xuhao asc";
$rs=mysql_query($sql);
?>
<script language = "JavaScript" type="text/JavaScript">
var onecount;
subcat = new Array();
        <?php 
        $count = 0;
        while($row = mysql_fetch_array($rs)){
        ?>
subcat[<?php echo $count?>] = new Array("<?php echo trim($row["classname"])?>","<?php echo trim($row["parentid"])?>","<?php echo trim($row["classid"])?>");
        <?php
        $count = $count + 1;
       }
        ?>
onecount=<?php echo $count ?>;

function changelocation(locationid)
    {
    document.myform.smallclassid.length = 1; 
    var locationid=locationid;
    var i;
    for (i=0;i < onecount; i++)
        {
            if (subcat[i][1] == locationid)
            { 
                document.myform.smallclassid.options[document.myform.smallclassid.length] = new Option(subcat[i][0], subcat[i][2]);
            }        
        }
    }</script> <select name="bigclassid" onchange="changelocation(document.myform.bigclassid.options[document.myform.bigclassid.selectedIndex].value)" size="1">
                <option value="" selected="selected">请选择大类别</option>
                <?php
	$sql = "select * from zzcms_specialclass where isshowforuser=1 and parentid=0 order by xuhao asc";
    $rs=mysql_query($sql);
	while($row = mysql_fetch_array($rs)){
	?>
                <option value="<?php echo trim($row["classid"])?>" <?php if ($row["classid"]==$rowzx["bigclassid"]) { echo "selected";}?>><?php echo trim($row["classname"])?></option>
                <?php
				}
				?>
              </select> <select name="smallclassid">
                <option value="0">不指定小类</option>
                <?php

$sql="select * from zzcms_specialclass where parentid=" .$rowzx["bigclassid"]." order by xuhao asc";
$rs=mysql_query($sql);
while($row = mysql_fetch_array($rs)){
?>
               <option value="<?php echo $row["classid"]?>" <?php if ($row["classid"]==$rowzx["smallclassid"]) { echo "selected";}?>><?php echo $row["classname"]?></option>
<?php
}
?>
              </select></td>
          </tr>
          <tr> 
            <td width="109" align="right" class="border">标题 <font color="#FF0000">*</font></td>
			
            <td class="border">
			 <input name="title" type="text" id="title2" size="50" maxlength="255" value="<?php echo $rowzx["title"]?>" >
			 <input type="checkbox" name="checkbox" value="checkbox" onclick="showlink()" <?php if ($rowzx["link"]<>''){ echo 'checked';}?> />
外链新闻 <span id="quote"></span> </td>
          </tr>
		  <?php 
		  if($rowzx["link"]<>''){
		  ?>
          <tr id="link" style="display:"> 
		  <?php 
		  }else{
		  ?>
		   <tr id="link" style="display:none"> 
		   <?php
		   }
		   ?>
            <td align="right" class="border" >链接地址 <font color="#FF0000">*</font></td>
            <td class="border" ><input name="link" type="text" id="laiyuan3" size="50" maxlength="255"  value="<?php echo $rowzx["link"]?>" /></td>
          </tr>
          <tr id="trlaiyuan"> 
            <td align="right" class="border2" >信息来源：</td>
            <td class="border2" > <input name="laiyuan" type="text" id="laiyuan" value="<?php echo sitename?>" size="50" maxlength="50" /></td>
          </tr>
          <tr id="trcontent"> 
            <td align="right" class="border2" >内容 <font color="#FF0000">*</font></td>
            <td class="border2" > <textarea name="content" type="hidden" id="content"><?php echo $rowzx["content"]?></textarea> 
              <script type="text/javascript">CKEDITOR.replace('content');	</script>            </td>
          </tr>
          <tr id="trseo">
            <td colspan="2" align="center" class="border" ><strong>SEO优化设置</strong></td>
          </tr>
          <tr id="trkeywords">
            <td align="right" class="border2" >关键词（keyword）</td>
            <td class="border2" ><input name="keywords" type="text" id="keywords" size="50" maxlength="50" value="<?php echo $rowzx["keywords"]?>" /></td>
          </tr>
          <tr id="trdescription">
            <td align="right" class="border" >描述（description）</td>
            <td class="border" ><input name="description" type="text" id="description" size="50" maxlength="500" value="<?php echo $rowzx["description"]?>" /></td>
          </tr><tr id="trquanxian">
      <td colspan="2" align="center" class="border2" ><strong>浏览权限设置</strong></td>
    </tr>
    <tr id="trquanxian2"> 
      <td align="right" class="border" >&nbsp;</td>
      <td class="border" > <select name="groupid">
          <option value="0">全部用户</option>
          <?php
		  $rs=mysql_query("Select * from zzcms_usergroup ");
		  $row = mysql_num_rows($rs);
		  if ($row){
		  while($row = mysql_fetch_array($rs)){
		  	if ($rowzx["groupid"]== $row["groupid"]) {
		  	echo "<option value='".$row["groupid"]."' selected>".$row["groupname"]."</option>";
			}else{
			echo "<option value='".$row["groupid"]."'>".$row["groupname"]."</option>";
			}
		  }
		  }
	 ?>
        </select> <select name="jifen" id="jifen">
          <option value="0">请选择无权限用户是否可用积分查看</option>
          <option value="0" <?php if ($rowzx["jifen"]==0) { echo "selected";}?>>无权限用户不可用积分查看</option>
          <option value="10" <?php if ($rowzx["jifen"]==10) { echo "selected";}?>>付我10积分可查看</option>
          <option value="20" <?php if ($rowzx["jifen"]==20) { echo "selected";}?>>付我20积分可查看</option>
          <option value="30" <?php if ($rowzx["jifen"]==30) { echo "selected";}?>>付我30积分可查看</option>
          <option value="50" <?php if ($rowzx["jifen"]==50) { echo "selected";}?>>付我50积分可查看</option>
          <option value="100" <?php if ($rowzx["jifen"]==100) { echo "selected";}?>>付我100积分可查看</option>
          <option value="200" <?php if ($rowzx["jifen"]==200) { echo "selected";}?>>付我200积分可查看</option>
          <option value="500" <?php if ($rowzx["jifen"]==500) { echo "selected";}?>>付我500积分可查看</option>
          <option value="1000" <?php if ($rowzx["jifen"]==1000) { echo "selected";}?>>付我1000积分可查看</option>
        </select> </td>
    </tr>
            <td align="right" class="border2">&nbsp;</td>
            <td class="border2"> <input name="Submit" type="submit" class="buttons" value="发 布">
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