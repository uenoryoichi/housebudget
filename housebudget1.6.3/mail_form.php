<?
session_start();
//データベースへの接続 housebudget
require 'function/connect_housebudget.php';
//ログインチェック
require 'function/login_check.php';
//関数設定
require 'library_all.php';

if (!empty($_POST)){
	//入力不足チェック
	if (empty($_POST['email'])){
		$error['email']='empty';
	}
	if (!preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/',$_POST['email'])) {
		$error['email']='no_email';
	}
	if (empty($_POST['subject'])){
		$error['subject']='empty';
	}
	if (empty($_POST['message'])){
		$error['message']='empty';
	}
	//エラーがなければ次へ
	if (empty($error)){
		$_SESSION['inquiry'] = $_POST;
		$_SESSION['key'] = $_POST['key'];
		header('Location: mail_action.php');
	}
}

$sql = sprintf('SELECT *
 				FROM users
 				WHERE id=%d',
		mysql_real_escape_string($_SESSION['user_id'])
);
$result = mysql_query($sql, $link) or die(mysql_error());
while ($row = mysql_fetch_assoc($result)) {
	$users = $row;
}

?>

<!DOCTYPE html>
<html lang=ja>
    <?php include 'include/head.html';?>

<body>
	<div id="head">
		<h1>お問い合わせフォーム</h1>
	</div>

	<!-- メニューバー -->
	<?php include 'include/menu.html';?>

	<div class="container">
		<div class="row"> 		
			<div class="col-md-offset-3 col-md-6">
           		<br><h2>お問い合わせフォーム</h2>
          		<form method = "POST" action = "" class = "form-horizontal well">
					<dl>
					<dt>連絡先(Emailアドレス)</dt>
						<dd><input name="email" type="text" class="form-control" maxlength="255" value=<?php echo h($users["email"]);?>></dd>
						<?php if ($error['email']=='empty'):?>
								<div class="alert alert-warning">
									<p class="error">* メールアドレスが入力されていません</p>
                    				</div>	
                    		<?php endif; ?>
                    		<?php if ($error['email']=='no_email'):?>
								<div class="alert alert-warning">
									<p class="error">* メールアドレスの形式が不正です</p>
                    				</div>	
                    		<?php endif; ?>
					<dt>件名</dt>
						<dd><input name="subject" type="text" class="form-control" maxlength="255" /></dd>
						<?php if ($error['subject']=='empty'):?>
								<div class="alert alert-warning">
									<p class="error">* 件名が入力されていません</p>
                    				</div>	
                    		<?php endif; ?>
					<dt>内容</dt>
						<dd>
							<textarea name="message" cols="50" rows="10" class="form-control" ></textarea>
						</dd>
						<?php if ($error['message']=='empty'):?>
								<div class="alert alert-warning">
									<p class="error">* 本文が入力されていません</p>
                    				</div>	
                    		<?php endif; ?>
					</dl>
					<div class="center">
						<input type = "hidden" name = "key" value="inquiry" >
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
