<?
session_start();
//データベースへの接続 housebudget
require 'function/connect_housebudget.php';
//ログインチェック
require 'function/login_check.php';
?>

<?php 
$sql = sprintf('SELECT *
 				FROM users
 				WHERE id=%d',
		$_SESSION['user_id']
);
$result = mysql_query($sql, $link) or die(mysql_error());
while ($row = mysql_fetch_assoc($result)) {
	$users = $row;
}

?>

<!DOCTYPE html>
<html lang=ja>
	<!-- ヘッダー -->
    <?php include 'include/head.html';?>

<body>

    <!-- 見出し -->
	<div id="head">
		<h1>お問い合わせフォーム</h1>
	</div>

	<!-- メニューバー -->
	<?php include 'include/menu.html';?>

	<div class="container">
		<div class="row"> 		
			<div class="col-md-offset-3 col-md-6">
           		<br><h2>お問い合わせフォーム</h2>
          		<form method = "POST" action = "mail_action.php" class = "form-horizontal well">
					<dl>
					<dt>連絡先(Emailアドレス)</dt>
						<dd><input name="email" type="text" class="form-control" maxlength="255" value=<?php echo $users["email"];?>></dd>
					<dt>件名</dt>
						<dd><input name="subject" type="text" class="form-control" maxlength="255" /></dd>
					<dt>内容</dt>
						<dd>
							<textarea name="message" cols="50" rows="10" class="form-control" ></textarea>
						</dd>
					</dl>
					<div class="center">
					<input type="submit" value="送信する" class="btn btn-primary"/>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- フッター -->
	<?php include 'include/footer.html';?>
			

</body>
</html>
