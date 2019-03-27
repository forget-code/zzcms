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
<title></title>
<link href="style.css" rel="stylesheet" type="text/css">
<script language = "JavaScript">
function CheckForm(){
if (document.myform.bigclassid.value==""){
    alert("请选择大类名称！");
	document.myform.bigclassid.focus();
	return false;
  }
if (document.myform.title.value==""){
    alert("标题不能为空！");
	document.myform.title.focus();
	return false;
  } 
}  
function doChange(objText, pic){
	if (!pic) return;
	var str = objText.value;
	var arr = str.split("|");
	pic.length=0;
	for (var i=0; i<arr.length; i++){
		pic.options[i] = new Option(arr[i], arr[i]);
	}
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
<div class="right">
<div class="admintitle">发布资讯信息</div>
<?php
$tablename="zzcms_zx";
include("checkaddinfo.php");
if (isset($_REQUEST["b"])){
$b=$_REQUEST["b"];
}
if (isset($_REQUEST["s"])){
$s=$_REQUEST["s"];
}
?>	  
<form action="zxsave.php" method="post" name="myform" id="myform" onSubmit="return CheckForm();">
        <table width="100%" border="0" cellpadding="3" cellspacing="1">
          <tr> 
            <td align="right" class="border2">类别 <font color="#FF0000">*</font></td>
            <td width="678" class="border2"> 
              <?php

$sql = "select * from zzcms_zxclass where parentid<>0 order by xuhao asc";
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
	$sql = "select * from zzcms_zxclass where isshowforuser=1 and parentid=0 order by xuhao asc";
    $rs=mysql_query($sql);
	while($row = mysql_fetch_array($rs)){
		if ($row["classid"]==@$b){
	?>
	 <option value="<?php echo trim($row["classid"])?>" selected><?php echo trim($row["classname"])?></option>
                <?php
		}elseif($row["classid"]==@$_SESSION["bigclassid"] && @$b==''){	
				?>
		<option value="<?php echo trim($row["classid"])?>" selected><?php echo trim($row["classname"])?></option>
		<?php 
		}else{
		?>
		<option value="<?php echo trim($row["classid"])?>"><?php echo trim($row["classname"])?></option>
		<?php 
		}
	}	
		?>		
              </select> 
			  <select name="smallclassid">
                <option value="0">不指定小类</option>
                <?php
if ($b!=''){//从index.php获取的大类值优先
$sql="select * from zzcms_zxclass where parentid=".$b." order by xuhao asc";
$rs=mysql_query($sql);
while($row = mysql_fetch_array($rs)){
				?>
				  <option value="<?php echo $row["classid"]?>" <?php if ($row["classid"]==$s) { echo "selected";}?>><?php echo $row["classname"]?></option>
                <?php
	}
}elseif($_SESSION["bigclassid"]!=''){
$sql="select * from zzcms_zxclass where parentid=" .@$_SESSION["bigclassid"]." order by xuhao asc";
$rs=mysql_query($sql);
	while($row = mysql_fetch_array($rs)){
	?>
   <option value="<?php echo $row["classid"]?>" <?php if ($row["classid"]==$_SESSION["smallclassid"]) { echo "selected";}?>><?php echo $row["classname"]?></option>
<?php 
	}
	}
	?>					  
              </select>
		  
			  </td>
          </tr>
          <tr> 
            <td width="139" align="right" class="border">标题 <font color="#FF0000">*</font></td>
			
            <td class="border">
			<script type="text/javascript" src="/js/jquery.js"></script>  
<script language="javascript">  
$(document).ready(function(){  
  $("#title").change(function() { //jquery 中change()函数  
	$("#quote").load(encodeURI("/ajax/zxtitlecheck_ajax.php?id="+$("#title").val()));//jqueryajax中load()函数 加encodeURI，否则IE下无法识别中文参数 
  });  
});  
</script>  
			 <input name="title" type="text" id="title" size="50" maxlength="255"> 
              <input type="checkbox" name="checkbox" value="checkbox" onclick="showlink()">
              外链新闻 
			  <span id="quote"></span>              </td>
          </tr>
          <tr id="link" style="display:none"> 
            <td align="right" class="border" >链接地址 <font color="#FF0000">*</font></td>
            <td class="border" ><input name="link" type="text" id="laiyuan3" size="50" maxlength="255" />            </td>
          </tr>
          <tr id="trlaiyuan"> 
            <td align="right" class="border2" >信息来源：</td>
            <td class="border2" > <input name="laiyuan" type="text" id="laiyuan" value="<?php echo sitename?>" size="50" maxlength="50" /></td>
          </tr>
          <tr id="trcontent"> 
            <td align="right" class="border2" >内容 <font color="#FF0000">*</font></td>
            <td class="border2" > <textarea name="content" id="content"></textarea> 
             <script type="text/javascript" src="/3/ckeditor/ckeditor.js"></script>
			  <script type="text/javascript">CKEDITOR.replace('content');</script>            </td>
          </tr>
          <tr id="trseo">
            <td colspan="2" align="center" class="border2" ><strong>SEO优化设置</strong></td>
          </tr>
          <tr id="trkeywords">
            <td align="right" class="border" >关键词（keywords）</td>
            <td class="border" ><input name="keywords" type="text" id="keywords" size="50" maxlength="50" /></td>
          </tr>
          <tr id="trdescription">
            <td align="right" class="border2" >描述（description）</td>
            <td class="border2" ><input name="description" type="text" id="description" size="50" maxlength="50" /></td>
          </tr>
          <tr id="trquanxian">
            <td colspan="2" align="center" class="border2" ><strong>浏览权限设置</strong></td>
          </tr>
          <tr id="trquanxian2">
            <td align="right" class="border" >&nbsp;</td>
            <td class="border" ><select name="groupid">
                <option value="0">全部用户</option>
                <?php
		  $rs=mysql_query("Select * from zzcms_usergroup ");
		  $row = mysql_num_rows($rs);
		  if ($row){
		  while($row = mysql_fetch_array($rs)){
		  	echo "<option value='".$row["groupid"]."'>".$row["groupname"]."</option>";
		  }
		  }
	 ?>
              </select>
                <select name="jifen" id="jifen">
                  <option value="0">请选择无权限用户是否可用积分查看</option>
                  <option value="0" >无权限用户不可用积分查看</option>
                  <option value="10" >付我10积分可查看</option>
                  <option value="20" >付我20积分可查看</option>
                  <option value="30" >付我30积分可查看</option>
                  <option value="50" >付我50积分可查看</option>
                  <option value="100" >付我100积分可查看</option>
                  <option value="200" >付我200积分可查看</option>
                  <option value="500" >付我500积分可查看</option>
                  <option value="1000">付我1000积分可查看</option>
                </select>
            </td>
          </tr>
          <tr> 
            <td align="right" class="border">&nbsp;</td>
            <td class="border"> <input name="Submit" type="submit" class="buttons" value="发 布">
              <input name="editor" type="hidden" id="editor2" value="<?php echo $username?>" />
              <input name="action" type="hidden" id="action3" value="add"></td>
          </tr>
        </table>
</form>
</div>

<div class="left">
<?php
include("left.php");
session_write_close();
?>
</div>
</div>
</div>
</body>
</html>