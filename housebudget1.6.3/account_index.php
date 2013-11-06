<?php
session_start();
//データベースへの接続 housebudget
require 'function/connect_housebudget.php';
//ログインチェック
require 'function/login_check.php';
//口座の現在残高取得
require 'function/calculate_account_balance.php';
?>

<!DOCTYPE html>
<html lang=ja>
	<!-- ヘッダーここから -->
    <?php include 'include/head.html';?>

	<!-- 本文　ここから -->	
<body>
	
	<!-- 見出し ここから　-->
	<div id="head">
		<h1>口座情報更新</h1>
	</div>
	
	<!-- メニューバー -->
	<?php include 'include/menu.html';?>
	
	<!-- 見出し　ここまで　-->
	<div class="container">
		<div class="row"> 		
			<div class="col-md-offset-3 col-md-6">
				<div class = "center">
					<br>
					<h2>最終更新日時：</h2>
           			<form method="POST" action="update_action" class="form-horizontal"></form>
	           			<table class="table table-hover table-bordered">
							<thead>
								<tr>
									<th scope="col">口座名</th>
									<th scope="col">金額</th>
								</tr>
							</thead>
							<?php for ($i = 0, $count_accounts=count($account); $i < $count_accounts;  $i++): ?>
							<tbody>
								<tr>
									<td><?php print(htmlspecialchars($account[$i]['name'], ENT_QUOTES));?></td>
									<td>
										<input type = "hidden" name = "user_accounts_id[]"  value="<?php print (htmlspecialchars($account[$i]['id'],ENT_QUOTES));?>"/>
										<input type = "text" name = "balance[]" class="form-control input-sm text-right" value="<?php print (htmlspecialchars($account[$i]['balance'],ENT_QUOTES));?>"/>
									</td>
								</tr>
							</tbody>
							<?php endfor;?>
						</table>
						<input type="hidden" name="key" value="account_balance"/>
             			<input type="submit" value="更新" class="btn btn-primary"/>	
					</form>
				</div>
			</div>
		</div>
	</div>
	
	<div class="center">
		<a href="index.php">Back To TOP</a>
	</div>
		
	<!-- フッター -->
	<?php include 'include/footer.html';?>
	
</body>
</html>

