<?php 
$sql=sprintf('SELECT * FROM pay_specifications
					WHERE user_id=0 OR user_id=%d AND uses=0
					ORDER BY ID ASC',
			mysql_real_escape_string($_SESSION['user_id'])
);
$result = mysql_query($sql) or die(mysql_error());

$record=NULL;
while ($row = mysql_fetch_assoc($result)) {
	$record[] = $row;
}
include_once 'library/optionLoop2.php';
optionLoop2 ($record, $selected);

unset($selected);

?>

