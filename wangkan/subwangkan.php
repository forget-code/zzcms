<?php
function bigclass($b){
$str="";
$n=1;
$sql="select bigclassname,bigclassid from zzcms_wangkanclass  order by xuhao";
$rs=mysql_query($sql);
$row=mysql_num_rows($rs);
if (!$row){
$str="暂无分类";
}else{

while ($row=mysql_fetch_array($rs)){
$str=$str."<li>";
	if($row['bigclassid']==$b){
	$str=$str."<a href='".getpageurl2("wangkan",$row["bigclassid"],"")."' class='current'>".$row["bigclassname"]."</a>";
	}else{
	$str=$str."<a href='".getpageurl2("wangkan",$row["bigclassid"],"")."'>".$row["bigclassname"]."</a>";
	}
	$str=$str."</li>";
$n=$n+1;		
}
}
return $str;
}		
?>