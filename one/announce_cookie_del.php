<?php  
setcookie("closegg",'close',time()+3600*24,"/");
$fromurl=$_SERVER['HTTP_REFERER'];
echo "<script>location.href='".$fromurl."'</script>";
?> 