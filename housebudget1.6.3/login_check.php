<?php

/*
 * ログインをチェックする関数
 * need：session_start();
 * need：require 'connect_housebudget.php';
 */


if (isset($_SESSION['user_id']) && $_SESSION['time'] + 3600 > time()) {
	// ログインしている
	$_SESSION['time'] = time();

	$sql = sprintf('SELECT * FROM user_master WHERE user_id=%d',
			mysql_real_escape_string($_SESSION['user_id'])
	);
	$record = mysql_query($sql) or die(mysql_error());
	$member = mysql_fetch_assoc($record);
} else {
	// ログインしていない
	header('Location: login.php'); exit();
}

?>