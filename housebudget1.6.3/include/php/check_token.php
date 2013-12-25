<?php 
if ($_POST['token']==$_SESSION['token']['value']) {
	if ($_SESSION['token']['created']>=(time()-3000)) {
		;
	} else {
		$_SESSION['token']=NULL;
		$_SESSION['error']='timeout';
		header('Location: index.php');
	}
} else {
	$_SESSION['token']=NULL;
	$_SESSION['error']='token_disagreement';
	header('Location: index.php');
}
$_POST['token']=NULL;
$_SESSION['token']=NULL;
