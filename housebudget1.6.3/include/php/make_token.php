<?php 
$token=sha1(uniqid(rand(),ture).'_'.session_id());
$_SESSION['token']['value']=$token;
$_SESSION['token']['created']=time();
?>