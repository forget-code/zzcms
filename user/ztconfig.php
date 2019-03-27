<?php
include("../inc/conn.php");
include("check.php");
$fpath="text/ztconfig.txt";
$fcontent=file_get_contents($fpath);
$f_array=explode("|||",$fcontent) ;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title><?php echo $f_array[0] ?></title>
<link href="style.css" rel="stylesheet" type="text/css" />
<script>
function  checkmobile(){ 
<?php echo $f_array[1] ?>
}
function  checkbannerheight(){ 
<?php echo $f_array[2] ?>
}
</script>
<?php
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
echo $f_array[3];	
}

$rs=mysql_query("select * from zzcms_usersetting where username='".$username."'");
$row=mysql_num_rows($rs);
if(!$row){
mysql_query("INSERT INTO zzcms_usersetting (username,skin,swf,daohang)VALUES('".$username."','blue1','6.swf','网站首页, 招商信息, 公司简介, 资质证书, 联系方式, 在线留言')");//如不存在自动添加
echo $f_array[4];
}else{
$row=mysql_fetch_array($rs);
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
<div class="admintitle"><?php echo $f_array[0] ?></div>
<?php 
if (check_usergr_power("zt")=="no" && $usersf=='个人'){
echo $f_array[5];
exit;
}
?>
<form name="myform" method="post" action="?action=modify"> 
        <table width="100%" border="0" cellpadding="3" cellspacing="1">
          <tr> 
            <td width="15%" class="border"><?php echo $f_array[6] ?></td>
            <td width="85%" height="210" valign="top" class="border">
			<div id="Layer2" style="position:absolute; width:684px; height:200px; z-index:1; overflow: scroll;"> 
                <table width="95%" border="0" cellspacing="1" cellpadding="5">
                  <tr> 
                    <?php 
$dir = opendir("../flash");
$i=0;
while(($file = readdir($dir))!=false){
  if ($file!="." && $file!="..") { //不读取. ..
    //$f = explode('.', $file);//用$f[0]可只取文件名不取后缀。 
?>
                    <td> <table width="180" border="0" cellpadding="5" cellspacing="0" >
                        <tr> 
                          <td align="center" <?php if($row["swf"]==$file){ echo "bgcolor='#FF0000'";}else{echo "bgcolor='#000'"; }?>><embed src="/flash/<?php echo $file?>" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="180" height="150" wmode="transparent"></embed></td>
                        </tr>
                        <tr> 
                          <td align="center" bgcolor="#FFFFFF">
						   <input name="swf" type="radio" value="<?php echo $file?>" id="<?php echo $file?>" <?php if($row["swf"]==$file){ echo"checked";}?>/> 
                            <label for='<?php echo $file?>'><?php echo $file?></label></td>
                        </tr>
                      </table></td>
                    <?php 
	$i=$i+1;
		if($i % 3==0 ){
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
            <td class="border2"><?php echo $f_array[7] ?> 
              <input name="oldimg" type="hidden" id="oldimg" value="<?php echo $row["bannerbg"]?>" /> 
              <input name="img" type="hidden" id="img" value="<?php echo trim($row["bannerbg"])?>" size="50" maxlength="255">            </td>
            <td class="border2"> <script type="text/javascript">
function showtxt(){
var sd =window.showModalDialog('/uploadimg_form.php?noshuiyin=1','','dialogWidth=400px;dialogHeight=300px');
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
				  echo "<img src='".$row["bannerbg"]."' border=0 width=120 /><br>".$f_array[8];
				  }else{
				  echo "<input name='Submit2' type='button'  value='".$f_array[9]."'/>";
				  }
				  ?>                  </td>
                </tr>
              </table>
              <input name='nobannerbg[]' type='checkbox' value='1' />
              <?php echo $f_array[10] ?> </td>
          </tr>
          <?php 
		  }else{
		  ?>
          <tr> 
            <td class="border2"><?php echo $f_array[11] ?></td>
            <td class="border2"><?php echo $f_array[12] ?></td>
          </tr>
		    <?php 
		  }
		  ?>
         
		   <tr> 
            <td class="border2"><?php echo $f_array[13] ?></td>
            <td class="border2"><input name="bannerheight" type="text" id="bannerheight" value="<?php echo $row["bannerheight"]?>" size="10" maxlength="3" onblur="checkbannerheight()" />
              px</td>
          </tr>
            <td class="border"><?php echo $f_array[14] ?></td>
            <td class="border"> <?php echo $f_array[15] ?>
              <select name="comanestyle" id="comanestyle">
                <option value="left" <?php if ($row["comanestyle"]=="left" ){ echo"selected";}?>><?php echo $f_array[16] ?></option>
                <option value="center" <?php if($row["comanestyle"]=="center" ){ echo"selected";}?>><?php echo $f_array[17] ?></option>
                <option value="right" <?php if($row["comanestyle"]=="right" ){ echo"selected";}?>><?php echo $f_array[18] ?></option>
				<option value="no" <?php if($row["comanestyle"]=="no" ){ echo"selected";}?>><?php echo $f_array[19] ?></option>
              </select>
              <?php echo $f_array[20] ?>
              <select name="comanecolor" id="comanecolor">
                <option value="#FFFFFF" <?php if($row["comanecolor"]=="#FFFFFF" ){ echo"selected";}?>><?php echo $f_array[21] ?></option>
                <option value="#000000" <?php if($row["comanecolor"]=="#000000" ){ echo"selected";}?>><?php echo $f_array[22] ?></option>
              </select> </td>
          </tr>
          <tr> 
            <td class="border2"><?php echo $f_array[23] ?></td>
            <td class="border2"> 
			<input name="daohang[]" type="checkbox" id="daohang" value="网站首页" <?php  if(strpos($row["daohang"],"网站首页")!==false ){ echo"checked";}?> />
              <?php echo $f_array[24] ?> 
              <input name="daohang[]" type="checkbox" id="daohang" value="招商信息" <?php if(strpos($row["daohang"],"招商信息")!==false ){ echo"checked";}?> />
              <?php echo channelzs?> 
			  <input name="daohang[]" type="checkbox" id="daohang" value="品牌信息" <?php if(strpos($row["daohang"],"品牌信息")!==false ){ echo"checked";}?> />
               <?php echo $f_array[25] ?> 
              <input name="daohang[]" type="checkbox" id="daohang" value="公司简介" <?php if(strpos($row["daohang"],"公司简介")!==false ){ echo"checked";}?> />
              <?php echo $f_array[26] ?> 
			  <input name="daohang[]" type="checkbox" id="daohang" value="公司新闻" <?php if(strpos($row["daohang"],"公司新闻")!==false ){ echo"checked";}?> />
               <?php echo $f_array[27] ?> 
			  <input name="daohang[]" type="checkbox" id="daohang" value="招聘信息" <?php if(strpos($row["daohang"],"招聘信息")!==false ){ echo"checked";}?> />
               <?php echo $f_array[28] ?>  
              <input name="daohang[]" type="checkbox" id="daohang" value="资质证书" <?php if(strpos($row["daohang"],"资质证书")!==false ){ echo"checked";}?> />
              <?php echo $f_array[29] ?> 
              <input name="daohang[]" type="checkbox" id="daohang" value="联系方式" <?php if(strpos($row["daohang"],"联系方式")!==false ){ echo"checked";}?> />
               <?php echo $f_array[30] ?>  
              <input name="daohang[]" type="checkbox" id="daohang" value="在线留言" <?php if(strpos($row["daohang"],"在线留言")>0 ){ echo"checked";}?> />
               <?php echo $f_array[31] ?>  </td>
          </tr>
          <tr>
            <td class="border2"> <?php echo $f_array[32] ?> </td>
            <td class="border2"><input name="tongji" type="text" id="tongji" value="<?php echo $row["tongji"]?>" size="90" maxlength="200" />            </td>
          </tr>
          <tr>
            <td class="border2"> <?php echo $f_array[33] ?> </td>
            <td class="border2"><input name="baidu_map" type="text" id="baidu_map" value="<?php echo $row["baidu_map"]?>" size="50" maxlength="200" />
              <a href="http://api.map.baidu.com/mapCard/" target="_blank" style="color:red"> <?php echo $f_array[34] ?> </a></td>
          </tr>
        
          <tr> 
            <td class="border2">&nbsp;</td>
            <td class="border2"> <input name="Submit2" type="submit" class="buttons" value=" <?php echo $f_array[35] ?> "></td>
          </tr>
          <tr> 
            <td colspan="2" class="admintitle"> <?php echo $f_array[36] ?> </td>
          </tr>
          <tr> 
            <td class="border"> <?php echo $f_array[37] ?> </td>
            <td class="border"> 
              <?php 
	if(check_user_power('set_mobile')=='yes'){
			?>
              <input name="mobile" type="text" id="mobile" value="<?php echo $row["mobile"]?>" size="30" maxlength="11" onblur="checkmobile()"> 
              <?php 	
	  }else{
	  ?>
              <input name="mobile" type="text" id="mobile" value=" <?php echo $f_array[38] ?> " size="30" disabled> 
              <?php 
	 }
	?>            </td>
          </tr>
          <tr>
            <td class="border2">&nbsp;</td>
            <td class="border2"><input name="Submit" type="submit" class="buttons" value=" <?php echo $f_array[35] ?> " /></td>
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