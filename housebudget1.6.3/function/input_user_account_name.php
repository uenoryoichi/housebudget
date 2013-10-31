<?php 

$sql = sprintf('SELECT a.name, u.id FROM user_accounts u JOIN accounts a ON u.account_id=a.id WHERE u.user_id=%d ORDER BY ID ASC',
		($_SESSION['user_id'])
	);
$result = mysql_query($sql) or die(mysql_error());

$accounts=NULL;		//2回使う時のための初期
while ($row = mysql_fetch_assoc($result)) {
	$accounts[] = $row;
}

if(isset($selected)){		//更新時
	for ($i=0,$count_accounts=count($accounts); $i<$count_accounts; $i++){
		if ($selected==$accounts[$i]['id']) {
			print ('<option value="'.$accounts[$i]['id'].'" selected>'.$accounts[$i]['name'].'</option>');
		}else {
			print('<option value="'.$accounts[$i]['id'].'">'.$accounts[$i]['name'].'</option>');
		}
	}
}else {							//入力時
	for ($i=0,$count_accounts=count($accounts); $i<$count_accounts; $i++){
		print('<option value="'.$accounts[$i]['id'].'">'.$accounts[$i]['name'].'</option>');
		
	}
}
?>

