<?php
session_start();

//データベースへの接続 housebudget
require 'function/connect_housebudget.php';
//ログインチェック
require 'function/login_check.php';
//関数設定
require 'library_all.php';

//口座の現在残高取得
require 'function/calculate_account_balance.php';
//今月の収支情報取得
require 'function/calculate_this_month.php';

?>
<!DOCTYPE html>
<html lang=ja>
    	<?php include 'include/head.html';?>

<body>
	<div id="head">
		<h1><?php echo $member['name'];?>さんのMy家計簿</h1>
		<h1>トップページ</h1>
	</div>
	
	<!-- メニューバー -->
	<?php include 'include/menu.html';?>

	<!-- 今月の収支 -->
	<div class="container">	
		<div class="row">
			<div class="col-md-offset-3 col-xs-6 well well-lg" >
				<div class="text-center">
					<h2>今月の収支</h2>
					<p><?php echo h($this_month);?> 出費：<?php echo h($sum_pay);?>円  収入：<?php echo h($sum_income);?>円</p>
				</div>
			</div>
		</div>
	</div>
	
	<!-- 口座残高 -->
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
								<td><?php print(h($account[$i]['name']));?></td>
								<td><?php print(h($account[$i]['balance']));?></td>
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



