<?php

/*
 * バージョン管理
 * 1.6.3
 * 
 * メモ
 * マスタ利用時修正必要
 * 
 * 
 */

//データベースへの接続 housebudget
require 'function/connect_housebudget.php';
//ここまで

session_start();

if (!empty($_POST)){
	//入力不足チェック
	if ($_POST['name'] == '') {
		$error['name']='blank';
	}
	if ($_POST['email'] == '') {
		$error['email']='blank';
	}
	if (strlen($_POST['user_password']) < 4) {
		$error['password']='length';
	}
	if ($_POST['user_password'] == '') {
		$error['password']='blank';
	}
	//重複アカウントチェック
	if (empty($error)) {
		$sql=sprintf('SELECT COUNT(*) AS cnt FROM users WHERE email="%s"',
			mysql_real_escape_string($_POST['email'])
		);
		$record=mysql_query($sql) or die(mysql_error());
		$table= mysql_fetch_assoc($record);
		if ($table['cnt']>0) {
			$error['email']='duplicate';
		}
	}
	//チェックへ
	if (empty($error)){
		$_SESSION['join'] = $_POST;		
		header('Location: join_check.php');
	}

}


//書き直し
if ($_REQUEST['action']== 'rewrite') {
	$_POST= $_SESSION['join'];
	$error['rewrite']=true;
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
		<h1>登録</h1>
	</div>
	<!-- 見出し　ここまで　-->
	
	<!-- insert部ここから -->
    <body>
        <div class="container">
            <div class="row">
                <div class="span6 offset3">
                    <h2>次のフォームに入力してください</h2>
                    <div class="control-group">
                        <form method = "POST" action = "join_index.php" enctype="multipart/form-date" class="well">
                            <label>ニックネーム<span class="required">必須</span></label>
                            <input type = "text" name = "name" size="35" maxlength="48" class="span3" value="<?php echo htmlspecialchars($_POST['name'], ENT_QUOTES);?>"/>
                            <?php if ($error['user_name']=='blank'):?>
							<p class="error">* ニックネームを入力してください</p>
                            <?php endif; ?>
                            <label>メールアドレス<span class="required">必須</span></label>
                            <input type = "text" name = "email" size="35" maxlength= "255" class="span3" value="<?php echo htmlspecialchars($_POST['email'], ENT_QUOTES);?>"/>
                            <?php if ($error['email']=='blank'):?>
							<p class="error">* メールアドレスを入力してください</p>
                            <?php endif; ?>
                            <?php if ($error['email']=='duplicate'): ?>
                            <p class="error">* 指定したメールアドレスはすでに登録されています。</p>
                            <?php endif;?>
							<label>パスワード<span class="required">必須</span></label>
                            <input type = "password" name = "user_password" size="10" maxlength="20" class="span3" value="<?php echo htmlspecialchars($_POST['password'], ENT_QUOTES);?>"/>
                            <?php if ($error['password']=='blank'):?>
							<p class="error">* パスワードを入力してください</p>
                            <?php endif; ?>
                            <?php if ($error['password']=='length'):?>
							<p class="error">* パスワードは４文字以上で入力してください</p>
                            <?php endif; ?>
                            <div><input type= "submit" value="入力内容確認" class="btn-primary"/></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
	<!-- insert部ここまで -->
        
    </body>
</html>

