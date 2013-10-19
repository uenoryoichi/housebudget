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
require 'connect_housebudget.php';


//ログインチェック
require 'login_check.php';

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
<link href="css/default.css" rel="stylesheet" type="text/css" />
<!-- /ここまで -->
<script type="text/javascript" src="js/default.js"></script>
</head>






<body>

	<div id="container">

		<h1>作成中</h1>

		<h2><a href="./"><?php echo $member['user_name'];?>さんのMy家計簿</a></h2>

		<div id="head">

			<div id="head_menu">
				<ul>
					<li><a href="./">HOME</a></li>
					<li><a href="pay_index.php">支出管理</a></li>
					<li><a href="income_index.php">収入管理</a></li>
					<li><a href="transfer_index.php">口座移動</a></li>
					<li><a href="account_index.php">口座残高</a></li>
					<li><a href="logout.php">ログアウト</a></li>
				</ul>
			</div>

			<div id="main_image">
				<p></p>
			</div>

		</div>

		<p><img src="img/common/line_02.gif" width="800" height="8" /></p>

		<div id="contents">

			<div id="top">

				<div id="left">
				
				
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
						for ($i = 0; $i < count($pay); $i++):
							$sum_pay += $pay[$i]['how_much'];
						endfor;
					
					//今月の収入データ取得					
						$this_month_income = date('Y-m');
						$sql = "SELECT * FROM income WHERE date  LIKE '$this_month%' ";
						$result = mysql_query($sql, $link);
						$sum_income = 0;
						while ($row = mysql_fetch_assoc($result)) {
							$income[] = $row;
						}
											
					//支払い合計金額
						for ($i = 0; $i < count($income); $i++):
							$sum_income += $income[$i]['amount'];
						endfor;
					?>
					
					

				
					<h3>無駄使いはするなよ～</h3>
					<h4><img src="img/top/st_info.gif" alt="インフォメーション" width="144" height="24" /></h4>
					<div id="info">
						<h2><?php echo $this_month;?> 出費：<?php echo $sum_pay;?>円  収入：<?php echo $sum_income;?>円</h2>
						<br>
						<h2>残高</h2>
						<p>メモ：データベース作成、口座間移動のphp、残高表示</p>
						<p>現金</p>
						<p>郵貯</p>
						<p>SBI銀行</p>
						<p>三井住友</p>
						<br>
						<p>GMO証券</p>
						<p>SBI証券</p>
						<p>松井証券</p>
						<p>マネックス証券</p>
						<p>大和証券</p>
												
					</div>
				</div>

				<div id="right">
					<div id="bnr_sps">
						<p><a href="contents01.html"><img src="img/top/bnr_sample.gif" alt="コンテンツ01へ" width="230" height="90" /></a></p>
						<p><a href="contents01.html"><img src="img/top/bnr_sample.gif" alt="コンテンツ01へ" width="230" height="90" /></a></p>
						<p><a href="contents01.html"><img src="img/top/bnr_sample.gif" alt="コンテンツ01へ" width="230" height="90" /></a></p>
					</div>
				</div>

			</div>

		</div>

		<div id="copy">Copyright (C) <script type="text/javascript">document.write(new Date().getFullYear());</script> <a href="./">My家計簿</a>. All Rights Reserved.</div>

	</div>

</body>
</html>


