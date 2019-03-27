<?php
include("../inc/stopsqlin.php");
$kind = isset($_GET['kind'])?nostr($_GET['kind']):"zs";
$keyword=isset($_GET['keyword'])?nostr($_GET['keyword']):"";
header("location:/$kind/search.php?keyword=$keyword"); 
?>