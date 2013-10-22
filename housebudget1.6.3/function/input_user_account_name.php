<?php 

$sql = sprintf('SELECT a.name, u.id FROM user_accounts u JOIN accounts a ON u.account_id=a.id WHERE u.user_id=%d ORDER BY ID ASC',
		($_SESSION['user_id'])
	);
$result = mysql_query($sql) or die(mysql_error());

while ($row = mysql_fetch_assoc($result)) {
	$account[] = $row;
}


for ($i=0,$count=count($account); $i<$count; $i++){
	print('<option value="'.$account_name[$i]['id'].'">'.$account_name[$i]['name'].'</option>');
}

?>