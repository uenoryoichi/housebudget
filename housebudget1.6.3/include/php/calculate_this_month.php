<?php
//今月分の支払いデータ取得

$stmt = $pdo->prepare("SELECT SUM(pay.how_much) AS sum_pay
					FROM pay
					WHERE user_id=:user_id
						AND date  >= DATE_FORMAT(NOW(), '%Y-%m-01')
						AND date < ADDDATE(DATE_FORMAT(NOW(), '%Y-%m-01'), interval 2 month)
                    	GROUP BY pay.user_id ");
$stmt->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$pay=$row;
$sum_pay=$pay['sum_pay'];

//収入データ
$stmt = $pdo->prepare("SELECT SUM(income.amount) AS sum_income
					FROM income 
					WHERE user_id=:user_id
						AND date  >= DATE_FORMAT(NOW(), '%Y-%m-01')
						AND date < ADDDATE(DATE_FORMAT(NOW(), '%Y-%m-01'), interval 2 month)
                    	GROUP BY income.user_id ");
$stmt->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$income=$row;
$sum_income=$income['sum_income'];

/*       
$sql = sprintf("SELECT SUM(pay.how_much) AS sum_pay
					FROM pay 
					WHERE user_id=%d
						AND date  >= DATE_FORMAT(NOW(), '%%Y-%%m-01')
						AND date < ADDDATE(DATE_FORMAT(NOW(), '%%Y-%%m-01'), interval 2 month)
                    	GROUP BY pay.user_id ",	
					mysql_real_escape_string($_SESSION['user_id'])
);
$result = mysql_query($sql, $link) or die(mysql_error());
while ($row = mysql_fetch_assoc($result)) {
	$pay = $row;
}
$sum_pay = $pay['sum_pay'];

//今月の収入データ取得					
$sql = sprintf("SELECT SUM(income.amount) AS sum_income
					FROM income 
					WHERE user_id=%d
						AND date  >= DATE_FORMAT(NOW(), '%%Y-%%m-01')
						AND date < ADDDATE(DATE_FORMAT(NOW(), '%%Y-%%m-01'), interval 2 month)
                    	GROUP BY income.user_id ",	
					mysql_real_escape_string($_SESSION['user_id'])
);
$result = mysql_query($sql, $link) or die(mysql_error());
while ($row = mysql_fetch_assoc($result)) {
	$income= $row;
}
$sum_income = $income['sum_income'];
*/
