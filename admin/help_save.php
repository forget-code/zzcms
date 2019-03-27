<?php
include("admin.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php
checkadminisdo("helps");
$b=trim($_POST["b"]);
$title=trim($_POST["title"]);
$content=stripfxg(rtrim($_POST["content"]));
$img=getimgincontent($content);
if (isset($_POST["elite"])){
$elite=$_POST["elite"];
}else{
$elite=0;
}
if ($_REQUEST["action"]=="add"){
	mysql_query("INSERT INTO zzcms_help (classid,title,content,img,elite,sendtime)VALUES('$b','$title','$content','$img','$elite','".date('Y-m-d H:i:s')."')");
	}elseif ($_REQUEST["action"]=="modify"){
	$id=trim($_POST["id"]);
	mysql_query("update zzcms_help set classid='$b',title='$title',content='$content',img='$img',elite='$elite',sendtime='".date('Y-m-d H:i:s')."' where id='$id' ");
}
mysql_close($conn);
echo "<script>location.href='help_manage.php?b=".$b."&page=".@$_POST["page"]."'</script>";
?>
</body>
</html>	