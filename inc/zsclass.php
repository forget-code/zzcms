<?php
function showzsclass($style,$column_b,$num_b,$long_b,$column_s,$num_s,$long_s,$column_p,$num_p,$long_p,$showcount='yes',$adv='no',$tdheight=55){
global $siteskin;
checkid($column_b);
checkid($column_s);
checkid($column_p);
$fp=zzcmsroot."cache/".$siteskin."/zsclass_".$style.".htm";
if (cache_update_time!=0 && file_exists($fp) && time()-filemtime($fp)<3600*24*cache_update_time ) {//12小时更新一次,
	$f=fopen($fp,"r+");
	$fcontent="";
	while (!feof($f)){$fcontent=$fcontent.fgets($f);}
	fclose($f);
	return $fcontent;
}else{
$sql="select * from zzcms_zsclass where parentid='A' and isshow=1 order by xuhao asc limit 0,$num_b";
$rs=mysql_query($sql);
$row=mysql_num_rows($rs);
if ($row){
$n=1;
$tdwidth=floor(100/$column_b);//取整
$liwidth=floor(100/$column_s);//取整
$str="<div style='position:relative;z-index:4'>";
if ($style==1){
$str=$str."<table border=0 cellspacing=0 cellpadding=0 class='zsclass_tablebg'><tr>";
}else{
$str=$str."<table border=0 cellspacing=1 cellpadding=0 class='zsclass_tablebg'><tr>";
}
while ($row=mysql_fetch_array($rs)){
if ($style==1){
$str=$str. "<td valign='top' class='zsclass_td_style1' onmouseover=\"adSetBg(this)\" onMouseOut=\"adReBg(this)\"  width='".$tdwidth."%'> \n";
$str=$str. "<div class='zsclass_b' onMouseOver=\"showfilter2(zsLayer$n)\" onMouseOut=\"showfilter2(zsLayer$n)\">\n";
}else{
	if ($n % 2==0){ 
	$str=$str. "<td valign='top' class='zsclass_td' width='".$tdwidth."%'> \n";	
	}else{
	$str=$str. "<td valign='top' class='zsclass_td2' width='".$tdwidth."%'> \n";	
	}
$str=$str. "<div class='zsclass_b2'>\n";
}
$str=$str. "<h2>";
	if ($row["img"]<>''&& $row["img"]<>0){
	$str=$str. "<img src=".$row["img"].">";
	}
$str=$str. "<a href=".getpageurl2("zs",$row["classzm"],'').">".cutstr($row["classname"],$long_b)."</a>";
	if($showcount=='yes'){
	$rsnumb=mysql_query("select count(*) as total from zzcms_main where bigclasszm='".$row["classzm"]."' ");//统计所属大类下的信息数
	$rown = mysql_fetch_array($rsnumb);
	$totlenum = $rown['total'];
	$str=$str. "<span>(共 <font color=#FF6600>" .$totlenum. "</font> 条)</span>" ;
	}
$str=$str. "</h2>\n";
if ($style==1){//为1时大类下显示小类
	if ($adv=="yes"){
	//$str=$str.showad(2,4,"no","yes","no",0,0,5,$row["classname"],"分类招商间","no");//两种方法都可以
	$str=$str.adshow("index_zsclass",$row["classname"],"分类招商间");//在广告标签中加个名为index_zsclass的广告,这种布局更灵活，缺点：得加个自定标签，麻烦点
	}else{
	$str=$str. "<div>\n";
	$rsn=mysql_query("select * from zzcms_zsclass where parentid='".$row["classzm"]."' order by xuhao asc limit 0,$num_s");
	$rown=mysql_num_rows($rsn);
		$nn=1;
		if ($rown){
			while ($rown=mysql_fetch_array($rsn)){
			$str=$str. "<a href=".getpageurl2('zs',$row["classzm"],$rown["classzm"]).">".cutstr($rown["classname"],$long_s)."</a>&nbsp;&nbsp;\n";
			if ($nn % $column_s==0){ $str=$str.  '<br/>';}
			$nn=$nn+1;
			}
		}else{
		$str=$str."下无子类";
		}
	$str=$str. "</div>";
	}
}				//end
	
$str=$str. "</div>\n";

if ($num_s!=0){//当小类数不为0时显示小类
if ($style==1){
//$minheight=$tdheight*$n-20+35;//使有足够的高度,20为padding值
//$minheight=$minheight.'px';
//$str=$str. "<div id=zsLayer$n class='zsclass_s' style='min-height:$minheight' onMouseOver=\"showfilter2(zsLayer$n)\" onMouseOut=\"showfilter2(zsLayer$n)\" >\n";
$str=$str. "<div id=zsLayer$n class='zsclass_s'  onMouseOver=\"showfilter2(zsLayer$n)\" onMouseOut=\"showfilter2(zsLayer$n)\" >\n";
$str=$str. "<div class='bigbigword'>".$row["classname"]."</div>";//右边的小类框上面显示大类名
}else{
$str=$str. "<div class='zsclass_box_s'>";
}
$nn=1;
$rsn=mysql_query("select * from zzcms_zsclass where parentid='".$row["classzm"]."' order by xuhao asc limit 0,$num_s");
$rown=mysql_num_rows($rsn);
	if ($rown){
		while ($rown=mysql_fetch_array($rsn)){
		$str=$str. "<div class='zsclass_s_li' style='width:".$liwidth."%'>\n";
		$str=$str. "<div class='zsclass_s_name'>\n";
		$str=$str. "<a href=".getpageurl2('zs',$row["classzm"],$rown["classzm"]).">".cutstr($rown["classname"],$long_s)."</a>\n";
		$str=$str. "</div>\n";
			if ($num_p<>0){
			$str=$str. "<div class='zsclass_cp'>\n";
			$nnn=1;
			if(zsclass_isradio=='No'){
			$sqlcp="select id,proname from zzcms_main where bigclasszm='".$row["classzm"]."' and smallclasszm like '%".$rown["classzm"]."%' order by sendtime desc limit 0,$num_p";
			}else{
			$sqlcp="select id,proname from zzcms_main where bigclasszm='".$row["classzm"]."' and smallclasszm='".$rown["classzm"]."' order by sendtime desc limit 0,$num_p";
			}
			$rscp=mysql_query($sqlcp);
			$rowcp=mysql_num_rows($rscp);
			if ($rowcp){
				while ($rowcp=mysql_fetch_array($rscp)){
				$str=$str. "<a href='".getpageurl("zs",$rowcp['id'])."' target='_blank'>".cutstr($rowcp['proname'],$long_p)."</a>\n";
				if ($nnn % $column_p==0){$str=$str.'<br/>' ;}else {$str=$str.'&nbsp;|&nbsp; ';}
				$nnn=$nnn+1;
				}
			}else{
			$str=$str. '下无产品';
			}
			$str=$str. '</div>';
			}
		$str=$str. "</div>\n";
		$nn=$nn+1;
		}
	//$str=$str. "<a href=".getpageurl2("zs",$row["classzm"],"").">更多...</a>";
	}else{
	$str=$str. '下无子类';
	}
$str=$str. "</div>\n";
}
$str=$str. "</td>\n";
if ($n % $column_b==0){ $str=$str.  '</tr>';}
$n=$n+1;		 
}
$str=$str. '</table>';
$str=$str. '</div>';
}else{
$str= '暂无分类信息';
}
	if (cache_update_time!=0){
	$fp=zzcmsroot."cache/".$siteskin."/zsclass_".$style.".htm";
	if (!file_exists(zzcmsroot."cache/".$siteskin)) {mkdir(zzcmsroot."cache/".$siteskin,0777,true);}
	$f=fopen($fp,"w+");//fopen()的其它开关请参看相关函数
	fputs($f,$str);
	fclose($f);
	}
return $str;
}
}
?>