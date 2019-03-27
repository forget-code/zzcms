<?php
include("../inc/conn.php");
include("../inc/top.php");
include("../inc/bottom.php");
include("../inc/fy.php");
include("subzs.php");
include("../label.php");
if (isset($_GET["px"])){
$px=$_GET["px"];
	if ($px!='hit' && $px!='id' && $px!='sendtime'){
	$px="sendtime";
	}
setcookie("pxzs",$px,time()+3600*24*360);
}else{
	if (isset($_COOKIE["pxzs"])){
	$px=$_COOKIE["pxzs"];
	}else{
	$px="sendtime";
	}
}
if (isset($_GET["page_size"])){
$page_size=$_GET["page_size"];
setcookie("page_size_zs",$page_size,time()+3600*24*360);
}else{
	if (isset($_COOKIE["page_size_zs"])){
	$page_size=$_COOKIE["page_size_zs"];
	}else{
	$page_size=pagesize_qt;
	}
}

if (isset($_GET["ys"])){
$ys=$_GET["ys"];
setcookie("yszs",$ys,time()+3600*24*360);
}else{
	if (isset($_COOKIE["yszs"])){
	$ys=$_COOKIE["yszs"];
	}else{
	$ys="list";
	}
}
if (isset($_GET['yiju'])){
$yiju=$_GET['yiju'];
}else{
$yiju="Pname";
}

if (isset($_GET['keyword'])){
$keywordNew=nostr(trim($_GET['keyword']));
setcookie("zskeyword",$keywordNew,time()+3600*24);
$keyword=$keywordNew;
}else{
	if (isset($_COOKIE['zskeyword'])){
	$keyword=trim($_COOKIE['zskeyword']);
	}else{
	$keyword='';
	}
}

if (isset($_GET['b'])){
$bNew=$_GET['b'];
setcookie("zsb",$bNew,time()+3600*24);
$b=$bNew;
}else{
	if (isset($_COOKIE['zsb'])){
	$b=$_COOKIE['zsb'];
	}else{
	$b="";
	}
}

if (isset($_GET['s'])){
$sNew=$_GET['s'];
setcookie("zss",$sNew,time()+3600*24);
$s=$sNew;
}else{
	if (isset($_COOKIE['zss'])){
	$s=$_COOKIE['zss'];
	}else{
	$s="";
	}
}
$szm=isset($_GET['szm'])?$_GET['szm']:'';

if (isset($_GET['province'])){
$provinceNew=$_GET['province'];
setcookie("zsprovince",$provinceNew,time()+3600*24);
$province=$provinceNew;
}else{
	if (isset($_COOKIE['zsprovince'])){
	$province=$_COOKIE['zsprovince'];
	}else{
	$province="";
	}
}

if (isset($_GET['p_id'])){
$p_idNew=$_GET['p_id'];
setcookie("zsp_id",$p_idNew,time()+3600*24);
$p_id=$p_idNew;
}else{
	if (isset($_COOKIE['zsp_id'])){
	$p_id=$_COOKIE['zsp_id'];
	}else{
	$p_id="";
	}
}

if (isset($_GET['city'])){
$cityNew=$_GET['city'];
setcookie("zscity",$cityNew,time()+3600*24);
$city=$cityNew;
}else{
	if (isset($_COOKIE['zscity'])){
	$city=$_COOKIE['zscity'];
	}else{
	$city="";
	}
}

if (isset($_GET['c_id'])){
$c_idNew=$_GET['c_id'];
setcookie("zsc_id",$c_idNew,time()+3600*24);
$c_id=$c_idNew;
}else{
	if (isset($_COOKIE['zsc_id'])){
	$c_id=$_COOKIE['zsc_id'];
	}else{
	$c_id="";
	}
}

if (isset($_GET['xiancheng'])){
$xianchengNew=$_GET['xiancheng'];
setcookie("zsxiancheng",$xianchengNew,time()+3600*24);
$xiancheng=$xianchengNew;
}else{
	if (isset($_COOKIE['zsxiancheng'])){
	$xiancheng=$_COOKIE['zsxiancheng'];
	}else{
	$xiancheng="";
	}
}

if (isset($_GET['sj'])){
$sjNew=$_GET['sj'];
setcookie("zssj",$sjNew,time()+3600*24);
$sj=$sjNew;
}else{
	if (isset($_COOKIE['zssj'])){
	$sj=$_COOKIE['zssj'];
	}else{
	$sj='';
	}
}

if ($sj!='') {
checkid($sj);
}
if (isset($_GET['tp'])){
$tpNew=$_GET['tp'];
setcookie("zstp",$tpNew,time()+3600*24);
$tp=$tpNew;
}else{
	if (isset($_COOKIE['zstp'])){
	$tp=$_COOKIE['zstp'];
	}else{
	$tp="";
	}
}

if (isset($_GET['vip'])){
$vipNew=$_GET['vip'];
setcookie("zsvip",$vipNew,time()+3600*24);
$vip=$vipNew;
}else{
	if (isset($_COOKIE['zsvip'])){
	$vip=$_COOKIE['zsvip'];
	}else{
	$vip="";
	}
}
if (isset($_GET['delb'])){
setcookie("zsb","xxx",1);
echo "<script>location.href='search.php'</script>";
}
if (isset($_GET['dels'])){
setcookie("zss","xxx",1);
echo "<script>location.href='search.php'</script>";
}
if (isset($_GET['delprovince'])){
setcookie("zsprovince","xxx",1);
setcookie("zscity","xxx",1);
setcookie("zsp_id","xxx",1);
setcookie("zsc_id","xxx",1);
setcookie("zsxiancheng","xxx",1);
echo "<script>location.href='search.php'</script>";
}
if (isset($_GET['delcity'])){
setcookie("zscity","xxx",1);
setcookie("zsc_id","xxx",1);
setcookie("zsxiancheng","xxx",1);
echo "<script>location.href='search.php'</script>";
}

if (isset($_GET['delxiancheng'])){
setcookie("zsxiancheng","xxx",1);
echo "<script>location.href='search.php'</script>";
}

if (isset($_GET['delsj'])){
setcookie("zssj","xxx",1);
echo "<script>location.href='search.php'</script>";
}
if (isset($_GET['deltp'])){
setcookie("zstp","xxx",1);
echo "<script>location.href='search.php'</script>";
}
if (isset($_GET['delvip'])){
setcookie("zsvip","xxx",1);
echo "<script>location.href='search.php'</script>";
}

$pagetitle="搜索".channelzs."信息-".sitename;
$pagekeyword="搜索".channelzs."信息-".sitename;
$pagedescription="搜索".channelzs."信息-".sitename;

$bigclassname="";
if ($b<>""){
$sql="select * from zzcms_zsclass where classzm='".$b."'";
$rs=mysql_query($sql);
$row=mysql_fetch_array($rs);
if ($row){
$bigclassname=$row["classname"];
}
}

$smallclassname="";
if ($s<>"") {
$sql="select * from zzcms_zsclass where classzm='".$s."'";
$rs=mysql_query($sql);
$row=mysql_fetch_array($rs);
if ($row){
	$smallclassname=$row["classname"];
}
}

if( isset($_GET["page"]) && $_GET["page"]!="") 
{
    $page=$_GET['page'];
	checkid($page);
}else{
    $page=1;
}

		function formbigclass(){
		$str="";
        $sql = "select * from zzcms_zsclass where parentid='A'";
        $rs=mysql_query($sql);
		$row=mysql_num_rows($rs);
		if (!$row){
		$str= "请先添加类别名称。";
		}else{
			while($row=mysql_fetch_array($rs)){
			$str=$str. "<a href=?b=".$row["classzm"].">".$row["classname"]."</a>&nbsp;&nbsp;";
			}
		}
		return $str;
		}
		
		function formsmallclass($b){
		$str="";
        $sql="select * from zzcms_zsclass where parentid='" .$b. "' order by xuhao asc";
        $rs=mysql_query($sql);
		$row=mysql_num_rows($rs);
		if ($row){
			while($row=mysql_fetch_array($rs)){
			$str=$str. "<a href=?s=".$row["classzm"].">".$row["classname"]."</a>&nbsp;&nbsp;";
			}
		}	
		return $str;
		}	
		
	function formprovince(){
		$str="";
		global $citys;
		$city=explode("#",$citys);
		$c=count($city);//循环之前取值
	for ($i=0;$i<$c;$i++){ 
		$location_p=explode("*",$city[$i]);//取数组的第一个就是省份名，也就是*左边的
		$str=$str . "<a href=?province=".$location_p[0]."&p_id=".$i.">".$location_p[0]."</a>&nbsp;&nbsp;";
	}
	return $str;
	}	
		
	function formcity(){
	global $citys,$p_id;
	$str="";
	if ($p_id<>"") {
	$city=explode("#",$citys);
	$location_cs=explode("*",$city[$p_id]);//取指定省份下的
	$location_cs2=explode("|",$location_cs[1]);//要*右边的市和县
	$c=count($location_cs2);//循环之前取值
		for ($i=0;$i<$c;$i++){ 
		$location_cs3=explode(",",$location_cs2[$i]);//取指定省份下的
		$str=$str . "<a href=?city=".$location_cs3[0]."&c_id=".$i.">".$location_cs3[0]."</a>&nbsp;&nbsp;";
		}
	}else{
	$city="";
	}
	return $str;
}

function formxiancheng(){
	global $citys,$p_id,$c_id;
	$str="";
	if ($p_id<>"" && $c_id<>"") {
	$city=explode("#",$citys);
	$location_cs=explode("*",$city[$p_id]);//取指定省份下的
	$location_cs2=explode("|",$location_cs[1]);//要*右边的市和县
	$location_cs3=explode(",",$location_cs2[$c_id]);//取指定市和县下的
	$c=count($location_cs3);//循环之前取值
		for ($i=1;$i<$c;$i++){ //从1开始，0对应的是，前面的市名，市名不要，这里只显示县名。
		$str=$str . "<a href=?xiancheng=".$location_cs3[$i].">".$location_cs3[$i]."</a>&nbsp;&nbsp;";
		}
	}else{
	$xiancheng="";
	}
	return $str;
}
		
		if ($b<>"" || $s<>"" || $province<>"" || $city<>"" || $xiancheng<>"" || $sj<>"" || $tp<>"" || $vip<>"") {
		$selected="<tr>";
		$selected=$selected."<td align='right'>已选条件：</td>";
		$selected=$selected."<td class='a_selected'>";
			if ($b<>"") {
			$selected=$selected."<a href='?delb=Yes' title='删除已选'>".$bigclassname."×</a>&nbsp;";
			}
			
			if ($s<>""){
			$selected=$selected."<a href='?dels=Yes' title='删除已选'>".$smallclassname."×</a>&nbsp;";
			}
		
			if ($province<>""){
			$selected=$selected."<a href='?delprovince=Yes' title='删除已选'>".$province."×</a>&nbsp;";
			}
		
			if ($city<>""){
			$selected=$selected."<a href='?delcity=Yes' title='删除已选'>".$city."×</a>&nbsp;";
			}
			
			if ($xiancheng<>""){
			$selected=$selected."<a href='?delxiancheng=Yes' title='删除已选'>".$xiancheng."×</a>&nbsp;";
			}
			
			if ($sj<>"") {
			$selected=$selected."<a href='?delsj=Yes' title='删除已选'>".$sj."天内的×</a>&nbsp;";
			}
			
			if ($tp<>"") {
			$selected=$selected."<a href='?deltp=Yes' title='删除已选'>有图片的×</a>&nbsp;";
			}
			
			if ($vip<>""){
			$selected=$selected."<a href='?delvip=Yes' title='删除已选'>vip会员的×</a>&nbsp;";
			}
		$selected=$selected."</td>";
		$selected=$selected."</tr>";
		}else{
		$selected="";
		}

$fp="../template/".$siteskin."/zs_search.htm";
$f = fopen($fp,'r');
$strout = fread($f,filesize($fp));
fclose($f);

$sql="select count(*) as total from zzcms_main where passed<>0 ";	
$sql2='';
	switch ($yiju){
	case "Pname";
	$sql2=$sql2. " and (proname like '%".$keyword."%' ";//加括号,否则后面的条件无效
	
	//$sql2=$sql2 . " or tag = '".$keyword."' ";
	$sql2=$sql2 . " or tag like '%".$keyword."%' ";//用like当管理后台设多个tag词时用=不行
	//以下是配产品关键字
	//for ($ik=0;$ik<strlen($keyword)/3;$ik++){//汉字在这里占三个字符
	//$sql2=$sql2 . " or tag like '%".mb_substr($keyword,$ik,1,'utf-8')."%' ";
	//}
	$sql2=$sql2. ")";
	//echo  $sql;
	break;
	case "Pcompany";
	$sql2=$sql2."and comane like '%".$keyword."%' " ;
	//strwhere=" editor in (select username from zzcms_user where comane like '%"&keyword&"%') " 
	break;
	}
	
if ($b<>""){
$sql2=$sql2."and bigclasszm='".$b."' ";
}

if ($s<>"") {
	if (zsclass_isradio=='Yes'){
	$sql2=$sql2." and smallclasszm ='".$s."'  ";
	}else{
	$sql2=$sql2." and smallclasszm like '%".$s."%' ";
	}
}

if ($szm<>"") {
$sql2=$sql2." and szm ='$szm' ";
}

if ($xiancheng<>"") {
$sql2=$sql2."and xiancheng like '".$xiancheng."%' ";
}elseif ($city<>"") {
$sql2=$sql2."and city like '".$city."%' ";
}elseif ($province<>"") {
$sql2=$sql2."and province like '".$province."%' ";
}

if ($sj<>''){
$sql2=$sql2." and  timestampdiff(day,sendtime,now()) <= ". $sj ." " ;
}

if ($tp=="yes" ){
$sql2=$sql2."and img<>'image/nopic.gif' ";
}

if ($vip=="yes") {
$sql2=$sql2." and editor in (select username from zzcms_user where groupid>1)";
}
$rs = mysql_query($sql.$sql2);
$row = mysql_fetch_array($rs);
$totlenum = $row['total'];
$offset=($page-1)*$page_size;//$page_size在上面被设为COOKIESS 
$totlepage=ceil($totlenum/$page_size);

$sql="select id,proname,prouse,pricels,gg,img,province,city,xiancheng,sendtime,editor,elite,userid,comane,qq,groupid,renzheng,tag from zzcms_main where passed=1 ";
$sql=$sql.$sql2;
$sql=$sql." order by groupid desc,elite desc,".$px." desc limit $offset,$page_size";
$rs = mysql_query($sql); 

$zs=strbetween($strout,"{zs}","{/zs}");
$list_list=strbetween($strout,"{loop_list}","{/loop_list}");
$list_window=strbetween($strout,"{loop_window}","{/loop_window}");

if(!$totlenum){
$strout=str_replace("{zs}".$zs."{/zs}","暂无信息",$strout) ;
}else{
$strout=str_replace("{#totlenum}",$totlenum,$strout) ;
$i=0;
$list2='';
	while($row= mysql_fetch_array($rs)){
	if ($ys=="window"){
	$list2 = $list2. str_replace("{#id}",$row["id"],$list_window) ;
	}else{
	$list2 = $list2. str_replace("{#id}",$row["id"],$list_list) ;
	}
	$list2 =str_replace("{#i}" ,$i,$list2) ;
	$list2 =str_replace("{#url}" ,getpageurl("zs",$row["id"]),$list2) ;
	$proname_num=strbetween($list2,"{#proname:","}");//两种情况，window,list
	$list2 =str_replace("{#proname:".$proname_num."}",cutstr($row["proname"],$proname_num),$list2) ;
	$list2 =str_replace("{#img}" ,getsmallimg($row["img"]),$list2) ;
	$list2 =str_replace("{#imgbig}" ,$row["img"],$list2) ;
	$list2 =str_replace("{#comane}" ,$row["comane"],$list2) ;
	$list2 =str_replace("{#province}" ,$row["province"],$list2) ;
	$list2 =str_replace("{#city}" ,$row["city"],$list2) ;
	$list2 =str_replace("{#xiancheng}" ,$row["xiancheng"],$list2) ;
	$list2 =str_replace("{#groupid}" ,$row["groupid"],$list2) ;
	$list2 =str_replace("{#userid}" ,$row["userid"],$list2) ;
	$list2 =str_replace("{#zturl}",getpageurlzt($row["editor"],$row["userid"]),$list2) ;//展厅地址
	
	if ($row["renzheng"]==1) {
	$list2 =str_replace("{#renzheng}" ,"<img src='/image/ico_renzheng.png' alt='认证会员'>",$list2) ;
	}else{
	$list2 =str_replace("{#renzheng}" ,"",$list2) ;
	}
	
	if ($row["elite"]==1) { 
	$list2 =str_replace("{#elite}" ,"<img src='/image/ico_jian.png' alt='tag:".$row["elite"]."' >",$list2) ;
	}else{
	$list2 =str_replace("{#elite}" ,"",$list2) ;
	}
	
	if ($row["qq"]!=''){
	$showqq="<a target=blank href=http://wpa.qq.com/msgrd?v=1&uin=".$row["qq"]."&Site=".sitename."&MMenu=yes><img border='0' src='http://wpa.qq.com/pa?p=1:".$row["qq"].":10' alt='QQ交流'></a> ";
	$list2 =str_replace("{#qq}",$showqq,$list2) ;
	}else{
	$list2 =str_replace("{#qq}","",$list2) ;
	}	
	
	$list2 =str_replace("{#gg}" ,$row["gg"],$list2) ;
	$list2 =str_replace("{#prouse}" ,cutstr($row["prouse"],20),$list2) ;
	$list2 =str_replace("{#pricels}" ,$row["pricels"],$list2) ;
	$list2 =str_replace("{#sendtime}" ,$row["sendtime"],$list2) ;

	$rsn=mysql_query("select grouppic,groupname from zzcms_usergroup where groupid=".$row["groupid"]."");
	$rown=mysql_fetch_array($rsn);
	if ($rown){
	$list2 =str_replace("{#grouppic}" ,"<img src=".$rown["grouppic"]." alt=".$rown["groupname"].">",$list2) ;
	}
	
	if (showdlinzs=="Yes") {
	$rsn=mysql_query("select id from zzcms_dl where cpid=".$row["id"]." and passed=1");
	$list2 =str_replace("{#dl_num}","(".channeldl."留言<font color='#FF6600'><b>".mysql_num_rows($rsn)."</b></font>条)",$list2) ;
	}else{
	$list2 =str_replace("{#dl_num}","",$list2) ;
	}
	
	$i=$i+1;
	}
if ($ys=="window"){	
$strout=str_replace("{loop_window}".$list_window."{/loop_window}",$list2,$strout) ;
$strout=str_replace("{loop_list}".$list_list."{/loop_list}","",$strout) ;
}else{
$strout=str_replace("{loop_list}".$list_list."{/loop_list}",$list2,$strout) ;
$strout=str_replace("{loop_window}".$list_window."{/loop_window}","",$strout) ;
}
$strout=str_replace("{#fenyei}",showpage1(),$strout) ;
$strout=str_replace("{zs}","",$strout) ;
$strout=str_replace("{/zs}","",$strout) ;
}

$strout=str_replace("{#siteskin}",$siteskin,$strout) ;
$strout=str_replace("{#sitename}",sitename,$strout) ;
$strout=str_replace("{#siteurl}",siteurl,$strout) ;
$strout=str_replace("{#station}",getstation(0,"",0,"","",$keyword,"zs"),$strout) ;
$strout=str_replace("{#pagetitle}",$pagetitle,$strout);
$strout=str_replace("{#pagekeywords}",$pagekeyword,$strout);
$strout=str_replace("{#pagedescription}",$pagedescription,$strout);
if ($b=="") {//当小类为空显示大类，否则只显小类
$strout=str_replace("{#formbigclass}",formbigclass(),$strout);
}else{
$strout=str_replace("{#formbigclass}","",$strout);
}
$strout=str_replace("{#formsmallclass}",formsmallclass($b),$strout);
if ($province=="") {
$strout=str_replace("{#formprovince}",formprovince(),$strout);
}else{
$strout=str_replace("{#formprovince}","",$strout);
}
if ($city=="") {
$strout=str_replace("{#formcity}",formcity(),$strout);
}else{
$strout=str_replace("{#formcity}","",$strout);
}

if ($yiju=="Pname") {
$strout=str_replace("{#Pname}","checked",$strout);
$strout=str_replace("{#Pcompany}","",$strout);
}else{
$strout=str_replace("{#Pcompany}","checked",$strout);
$strout=str_replace("{#Pname}","",$strout);
}
$strout=str_replace("{#formxiancheng}",formxiancheng(),$strout);
$strout=str_replace("{#selected}",$selected,$strout);
$strout=str_replace("{#formkeyword}",$keyword,$strout);
$strout=str_replace("{#keyword}",cutstr($keyword,5),$strout);
$strout=str_replace("{#showzsforsearch}",showzsforsearch(10,10,"id",$b,false,$keyword),$strout);
$strout=str_replace("{#showzsorder}",showzsorder($b,$sj,10,10,$keyword),$strout);
$strout=str_replace("{#sitebottom}",sitebottom(),$strout);
$strout=str_replace("{#sitetop}",sitetop(),$strout);
$strout=str_replace("{#searchbyszm}",szm(),$strout);
$strout=showlabel($strout);
mysql_close($conn);
echo  $strout;				
?>