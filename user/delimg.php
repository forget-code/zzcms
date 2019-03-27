<?php
include("../inc/conn.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
</head>
<body>
<?php
$id=$_REQUEST['id'];
$sql="select img,img2,img3,flv,editor from zzcms_main where id ='$id'";
$rs=mysql_query($sql);
$row=mysql_fetch_array($rs);
if ($_REQUEST['action']==1){		
			if ($row['img']<>"/image/nopic.gif"){
			$f="../".substr($row['img'],1);
				if (file_exists($f)){
				unlink($f);
				}
			$fs="../".substr(str_replace(".","_small.",$row['img']),1)."";
				if (file_exists($fs)){
				unlink($fs);
				}
			}
mysql_query("update zzcms_main set img='/image/nopic.gif' where id='$id'");					
}

if ($_REQUEST['action']==2){		
			if ($row['img2']<>"/image/nopic.gif"){
			$f="../".substr($row['img2'],1);
				if (file_exists($f)){
				unlink($f);
				}
			$fs="../".substr(str_replace(".","_small.",$row['img2']),1)."";
				if (file_exists($fs)){
				unlink($fs);	
				}
			}
mysql_query("update zzcms_main set img2='/image/nopic.gif' where id='$id'");							
}

if ($_REQUEST['action']==3){		
			if ($row['img3']<>"/image/nopic.gif"){
			$f="../".substr($row['img3'],1);
				if (file_exists($f)){
				unlink($f);
				}
			$fs="../".substr(str_replace(".","_small.",$row['img3']),1)."";
				if (file_exists($fs)){
				unlink($fs);		
				}
			}
mysql_query("update zzcms_main set img3='/image/nopic.gif' where id='$id'");		
}
echo "<script>window.close()</script>";	
?>
</body>
</html>
