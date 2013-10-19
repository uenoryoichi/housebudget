<?php 

$sql = sprintf('SELECT a.name FROM user_accounts u JOIN accounts a ON u.account_id=a.id WHERE u.user_id=%d ORDER BY ID ASC',
		($_SESSION['user_id'])
);
$result = mysql_query($sql, $link);

while ($row = mysql_fetch_assoc($result)) {
	$account_name[] = $row;
}

?>