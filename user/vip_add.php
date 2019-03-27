<?php
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
$ErrMsg="";
$FoundErr=0;
if (isset($_REQUEST["action"])){
$action=$_REQUEST["action"];
}else{
$action="";
}
if (isset($_POST["canshu"])){
$groupid=$_POST["canshu"];//由VIPUSER.php传来的值
checkid($groupid);
}else{
$groupid=2;
}
//groupid=$_POST("groupid");

if ($action=="modify"){
	$sj=trim($_POST["sj"]);
	$startdate=date('Y-m-d');
	if ($sj<>""){
	checkid($sj);
	}
	$enddate=date('Y-m-d',time()+60*60*24*365);
		
    $rs=mysql_query("Select RMB from zzcms_usergroup where groupid='$groupid'");
	$row=mysql_fetch_array($rs);
	$totleRMB=$sj*$row["RMB"];
	
	$rs=mysql_query("select * from zzcms_user where username='" . $username ."'");
	$row=mysql_num_rows($rs);
	if (!$row){
		$FoundErr=1;
		$ErrMsg=$ErrMsg. "<li>找不到指定的用户！</li>";
		WriteErrMsg($ErrMsg);
	}else{
	$row=mysql_fetch_array($rs);
		if ($row["groupid"]>=$groupid){
			$FoundErr=1;
			$ErrMsg=$ErrMsg . "<li>只能升级到上一级用户组</li>";
			WriteErrMsg($ErrMsg);
		}else{
			if ($row["totleRMB"]<$totleRMB){
			$FoundErr=1;
			$ErrMsg=$ErrMsg . "<li>您的余额不足，请先<a href='/3/alipay'>充值</a>！</li>";
			WriteErrMsg($ErrMsg);
			}else{
			mysql_query("update zzcms_user set groupid='$groupid',startdate='$startdate',enddate='$enddate',totleRMB=totleRMB-".$totleRMB." where username='" . $username ."'");			
			mysql_query("Update zzcms_main set groupid=" . $groupid . " where editor='" . $username . "'");
			mysql_query("insert into zzcms_pay (username,dowhat,RMB,mark,sendtime)values('$username','会员升级费用','$totleRMB','服务时间：".$startdate."至".$enddate."','".date('Y-m-d H:i:s')."')");
			echo "<script>alert('升级成功');location.href='vip_add.php'</script>";
			}
		}
	}	
}else{		
				
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
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="admintitle">会员升级</td>
  </tr>
</table>
<FORM name="myform" action="?action=modify" method="post">
<TABLE cellSpacing="0" cellPadding="0" width="100%" border="0">
        <TBODY>
          <tr> 
              <td>
<table width="100%" border="0" cellpadding="3" cellspacing="1">
            <tr> 
              <td width="15%" align="right" class="border">用户名：</td>
              <td width="85%" class="border"><?php echo $username?></td>
            </tr>
            <tr> 
              <td align="right" class="border2">你当前所属用户组：</td>
                    <td class="border2"> 
                      <?php
$rs=mysql_query("Select groupname from zzcms_usergroup where groupid=(select groupid from zzcms_user where username='".$username."')");
$row=mysql_fetch_array($rs);
echo $row["groupname"];
?>
                      <a href="/one/vipuser.php" target="_blank"><strong>(查看我的权限) 
                      </strong></a></td>
            </tr>
            <tr> 
              <td align="right" class="border2">请选择会员类型：</td>
              <td width="85%" class="border2"> <select name="canshu">
                  <?php
				
     $rs=mysql_query("Select * from zzcms_usergroup ");
	 $row=mysql_num_rows($rs);
     if ($row){
	 while($row=mysql_fetch_array($rs)){
	 ?>
      <option value="<?php echo $row["groupid"]?>" <?php if ($row["groupid"]==$groupid){ echo "selected";}?>><?php echo $row["groupname"]?>(<?php echo $row["RMB"]?>元/年)</option>
    <?php
	}
	}
			?>
                </select>
              </td>
            </tr>
            <tr> 
              <td align="right" class="border">会员期限：</td>
              <td class="border"><select name="sj" id="sj">
                  <option value="1" selected>一年</option>
                  <option value="2">二年</option>
                  <option value="3">三年</option>
                  <option value="5">五年</option>
                </select> </td>
            </tr>
            <tr > 
              <td align="right" class="border2">&nbsp;</td>
              <td class="border2"> <input name="Submit2"   type="submit" class="buttons" id="Submit2" value="保存"></td>
            </tr>
          </TABLE></td>
            
          </tr>
        </TBODY>
      </TABLE>  
  </form>
</div>
</div>
</div> 
</body>
</html>
<?php
}
mysql_close($conn);
?>