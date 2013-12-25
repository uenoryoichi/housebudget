<?php 
$stmt = $pdo->query('SELECT * FROM account_classfications ORDER BY ID ASC');
/*
$sql = sprintf('SELECT * FROM account_classifications ORDER BY ID ASC');
$result = mysql_query($sql) or die(mysql_error());

*/
$account_classifications=NULL;
while ($row=$stmt->fetch(PDO::FETCH_ASSOC)){
	$account_classifications[] = $row;
}

include_once 'library/optionLoop2.php';
optionLoop2($account_classifications, $selected);

?>

