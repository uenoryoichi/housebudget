<?php 

$sql = sprintf('SELECT * FROM account_classifications ORDER BY ID ASC');
$result = mysql_query($sql) or die(mysql_error());
$account_classifications=NULL;
while ($row = mysql_fetch_assoc($result)) {
	$account_classifications[] = $row;
}

include 'library/optionLoop2.php';
optionLoop2($account_classifications, $selected);

?>

