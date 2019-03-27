<?php
include("admin.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<link href="style.css" rel="stylesheet" type="text/css">
<?php
checkadminisdo("zs");
?>
<script language="javascript" src="/js/timer.js"></script>
<script language = "JavaScript" src="/js/gg.js"></script>
</head>
<body>
<script language = "JavaScript">
function CheckForm(){
if (document.myform.bigclassid.value==""){
    alert("请选择产品类别！");
	document.myform.bigclassid.focus();
	return false;
  }
  if (document.myform.cpname.value==""){
    alert("产品名称不能为空！");
	document.myform.cpname.focus();
	return false;
  }
  if (document.myform.prouse.value==""){
    alert("产品特点不能为空！");
	document.myform.prouse.focus();
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
<div class="admintitle">修改<?php echo channelzs?>信息</div>
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
  });  
});  
</script> 
<form action="zs_save.php" method="post" name="myform" id="myform" onSubmit="return CheckForm();">

<?php
$id=$_REQUEST["id"];
if ($id<>"") {
checkid($id);
}else{
$id=0;
}
$sql="select * from zzcms_main where id='$id'";
$rs=mysql_query($sql);
$row=mysql_fetch_array($rs);
?>
  <table width="100%" border="0" cellpadding="5" cellspacing="0">
    <tr> 
      <td align="right" class="border">产品名称 <font color="#FF0000">*</font></td>
      <td width="82%" class="border"> <input name="cpname" type="text" id="cpname" value="<?php echo $row["proname"]?>" size="45" maxlength="50">
	  <span id="span_szm">  <input name="szm" type="hidden" value="<?php echo $row["szm"]?>"  />
        </span>      </td>
    </tr>
    <tr> 
      <td width="18%" align="right" class="border"> 所属类别 <font color="#FF0000">*</font></td>
      <td class="border"> 
        
		<table width="100%" border="0" cellpadding="0" cellspacing="1">
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
		echo "<input name='bigclassid' type='radio' id='E$n'  onclick='javascript:doClick_E(this);uncheckall()' value='".$rowB['classzm']."' checked/><label for='E$n'>".$rowB['classname']."</label>";
		}else{
		echo "<input name='bigclassid' type='radio' id='E$n'  onclick='javascript:doClick_E(this);uncheckall()' value='".$rowB['classzm']."' /><label for='E$n'>".$rowB['classname']."</label>";
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
$sqlS="select * from zzcms_zsclass where parentid='".$rowB['classzm']."' order by xuhao asc";
$rsS = mysql_query($sqlS,$conn); 
$nn=0;
while($rowS= mysql_fetch_array($rsS)){
if (zsclass_isradio=='Yes'){
	if ($row['smallclasszm']==$rowS['classzm']){
	echo "<input name='smallclassid[]' id='radio$nn$n' type='radio' value='".$rowS['classzm']."' checked/>";
	}else{
	echo "<input name='smallclassid[]' id='radio$nn$n' type='radio' value='".$rowS['classzm']."' />";
	}
}else{
	if (strpos($row['smallclasszm'],$rowS['classzm'])!==false && $row['bigclasszm']==$rowB['classzm']){
	echo "<input name='smallclassid[]' id='radio$nn$n' type='checkbox' value='".$rowS['classzm']."' checked/>";
	}else{
	echo "<input name='smallclassid[]' id='radio$nn$n' type='checkbox' value='".$rowS['classzm']."' />";
	}
}
echo "<label for='radio$nn$n'>".$rowS['classname']."</label>";
$nn ++;
if ($nn % 6==0) {echo "<br/>";}            
}
echo "</fieldset>";
echo "</div>";
}
?>                  </td>
                </tr>
              </table>
		 </td>
    </tr>
	   <?php 
		  $rsn = mysql_query("select * from zzcms_zsclass_shuxing order by xuhao asc"); 
		$rown= mysql_num_rows($rsn);
		if ($rown){
		  ?>
          <tr>
            <td align="right" class="border" >属性</td>
            <td class="border" >
			<?php
        $n=0;
		while($rown= mysql_fetch_array($rsn)){
		$n ++;
		if ($row['shuxing']==$rown['bigclassid']){
		echo "<input name='shuxing' type='radio' id='shuxing$n' value='".$rown['bigclassid']."' checked/><label for='shuxing$n'>".$rown['bigclassname']."</label>";
		}else{
		echo "<input name='shuxing' type='radio' id='shuxing$n' value='".$rown['bigclassid']."'/><label for='shuxing$n'>".$rown['bigclassname']."</label>";
		}
		
	}
			?></td>
          </tr>
		    <?php 
		 }
		  ?>
    <tr> 
      <td align="right" class="border">产品特点<font color="#FF0000"> *</font></td>
      <td class="border"> <textarea name="prouse" cols="60" rows="3" id="prouse"><?php echo $row["prouse"]?></textarea>      </td>
    </tr>
    <tr> 
      <td align="right" class="border">规格/包装 <font color="#FF0000">*</font></td>
      <td class="border"> <input name="gg" type="text" id="gg" value="<?php echo $row["gg"]?>" size="45">      </td>
    </tr>
    <tr> 
      <td align="right" class="border" >零售价 <font color="#FF0000">*</font></td>
      <td class="border" ><input name="lsj" type="text" id="lsj"  value="<?php echo $row["pricels"]?>" size="45"></td>
    </tr>
    <tr> 
      <td align="right" class="border">产品说明：</td>
      <td class="border"> 
	  <textarea name="sm" id="sm"><?php echo $row["sm"] ?></textarea> 
             <script type="text/javascript" src="/3/ckeditor/ckeditor.js"></script>
			  <script type="text/javascript">CKEDITOR.replace('sm');</script>   
			
	  </td>
    </tr>
    <tr> 
      <td align="right" class="border">图片地址： <script type="text/javascript">
function showtxt(num)
{
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
</script> <input name="img1" type="hidden" id="img1" value="<?php echo $row["img"]?>" size="45"> 
        <input name="img2" type="hidden" id="img2" value="<?php echo $row["img2"]?>" size="45"> 
        <input name="img3" type="hidden" id="img3" value="<?php echo $row["img3"]?>" size="45"></td>
      <td class="border"> <table height="120" border="0" cellpadding="5" cellspacing="1" bgcolor="#999999">
          <tr> 
            <td width="120" align="center" bgcolor="#FFFFFF" id="showimg1" onclick='showtxt(1)'> 
              <?php
				  if($row["img"]<>""){
				  echo "<img src='".$row["img"]."' border=0 width=120 /><br>点击可更换图片";
				  }else{
				  echo "<input name='Submit2' type='button'  value='上传图片'/>";
				  }
				  
				  ?>            </td>
            <td width="120" align="center" bgcolor="#FFFFFF" id="showimg2" onclick='showtxt(2)'> 
              <?php
				  if($row["img2"]<>""){
				  echo "<img src='".$row["img2"]."' border=0 width=120 /><br>点击可更换图片";
				  }else{
				  echo "<input name='Submit2' type='button'  value='上传图片'/>";
				  }
				  
				  ?>            </td>
            <td width="120" align="center" bgcolor="#FFFFFF" id="showimg3" onclick='showtxt(3)'> 
              <?php
				  if($row["img3"]<>""){
				  echo "<img src='".$row["img3"]."' border=0 width=120 /><br>点击可更换图片";
				  }else{
				  echo "<input name='Submit2' type='button'  value='上传图片'/>";
				  }
				  
				  ?>            </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td align="right" class="border">视频地址：</td>
      <td class="border"> <input name="flv" type="text" id="flv" value="<?php echo $row["flv"]?>" size="60"></td>
    </tr>
    <tr> 
      <td align="right" class="border">可提供的支持：</td>
      <td class="border"> <textarea name="zc" cols="60" rows="3" id="zc"><?php echo $row["zc"]?></textarea>      </td>
    </tr>
    <tr> 
      <td align="right" class="border">对<?php echo channeldl?>商的要求：</td>
      <td class="border"> <textarea name="yq" cols="60" rows="3" id="yq"><?php echo $row["yq"]?></textarea>      </td>
    </tr>
    <tr> 
      <td align="right" class="border">发布人：</td>
      <td class="border"><input name="editor" type="text" id="editor" value="<?php echo $row["editor"]?>" size="45"> 
        <input name="oldeditor" type="hidden" id="oldeditor" value="<?php echo $row["editor"]?>"></td>
    </tr>
    <tr> 
      <td align="right" class="border">审核：</td>
      <td class="border"><input name="passed[]" type="checkbox" id="passed[]" value="1"  <?php if ($row["passed"]==1) { echo "checked";}?>>
        （选中为通过审核） </td>
    </tr>
    <tr>
      <td align="right" class="border">&nbsp;</td>
      <td class="border"><input type="submit" name="Submit22" value="修 改"></td>
    </tr>
	 <tr> 
      <td colspan="2" class="userbar">SEO设置</td>
    </tr>
	
    <tr>
      <td align="right" class="border" >标题（title）</td>
      <td class="border" ><input name="title" type="text" id="title" value="<?php echo $row["title"] ?>" size="60" maxlength="255"></td>
    </tr>
    <tr>
      <td align="right" class="border" >关键词（keywords）</td>
      <td class="border" ><input name="keyword" type="text" id="keyword" value="<?php echo $row["keywords"] ?>" size="60" maxlength="255">
        (多个关键词以“,”隔开)</td>
    </tr>
    <tr>
      <td align="right" class="border" >描述（description）</td>
      <td class="border" ><input name="discription" type="text" id="discription" value="<?php echo $row["description"] ?>" size="60" maxlength="255">
        (适当出现关键词，最好是完整的句子)</td>
    </tr>
    <tr> 
      <td align="right" class="border">&nbsp;</td>
      <td class="border"><input type="submit" name="Submit2" value="修 改"></td>
    </tr>
    <tr> 
      <td colspan="2" class="userbar">排名设置</td>
    </tr>
    <tr> 
      <td align="right" class="border">设为关键字排名产品</td>
      <td class="border"><input name="elite[]" type="checkbox" id="elite[]" value="1" <?php if ($row["elite"]==1) { echo "checked";}?>>
        时间： 
        <input name="elitestarttime" type="text" value="<?php echo $row["elitestarttime"]?>" size="20" onFocus="JTC.setday(this)">
        至 
        <input name="eliteendtime" type="text" value="<?php echo $row["eliteendtime"]?>" size="20" onFocus="JTC.setday(this)">      </td>
    </tr>
    <tr> 
      <td align="right" class="border">搜索热门词：</td>
      <td class="border"><input name="tag" type="text" id="tag" value="<?php echo $row["tag"]?>" size="45">
        (多个词可用,隔开) </td>
    </tr>
    <tr> 
      <td align="center" class="border">&nbsp;</td>
      <td class="border"><input name="cpid" type="hidden" id="cpid" value="<?php echo $row["id"]?>"> 
        <input name="sendtime" type="hidden" id="sendtime" value="<?php echo $row["sendtime"]?>"> 
        <input name="page" type="hidden" id="page" value="<?php echo $_GET["page"]?>"> 
        <input type="submit" name="Submit" value="修 改"></td>
    </tr>
  </table>
</form>
<?php
mysql_close($conn);
?>
</body>
</html>
