<?php 	
	
	//account情報を入手
    $sql = sprintf('SELECT a.name, u.* FROM user_accounts u JOIN accounts a ON u.account_id=a.id WHERE u.user_id=%d ORDER BY ID ASC',
					mysql_real_escape_string($_SESSION['user_id'])
	);
	$result = mysql_query($sql, $link);
	while ($row = mysql_fetch_assoc($result)) {
		$account[] = $row;
	}
	
	//支払い情報を入手
	$sql = sprintf('SELECT u.account_id, sum(p.how_much) 
					FROM user_accounts u 
						JOIN pay p ON p.user_accounts_id=u.id 
					WHERE p.user_accounts_id 
						IN (SELECT u.id FROM user_accounts u WHERE u.user_id=%d) AND p.date>u.checked 
					GROUP BY p.user_accounts_id',
					mysql_real_escape_string($_SESSION['user_id'])
	);
	$result = mysql_query($sql, $link);
	while ($row = mysql_fetch_assoc($result)) {
		$pay[] = $row;
	}
	
	//収入情報を入手
	$sql = sprintf('SELECT u.account_id, sum(i.amount) 
					FROM user_accounts u 
						JOIN income i ON i.user_accounts_id=u.id 
					WHERE i.user_accounts_id 
						IN (SELECT u.id FROM user_accounts u WHERE u.user_id=%d) AND i.date>u.checked 
					GROUP BY i.user_accounts_id',
					mysql_real_escape_string($_SESSION['user_id'])
	);
	$result = mysql_query($sql, $link);
	while ($row = mysql_fetch_assoc($result)) {
		$income[] = $row;
	}
	
	//口座間移動情報を入手
	//送金側
	$sql = sprintf('SELECT u.account_id, sum(t.amount) 
					FROM user_accounts u 
						JOIN transfer t ON t.user_accounts_id_remitter=u.id 
					WHERE t.user_accounts_id_remitter
						IN (SELECT u.id FROM user_accounts u WHERE u.user_id=%d) AND t.date>u.checked 
					GROUP BY t.user_accounts_id_remitter',
					mysql_real_escape_string($_SESSION['user_id'])
	);	
	$result = mysql_query($sql, $link) or die(mysql_error());;
	while ($row = mysql_fetch_assoc($result)) {
		$transfer_remitter[] = $row;
	}	
	//受け取り側
	$sql = sprintf('SELECT u.account_id, sum(t.amount)
					FROM user_accounts u
						JOIN transfer t ON t.user_accounts_id_remittee=u.id
					WHERE t.user_accounts_id_remittee
						IN (SELECT u.id FROM user_accounts u WHERE u.user_id=%d) AND t.date>u.checked
					GROUP BY t.user_accounts_id_remittee',
			  		mysql_real_escape_string($_SESSION['user_id'])
	);
	$result = mysql_query($sql, $link) or die(mysql_error());
	while ($row = mysql_fetch_assoc($result)) {
		$transfer_remittee[] = $row;
	}
	
	//支払い、収入、口座間移動を用いて、口座情報を更新
	for ($i = 0, $count_account=count($account); $i < $count_account; ++$i) {
		$account_id=$account[$i]['account_id'];
		//支払い
		for($j = 0, $count=count($pay); $j < $count; ++$j) {
			if ($pay[$j]['account_id']==$account_id) {
				$account[$i]['balance']-=$pay[$j]['sum(p.how_much)'];
				break;
			};	
		}
		//収入
		for($j = 0, $count=count($income); $j < $count; $j++) {
			if ($income[$j]['account_id']==$account_id) {
				$account[$i]['balance']+=$income[$j]['sum(i.amount)'];
				break;
			};
		}
		//口座移動送り手
		for($j = 0, $count=count($transfer_remitter); $j < $count; ++$j) {
			if ($transfer_remitter[$j]['account_id']==$account_id) {
				$account[$i]['balance']-=$transfer_remitter[$j]['sum(t.amount)'];
				break;
			};
		}
		//口座移動受け手
		for($j = 0, $count=count($transfer_remittee); $j < $count; $j++) {
			if ($transfer_remittee[$j]['account_id']==$account_id) {
				$account[$i]['balance']+=$transfer_remittee[$j]['sum(t.amount)'];
				break;
			};
		}
	}
?>