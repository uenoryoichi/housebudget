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
session_start();
//データベースへの接続 housebudget
require('connect_housebudget.php');

if (!isset($_SESSION['join'])) {
	header('Location: join_index.php');
}

//登録処理

if (!empty($_POST)) {
	$sql = sprintf('INSERT INTO user_master SET user_name="%s", email="%s", user_password="%s",created="%s"',
		mysql_real_escape_string($_SESSION['join']['user_name']),
		mysql_real_escape_string($_SESSION['join']['email']),
		mysql_real_escape_string(sha1($_SESSION['join']['user_password'])),
		date('Y-m-d H:i:s')
	);
	mysql_query($sql) or die(mysql_error());

	unset($_SESSION['join']);
	
	header('Location: join_thanks.php');
	exit();
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
                    <h2>次の内容を確認して登録するボタンをクリックしてください</h2>
                    <div class="control-group">
                    	<form action="" method="POST" class="well">
                    	    <input type="hidden" name="action" value="submit" />
                    	    <dl>
                   	 	    	<dt>ニックネーム</dt>
                    	        <dd><?php echo htmlspecialchars($_SESSION['join']['user_name'], ENT_QUOTES, 'UTF-8'); ?></dd>
                        	    <dt>メールアドレス</dt>
                            	<dd><?php echo htmlspecialchars($_SESSION['join']['email'], ENT_QUOTES, 'UTF-8');?></dd>
		              			<dt>パスワード</dt>
             	               	<dd>【表示されません】</dd>
                	        </dl>   
                            <div><a href="join_index.php?action=rewrite">&laquo;&nbsp;修正する</a>｜		<!-- 意味チェックする -->
                            <input type= "submit" value="登録する" class="btn-primary"/></div>
                    	</form>
                    </div>
                </div>
            </div>
        </div>
	<!-- insert部ここまで -->
        
    </body>
</html>

