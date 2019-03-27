<?php
include("../inc/conn.php");
if(isset($_REQUEST['cpid'])){
$cpid=$_REQUEST['cpid'];
checkid($cpid);
}else{
$cpid=0;
}

$rs=mysql_query("select * from zzcms_job where id='$cpid'");
$row=mysql_num_rows($rs);
if(!$row){
showmsg('无记录');
}else{
mysql_query("update zzcms_job set hit=hit+1 where id='$cpid'");
$row=mysql_fetch_array($rs);
$editorinzsshow=$row["editor"];//供传值到top.php
$jobname=$row['jobname'];
$province=$row['province'];
$city=$row['city'];
$sendtime=$row["sendtime"];
$hit=$row["hit"];
$sm=$row["sm"];

include("top.php");
include("bottom.php");
include("left.php");

$fp="../skin/".$skin."/jobshow.htm";
if (file_exists($fp)==false){
WriteErrMsg($fp.'模板文件不存在');
exit;
}
$f = fopen($fp,'r');
$strout = fread($f,filesize($fp));
fclose($f);

$pagetitle=$comane.jobshowtitle.$jobname;
$pagekeywords=$comane.jobshowkeyword.$jobname;
$pagedescription=$comane.jobshowdescription.$jobname;

$strout=str_replace("{#jobname}",$jobname,$strout) ;
$strout=str_replace("{#comane}",$comane,$strout) ;
$strout=str_replace("{#hit}",$hit,$strout) ;
$strout=str_replace("{#province}",$province,$strout) ;
$strout=str_replace("{#city}",$city,$strout) ;
$strout=str_replace("{#sendtime}",$sendtime,$strout) ;
$strout=str_replace("{#email}",$email,$strout) ;
$strout=str_replace("{#sm}",nl2br($sm),$strout) ;

$strout=str_replace("{#siteskin}",siteskin,$strout) ;
$strout=str_replace("{#sitename}",sitename,$strout) ;
$strout=str_replace("{#siteurl}",siteurl,$strout);
$strout=str_replace("{#pagetitle}",$pagetitle,$strout);
$strout=str_replace("{#pagekeywords}",$pagekeywords,$strout);
$strout=str_replace("{#pagedescription}",$pagedescription,$strout);
$strout=str_replace("{#ztleft}",$siteleft,$strout);
$strout=str_replace("{#showdaohang}",$showdaohang,$strout);
$strout=str_replace("{#skin}",$skin,$strout);

$strout=str_replace("{#sitebottom}",$sitebottom,$strout);
$strout=str_replace("{#sitetop}",$sitetop,$strout);
echo  $strout;
}			  
?>