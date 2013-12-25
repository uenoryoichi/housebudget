<?php
session_start();
//データベースへの接続 housebudget
require 'function/connect_pdo_db.php';
require'function/connect_housebudget.php';

if (!isset($_SESSION['join'])) {
	header('Location: join_index.php');
}

//登録処理

if (!empty($_POST)) {
	$stmt= $pdo->prepare('INSERT INTO users SET name=:name, email=:email, password=:pass, created=NOW()');
	$stmt->bindValue(':name', $_SESSION['join']['name'], PDO::PARAM_STR);
	$stmt->bindValue(':email', $_SESSION['join']['email'], PDO::PARAM_STR);
	$stmt->bindValue(':pass', sha1($_SESSION['join']['user_password']), PDO::PARAM_STR);
	$stmt->execute();
	
	/*
	$sql = sprintf('INSERT INTO users SET name="%s", email="%s", password="%s",created="%s"',
		mysql_real_escape_string($_SESSION['join']['name']),
		mysql_real_escape_string($_SESSION['join']['email']),
		mysql_real_escape_string(sha1($_SESSION['join']['user_password'])),
		date('Y-m-d H:i:s')
	);
	mysql_query($sql) or die(mysql_error());
	*/
	
	$_SESSION['join']=NULL;
	
	header('Location: join_thanks.php');
	exit();
}


?>

<!DOCTYPE html>
<html lang=ja>
<!-- ヘッダーここから -->
<?php include 'include/head.html';?>
	
<body>
	<!-- 見出し ここから　-->
	<div id="head">
		<h1>登録</h1>
	</div>
	<!-- 見出し　ここまで　-->
	
	<!-- insert部ここから -->
	<div class="container">
		<div class="row"> 		
			<div class="col-md-offset-3 col-md-6">
           		<br><h2>次の内容を確認して登録するボタンをクリックしてください</h2>
                 <form action="" method="POST" class="form-horizontal well">
                  	<dl>
                  		<dt>ニックネーム</dt>
                    			<dd><?php echo htmlspecialchars($_SESSION['join']['name'], ENT_QUOTES, 'UTF-8'); ?></dd>
                     		<dt>メールアドレス</dt>
                            	<dd><?php echo htmlspecialchars($_SESSION['join']['email'], ENT_QUOTES, 'UTF-8');?></dd>
		              	<dt>パスワード</dt>
             	           	<dd>【表示されません】</dd>
                	 	</dl>   
          			<div class="center">
          				<a href="join_index.php?action=rewrite" class="btn btn-default">&laquo;&nbsp;修正する</a>｜		<!-- 意味チェックする -->
                        	<input type="hidden" name="action" value="submit" />
                       	<input type= "submit" value="登録する" class="btn btn-success"/>
                  	</div>
               	</form>
            	</div>
        	</div>
  	</div>
	<!-- insert部ここまで -->
        
    </body>
</html>

