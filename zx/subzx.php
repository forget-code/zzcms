<?php
function zxbigclass($b,$url=1){
$n=1;
$str='';
$sql="select classid,classname from zzcms_zxclass where isshowininfo=1 and parentid=0 order by xuhao asc";
$rs=mysql_query($sql);
$row=mysql_num_rows($rs);
if ($row){
while($row=mysql_fetch_array($rs)){
	$str=$str."<li>";
	if($url==2){
		if($row['classid']==$b){
		$str=$str."<a href='".getpageurl2("zx",$row["classid"],"")."' class='current'>".$row["classname"]."</a>";
		}else{
		$str=$str."<a href='".getpageurl2("zx",$row["classid"],"")."'>".$row["classname"]."</a>";
		}
	}else{
		if($row['classid']==$b){
		$str=$str."<a href='".getpageurlzx("zx",$row["classid"])."' class='current'>".$row["classname"]."</a>";
		}else{
		$str=$str."<a href='".getpageurlzx("zx",$row["classid"])."'>".$row["classname"]."</a>";
		}
	}
	$str=$str."</li>";
	$n=$n+1;	
	}
}else{
$str="暂无分类";
}
return $str;
}

function zxsmallclass($column,$b,$s){
if ($b<>""){
$n=1;
$sql="select classid,classname from zzcms_zxclass where parentid=".$b." order by xuhao";
$rs=mysql_query($sql);
$row=mysql_num_rows($rs);
if ($row){

$str="<table width=100% border=0 cellspacing=1 cellpadding=0 class='bgcolor3'><tr>";
while($row=mysql_fetch_array($rs)){
$str=$str."<td height=23 align='center' class='infos'>";
if ($row["classid"]==$s){
$str=$str. " <a href='".getpageurl2("zx",$b,$row["classid"])."'><b>".$row["classname"]."</b></a>";
}else{
$str=$str. " <a href='".getpageurl2("zx",$b,$row["classid"])."'>".$row["classname"]."</a>";
}
$str=$str."</td>";
	if ($n % $column==0){
	$str=$str. "</tr>";
	}
$n=$n+1;
}
$str=$str."</table>";
return $str;
}
}
}

function showzx($b,$s,$editor,$show){
$str="";
$sql="select content,id,title,img from zzcms_zx where bigclassid=$b ";
if ($s!=0){
$sql=$sql." and smallclassid=$s ";
}
$sql=$sql." and editor ='".$editor."' and passed=1 order by id desc";
$rs=mysql_query($sql);
$row=mysql_num_rows($rs);
//echo $sql;
if ($row){
while ($row=mysql_fetch_array($rs)){
	if ($show==1){
	$str=$str ." <li><a href='".getpageurl("zx",$row["id"])."' target='_blank'><table border='0' cellpadding='5' cellspacing='1' class='bgcolor2' height='140' width='140'><tr><td bgcolor='#ffffff' align='center'><img src='".getsmallimg($row["img"])."'></td></tr></table>".cutstr($row["title"],9)."</a></li>";
	}elseif($show==2){
	$str=$str . $row["content"];
	}elseif($show==3){
	$str=$str ." <li><a href='".getpageurl("zx",$row["id"])."' target='_blank'>".$row["title"]."</a></li>";
	}
}
}else{
$str="暂无信息";
}
return $str;
}
?>