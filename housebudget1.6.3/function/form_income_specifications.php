<?php 
//前提テーブルのプライマリはid、名称はnameで登録されている
//すべてのユーザーが使うものはuser_id=initial_id(標準は0)の値として登録
//初期選択は$selectedで指定。中身は$tableで指定したテーブルのid
$sql=sprintf('SELECT * FROM income_specifications
					WHERE user_id=0 OR user_id=%d
					ORDER BY ID ASC',
			mysql_real_escape_string($_SESSION['user_id'])
);
$result = mysql_query($sql) or die(mysql_error());

$record=NULL;
while ($row = mysql_fetch_assoc($result)) {
	$record[] = $row;
}
include 'library/optionLoop2.php';
optionLoop2 ($record, $selected);

unset($selected);



?>

