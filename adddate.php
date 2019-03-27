<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?
set_time_limit(1800) ;
include("inc/conn.php");
for ($i=0;$i<=10000;$i++){ 
//mysql_query("Insert into zzcms_zh(bigclassid,title,address,timestart,timeend,content,editor,sendtime,passed) values
//('1','展会测试','展会测试','".date('Y-m-d H:i:s')."','".date('Y-m-d H:i:s')."','展会测试展会测试','test','".date('Y-m-d H:i:s')."',1)") ;

mysql_query("Insert into zzcms_dl(classzm,cp,province,city,xiancheng,content,dlsname,tel,editor,sendtime,passed) values
('xiyao','西药代理测试$i','广西','南宁','马山县','代理测试代理测试代理测试','李志阳','13838064112','test','".date('Y-m-d H:i:s')."',1)") ;
$dlid=mysql_insert_id();
mysql_query("Insert into zzcms_dl_xiyao(dlid,cp,province,city,xiancheng,content,dlsname,tel,editor,sendtime,passed) values
($dlid,'西药代理测试$i','广西','南宁','马山县','代理测试代理测试代理测试','李志阳','13838064112','test','".date('Y-m-d H:i:s')."',1)") ;

//mysql_query("Insert into zzcms_main(bigclasszm,smallclasszm,img,proname,prouse,sm,province,city,xiancheng,editor,sendtime,passed) values
//('yuanliaoyao','kangshengsu','/image/nopic.gif','招商测试','招商测试商测试','招商测试测测试招商测试','河南省','濮阳市','范县','test','".date('Y-m-d H:i:s')."',1)") ;

//mysql_query("Insert into zzcms_zx(bigclassid,bigclassname,title,content,img,editor,sendtime,passed) values
//('1','公司新闻','资讯测试资讯测试','资讯测试资讯测试资讯测试资讯测试','/uploadfiles/2014-11/20141101234940258.gif','test','".date('Y-m-d H:i:s')."',1)") ;
}
echo '完成';

?>
