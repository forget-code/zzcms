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

if (isset($_REQUEST["action"])){
$action=$_REQUEST["action"];
}else{
$action="";
}
if($action=="modify"){
$comanestyle=$_POST["comanestyle"];
$comanecolor=$_POST["comanecolor"];
if (isset($_POST["swf"])){
$swf=$_POST["swf"];
}else{
$swf="";
}
$daohang="";
if(!empty($_POST['daohang'])){
    for($i=0; $i<count($_POST['daohang']);$i++){
    $daohang=$daohang.($_POST['daohang'][$i].',');
    }
	$daohang=substr($daohang,0,strlen($daohang)-1);//去除最后面的","
}
if (isset($_POST["img"])){
$bannerbg=$_POST["img"];
}else{
$bannerbg="";
}
if (isset($_POST["oldimg"])){
$oldbannerbg=$_POST["oldimg"];
}else{
$oldbannerbg="";
}
if (isset($_POST["nobannerbg"])){
$bannerbg="";
}
$bannerheight=@$_POST["bannerheight"];
if (isset($_POST["mobile"])){
$mobile=$_POST["mobile"];
}else{
$mobile=0;
}
$tongji=str_replace('"','',str_replace("'",'',stripfxg(trim($_POST['tongji']))));
$baidu_map=str_replace('"','',str_replace("'",'',stripfxg(trim($_POST['baidu_map']))));
mysql_query("update zzcms_usersetting set comanestyle='$comanestyle',comanecolor='$comanecolor',swf='$swf',daohang='$daohang',bannerbg='$bannerbg',bannerheight='$bannerheight',mobile='$mobile',tongji='$tongji',baidu_map='$baidu_map' where username='".$username."'");		

if($oldbannerbg<>$bannerbg && $oldbannerbg<>"/image/nopic.gif" && $oldbannerbg<>"" ) {
	$f="../".$oldbannerbg;
	if(file_exists($f)){
	unlink($f);
	}
}	
echo "<script>alert('成功更新设置');location.href='ztconfig.php'</script>";	
}

$rs=mysql_query("select * from zzcms_usersetting where username='".$username."'");
$row=mysql_num_rows($rs);
if(!$row){
mysql_query("INSERT INTO zzcms_usersetting (username,skin,swf,daohang)VALUES('".$username."','blue1','6.swf','网站首页, 招商信息, 公司简介, 资质证书, 联系方式, 在线留言')");//如不存在自动添加
echo '用户配置记录不存在，已自动修复，请刷新页面';
}else{
$row=mysql_fetch_array($rs);
?>
<script>
function  checkmobile()
{ 
//定义正则表达式部分
var strP=/^\d+$/;
if(!strP.test(document.myform.mobile.value)) 
{
alert("此处必须为数字！"); 
document.myform.mobile.focus(); 
return false; 
}
}
function  checkbannerheight()
{ 
//定义正则表达式部分
var strP=/^\d+$/;
if(!strP.test(document.myform.bannerheight.value)) 
{
alert("此处必须为数字！"); 
document.myform.bannerheight.focus(); 
return false; 
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
<div class="admintitle">展厅设置</div>
<?php 
if (check_usergr_power("zt")=="no" && $usersf=='个人'){
showmsg('个人用户没有此权限');
}
?>
<form name="myform" method="post" action="?action=modify"> 
        <table width="100%" border="0" cellpadding="3" cellspacing="1">
          <tr> 
            <td width="15%" class="border">banner动画效果设置</td>
            <td width="85%" height="210" valign="top" class="border"> <div id="Layer2" style="position:absolute; width:684px; height:200px; z-index:1; overflow: scroll;"> 
                <table width="95%" border="0" cellspacing="1" cellpadding="5">
                  <tr> 
                    <?php 
$dir = opendir("../flash");
$i=0;
while(($file = readdir($dir))!=false){
  if ($file!="." && $file!="..") { //不读取. ..
    //$f = explode('.', $file);//用$f[0]可只取文件名不取后缀。 
?>
                    <td> <table width="120" border="0" cellpadding="5" cellspacing="1">
                        <tr> 
                          <td align="center" bgcolor="#FFFFFF"><embed src="/flash/<?php echo $file?>" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="120" height="120"></embed></td>
                        </tr>
                        <tr> 
                          <td align="center" bgcolor="#FFFFFF"> <input name="swf" type="radio" value="<?php echo $file?>" <?php if($row["swf"]==$file){ echo"checked";}?>/> 
                            <?php echo $file?></td>
                        </tr>
                      </table></td>
                    <?php 
	$i=$i+1;
		if($i % 4==0 ){
		echo"<tr>";
		}
	}
}
closedir($dir)
?>
                </table>
              </div></td>
          </tr>
          <?php if(check_user_power('set_zt')=='yes'){?>
          <tr> 
            <td class="border2">banner背景图自定义 
              <input name="oldimg" type="hidden" id="oldimg" value="<?php echo $row["bannerbg"]?>" /> 
              <input name="img" type="hidden" id="img" value="<?php echo trim($row["bannerbg"])?>" size="50" maxlength="255">            </td>
            <td class="border2"> <script type="text/javascript">
function showtxt()
{
var sd =window.showModalDialog('/uploadimg_form.php','','dialogWidth=400px;dialogHeight=300px');
//for chrome 
if(sd ==undefined) {  
sd =window.returnValue; 
}
if(sd!=null) {  
document.getElementById("img").value=sd;//从子页面得到值写入母页面
document.getElementById("showimg").innerHTML="<img src='../"+sd+"' width=120>";
}
}
</script> <table width="120" height="120" border="0" cellpadding="5" cellspacing="1" bgcolor="#999999">
                <tr> 
                  <td align="center" bgcolor="#FFFFFF" id="showimg" onclick='showtxt()'> 
                    <?php
				  if($row["bannerbg"]<>""){
				  echo "<img src='".$row["bannerbg"]."' border=0 width=120 /><br>点击可更换图片";
				  }else{
				  echo "<input name='Submit2' type='button'  value='上传图片'/>";
				  }
				  ?>                  </td>
                </tr>
              </table>
              <input name='nobannerbg[]' type='checkbox' value='1' />
              使用默认图片 </td>
          </tr>
          <?php 
		  }else{
		  ?>
          <tr> 
            <td class="border2">banner背景图自定义</td>
            <td class="border2">您所在的用户组没有权限，不能使用本功能</td>
          </tr>
		    <?php 
		  }
		  ?>
         
		   <tr> 
            <td class="border2">banner高度设置</td>
            <td class="border2"><input name="bannerheight" type="text" id="bannerheight" value="<?php echo $row["bannerheight"]?>" size="10" maxlength="3" onblur="checkbannerheight()" />
              px</td>
          </tr>
            <td class="border">公司名称</td>
            <td class="border"> 显式方式： 
              <select name="comanestyle" id="comanestyle">
                <option value="left" <?php if ($row["comanestyle"]=="left" ){ echo"selected";}?>>左边</option>
                <option value="center" <?php if($row["comanestyle"]=="center" ){ echo"selected";}?>>居中</option>
                <option value="right" <?php if($row["comanestyle"]=="right" ){ echo"selected";}?>>右边</option>
				<option value="no" <?php if($row["comanestyle"]=="no" ){ echo"selected";}?>>不在banner上显示公司名</option>
              </select>
              字体颜色： 
              <select name="comanecolor" id="comanecolor">
                <option value="#FFFFFF" <?php if($row["comanecolor"]=="#FFFFFF" ){ echo"selected";}?>>白色</option>
                <option value="#000000" <?php if($row["comanecolor"]=="#000000" ){ echo"selected";}?>>黑色</option>
              </select> </td>
          </tr>
          <tr> 
            <td class="border2">导航栏目设置</td>
            <td class="border2"> 
			<input name="daohang[]" type="checkbox" id="daohang" value="网站首页" <?php  if(strpos($row["daohang"],"网站首页")!==false ){ echo"checked";}?> />
              网站首页 
              <input name="daohang[]" type="checkbox" id="daohang" value="招商信息" <?php if(strpos($row["daohang"],"招商信息")!==false ){ echo"checked";}?> />
              <?php echo channelzs?>信息 
			  <input name="daohang[]" type="checkbox" id="daohang" value="品牌信息" <?php if(strpos($row["daohang"],"品牌信息")!==false ){ echo"checked";}?> />
              品牌信息 
              <input name="daohang[]" type="checkbox" id="daohang" value="公司简介" <?php if(strpos($row["daohang"],"公司简介")!==false ){ echo"checked";}?> />
              公司简介
			  <input name="daohang[]" type="checkbox" id="daohang" value="公司新闻" <?php if(strpos($row["daohang"],"公司新闻")!==false ){ echo"checked";}?> />
              公司新闻
			  <input name="daohang[]" type="checkbox" id="daohang" value="招聘信息" <?php if(strpos($row["daohang"],"招聘信息")!==false ){ echo"checked";}?> />
              招聘信息 
              <input name="daohang[]" type="checkbox" id="daohang" value="资质证书" <?php if(strpos($row["daohang"],"资质证书")!==false ){ echo"checked";}?> />
              资质证书 
              <input name="daohang[]" type="checkbox" id="daohang" value="联系方式" <?php if(strpos($row["daohang"],"联系方式")!==false ){ echo"checked";}?> />
              联系方式 
              <input name="daohang[]" type="checkbox" id="daohang" value="在线留言" <?php if(strpos($row["daohang"],"在线留言")>0 ){ echo"checked";}?> />
              在线留言 </td>
          </tr>
          <tr>
            <td class="border2">统计代码：</td>
            <td class="border2"><input name="tongji" type="text" id="tongji" value="<?php echo $row["tongji"]?>" size="90" maxlength="200" />            </td>
          </tr>
          <tr>
            <td class="border2">百度地图代码：</td>
            <td class="border2"><input name="baidu_map" type="text" id="baidu_map" value="<?php echo $row["baidu_map"]?>" size="50" maxlength="200" />
              <a href="http://api.map.baidu.com/mapCard/" target="_blank" style="color:red">制做百度地图，获取地图代码</a></td>
          </tr>
        
          <tr> 
            <td class="border2">&nbsp;</td>
            <td class="border2"> <input name="Submit2" type="submit" class="buttons" value="更新设置"></td>
          </tr>
          <tr> 
            <td colspan="2" class="admintitle">绑定手机</td>
          </tr>
          <tr> 
            <td class="border"><strong>绑定手机(免费)<br>
              </strong>设置邦定的手机号码</td>
            <td class="border"> 
              <?php 
	if(check_user_power('set_mobile')=='yes'){
			?>
              <input name="mobile" type="text" id="mobile" value="<?php echo $row["mobile"]?>" size="30" maxlength="11" onblur="checkmobile()"> 
              <?php 	
	  }else{
	  ?>
              <input name="mobile" type="text" id="mobile" value="你所在的用户组没有绑定手机的权限" size="30" disabled> 
              <?php 
	 }
	?>            </td>
          </tr>
          <tr>
            <td class="border2">&nbsp;</td>
            <td class="border2"><input name="Submit" type="submit" class="buttons" value="更新设置" /></td>
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
?>