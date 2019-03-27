// JavaScript Document
function ConfirmDel()
{
   if(confirm("确定要删除吗？一旦删除将不能恢复！"))
     return true;
   else
     return false;	 
}
function DLS(id) 
{ 
window.open("dls_show.php?id="+id,"","height=420,width=470,left=300,top=100,resizable=yes,scrollbars=yes,status=no,toolbar=no,menubar=no,location=no");
}
function fSetBg(obj){
	obj.style.backgroundColor = '#FFFFFF';
}
function fReBg(obj){
	obj.style.backgroundColor = '';
}
function CheckAll(form){
  for (var i=0;i<form.elements.length;i++)//elements
    {
    var e = form.elements[i];
    if (e.Name != "chkAll")
       e.checked = form.chkAll.checked;
    }
}
  
function uncheckall()   {   
var code_Values = document.all['smallclassid[]'];   
if(code_Values.length){   
	for(var i=0;i<code_Values.length;i++) {   
	code_Values[i].checked = false;   
	}   
}else{   
code_Values.checked = false;   
}   
} 

function showfilter2(obj2) {
	if (obj2.style.display=="block") {
        obj2.style.display="none";
    }else {
        obj2.style.display="block";
    }   
}
function  pass(myform){   
      myform.action="?action=pass";   
      //myform.target="_blank";     //指向什么帧名，你自己定，我这是新开一页   
      //myform.submit();   
      } 
function  del(myform){   
	if(confirm("确定要删除选中的信息吗？"))
    myform.action="?action=del";  
	else		
	return false;     
      }  
function  dele(myform,channel){ 
	if(confirm("确定要删除选中的信息吗？"))
    myform.action="del.php?channel="+channel 
	else		
	return false;     
      } 

function  deluser(myform){ 
	if(confirm("确定要删除选中的信息吗？"))
    myform.action="userdel.php";  
	else		
	return false;     
      }
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
