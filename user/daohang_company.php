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
//本页用于初次注册本站的公司用户来完善公司信息（公司简介及公司形象图片信息）
	if (isset($_REQUEST['action'])){
	$action=$_REQUEST['action'];
	}else{
	$action="";
	}	
if ($action=="modify") {
			$province=trim($_POST["province"]);
			$city=trim($_POST["city"]);
			$xiancheng=trim($_POST["xiancheng"]);
			$b=trim($_POST["b"]);
			$s=trim($_POST["s"]);		
			$address=$_POST["address"];
			$homepage=$_POST["homepage"];
			$content=rtrim($_POST["content"]);
			$oldcontent=rtrim($_POST["oldcontent"]);
			$img=$_POST["img"];
			$sex=$_POST["sex"];
			$mobile=$_POST["mobile"];
			$qq=$_POST["qq"];
			mysql_query("update zzcms_user set bigclassid='$b',smallclassid='$s',content='$content',img='$img',
			province='$province',city='$city',xiancheng='$xiancheng',sex='$sex',mobile='$mobile',address='$address',qq='$qq',
			homepage='$homepage' where username='".$username."'");
			if ($oldcontent=="" || $oldcontent=="该公司暂无简介信息" || $oldcontent=="暂无简介信息"){//只有第一次完善时加分，修改信息不计分，这里需要加验证，不许改为空，防止刷分
				mysql_query("update zzcms_user set totleRMB=totleRMB+".jf_addreginfo." where username='".$username."'");
				mysql_query("insert into zzcms_pay (username,dowhat,RMB,mark,sendtime) values('$username','完善注册信息','+".jf_addreginfo."','+".jf_addreginfo."','".date('Y-m-d H:i:s')."')");
				echo "<script>alert('成功完善了注册信息，获得".jf_addreginfo."金币')</script>";
			}		
			echo"<script language=JavaScript>alert('操作成功！进入下一步');location.href='daohang_skin.php'</script>";
}else{		
?>
<script language = "JavaScript">
function CheckForm()
{
  if (document.myform.province.value=="")
  {
    alert("请选择公司所在省份！");
	document.myform.province.focus();
	return false;
  } 
    if (document.myform.city.value=="")
  {
    alert("请选择公司所在城市！");
	document.myform.city.focus();
	return false;
  } 
if (document.myform.content.value=="")
  {
    alert("请填写公司简介！");
	document.myform.content.focus();
	return false;
  }
  if (document.myform.content.value=="该公司暂无简介信息")
  {
    alert("请填写公司简介！");
	document.myform.content.focus();
	return false;
  }

    if (document.myform.kind.value=="")
  {
    alert("请选择经营模式！");
	document.myform.kind.focus();
	return false;
  }

//定义正则表达式部分
var strP=/^\d+$/;
if(!strP.test(document.myform.qq.value) && document.myform.qq.value!="") 
{
alert("QQ只能填数字！"); 
document.myform.qq.focus(); 
return false; 
}   
  return true;  
}
</SCRIPT>
</head>
<body>
<div class="main">
<?php
include("top.php");
?>
<div class="pagebody" >
<div class="left">
<?php
include("left.php");
?>
</div>
<div class="right">
<div class="admintitle">完善注册信息</div>
<?php
$sql="select * from zzcms_user where username='" .$username. "'";
$rs=mysql_query($sql);
$row=mysql_fetch_array($rs);
?>
<table width="100%" border="0" cellpadding="5" cellspacing="1">
  <tr> 
    <td class="border"> 
	<?php
	if ($row['logins']==1) {
	?>
	<table width="100%" height="60" border="0" cellpadding="10" cellspacing="0" bgcolor="#FFFFFF">
        <tr> 
          <td class="px14"> 
            <?php
echo "您好！<b>".$username."</b>"?>
            恭喜您成为本站注册会员！<br>
            请完善您的公司简介信息，以便生成您公司的展厅页面。&gt;&gt;&gt; <a href="daohang_skin.php" target="_self">跳过此步以后再填</a></td>
        </tr>
      </table>
	  <?php
	  }else{
	  ?>
      <table width="100%" height="60" border="0" cellpadding="10" cellspacing="0" bgcolor="#FFFFCC">
        <tr> 
          <td class="px14"> <font color="#FF0000"><strong>提示：</strong>公司简介信息尚未填写！<br>
            请完善您的公司简介信息，以提高公司诚信度。</font></td>
        </tr>
      </table>
	  <?php
	  }
	  ?>
	  </td>
  </tr>
</table>
<FORM name="myform" action="?action=modify" method="post" onSubmit="return CheckForm();">
        <table width="100%" border="0" cellpadding="3" cellspacing="1">
          <tr> 
            <td align="right" class="border2">公司所在地 </td>
                  <td class="border2">
<select name="province" id="province"></select>
<select name="city" id="city"></select>
<select name="xiancheng" id="xiancheng"></select>
<script src="/js/area.js"></script>
<script type="text/javascript">
new PCAS('province', 'city', 'xiancheng', '<?php echo $row['province']?>', '<?php echo $row["city"]?>', '<?php echo $row["xiancheng"]?>');
</script>             
             		  </td>
          </tr>
          <tr > 
            <td align="right" class="border">公司地址</td>
            <td class="border"> 
              <input name="address" id="address" tabindex="4" value="<?php echo $row['address']?>" size="30" maxlength="50"> 
            </td>
          </tr>
          <tr > 
            <td align="right" class="border2">公司网站</td>
            <td class="border2"> 
              <input name="homepage" id="homepage" value="<?php if ($row["homepage"]<>'') { echo  $row["homepage"] ;}else{ echo siteurl.getpageurl('zt',$row['id']);}?>" tabindex="5" size="30" maxlength="100"></td>
          </tr>
          <tr> 
            <td align="right" class="border">企业类别</td>
            <td class="border">
			<?php
$sqln = "select * from zzcms_userclass where parentid<>'0' order by xuhao asc";
$rsn=mysql_query($sqln);
?>
<script language = "JavaScript" type="text/JavaScript">
var onecount;
subcat = new Array();
<?php 
$count = 0;
        while($rown = mysql_fetch_array($rsn)){
        ?>
subcat[<?php echo $count?>] = new Array("<?php echo trim($rown["classname"])?>","<?php echo trim($rown["parentid"])?>","<?php echo trim($rown["classid"])?>");
       <?php
		$count = $count + 1;
       }
        ?>
onecount=<?php echo $count ?>;
function changelocation(locationid){
    document.myform.s.length = 1; 
    var locationid=locationid;
    var i;
    for (i=0;i < onecount; i++)
        {
            if (subcat[i][1] == locationid){ 
                document.myform.s.options[document.myform.s.length] = new Option(subcat[i][0], subcat[i][2]);
            }        
        }
    }</script>
      <select name="b" size="1" id="b" onchange="changelocation(document.myform.b.options[document.myform.b.selectedIndex].value)">
        <option value="" selected="selected">请选择大类</option>
        <?php
	$sqln = "select * from zzcms_userclass where  parentid='0' order by xuhao asc";
    $rsn=mysql_query($sqln);
	while($rown = mysql_fetch_array($rsn)){
	?>
        <option value="<?php echo trim($rown["classid"])?>" <?php if ($rown["classid"]==$row["bigclassid"]) { echo "selected";}?>><?php echo trim($rown["classname"])?></option>
        <?php
				}
				?>
      </select>
	  <select name="s">
      <option value="0">请选择小类</option>
      <?php	  
$sqln="select * from zzcms_userclass where parentid='" .$row["bigclassid"]."' order by xuhao asc";
$rsn=mysql_query($sqln);
while($rown = mysql_fetch_array($rsn)){
?>
<option value="<?php echo $rown["classid"]?>" <?php if ($rown["classid"]==$row["smallclassid"]) { echo "selected";}?>><?php echo $rown["classname"]?></option>
<?php 	  
}
?>
    </select>
			</td>
          </tr>
          <tr> 
            <td width="17%" align="right" class="border2">公司简介 
              <input name="oldcontent" type="hidden" id="oldcontent" value="<?php echo $row["content"]?>"></td>
            <td width="83%" class="border2"> 
              <textarea name="content" id="content"><?php echo $row["content"]?></textarea> 
			   <script type="text/javascript" src="/3/ckeditor/ckeditor.js"></script>
			  <script type="text/javascript">CKEDITOR.replace('content');</script> 
            </td>
          </tr>
          <tr> 
            <td height="50" align="right" class="border"> 上传公司形象图片<br>
              （不要超过<?php echo maximgsize?>K） 
                    <input name="img" type="hidden" id="img" value="/image/nopic.gif" tabindex="8"></td>
            <td height="50" class="border">   
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
            <td id="showimg" onClick="showtxt()"> <input name="Submit2" type="button"  value="上传图片" /></td>
          </tr>
        </table>
			
            </td>
          </tr>
          <tr> 
            <td align="right" class="border2">联系人性别</td>
            <td class="border2"> 
              <input name="sex" type="radio" tabindex="9" value="1" <?php if ($row["sex"]==1) { echo 'checked';}?>/>
              先生 
              <input name="sex" type="radio" tabindex="10" value="0" <?php if ($row["sex"]==0) { echo 'checked';}?> />
              女士</td>
          </tr>
          <tr > 
            <td align="right" class="border">联系人QQ号</td>
            <td class="border"> <input name="qq" id="qq" value="<?php echo $row['qq']?>" tabindex="11" size="30" maxLength="50"></td>
          </tr>
          <tr > 
            <td align="right" class="border2">联系人手机</td>
            <td class="border2"> 
              <input name="mobile" id="mobile" value="<?php echo $row['mobile']?>" tabindex="12" size="30" maxLength="50"></td>
          </tr>
          <tr> 
            <td class="border">&nbsp;</td>
            <td class="border"> <input name="Submit"  type="submit" class="buttons" id="Submit" value="填好了，提交信息！" tabindex="13"> 
            </td>
          </tr>
        </table>
	  
	
  </form>
</div>
</div>
</div>
</body>
</html>
<?php
}
mysql_close($conn);
?>