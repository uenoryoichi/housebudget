<?php
/*
 * var1.6で実現したいこと
 * マスタ設定　pay_indexでチャレンジ中
 * マスタの設定
 * //unset($_POST)で重複登録防止
 * 登録メールアドレスの形状
 * htmlspecialcharsのショートカット
 * function j($value) {
 * 	return htmlspecialchars($value, ENT_QUORTES, 'UTF-8');
 * }
 * 
 * 
 * 1.6.3 ログイン確認を関数化
 * 1.6.2 各画面へ入るのにログインを必須とする
 * 1.6.1 ログイン機能-画面実装
 * 1.5.3 口座移動管理機能 一覧表示中央揃え
 * 1.5.2　一覧に戻るの位置を変える　
 * housebudget1.5.1 選択肢式に切り替え
 * housebudget1.4.2	収入管理機能実装
 * housebudget1.4.1	income_index完成、insertへの流れ完成、delete_action修正
 * housebudget1.4	@収入管理機能実装(予定)
 * housebudget1.3.1	不要ファイル整理
 * housebudget1.3　	pay_index実装(insertとichiran合体)、insertのvalue部変更
 * housebudget1.2　	不要ファイル整理
 * housebudget1.1　	編集機能実装
 * 
 * 
 * test
 * test
 * 
 * aaaa
 * 
 */


session_start();

//データベースへの接続 housebudget
require 'function/connect_housebudget.php';

//ログインチェック
require 'function/login_check.php';

//口座の現在残高取得
require 'function/calculate_account_balance.php';

//今月の収支情報取得
require 'function/calculate_this_month.php';

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ja" xml:lang="ja" xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>MY家計簿</title>
<meta name="keywords" content="家計簿" />
<meta name="description" content="自分専用家計簿ページ" />
<meta http-equiv="content-script-type" content="text/javascript" />
<meta http-equiv="content-style-type" content="text/css" />
<meta http-equiv="imagetoolbar" content="no" />
<!-- 外部CSS読み込み -->
<!--  <link href="css/default.css" rel="stylesheet" type="text/css" />
-->
		<link rel="stylesheet" type="text/css" href="css/style.css" />

<!-- /ここまで -->
<script type="text/javascript" src="js/default.js"></script>
</head>

<body>
	<div id="head">
		<h1><?php echo $member['name'];?>さんのMy家計簿</h1>
		<h1>トップページ</h1>
	</div>
	<div id="container">
		<div class="">
			<ul>
				<li><a href="./">HOME</a></li>
				<li><a href="pay_index.php">支出管理</a></li>
				<li><a href="income_index.php">収入管理</a></li>
				<li><a href="transfer_index.php">口座移動</a></li>
				<li><a href="account_index.php">口座残高</a></li>
				<li><a href="logout.php">ログアウト</a></li>
			</ul>
		</div>
		<div id="contents">
			<div id="top">
				<div id="left">
					<div id="info">
						<h2><?php echo $this_month;?> 出費：<?php echo $sum_pay;?>円  収入：<?php echo $sum_income;?>円</h2>
					</div>
					
					<div class = "center">
						<h2>口座情報</h2>
						<table align = "center" >
							<tr>
								<th scope="col">口座名</th>
								<th scope="col">金額</th>
							</tr>
							<?php for ($i = 0; $i < count($account); $i++): ?>
							<tr>
								<td><?php print(htmlspecialchars($account[$i]['name'], ENT_QUOTES));?></td>
								<td><?php print(htmlspecialchars($account[$i]['balance'], ENT_QUOTES));?></td>
							</tr>
							<?php endfor;?>
						</table>
					</div>
				</div>
			</div>
		</div>

		<div id="copy">Copyright (C) 
			<script type="text/javascript">document.write(new Date().getFullYear());</script> 
			<a href="./">My家計簿</a>. All Rights Reserved.
		</div>
	</div>
</body>
</html>


