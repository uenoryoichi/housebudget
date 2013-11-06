<?php 

$sql = sprintf('SELECT * FROM account_classifications ORDER BY ID ASC');
$result = mysql_query($sql) or die(mysql_error());
$account_classifications=NULL;
while ($row = mysql_fetch_assoc($result)) {
	$account_classifications[] = $row;
}
							//入力時
for ($i=0,$count_account_classifications=count($account_classifications); $i<$count_account_classifications; $i++){
	print('<option value="'.$account_classifications[$i]['id'].'">'.$account_classifications[$i]['name'].'</option>');
}

?>

