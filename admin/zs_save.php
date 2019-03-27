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
$cpid=trim($_POST["cpid"]);
$bigclassid=trim($_POST["bigclassid"]);

if (zsclass_isradio=='Yes'){
$smallclassid=@trim($_POST["smallclassid"][0]);//加[]可同多选共用同一个JS判断函数uncheckall,加@有不加小类的情况
}else{
$smallclassid="";
	if(!empty($_POST['smallclassid'])){
    for($i=0; $i<count($_POST['smallclassid']);$i++){
    $smallclassid=$smallclassid.('"'.$_POST['smallclassid'][$i].'"'.',');
	//$smallclassid=$smallclassid.($_POST['smallclassid'][$i].',');
    }
	$smallclassid=substr($smallclassid,0,strlen($smallclassid)-1);//去除最后面的","
	}
}

$shuxing = isset($_POST['shuxing'])?$_POST['shuxing']:'0'; 
$szm = isset($_POST['szm'])?$_POST['szm']:'';
$cpname=trim($_POST["cpname"]);
$prouse=trim($_POST["prouse"]);
$gg=trim($_POST["gg"]);
$lsj=trim($_POST["lsj"]);
$sm=str_replace("'","",stripfxg(trim($_POST["sm"])));
$img1=trim($_POST["img1"]);
$img2=trim($_POST["img2"]);
$img3=trim($_POST["img3"]);
$flv=trim($_POST["flv"]);
$zc=trim($_POST["zc"]);
$yq=trim($_POST["yq"]);
$sendtime=$_POST["sendtime"];
$editor=trim($_POST["editor"]);
$oldeditor=trim($_POST["oldeditor"]);
$tag=trim($_POST["tag"]);

if(!empty($_POST['passed'])){
$passed=$_POST['passed'][0];
}else{
$passed=0;
}
if(!empty($_POST['elite'])){
$elite=$_POST['elite'][0];
}else{
$elite=0;
}

$title=@$_POST["title"];
if ($title==""){$title=$cp_name;}
$keyword=@$_POST["keyword"];
if ($keyword==""){$keyword=$cp_name;}
$discription=@$_POST["discription"];
if ($discription==""){$discription=$cp_name;}

$elitestarttime=trim($_POST["elitestarttime"]);
if ($elitestarttime=="") {
$elitestarttime=date('Y-m-d H:i:s');
}
$eliteendtime=trim($_POST["eliteendtime"]);
if ($eliteendtime=="") {
$eliteendtime=date('Y-m-d H:i:s',time()+365*3600*24);
}

mysql_query("update zzcms_main set bigclasszm='$bigclassid',smallclasszm='$smallclassid',shuxing='$shuxing',szm='$szm',prouse='$prouse',proname='$cpname',gg='$gg',pricels='$lsj',sm='$sm',img='$img1',img2='$img2',img3='$img3',flv='$flv',zc='$zc',yq='$yq',title='$title',keywords='$keyword',description='$discription',sendtime='$sendtime',tag='$tag' where id='$cpid'");
if ($editor<>$oldeditor) {
$rs=mysql_query("select groupid,qq,comane,id,renzheng from zzcms_user where username='".$editor."'");
$row = mysql_num_rows($rs);
if ($row){
$row = mysql_fetch_array($rs);
$groupid=$row["groupid"];
$userid=$row["id"];
$qq=$row["qq"];
$comane=$row["comane"];
$renzheng=$row["renzheng"];
}else{
$groupid=0;
$userid=0;
$qq="";
$comane="";
$renzheng=0;
}
mysql_query("update zzcms_main set editor='$editor',userid='$userid',groupid='$groupid',qq='$qq',comane='$comane',renzheng='$renzheng' where id='$cpid'");
}
mysql_query("update zzcms_main set passed='$passed',elite='$elite',elitestarttime='$elitestarttime',eliteendtime='$eliteendtime' where id='$cpid'");
mysql_close($conn);
echo "<script>location.href='zs_manage.php?keyword=".$_POST["editor"]."&page=".$_REQUEST["page"]."'</script>";
?>
</body>
</html>