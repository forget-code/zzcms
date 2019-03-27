<?php
if(!isset($_SESSION)){session_start();} 
include("../inc/conn.php");
include("check.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title></title>
<link href="style.css" rel="stylesheet" type="text/css">
<?php
if (check_usergr_power("zs")=="no" && $usersf=='个人'){
showmsg('个人用户没有此权限');
}

if (isset($_REQUEST["page"])){ 
$page=$_REQUEST["page"];
}else{
$page=1;
}
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
$cp_name=$_POST["name"];
$gnzz=$_POST["gnzz"];
$gg=$_POST["gg"];
//$sm=stripfxg(trim($_POST["sm"]));
$sm=str_replace("'","",stripfxg(trim($_POST["sm"])));
$img1=$_POST["img1"];
$img2=$_POST["img2"];
$img3=$_POST["img3"];

$flv=@$_POST["flv"];
$province=$_POST["province"];
$city=$_POST["city"];
$xiancheng=$_POST["cityforadd"];
$lsj=$_POST["lsj"];
$zc=$_POST["zc"];
$yq=$_POST["yq"];
$title=@$_POST["title"];
if ($title==""){$title=$cp_name;}
$keyword=@$_POST["keyword"];
if ($keyword==""){$keyword=$cp_name;}
$discription=@$_POST["discription"];
if ($discription==""){$discription=$cp_name;}
$skin=$_POST["skin"];

$rs=mysql_query("select groupid,qq,comane,id,renzheng from zzcms_user where username='".$username."'");
$row=mysql_fetch_array($rs);
$groupid=$row["groupid"];
$qq=$row["qq"];
$comane=$row["comane"];
$renzheng=$row["renzheng"];
$userid=$row["id"];
if (isset($_POST["ypid"])){
$cpid=$_POST["ypid"];
}else{
$cpid=0;
}

//判断是不是重复信息
if ($_REQUEST["action"]=="add" ){
$sql="select * from zzcms_main where proname='".$cp_name."' and editor='".$username."' ";
$rs=mysql_query($sql);
$row=mysql_num_rows($rs);
if ($row){
showmsg('您已发布过该产品，请不要发布重复的信息！','zsmanage.php');
}
}elseif($_REQUEST["action"]=="modify"){
$sql="select * from zzcms_main where proname='".$cp_name."' and editor='".$username."' and id<>".$cpid." ";
$rs=mysql_query($sql);
$row=mysql_num_rows($rs);
if ($row){
showmsg('您已发布过该产品，请不要发布重复的信息！','zsmanage.php');
}
}

$ranNum=rand(100000,99999);
if ($groupid>1){
$TimeNum=date('Y')+1;
}else{
$TimeNum=date('Y');
}	
$TimeNum=$TimeNum.date("mdHis").$ranNum;
  
if ($_POST["action"]=="add"){
$isok=mysql_query("Insert into zzcms_main(proname,bigclasszm,smallclasszm,shuxing,szm,prouse,gg,pricels,sm,img,img2,img3,flv,province,city,xiancheng,zc,yq,title,keywords,description,sendtime,timefororder,editor,userid,groupid,qq,comane,renzheng,skin) values('$cp_name','$bigclassid','$smallclassid','$shuxing','$szm','$gnzz','$gg','$lsj','$sm','$img1','$img2','$img3','$flv','$province','$city','$xiancheng','$zc','$yq','$title','$keyword','$discription','".date('Y-m-d H:i:s')."','$TimeNum','$username','$userid','$groupid','$qq','$comane','$renzheng','$skin')") ;  
$cpid=mysql_insert_id();		
}elseif ($_POST["action"]=="modify"){
$oldimg1=trim($_POST["oldimg1"]);
$oldimg2=trim($_POST["oldimg2"]);
$oldimg3=trim($_POST["oldimg3"]);
$oldflv=trim($_POST["oldflv"]);

$isok=mysql_query("update zzcms_main set proname='$cp_name',bigclasszm='$bigclassid',smallclasszm='$smallclassid',shuxing='$shuxing',szm='$szm',prouse='$gnzz',gg='$gg',pricels='$lsj',sm='$sm',img='$img1',img2='$img2',img3='$img3',flv='$flv',province='$province',city='$city',xiancheng='$xiancheng',zc='$zc',yq='$yq',title='$title',keywords='$keyword',description='$discription',sendtime='".date('Y-m-d H:i:s')."',timefororder='$TimeNum',editor='$username',userid='$userid',groupid='$groupid',qq='$qq',comane='$comane',renzheng='$renzheng',skin='$skin',passed=0 where id='$cpid'");

	if ($oldimg1<>$img1 && $oldimg1<>"image/nopic.gif") {
	//deloldimg
		$f=$oldimg1;
		if (file_exists($f)){
		unlink($f);		
		}
		$fs=str_replace(".","_small.",$oldimg1);
		if (file_exists($fs)){
		unlink($fs);		
		}
	}
	if ($oldimg2<>$img2 && $oldimg2<>"image/nopic.gif") {
	//deloldimg
		$f=$oldimg2;
		if (file_exists($f)){
		unlink($f);		
		}
		$fs=str_replace(".","_small.",$oldimg2);
		if (file_exists($fs)){
		unlink($fs);		
		}
	}
	if ($oldimg3<>$img3 && $oldimg3<>"image/nopic.gif") {
	//deloldimg
		$f=$oldimg3;
		if (file_exists($f)){
		unlink($f);		
		}
		$fs=str_replace(".","_small.",$oldimg3);
		if (file_exists($fs)){
		unlink($fs);		
		}
	}
	if ($oldflv<>$flv && $oldflv<>""){
	//deloldflv
		$f="../".$oldflv;
		if (file_exists($f)){
		unlink($f);		
		}
	}			
}
$_SESSION['bigclassid']=$bigclassid;
$_SESSION['province']=$province;
$_SESSION['city']=$city;
$_SESSION['xiancheng']=$xiancheng;
$_SESSION['zc']=$zc;
$_SESSION['yq']=$yq;
passed("zzcms_main");		
?>
</head>

<body>
<div class="main">
<?php
include("top.php");
?>
<div class="pagebody">
<div class="left">
<?php
include("left.php");
?>
</div>
<div class="right">
<br><br>
<table width="400" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td class="tstitle"> <?php
	if ($isok) {
      echo "发布成功 ";
	  }else{
	  echo"发布失败";}
     ?>
      </td>
  </tr>
  <tr> 
    <td><table width="100%" border="0" cellspacing="0" cellpadding="3">
        <tr bgcolor="#FFFFFF"> 
          <td width="25%" align="right" bgcolor="#FFFFFF"><strong>名称：</strong></td>
          <td width="75%"><?php echo $cp_name?></td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td align="right" bgcolor="#FFFFFF"><strong>规格：</strong></td>
          <td><?php echo $gg?></td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td align="right" bgcolor="#FFFFFF"><strong><?php echo channelzs?>区域：</strong></td>
          <td><?php echo $province.$city?></td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td><table width="100%" border="0" cellpadding="5" cellspacing="1">
        <tr> 
          <td width="120" align="center" class="border"><a href="zsadd.php">继续添加</a></td>
                <td width="120" align="center" class="border"><a href="zsmodify.php?id=<?php echo $cpid?>">修改</a></td>
                <td width="120" align="center" class="border"><a href="zsmanage.php?page=<?php echo $page?>">返回</a></td>
                <td width="120" align="center" class="border"><a href="<?php echo getpageurl("zs",$cpid)?>" target="_blank">预览</a></td>
        </tr>
      </table></td>
  </tr>
</table>
<?php
session_write_close();
?>
</div>
</div>
</div>
</body>
</html>