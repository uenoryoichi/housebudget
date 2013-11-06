<?php
session_start();

//データベースへの接続 housebudget
require 'function/connect_housebudget.php';
//ここまで

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
           		<br><h2>次のフォームに入力してください</h2>
                	<form method = "POST" action = "join_index.php" enctype="multipart/form-date" class="form-horizontal well">
               		<label>ニックネーム<span class="label label-danger">必須</span></label>
                    	<input type = "text" name = "name" class="form-control" value="<?php echo htmlspecialchars($_POST['name'], ENT_QUOTES);?>"/>
                   	<?php if ($error['user_name']=='blank'):?>
						<p class="error">* ニックネームを入力してください</p>
                    	<?php endif; ?>
                            
                   	<label>メールアドレス<span class="label label-danger">必須</span></label>
                   	<input type = "text" name = "email" class="form-control" value="<?php echo htmlspecialchars($_POST['email'], ENT_QUOTES);?>"/>
                  	<?php if ($error['email']=='blank'):?>
						<p class="error">* メールアドレスを入力してください</p>
                  	<?php endif; ?>
                  	<?php if ($error['email']=='duplicate'): ?>
                    		<p class="error">* 指定したメールアドレスはすでに登録されています。</p>
                  	<?php endif;?>
							
					<label>パスワード<span class="label label-danger">必須</span></label>
                  	<input type = "password" name = "user_password" maxlength="20" class="form-control"value="<?php echo htmlspecialchars($_POST['password'], ENT_QUOTES);?>"/>
                   	<?php if ($error['password']=='blank'):?>
						<p class="error">* パスワードを入力してください</p>
                  	<?php endif; ?>
                  	<?php if ($error['password']=='length'):?>
						<p class="error">* パスワードは４文字以上で入力してください</p>
                   	<?php endif; ?>
                   	<div class="center">
                   		<input type= "submit" value="入力内容確認" class="btn btn-primary"/>
                   	</div>
             	</form>
          	</div>
     	</div>
  	</div>
	<!-- insert部ここまで -->
        
    </body>
</html>

