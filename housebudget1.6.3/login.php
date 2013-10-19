<?php

//データベースへの接続 housebudget
require 'connect_housebudget.php';
//ここまで

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
		<h1>ログインする</h1>
	</div>
	<!-- 見出し　ここまで　-->

	<body>
<!-- ログイン画面ここから -->	
	<div class="container">
		<div class="row">
			<div class="span6 offset3">
				<h2>メールアドレスとパスワードを記入してログインしてください<h2p>
				<p>登録されていない方はこちらから</p>
				<p>&raquo;<a href="join_index.php">入会手続きをする</a></p>
				<div class="control-group">
					<form method = "POST" action = "" class="well">
						<dl>
							<dt>メールアドレス</dt>
							<dd>
								<input type = "text" name = "email" size="35" maxlength="255" class="span3" value="<?php echo htmlspecialchars($_POST['email']);?>"/>
                    			<?php if ($error['login']=='blank'):?>
								<p class="error">* メールアドレスとパスワードを入力してください</p>
                    			<?php endif; ?>
                    			<?php if ($error['login']=='failed'): ?>
                    			<p class="error">* ログインに失敗しました。正しく入力してください</p>
                    			<?php endif;?>
                    		</dd>
							<dt>パスワード</dt>
							<dd>
                    			<input type = "password" name = "user_password" size="10" maxlength="20" class="span3" value="<?php echo htmlspecialchars($_POST['password']);?>"/>
							</dd>
							<?php //ログイン情報の記録?>
							<dd>
								<input id ="save" type="checkbox" name="save" value="on">次回からは自動的にログインする
							</dd>
						</dl>
						<div>
							<input type="submit" value="ログイン" class="btn-primary"/>
						</div>
					</form>
	            </div>
	  		</div>
    	</div>
    </div>
<!-- ログイン画面ここまで -->		
	</body>
	
	
</html>
