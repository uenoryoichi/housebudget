<?php
//データベースへの接続 housebudget
require 'function/connect_housebudget.php';
//関数設定
require 'library_all.php';

session_start();

if ($_COOKIE['email'] != '') {
	$_POST['email'] = $_COOKIE['email'];
	$_POST['password'] = $_COOKIE['password'];
	$_POST['save'] = 'on';
}


if (!empty($_POST)) {
	// ログインの処理
	if ($_POST['email'] != '' && $_POST['password'] != '') {
		$sql = sprintf('SELECT * FROM users WHERE email="%s" AND password="%s"',
			mysql_real_escape_string($_POST['email']),
			sha1(mysql_real_escape_string($_POST['password']))
		);
		$record = mysql_query($sql) or die(mysql_error());
		if ($table = mysql_fetch_assoc($record)) {
			// ログイン成功
			$_SESSION['user_id'] = $table['id'];
			$_SESSION['time'] = time();

			// ログイン情報を記録する
			if ($_POST['save'] == 'on') {
				setcookie('email', $_POST['email'], time()+60*60*24*14);
				setcookie('password', $_POST['password'], time()+60*60*24*14);
			}

			header('Location: index.php'); exit();
		} else {
			$error['login'] = 'failed';
		}
	} else {
		$error['login'] = 'blank';
	}
}


//デモ用のアカウント候補生成
$demo="demo".rand(1, 3);

?>

<!DOCTYPE html>
<html lang=ja>
	<!-- ヘッダーここから -->
    <?php include 'include/head.html';?>

<body>
	<div id="head">
		<h1>ログインする</h1>
	</div>

<!-- ログイン画面ここから -->	
	<div class="container">
		<div class="row"> 		
			<div class="col-md-offset-3 col-md-6">
           		<h2>メールアドレスとパスワードを記入してログインしてください</h2>
					<form method = "POST" action = "" class="form-horizontal well">
					<dl>
						<dt>メールアドレス</dt>
							<dd>
								<input type = "text" name = "email" maxlength="255" class="form-control"" value="<?php echo h($_POST['email']);?>"/>
                    				<?php if ($error['login']=='blank'):?>
									<p class="error">* メールアドレスとパスワードを入力してください</p>
                    				<?php endif; ?>
                    				<?php if ($error['login']=='failed'): ?>
                    					<p class="error">* ログインに失敗しました。正しく入力してください</p>
                    				<?php endif;?>
                    			</dd>
						<dt>パスワード</dt>
							<dd>
                    				<input type = "password" name = "password" maxlength="20" class="form-control" value="<?php echo h($_POST['password']);?>"/>
							</dd>
							<?php //ログイン情報の記録?>
							<dd>
								<input id ="save" type="checkbox" name="save" value="on">次回からは自動的にログインする
							</dd>
					</dl>
					<div class="center">
						<input type="submit" value="ログイン" class="btn btn-primary"/>
					</div>
				</form>
	       	</div>
	 	</div>
    	</div>
    	
    	<div class="container">
		<div class="row"> 		
			<div class="col-md-offset-3 col-md-6">
				<div class="well">
					<dl>
						<dt>登録されていない方はこちらから</dt>
							<dd class="center">
								<a href="join_index.php"  class="btn btn-success">ユーザー登録</a>
							</dd>
					</dl>
				</div>
	       	</div>
	 	</div>
    	</div>
    	
    	<div class="container">
		<div class="row"> 		
			<div class="col-md-offset-3 col-md-6">
				<form method = "POST" action = "" class="form-horizontal well">
					<dl>
						<dt>登録をせずにデモ用ユーザーとして試す</dt>
								<input type ="hidden" name = "email" value="<?php echo $demo;?>"/>
                    				<input type = "hidden" name = "password"  value="<?php echo $demo;?>"/>
					</dl>
					<div class="center">
						<input type="submit" value="デモ版" class="btn btn-primary"/>
					</div>
				</form>
	       	</div>
	 	</div>
    	</div>
    	
<?php include 'include/footer.html';?>
    		
</body>
	
	
</html>
