<?php

/*
 * バージョン管理
 * 1.6.3
 * 
 * メモ
 * マスタ利用時修正必要
 * 
 * 
 */

session_start();

//データベースへの接続 housebudget
require 'function/connect_housebudget.php';


//ログインチェック
require 'function/login_check.php';


?>

<!DOCTYPE html>
<html>
	<head>
        <meta http-equiv = "Content-Type" content = "text/html; charset=UTF-8" />
        <link rel="stylesheet" type="text/css" href="./css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="./css/common.css" />
		<link rel="stylesheet" type="text/css" href="css/style.css" />
        <title>my家計簿</title>
	</head>

	<!-- 本文　ここから -->
	
	<!-- 見出し ここから　-->
	<div id="head">
		<h1>口座情報一覧</h1>
	</div>
	<!-- 見出し　ここまで　-->
	
	     
	<div class = "center">
		<a href="index.php">Back To TOP</a>
	</div>
     
     <!-- 一覧部ここから -->   
<?php
	//account情報を入手
    $sql = sprintf('SELECT a.name, u.* FROM user_accounts u JOIN accounts a ON u.account_id=a.id WHERE u.user_id=%d ORDER BY ID ASC',
		($_SESSION['user_id'])
	);
	$result = mysql_query($sql, $link);
	while ($row = mysql_fetch_assoc($result)) {
		$account[] = $row;
	}
	
	//支払い情報を入手
	$sql = sprintf('SELECT p.account_id, sum(p.how_much) 
					FROM user_accounts u 
						JOIN pay p ON p.user_accounts_id=u.id 
					WHERE p.user_accounts_id 
						IN (SELECT u.id FROM user_accounts u WHERE u.user_id=%d) AND p.date>u.checked 
					GROUP BY p.user_accounts_id',
				($_SESSION['user_id'])
	);
	$result = mysql_query($sql, $link);
	while ($row = mysql_fetch_assoc($result)) {
	$pay[] = $row;
	}
	
	//収入情報を入手
	$sql = sprintf('SELECT i.account_id, sum(i.amount) 
					FROM user_accounts u 
						JOIN income i ON i.user_accounts_id=u.id 
					WHERE i.user_accounts_id 
						IN (SELECT u.id FROM user_accounts u WHERE u.user_id=%d) AND i.date>u.checked 
					GROUP BY i.user_accounts_id',
				($_SESSION['user_id'])
	);
	$result = mysql_query($sql, $link);
	while ($row = mysql_fetch_assoc($result)) {
	$income[] = $row;
}
	
	var_dump($result);
	var_dump($pay);
	
?>
	<div class = "center">
	<h2>口座情報</h2>
	<table align = "center" >
		<tr>
			<th scope="col">ID</th>
			<th scope="col">口座名</th>
			<th scope="col">金額</th>
			<th scope="col">編集</th>
			<th scope="col">削除</th>
		</tr>

		<?php for ($i = 0; $i < count($account); $i++): ?>
	
		<tr>
			<td><?php print(htmlspecialchars($account[$i]['id'], ENT_QUOTES));?></td>
			<td><?php print(htmlspecialchars($account[$i]['name'], ENT_QUOTES));?></td>
			<td><?php print(htmlspecialchars($account[$i]['balance'], ENT_QUOTES));?></td>
			<td>
				<form method = "POST" action = "account_update.php" >
                 	<?php  //編集　id送信 ?>
					<input type = "hidden" name = "id" value=<?php print(htmlspecialchars($account[$i]['id'], ENT_QUOTES));?> >
					<input type = "submit" value = "編集" class="btn-primary" >
                </form>
            </td>
            <td>   
                <form method = "POST" action = "delete_action.php" >
                 	<?php  //削除　収入キー送信　id送信 ?>
					<input type = "hidden" name = "key" value="account" >
					<input type = "hidden" name = "id" value=<?php print(htmlspecialchars($account[$i]['id'], ENT_QUOTES));?> >
					<input type = "submit" value = "削除" class="btn-primary" onclick="return confirm('削除してよろしいですか');">
                </form>
			</td>
		
		</tr>
		<?php endfor;?>
	</table>
	</div>

	<div class = "center">
		<a href="index.php">Back To TOP</a>
	</div>

	<!--一覧表示部終わり-->

</body>
</html>

