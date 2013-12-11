<?php 
if ($_POST['token']==$_SESSION['token']['value']) {
	if ($_SESSION['token']['created']>=(time()-3000)) {
		;
	} else {
		$error['token']='timeout';
	}
} else {
	$error['token']='token_disagreement';
}
$_POST['token']=NULL;
$_SESSION['token']=NULL;
?>