<?php 
$logid = $_SESSION['user_id'];
if (isset($_SESSION['user_id']) && $_SESSION['time'] + 3600 > time()) {
	$_SESSION['time'] = time();
	$sql = 'SELECT * FROM users WHERE id= :logid;';
	$stmt = $pdo -> prepare($sql);
	$stmt -> bindParam(':logid', $logid, PDO::PARAM_STR);
	$stmt -> execute();
	$member = $stmt -> fetch(PDO::FETCH_ASSOC);
}else{
	header('Location: login.php');
}
	/*
	$sql = sprintf('SELECT * FROM users WHERE id=%d',
			mysql_real_escape_string($_SESSION['user_id'])
	);
	$record = mysql_query($sql) or die(mysql_error());
	$member = mysql_fetch_assoc($record);
	
} else {
	// ログインしていない
	header('Location: login.php'); exit();
}

?>