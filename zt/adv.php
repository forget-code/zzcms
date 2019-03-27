<?php
function adv($editor,$classname){
$str='';
$sql="select title,link,img from zzcms_ztad where editor='".$editor."' and passed=1 and classname='".$classname."'";
$rs=mysql_query($sql);
$row=mysql_num_rows($rs);
if ($row){
while($row = mysql_fetch_array($rs)){
$str=$str."<li><div><a href=".$row['link']."><img src=".$row['img']." alt=".$row['title']." /></a></div>";
$str=$str."<div>".$row['title']."</div>";
$str=$str."</li>";
}
}
return $str;
}
?>