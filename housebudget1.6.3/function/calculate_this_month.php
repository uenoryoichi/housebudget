<?php
//今月分の支払いデータ取得					
$this_month = date('Y-m');
$sql = "SELECT * FROM pay WHERE date  LIKE '$this_month%' ";
$result = mysql_query($sql, $link);
$sum_pay = 0;
while ($row = mysql_fetch_assoc($result)) {
	$pay[] = $row;
}				

//支払い合計金額
for ($i = 0; $i < count($pay); $i++){
	$sum_pay += $pay[$i]['how_much'];
}
					
//今月の収入データ取得					
$this_month_income = date('Y-m');
$sql = "SELECT * FROM income WHERE date  LIKE '$this_month%' ";
$result = mysql_query($sql, $link);
$sum_income = 0;
while ($row = mysql_fetch_assoc($result)) {
	$income[] = $row;
}
											
//支払い合計金額
for ($i = 0; $i < count($income); $i++){
	$sum_income += $income[$i]['amount'];
}

?>	