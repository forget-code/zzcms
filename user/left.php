<script type="text/javascript">
<!--
function disp(n){
for (var i=0;i<9;i++){
	if (!document.getElementById("left"+i)) return;			
		document.getElementById("left"+i).style.display="none";
	}
	document.getElementById("left"+n).style.display="";
}

function Confirmdeluser(){
   if(confirm("注销后将不能恢复！确定要注销帐户么？"))
     return true;
   else
     return false;	 
}	
//-->
</script>
<div id="left0" style="display:block" class="left_color" ></div>
<div id="left1" style="display:block" class="left_color2"> 
<div class="lefttitle"><img src="image/ico/ico4.gif" border=0>  发布信息</div>
<div class="leftcontent">
<ul>

<?php
if (check_usergr_power('zs')=='yes'|| $usersf=='公司'){?>
<li><a href="zsadd.php" target="_self"> 发<?php echo channelzs?></a> | <a href="zsmanage.php" target="_self"> 管理</a></li> 
<?php 
}
if (check_usergr_power('pp')=='yes'|| $usersf=='公司'){
?>
<li><a href="ppadd.php" target="_self"> 发品牌</a> | <a href="ppmanage.php" target="_self">管理</a></li> 
<?php 
}
if (check_usergr_power('dl')=='yes'|| $usersf=='公司'){
?>
<li><a href="dladd.php" target="_self"> 发<?php echo channeldl?></a> | <a href="dlmanage.php" target="_self"> 管理</a></li>
<?php 
}
if (check_usergr_power('zh')=='yes'|| $usersf=='公司'){
?>
<li><a href="zhadd.php" target="_self"> 发展会</a> | <a href="zhmanage.php" target="_self"> 管理</a></li>
<?php 
}
if (check_usergr_power('zx')=='yes'|| $usersf=='公司'){
?>
<li><a href="zxadd.php" target="_self"> 发资讯</a> | <a href="zxmanage.php" target="_self"> 管理</a></li>
<?php 
}
if (check_usergr_power('special')=='yes'|| $usersf=='公司'){
?>
<li><a href="specialadd.php" target="_self"> 发专题</a> | <a href="specialmanage.php" target="_self"> 管理</a></li>
<?php 
}
if (check_usergr_power('job')=='yes'|| $usersf=='公司'){
?>
<li><a href="jobadd.php" target="_self"> 发招聘</a> | <a href="jobmanage.php" target="_self"> 管理</a></li>
<?php 
}
if (check_usergr_power('zx')=='yes'|| $usersf=='公司'){
?>
<li><a href="index.php?gotopage=zxadd.php&b=64" target="_self"> 发公司新闻</a> | <a href="zxmanage.php?bigclassid=64">管理</a></li> 
<li><a href="advadd.php" target="_self">发广告</a> | <a href="advmanage.php">管理</a></li>
<?php 
}
?>
</ul>
</div>
</div>

<?php if (check_usergr_power('zs')=='yes'|| $usersf=='公司'){?>
<div id="left2" style="display:block" class="left_color">
<div class="lefttitle"><img src="image/ico/ico8.gif">查看留言</div>
<div class="leftcontent">
<ul>
<li><a href="dls_message_manage.php" target="_self" >产品<?php echo channeldl?>留言</a></li>
<li><a href="ztliuyan.php?show=all" target="_self">网站留言本</a></li>			
</ul>		
</div>
</div>
<?php }?>

<div id="left3" style="display:block" class="left_color"> 		
<div class="lefttitle"> <img src="image/ico/ico9.gif" width="12" height="16"> 抢广告位</div>
<div class="leftcontent"> 
<ul>
<li><a href="adv.php" target="_self">设置/更换广告词</a></li>
<li><a href="adv2.php" target="_self">抢占广告位</a><img src="image/ico/ico6.gif" width="23" height="12"></li>
</ul>
</div>
</div>

<?php 
if ($usersf=="公司"){ 
?>	
<div id="left4" style="display:block" class="left_color"> 
<div class="lefttitle"><img src="image/ico/ico5.gif" width="16" height="16"> 资质管理</div>
<div class="leftcontent">
<ul>			
<li><a href="licence_add.php" target="_self"> 资质证书添加</a></li> 
<li><a href="licence.php" target="_self" >资质证书管理</a></li>
</ul>
</div>
</div>
<?php 
}
?>
<div id="left5" style="display:block" class="left_color"> 
<div class="lefttitle"><img src="image/ico/ico7.gif" width="16" height="15"> 财务管理</div>
<div class="leftcontent">
<ul>	
<li><a href="/3/alipay/" target="_blank"> 用支付宝充值</a></li>
<li><a href="/3/tenpay/" target="_blank"> 用财富通充值</a></li>
<li><a href="pay_manage.php" target="_self"> 我的财务记录</a></li>
</ul>
</div>
</div>
			
<div id="left6" style="display:block" class="left_color"> 
<div class="lefttitle"><img src="image/ico/ico10.gif" width="16" height="16"> 用户设置</div>
<div class="leftcontent">
<ul>
<li><a href="vip_add.php" target="_self">会员自助升级</a></li> 
<li><a href="vip_xufei.php" target="_self">会员自助续费</a></li> 
<li><a href="manage.php" target="_self">修改注册信息</a></li>
<li><a href="managepwd.php" target="_self">修改登陆密码</a></li>
<li><a href="/one/vipuser.php" target="_blank">查看我的权限</a></li>
<li><a href="index.php" target="_self">查看帐号信息</a></li> 
</ul>
</div>
</div>
<?php if ($usersf=="公司"){ ?>
<div id="left7" style="display:block" class="left_color"> 
<div class="lefttitle"><img src="image/ico/ico10.gif" width="16" height="16"> 展厅设置</div>
<div class="leftcontent">
<ul>
<li><a href="ztconfig_skin.php" target="_self"> 模板更换</a></li>
<li><a href="ztconfig_skin_mobile.php" target="_self">手机版模板更换</a></li>
<li><a href="ztconfig.php" target="_self"> 用户展厅设置</a></li>
</ul>
</div>
</div>				
<?php 
}
?>				
<div id="left8" style="display:block" class="left_color">			
<div class="lefttitle"><img src="image/ico/ico8.gif"> 群发信息</div>
<div class="leftcontent">
<ul>
<li><a href="msg_manage.php" target="_self" >邮件/短信内容设置</a></li>
<li><a href="../dl/dl.php" target="_blank">给<?php echo channeldl?>商群发信息</a></li>			
</ul>		
</div>
</div>		

<div id="left9" style="display:block" class="left_color"> 
<div class="lefttitle"><img src="image/ico/ico3.gif"> 需要帮助</div>
<div class="leftcontent">
<ul>
<li><a target=blank href=http://wpa.qq.com/msgrd?v=1&uin=<?php echo kfqq?>&Site=<?php echo sitename?>&Menu=yes><img border="0" src=http://wpa.qq.com/pa?p=1:<?php echo kfqq ?>:4 alt="在线客服QQ">在线客服</a></li>
<li><a href="#">电话：<?php echo kftel?></a></li>
<li><a href="/one/help.php" target="_blank">常见问题解答</a></li>
<li><a href="message.php">给管理员发信息</a></li>
</ul>
</div>
</div>