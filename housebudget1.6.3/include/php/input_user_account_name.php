<?php 

$sql = sprintf('SELECT a.name, u.id FROM user_accounts u JOIN accounts a ON u.account_id=a.id WHERE u.user_id=%d ORDER BY ID ASC',
		(mysql_real_escape_string($_SESSION['user_id']))
	);
$result = mysql_query($sql) or die(mysql_error());

$accounts=NULL;		//2回使う時のための初期
while ($row = mysql_fetch_assoc($result)) {
	$accounts[] = $row;
}

include_once 'library/optionLoop2.php';
optionLoop2($accounts, $selected) ;
unset($selected);
?>

