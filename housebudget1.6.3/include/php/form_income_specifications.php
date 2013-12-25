<?php 
//前提テーブルのプライマリはid、名称はnameで登録されている
//すべてのユーザーが使うものはuser_id=initial_id(標準は0)の値として登録
//初期選択は$selectedで指定。中身は$tableで指定したテーブルのid
$stmt= $pdo->prepare("SELECT * FROM income_specifications
					WHERE user_id=0 OR user_id=:user_id AND uses=0
					ORDER BY ID ASC");
$stmt->bindValue(':user_id', mysql_real_escape_string($_SESSION['user_id']), PDO::PARAM_INT);
$stmt->execute();
$record=NULL;
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
	$record[] = $row;
}
/*
$sql=sprintf('SELECT * FROM income_specifications
					WHERE user_id=0 OR user_id=%d AND uses=0
					ORDER BY ID ASC',
			mysql_real_escape_string($_SESSION['user_id'])
);
$result = mysql_query($sql) or die(mysql_error());

$record=NULL;
while ($row = mysql_fetch_assoc($result)) {
	$record[] = $row;
}
*/
include_once 'library/optionLoop2.php';
optionLoop2 ($record, $selected);

$selected=NULL;

