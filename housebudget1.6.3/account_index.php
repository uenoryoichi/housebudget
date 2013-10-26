<?php

/*
 * バージョン管理
 * 1.6.3
 * 
 * メモ
 * マスタ利用時修正必要
 * 
 * 
 * 
 */

session_start();

//データベースへの接続 housebudget
require 'function/connect_housebudget.php';
//ログインチェック
require 'function/login_check.php';
//口座の現在残高取得
require 'function/calculate_account_balance.php';
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
	
	 <!-- 一覧部ここから -->   
		<h2>口座情報</h2>
		<table align = "center" >
			<tr>
				<th scope="col">口座名</th>
				<th scope="col">金額</th>
			</tr>

			<?php for ($i = 0; $i < count($account); $i++): ?>
			<tr>
				<td><?php print(htmlspecialchars($account[$i]['name'], ENT_QUOTES));?></td>
				<td><input type = "text" name = "balance" class="span2" style="text-align: right;" value="<?php print (htmlspecialchars($account[$i]['balance'],ENT_QUOTES));?>"/></td>
			</tr>
			<?php endfor;?>
		</table>
		
		<a href="index.php">Back To TOP</a>
	</div>

	<!--一覧表示部終わり-->
</body>
</html>

