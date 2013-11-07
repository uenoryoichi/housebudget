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
<!DOCTYPE html>
<html lang=ja>
	<?php //ヘッダー情報取り込み?>
    	<?php include 'include/head.html';?>

<body>
	<!-- 見出しここから -->
	<div id="head">
		<h1><?php echo $member['name'];?>さんのMy家計簿</h1>
		<h1>トップページ</h1>
	</div>
	
	<!-- メニューバー -->
	<?php include 'include/menu.html';?>

	<!-- 情報一覧 -->
	<div class="container">	
		<div class="row">
			<div class="col-md-offset-3 col-xs-6 well well-lg" >
				<div class="text-center">
					<h2>今月の収支</h2>
					<p><?php echo $this_month;?> 出費：<?php echo $sum_pay;?>円  収入：<?php echo $sum_income;?>円</p>
				</div>
			</div>
		</div>
	</div>
	
	<div class="container">	
		<div class="row">
			<div class="col-md-offset-3 col-xs-6">
				<div class="center">
					<h2>口座情報</h2>
					<table class="table table-hover table-bordered">
						<thead>
							<tr>
								<th scope="col">口座名</th>
								<th scope="col">金額</th>
							</tr>
						</thead>
						<?php for ($i = 0; $i < count($account); $i++): ?>
						<tbody>
							<tr>
								<td><?php print(htmlspecialchars($account[$i]['name'], ENT_QUOTES));?></td>
								<td><?php print(htmlspecialchars($account[$i]['balance'], ENT_QUOTES));?></td>
							</tr>
						</tbody>
						<?php endfor;?>
					</table>
				</div>
			</div>
		</div>
	</div>
					
　<div class="container">	
		<div class="row">
			<div class="col-md-offset-3 col-xs-6 well">
				<div class="center">
					<br>
					<h2>更新履歴</h2>
					<?php include 'include/change_log.html';?>
				</div>
			</div>
		</div>
	</div>
	
	<div class="container">	
		<div class="row">
			<div class="col-md-offset-3 col-xs-6 well">
				<div class="center">
					<br>
					<h2>coming_soon</h2>
					<?php include 'include/coming_soon.html';?>
				</div>
			</div>
		</div>
	</div>
	
	<!-- フッター -->
	<?php include 'include/footer.html';?>
	
</body>
</html>

<!-- google analytics -->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-45505701-2', 'lost-waldo.jp');
  ga('send', 'pageview');

</script>


