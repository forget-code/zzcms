<?php
function bigclass($b){
$str="";
$n=1;
$sql="select classname,classid from zzcms_jobclass where parentid='0' order by xuhao";
$rs=mysql_query($sql);
$row=mysql_num_rows($rs);
if (!$row){
$str="暂无分类";
}else{

while ($row=mysql_fetch_array($rs)){
if($row['classid']==$b){$str=$str."<li class='current'>";}else{$str=$str."<li>";}
	$str=$str."<a href='".getpageurl2("job",$row["classid"],"")."'>".$row["classname"]."</a>";
	$str=$str."</li>";
$n=$n+1;		
}
}
return $str;
}


function showjobsmallclass($b,$s,$column,$num){
$str="";
$n=1;
if ($num<>""){
$sql="select classname,classid from zzcms_jobclass where parentid='". $b ."' order by xuhao limit 0,$num";
}else{
$sql="select classname,classid from zzcms_jobclass where parentid='". $b ."' order by xuhao";
}
$rs=mysql_query($sql);
$row=mysql_num_rows($rs);
if (!$row){
$str="暂无分类";
}else{
while ($row=mysql_fetch_array($rs)){
	$str=$str."<li>";
	if($row['classid']==$s){
	$str=$str. "<a href='".getpageurl2("job",$b,$row["classid"])."' class='current'>".$row["classname"]."</a>";	
	}else{
	$str=$str. "<a href='".getpageurl2("job",$b,$row["classid"])."'>".$row["classname"]."</a>";	
	}
	$str=$str."</li>";
$n=$n+1;		
}
}
return $str;
}

function showjob($num,$strnum,$editor){
$str="";
$sql="select jobname,id from zzcms_job where editor ='".$editor."' and passed=1 order by id desc";
$sql=$sql." limit 0,$num";
$rs=mysql_query($sql);
$row=mysql_num_rows($rs);
if ($row){
while ($row=mysql_fetch_array($rs)){
$str=$str ." <li><a href='".getpageurl("job",$row["id"])."' target='_blank'>".cutstr($row["jobname"],$strnum)."</a></li>";
}
}else{
$str="暂无信息";
}
return $str;
}
?>