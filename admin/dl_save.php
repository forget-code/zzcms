<?php
include ("admin.php");
?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php
checkadminisdo("dl");
if (isset($_POST["page"])){
$page=$_POST["page"];
}else{
$page=1;
}
if (isset($_POST["dlid"])){
$id=$_POST["dlid"];
}else{
$id=0;
}
$classid=$_POST["classid"];
$cp=$_POST["cp"];
$province=$_POST["province"];
$city=$_POST["cityforadd"];
$content=$_POST["content"];
$dlsf=$_POST["dlsf"];
if (isset($_POST["companyname"])){
$companyname=$_POST["companyname"];
}else{
$companyname="";
}
if ($dlsf=="个人" ){
$companyname="";
}
$truename=$_POST["truename"];
$tel=$_POST["tel"];
$email=$_POST["email"];
$address=$_POST["address"];
if(!empty($_POST['passed'])){
$passed=$_POST['passed'][0];
}else{
$passed=0;
}
if ($_POST["action"]=="add"){
if ($cp<>'' && $truename<>'' && $tel<>''){
$addok=mysql_query("Insert into zzcms_dl(classzm,cpid,cp,province,city,content,company,companyname,dlsname,tel,address,email,sendtime) values('$classid',0,'$cp','$province','$city','$content','$dlsf','$companyname','$truename','$tel','$address','$email','".date('Y-m-d H:i:s')."')") ; 
$dlid=mysql_insert_id();

mysql_query("Insert into zzcms_dl_".$classid."(dlid,cpid,cp,province,city,content,company,companyname,dlsname,tel,address,email,sendtime) values('$dlid',0,'$cp','$province','$city','$content','$dlsf','$companyname','$truename','$tel','$address','$email','".date('Y-m-d H:i:s')."')") ;   
}
}elseif ($_POST["action"]=="modify"){

$oldprovince=trim($_POST["oldprovince"]);
if ($province=='请选择省份'){
$province=$oldprovince;
}
$addok=mysql_query("update zzcms_dl set classzm='$classid',cp='$cp',province='$province',city='$city',content='$content',company='$dlsf',companyname='$companyname',dlsname='$truename',tel='$tel',address='$address',email='$email',sendtime='".date('Y-m-d H:i:s')."',passed='$passed' where id='$id'");

mysql_query("update `zzcms_dl_".$classid."` set cp='$cp',province='$province',city='$city',content='$content',company='$dlsf',companyname='$companyname',dlsname='$truename',tel='$tel',address='$address',email='$email',sendtime='".date('Y-m-d H:i:s')."',passed='$passed' where dlid='$id'");

}
if ($addok){
echo "<script>location.href='dl_manage.php?page=".$_REQUEST["page"]."'</script>";
}		
?>
</body>
</html>