<?php
if(!isset($_SESSION)){session_start();} 
include("../inc/conn.php");
include("check.php");
$fpath="text/zsadd.txt";
$fcontent=file_get_contents($fpath);
$f_array=explode("|||",$fcontent) ;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<?php
if (check_usergr_power("zs")=="no" && $usersf=='个人'){
echo $f_array[0];//不返回到上一页，防止由user/index.php?goto='zsadd.php'过来的造成死循环提示
exit;
}
?>
<title></title>
<script language = "JavaScript" src="/js/gg.js"></script>
<script language = "JavaScript">
function CheckForm(){
<?php echo $f_array[1]?>
var v = '';
for(var i = 0; i < document.myform.destList.length; i++){
if(i==0){
v = document.myform.destList.options[i].text;
}else{
v += ','+document.myform.destList.options[i].text;
}
}
//alert(v);
document.myform.cityforadd.value=v;
}

function showinfo(name, n){
	var chList=document.getElementsByName("ch"+name);
	var TextArea=document.getElementById(name);
	if(chList[n-1].checked) //数组从0开始
	{
		temp= TextArea.value; 
		TextArea.value = temp.replace(eval("document.getElementById(name+n).innerHTML"),"");
		TextArea.value+= eval("document.getElementById(name+n).innerHTML")
	}else{
		temp= TextArea.value; 
		TextArea.value = temp.replace(eval("document.getElementById(name+n).innerHTML"),"");
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
 
function ValidSelect(checkboxselect){
<?php echo $f_array[2]?>	
}	

function isNumber(String){ 
var Letters = "1234567890";   //可以自己增加可输入值
var i;
var c;
for( i = 0; i<String.length;i ++ ){ 
c=String.charAt( i );
if(Letters.indexOf( c )> 0)
return  false;
}
return  true;
}
function  CheckNum(){ 
<?php echo $f_array[3]?>
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
<div class="admintitle"><?php echo str_replace("{#channelzs}",channelzs,$f_array[4])?></div>
<?php
$tablename="zzcms_main";
include("checkaddinfo.php");
?>
<script type="text/javascript" src="/js/jquery.js"></script>  
<script type="text/javascript" language="javascript">
$.ajaxSetup ({
cache: false //close AJAX cache
});
</script>
<script language="javascript">  
$(document).ready(function(){  
  $("#name").change(function() { //jquery 中change()函数  
	$("#span_szm").load(encodeURI("../ajax/zsadd_ajax.php?id="+$("#name").val()));//jqueryajax中load()函数 加encodeURI，否则IE下无法识别中文参数 
	$("#quote").load(encodeURI("/ajax/zstitlecheck_ajax.php?id="+$("#name").val()));//jqueryajax中load()函数 加encodeURI，否则IE下无法识别中文参数 
  });  
});   
</script> 
<form  action="zssave.php" method="post" name="myform" id="myform" onSubmit="return CheckForm();">
        <table width="100%" border="0" cellpadding="3" cellspacing="1">
          <tr> 
            <td width="20%" align="right" class="border2" > <?php echo $f_array[5]?> <font color="#FF0000">*</font></td>
            <td class="border2" > <input name="name" type="text" id="name" onclick="javascript:if (this.value=='<?php echo $f_array[6]?>') {this.value=''};this.style.backgroundColor='';" onblur="javascript:if (this.value=='<?php echo $f_array[6]?>') {this.value=''};this.style.backgroundColor='';" size="60" maxlength="45" /><span id="quote"></span> 
             <span id="span_szm">  <input name="szm" type="hidden"  /></span>
              <br />
              <?php echo $f_array[7]?></td>
          </tr>
          <tr> 
            <td align="right" valign="top" class="border"><?php echo $f_array[8]?><font color="#FF0000"> 
              *</font></td>
            <td valign="middle" class="border" > <table width="100%" border="0" cellpadding="5" cellspacing="1">
                <tr> 
                  <td> <fieldset>
                    <legend><?php echo $f_array[9]?></legend>
                    <?php
        $sql = "select * from zzcms_zsclass where parentid='A' order by xuhao asc";
		$rs = mysql_query($sql,$conn); 
		$n=0;
		while($row= mysql_fetch_array($rs)){
		$n ++;
		if (@$_SESSION['bigclassid']==$row['classzm']){
		echo "<input name='bigclassid' type='radio' id='E$n'  onclick='javascript:doClick_E(this);uncheckall()' value='$row[classzm]' checked/><label for='E$n'>$row[classname]</label>";
		}else{
		echo "<input name='bigclassid' type='radio' id='E$n'  onclick='javascript:doClick_E(this);uncheckall()' value='$row[classzm]'/><label for='E$n'>$row[classname]</label>";
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
echo "<fieldset><legend>".$f_array[10]."</legend>";

$sqln="select * from zzcms_zsclass where parentid='$row[classzm]' order by xuhao asc";
$rsn = mysql_query($sqln,$conn); 
$nn=0;
while($rown= mysql_fetch_array($rsn)){
if (zsclass_isradio=='Yes'){
echo "<input name='smallclassid[]' id='radio$nn$n' type='radio' value='$rown[classzm]' />";
}else{
echo "<input name='smallclassid[]' id='radio$nn$n' type='checkbox' value='$rown[classzm]' onclick='javascript:ValidSelect(this)'/>";
}
echo "<label for='radio$nn$n'>$rown[classname]</label>";
$nn ++;	
if ($nn % 6==0) {echo "<br/>";}
}
echo "</fieldset>";
echo "</div>";
}
?>                  </td>
                </tr>
              </table></td>
          </tr>
		   <?php 
		  $rs = mysql_query("select * from zzcms_zsclass_shuxing order by xuhao asc"); 
		$row= mysql_num_rows($rs);
		if ($row){
		  ?>
          <tr> 
            <td align="right" class="border2" ><?php echo $f_array[11]?></td>
            <td class="border2" > 
	<?php
	$n=0;
	while($row= mysql_fetch_array($rs)){
	$n ++;
	echo "<input name='shuxing' type='radio' id='shuxing$n' value='$row[bigclassid]'/><label for='shuxing$n'>$row[bigclassname]</label>";	
	}
	?>		</td>
          </tr>
		  <?php
		  }
		  ?>
          <tr>
            <td align="right" class="border2" ><?php echo $f_array[12]?><font color="#FF0000"> *</font></td>
            <td class="border2" ><textarea name="gnzz" cols="60" rows="4" id="gnzz" onclick="javascript:if (this.value=='此处不能为空') {this.value=''};this.style.backgroundColor='';" onblur="javascript:if (this.value=='此处不能为空') {this.value=''};this.style.backgroundColor='';"></textarea></td>
          </tr>
          <tr> 
            <td align="right" class="border" ><?php echo $f_array[13]?></td>
            <td class="border" > <input name="gg" type="text" id="gg"  size="60" maxlength="45" />            </td>
          </tr>
          <tr> 
            <td align="right" class="border2" ><?php echo $f_array[14]?></td>
            <td class="border2" > <input name="lsj" type="text" id="lsj"  size="60" maxlength="45" /></td>
          </tr>
          <tr> 
            <td align="right" class="border" ><?php echo $f_array[15]?> <font color="#FF0000">*</font></td>
            <td class="border" > 
			<textarea name="sm" id="sm"></textarea> 
             <script type="text/javascript" src="/3/ckeditor/ckeditor.js"></script>
			  <script type="text/javascript">CKEDITOR.replace('sm');</script>			</td>
          </tr>
          <tr> 
            <td align="right" class="border2"><?php echo channelzs.$f_array[16]?><font color="#FF0000">*</font></td>
            <td class="border2"> <table border="0" cellpadding="3" cellspacing="0">
                <tr> 
                  <td><script language="JavaScript" type="text/javascript">
function addSrcToDestList() {
destList = window.document.forms[0].destList;
city = window.document.forms[0].xiancheng;
var len = destList.length;
for(var i = 0; i < city.length; i++) {
if ((city.options[i] != null) && (city.options[i].selected)) {
var found = false;
for(var count = 0; count < len; count++) {
if (destList.options[count] != null) {
if (city.options[i].text == destList.options[count].text) {
found = true;
break;
}
}
}
if (found != true) {
destList.options[len] = new Option(city.options[i].text);
len++;
}
}
}
}
function deleteFromDestList() {
var destList = window.document.forms[0].destList;
var len = destList.options.length;
for(var i = (len-1); i >= 0; i--) {
if ((destList.options[i] != null) && (destList.options[i].selected == true)) {
destList.options[i] = null;
}
}
} 
</script>                   
<select name="province" id="province"></select>
<select name="city" id="city"></select>
<select name="xiancheng" id="xiancheng" onchange="addSrcToDestList()"></select>
<script src="/js/area.js"></script>
<script type="text/javascript">
new PCAS('province', 'city', 'xiancheng', '<?php echo @$_SESSION['province']?>', '<?php echo @$_SESSION["city"]?>', '<?php echo @$_SESSION["xiancheng"]?>');
</script>

                  <td width="100" align="center" valign="top"><?php echo $f_array[17]?>
                    
                    <select name="destList" size="5" multiple="multiple" style='width:100px;font-size:13px'>
              <?php 
			  if (isset($_SESSION['xiancheng'])){
			  		if (strpos($_SESSION["xiancheng"],",")==0) {?>
                     <option value="<?php echo $_SESSION["xiancheng"]?>"><?php echo $_SESSION["xiancheng"]?></option>
                     <?php 
					 }else{
			  		$selectedcity=explode(",",$_SESSION["xiancheng"]);
						for ($i=0;$i<count($selectedcity);$i++){    ?>
                  		<option value="<?php echo $selectedcity[$i]?>"><?php echo $selectedcity[$i]?></option>
                      	<?php 
						}
					}
			}
			?>
                  </select>
				  <input name="cityforadd" type="hidden" id="cityforadd" />                
				  <input name="button" type="button" onclick="javascript:deleteFromDestList();" value="<?php echo $f_array[18]?>" /></td>
                </tr>
                
              </table></td>
          </tr>
          <tr> 
            <td align="right" class="border" ><?php echo str_replace("{#maximgsize}",maximgsize,$f_array[19])?><br /> 
              <script src="/js/swfobject.js" type="text/javascript"></script> <script type="text/javascript">
function showtxt(num){
var sd =window.showModalDialog('/uploadimg_form.php','','dialogWidth=400px;dialogHeight=300px');
//for chrome 
if(sd ==undefined) {  
sd =window.returnValue; 
}
if(sd!=null) { 
document.getElementById("img"+num).value=sd;//从子页面得到值写入母页面
document.getElementById("showimg"+num).innerHTML="<img src='"+sd+"' width=120>";
}
}

function openflv(){
var sd =window.showModalDialog('/uploadflv_form.php','','dialogWidth=400px;dialogHeight=300px');
//for chrome 
if(sd ==undefined) {  
sd =window.returnValue; 
}
if(sd!=null) {  
document.getElementById("flv").value=sd;//从子页面得到值写入母页面
	if(sd.substr(sd.length-3).toLowerCase()=='flv'){//用这个播放器无法播放网络上的SWF格式的视频
        var s1 = new SWFObject("/image/player.swf","ply","200","200","9","#FFFFFF");
          s1.addParam("allowfullscreen","true");
          s1.addParam("allowscriptaccess","always");
          s1.addParam("flashvars","file="+sd+"&autostart=true");
          s1.write("container");
		  
	}else if(sd.substr(sd.length-3).toLowerCase()=='swf'){
	var s1="<embed src='"+sd+"' quality='high' pluginspage='http://www.macromedia.com/go/getflashplayer' type='application/x-shockwave-flash' width=200 height=200></embed>";
	document.getElementById("container").innerHTML=s1+"<br/><?php echo $f_array[20]?>";
	}
}
}
</script> <input name="img1" type="hidden" id="img1" value="/image/nopic.gif"/> 
              <input name="img2" type="hidden" id="img2" value="/image/nopic.gif"/> 
              <input name="img3" type="hidden" id="img3" value="/image/nopic.gif"/>            </td>
            <td class="border" > <table height="120" border="0" cellpadding="5" cellspacing="5">
                <tr align="center" bgcolor="#FFFFFF"> 
                  <td width="120" id="showimg1" onClick="showtxt(1)"> <input name="Submit2" type="button"  value="<?php echo $f_array[21]?>" /></td>
                      <?php
		 if (check_user_power("uploadmoreimg")=="no"){
?>
                  <td width="120" onClick="javascript:window.location.href='vip_add.php'"> 
                    <img src="../image/jx.gif" width="48" height="48" /><br />
                      <?php echo $f_array[22]?><br /><span class='buttons'><?php echo $f_array[23]?></span></td>    
                  <td width="120" onClick="javascript:window.location.href='vip_add.php'">
				  <img src="../image/jx.gif" width="48" height="48" /><br />
                      <?php echo $f_array[22]?><br /><span class='buttons'><?php echo $f_array[23]?></span></td>
			    <?php
		   }else{
		  ?>	  
				  <td width="120" id="showimg2" onClick="showtxt(2)"> <input name="Submit22" type="button"  value="<?php echo $f_array[21]?>" /></td>
                  <td width="120" id="showimg3" onClick="showtxt(3)"> <input name="Submit23" type="button"  value="<?php echo $f_array[21]?>" /></td>
			  <?php
			  }
			  ?>		  
                </tr>
              </table></td>
          </tr>
          <tr> 
            <td align="right" class="border2" ><?php echo $f_array[24]?><br />
              <?php echo str_replace("{#maxflvsize}",maxflvsize,$f_array[25])?><input name="flv" type="hidden" id="flv" /></td>
            <td class="border2" >
			    <?php
if (check_user_power("uploadflv")=="yes"){
?>
			<table width="120" height="120" border="0" cellpadding="5" cellspacing="1" bgcolor="#999999">
                <tr align="center" bgcolor="#FFFFFF"> 
                  <td id="container" onClick="openflv()"> <input name="Submit24" type="button"  value="<?php echo $f_array[26]?>" />                  </td>
                </tr>
              </table>
			    <?php
		   }else{
		  ?>
		  <table width="120" height="120" border="0" cellpadding="5" cellspacing="1" bgcolor="#999999">
                <tr align="center" bgcolor="#FFFFFF"> 
                  <td id="container" onClick="javascript:window.location.href='vip_add.php'"> <p><img src="../image/jx.gif" width="48" height="48" /><br />
                      <?php echo $f_array[22]?></p>
                    <p><span class='buttons'><?php echo $f_array[23]?></span><br />
                    </p></td>
                </tr>
              </table>
			  <?php
			  }
			  ?>			  </td>
          </tr>
        
          <tr> 
            <td align="right" class="border2" ><?php echo $f_array[27]?></td>
            <td class="border2" > <textarea name="zc" cols="60" rows="4" id="zc" onfocus="this.select()"><?php if (isset($_SESSION["zc"]))echo $_SESSION["zc"];?></textarea> 
              <div> <?php echo $f_array[28]?> </div></td>
          </tr>
          <tr> 
            <td align="right" class="border" ><?php echo str_replace("{#channeldl}",channeldl,$f_array[29])?></td>
            <td class="border" > <textarea name="yq" cols="60" rows="4" id="yq" onfocus="this.select()"><?php if (isset($_SESSION["yq"]))echo $_SESSION["yq"];?></textarea> 
              <div><?php echo $f_array[30]?> </div></td>
          </tr>
          <tr align="center"> 
            <td colspan="2" class="border2" ><strong><?php echo $f_array[31]?></strong></td>
          </tr>
		  	    <?php
if (check_user_power("seo")=="yes"){
?>
          <tr> 
            <td align="right" class="border" ><?php echo $f_array[32]?></td>
            <td class="border" ><input name="title" type="text" id="title" onclick="javascript:if (this.value=='<?php echo $f_array[6]?>') {this.value=''};this.style.backgroundColor='';" onblur="javascript:if (this.value=='<?php echo $f_array[6]?>') {this.value=''};this.style.backgroundColor='';" size="60" maxlength="255" /></td>
          </tr>
          <tr> 
            <td align="right" class="border2" ><?php echo $f_array[33]?></td>
            <td class="border2" > <input name="keyword" type="text" id="keyword" onclick="javascript:if (this.value=='<?php echo $f_array[6]?>') {this.value=''};this.style.backgroundColor='';" onblur="javascript:if (this.value=='<?php echo $f_array[6]?>') {this.value=''};this.style.backgroundColor='';" size="60" maxlength="255" />
              <?php echo $f_array[34]?></td>
          </tr>
          <tr> 
            <td align="right" class="border" ><?php echo $f_array[35]?></td>
            <td class="border" ><input name="discription" type="text" id="discription" onblur="javascript:if (this.value=='<?php echo $f_array[6]?>') {this.value=''};this.style.backgroundColor='';" onclick="javascript:if (this.value=='<?php echo $f_array[6]?>') {this.value=''};this.style.backgroundColor='';" value="" size="60" maxlength="255" />
              <?php echo $f_array[36]?></td>
          </tr>
		  <?php 
		  }else{
		  ?>
  <tr> 
            <td align="right" class="border" ><?php echo $f_array[32]?></td>
            <td class="border" ><input type="text" size="60" maxlength="255" disabled="disabled" value="<?php echo $f_array[37]?>"/></td>
          </tr>
          <tr> 
            <td align="right" class="border2" ><?php echo $f_array[33]?></td>
            <td class="border2" > <input  type="text"  size="60" maxlength="255" value="<?php echo $f_array[37]?>" disabled="disabled"/>
              <?php echo $f_array[34]?></td>
          </tr>
          <tr> 
            <td align="right" class="border" ><?php echo $f_array[35]?></td>
            <td class="border" ><input type="text"  value="<?php echo $f_array[37]?>" size="60" maxlength="255" disabled="disabled"/>
             <?php echo $f_array[36]?></td>
          </tr>
		   <?php 
		  }
		  ?>	
          <tr>
            <td colspan="2" align="center" class="border2" ><strong><?php echo $f_array[38]?></strong></td>
          </tr>
		     <?php
if (check_user_power("zsshow_template")=="yes"){
?>
          <tr>
            <td align="right" class="border" ><?php echo $f_array[39]?></td>
            <td class="border" >
              <input name="skin" type="radio" id="cp" value="cp" checked="checked" />
            <label for="cp"><?php echo $f_array[40]?></label>
              <input type="radio" name="skin" value="xm" id="xm" />
            <label for="xm"><?php echo $f_array[41]?></label></td>
          </tr>
 <?php 
		  }else{
		  ?>		 
		 <tr>
            <td align="right" class="border" ><?php echo $f_array[42]?></td>
            <td class="border" >
              <input name="skin" type="radio" id="cp" value="cp" checked="checked" disabled="disabled"/>
            <label for="cp"><?php echo $f_array[40]?></label>
              <input type="radio" name="skin" value="xm" id="xm" disabled="disabled"/>
            <label for="xm"><?php echo $f_array[41]?></label></td>
          </tr> 
		 <?php 
		  }
		  ?>		  
          <tr> 
            <td align="center" class="border2" >&nbsp;</td>
            <td class="border2" > <input name="action" type="hidden" id="action2" value="add" /> 
              <input name="Submit" type="submit" class="buttons" value="<?php echo $f_array[43]?>" /></td>
          </tr>
        </table>
</form>
</div>	  
</div>
</div>
<?php
mysql_close($conn);
session_write_close();
?>
</body>
</html>